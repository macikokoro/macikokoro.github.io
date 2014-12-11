<?php

namespace app\controllers;

use lithium\security\Auth;
use app\models\Questions;
use app\models\Categories;
use app\models\QuestionCategory;
use app\models\QuestionFiles;
use app\models\QuestionHints;
use app\models\QuestionSolutions;
use app\models\GeneralSettings;

class AdminQuestionsController extends \lithium\action\Controller {
    
    public function index() {
        $questions = Questions::all();
        return compact('questions');
    }
    
    public function add() {
        $post = $data = $this->request->data;
        $errors = [];
        $question = null;
        if($data) {
            // validation part
            $hintCnt = 0;
            foreach($data['hint'] as $hint) if(strlen(trim($hint)) > 0) $hintCnt++;
            //if($hintCnt == 0) $errors[] = "Add atleast 1 hint";
            $tmp = explode(',', $data['categories']);
            $categories = [];
            foreach($tmp as $catName) {
                if(strlen(trim($catName)) > 0) $categories[] = trim($catName);
            }
            if(count($categories) == 0) $errors[] = "Add atleast 1 category";
            
            if(count($errors) == 0) {
                $question = Questions::create();
                $question->title = $data['title'];
                $question->description = $data['description'];
                $question->level = $data['level'];
                $question->language = $data['language'];
                if($question->save()) {
                    $this->saveHints($question->id, $data['hint']);
                    $tmp = explode(',', $data['categories']);
                    $categories = [];
                    foreach($tmp as $catName) {
                        $catName = trim($catName);
                        $cat = Categories::first([
                            "conditions" => [
                                "name" => [
                                    "like" => $catName
                                ]
                            ]
                        ]);
                        if(empty($cat->id)) {
                            $cat = Categories::create();
                            $cat->name = $catName;
                            $cat->save();
                        }
                        $qCategory = QuestionCategory::create();
                        $qCategory->question_id = $question->id;
                        $qCategory->category_id = $cat->id;
                        $qCategory->save();
                    }
                    if($this->getTestFiles($question->id, $question->language, $data)) {
                        if($this->getSolutionFiles($question->id, $question->language, $data)) {
                            $this->gitCommitAndPush('test_files',$question->id);
                            $this->gitCommitAndPush('solution_files',$question->id);
                            $this->redirect("AdminQuestions::index");
                        } else {
                            $errors[] = "One or more solution files was not saved";
                        }
                    } else {
                        $errors[] = "One or more files was not saved";
                    }
                } else {
                    $errors += $question->errors();
                }
            }
        }
        if(!empty($question->id) && count($errors) > 0) $this->delete($question->id, false);
        $categories = Categories::all();
        $action = 'add';
        return compact('categories', 'action', 'errors', 'post');
    }
    
    public function edit($id) {
        $data = $this->request->data;
        $errors = [];
        $question = Questions::find('first', array(
            'conditions' => array(
                'id' => $id
            ),
            'with' => ['QuestionCategory','QuestionFiles','QuestionHints','QuestionSolutions']
        ));
        //var_dump($question->to('array'), 1);exit;
        if($data) {
            //$question = Questions::create();
            $question->title = $data['title'];
            $question->description = $data['description'];
            $question->level = $data['level'];
            $old_language = $question->language;
            $question->language = $data['language'];
            if($question->save()) {
                foreach($question->question_hints as $hint) $hint->delete();
                foreach($question->question_categories as $qCat) $qCat->delete();
                if($this->saveHints($question->id, $data['hint'])) {
                    $tmp = explode(',', $data['categories']);
                    $categories = [];
                    foreach($tmp as $catName) {
                        $catName = trim($catName);
                        if(empty($catName)) continue;
                        $cat = Categories::first([
                            "conditions" => [
                                "name" => [
                                    "like" => $catName
                                ]
                            ]
                        ]);
                        if(empty($cat->id)) {
                            $cat = Categories::create();
                            $cat->name = $catName;
                            $cat->save();
                        }
                        $categories[] = $cat->id;
                        $qCategory = QuestionCategory::create();
                        $qCategory->question_id = $question->id;
                        $qCategory->category_id = $cat->id;
                        $qCategory->save();
                    }
                    if(count($categories) > 0) {
                        $this->removeAllFiles($question->id, $old_language);
                        if($this->getTestFiles($question->id, $question->language, $data)) {
                            if($this->getSolutionFiles($question->id, $question->language, $data)) {
                                $this->gitCommitAndPush('test_files');
                                $this->gitCommitAndPush('solution_files');
                                $this->redirect("AdminQuestions::index");
                            } else {
                                $errors[] = "One or more solution files was not saved";
                            }
                        } else {
                            $errors[] = "One or more files was not saved";
                        }
                    } else {
                        $errors[] = "Add atleast 1 category";
                    }
                } else {
                    $errors[] = "Add atleast 1 hint";
                }
            } else {
                $errors += $question->errors();
            }
        }
        $categories = Categories::all();
        $action = $id;
        $testDir = dirname(dirname(__DIR__)) . '/test_files/java/question' . $question->id;
        $solutionDir = dirname(dirname(__DIR__)) . '/solution_files/java/question' . $question->id;
        return compact('categories', 'action', 'errors', 'question', 'testDir', 'solutionDir');
    }
    
    public function delete($id, $redirect = true)
    {
        $question = Questions::find('first', array(
            'conditions' => array(
                'id' => $id
            ),
            'with' => ['QuestionCategory','QuestionFiles','QuestionHints']
        ));

        if (isset($question)){
            foreach($question->question_hints as $hint) $hint->delete();
            foreach($question->question_categories as $qCat) $qCat->delete();
            $this->removeAllFiles($question->id, $question->language, true);
            $question->delete();
            if($redirect) {
                $this->redirect("AdminQuestions::index");
            }
        }
    }
    
    private function getTestFiles($question_id, $lang, $data)
    {
        switch($data['code_input_type']) {
            case 'git':
                return $this->getFilesFromGit("test_files", $lang, $question_id, $data['git_repo'], $data['git_username'], $data['git_password']);
            case 'files':
                return $this->uploadFiles("test_files", $lang, $question_id);
            case 'editor':
                return $this->createFiles("test_files", $lang, $question_id, $data['test_class']);
        }
    }
    
    private function getSolutionFiles($question_id, $lang, $data)
    {
        switch($data['solutions_input_type']) {
            case 'git':
                return $this->getFilesFromGit("solution_files", $lang, $question_id, $data['git_solutions_repo'], $data['git_solutions_username'], $data['git_solutions_password']);
            case 'files':
                return $this->uploadFiles("solution_files", $lang, $question_id);
            case 'editor':
                return $this->createFiles("solution_files", $lang, $question_id, $data['solutions_class']);
        }
    }
    
    private function getFilesFromGit($type, $lang, $question_id, $git_repo, $git_username, $git_password)
    {
        $result = false;
        // create directory
        $dirname = dirname(dirname(__DIR__)) . "/{$type}/{$lang}/question{$question_id}";
        if(!file_exists($dirname)) mkdir($dirname);
        
        if(!empty($git_username) && !empty($git_password)) {
            $git_repo = preg_replace('/^(.+?:\/\/)(.*?)$/i', '$1' . urlencode($git_username) . ':' . urlencode($git_password) . '@$2', $git_repo);
        }
        
        $command = "git clone {$git_repo}";
        $descriptorspec = array(
           0 => array("pipe", "r"),
           1 => array("pipe", "w"),
           2 => array("pipe", "w")
        );
        
        $process = proc_open($command, $descriptorspec, $pipes, $dirname, array('HOME' => GIT_HOME));
        
        if(is_resource($process)) {
            $return1 =  stream_get_contents($pipes[1]);
            $return2 =  stream_get_contents($pipes[2]);
            
            foreach($pipes as &$pipe) fclose($pipe);
            
            $result = proc_close($process);
            
            $result = ($result == 0);
            
            $result = $result && $this->saveFilesFromDirectory($type, $question_id, $dirname);
        }
        return $result;
    }
    
    private function uploadFiles($type, $lang, $question_id)
    {
        $result = null;
        $dirname = dirname(dirname(__DIR__)) . "/{$type}/{$lang}/question{$question_id}";
        if(!file_exists($dirname)){
            mkdir($dirname,0777,true);
        }
        $field_name = $type == "test_files" ? "test_file" : "solutions_file";
        foreach($_FILES[$field_name]['name'] as $k => $filename) {
            $new_filename = preg_replace('/\.java$/i', '.java', $filename);
            if(!file_exists($dirname . '/' . $new_filename) &&
                    move_uploaded_file($_FILES[$field_name]['tmp_name'][$k], $dirname . '/' . $new_filename)) {
                $qFile = $type == "test_files" ? QuestionFiles::create() : QuestionSolutions::create();
                $qFile->filename = $new_filename;
                $qFile->question_id = $question_id;
                if(is_null($result)) $result = true;
                $result = $result && $qFile->save();
            } else {
                $result = false;
            }
        }
        return true;
    }
    
    private function createFiles($type, $lang, $question_id, $classes)
    {
        $result = null;
        $dirname = dirname(dirname(__DIR__)) . "/{$type}/{$lang}/question{$question_id}";
        if(!file_exists($dirname)) mkdir($dirname);
        foreach($classes['filename'] as $k => $filename) {
            if(empty($filename)) continue;
            if(is_null($result)) $result = true;
            $this->createDirIfNotExists(dirname("{$dirname}/{$filename}"));
            
            if(!file_exists($dirname . '/' . $filename) && @file_put_contents($dirname . '/' . $filename, $classes['code'][$k])) {
                $qFile = $type == "test_files" ? QuestionFiles::create() : QuestionSolutions::create();
                $qFile->filename = $filename;
                $qFile->question_id = $question_id;
                $result = $result && $qFile->save();
            } else {
                $result = false;
            }
        }
        return $result;
    }
    
    private function saveHints($question_id, $hints)
    {
        $res = null;
        foreach($hints as $hintText) {
            $hintText = trim($hintText);
            if(empty($hintText)) continue;
            if(is_null($res)) $res = true;
            $hint = QuestionHints::create();
            $hint->question_id = $question_id;
            $hint->hint = $hintText;
            $res = $res && $hint->save();
        }
        return $res;
    }
    
    public function saveFilesFromDirectory($type, $question_id, $dirname, $parentdir = null) {
        $result = true;
        $parentdir = empty($parentdir) ? $dirname : $parentdir;
        $dir = opendir($dirname);
        if(!is_resource($dir)) return false;
        while( ($filename = readdir($dir)) !== false) {
            if( preg_match('/^\./', $filename)) continue;
            if( is_dir("{$dirname}/{$filename}") ) {
                $result = $result && $this->saveFilesFromDirectory($type, $question_id, "{$dirname}/{$filename}", $parentdir);
            } else if( is_file("{$dirname}/{$filename}") ){
                $new_filename = str_replace($parentdir.'/', '', "{$dirname}/{$filename}");
                $qFile = $type == "test_files" ? QuestionFiles::create() : QuestionSolutions::create();
                $qFile->filename = $new_filename;
                $qFile->question_id = $question_id;
                $result = $result && $qFile->save();
            }
        }
        closedir($dir);
        return $result;
    }
    
    private function removeAllFiles($question_id, $lang, $removeParentDir = false)
    {
        $dirname = dirname(dirname(__DIR__)) . "/test_files/{$lang}/question{$question_id}";
        $this->removeDirectory($dirname, !$removeParentDir);
        $files = QuestionFiles::find('all', array('conditions' => array('question_id' => $question_id)));
        foreach($files as $f) $f->delete();
        
        $dirname = dirname(dirname(__DIR__)) . "/solution_files/{$lang}/question{$question_id}";
        $this->removeDirectory($dirname, !$removeParentDir);
        $files = QuestionSolutions::find('all', array('conditions' => array('question_id' => $question_id)));
        foreach($files as $f) $f->delete();
    }
    
    private function removeDirectory($dirname, $removeChildrenOnly = false)
    {
        if (!is_dir($dirname)){
            return;
        }

        $dir = opendir($dirname);
        if(!is_resource($dir)){
            return;
        }

        while(($filename = readdir($dir)) !== false) {
            if($filename != '.' && $filename != '..') {
                if(is_dir("{$dirname}/{$filename}") && (!$removeChildrenOnly || !preg_match('/^\./', $filename))) {
                    $this->removeDirectory("{$dirname}/{$filename}");
                } else {
                    @unlink("{$dirname}/{$filename}");
                }
            }
        }
        if(!$removeChildrenOnly) closedir($dir);
        rmdir($dirname);
    }
    
    private function createDirIfNotExists($dirname)
    {
        if(!file_exists($dirname)) 
        {
            $this->createDirIfNotExists(dirname($dirname));
            mkdir($dirname);
        }
    }
    
    private function gitCommitAndPush($type,$question_id)
    {
        if(!$this->isGitReady($type)){
            return;
        }

        $result = false;
        // create directory
        $dirname = dirname(dirname(__DIR__)) . "/{$type}";
        if(!file_exists($dirname)) mkdir($dirname);
        
        $command = "git add -A";
        $descriptorspec = array(
           0 => array("pipe", "r"),
           1 => array("pipe", "w"),
           2 => array("pipe", "w")
        );
        
        $process = proc_open($command, $descriptorspec, $pipes, $dirname, array('HOME' => GIT_HOME));
        
        if(is_resource($process)) {
            $return1 =  stream_get_contents($pipes[1]);
            $return2 =  stream_get_contents($pipes[2]);
            
            foreach($pipes as &$pipe) fclose($pipe);
            
            $result = proc_close($process);
            
            $result = ($result == 0);
        }
        
        $command = "git commit -m 'question {$question_id}'";
        
        $process = proc_open($command, $descriptorspec, $pipes, $dirname, array('HOME' => GIT_HOME));
        
        if(is_resource($process)) {
            $return1 =  stream_get_contents($pipes[1]);
            $return2 =  stream_get_contents($pipes[2]);
            
            foreach($pipes as &$pipe) fclose($pipe);
            
            $result = proc_close($process);
            
            $result = ($result == 0);
        }
        
        $command = "git push -u origin master";
        
        $process = proc_open($command, $descriptorspec, $pipes, $dirname, array('HOME' => GIT_HOME));
        
        if(is_resource($process)) {
            $return1 =  stream_get_contents($pipes[1]);
            $return2 =  stream_get_contents($pipes[2]);
            
            foreach($pipes as &$pipe) fclose($pipe);
            
            $result = proc_close($process);
            
            $result = ($result == 0);
        }
        
        return $result;
    }
    
    private function isGitReady($type)
    {
        switch($type) {
            case 'test_files':
                $gitUrlS = GeneralSettings::find('first', array('conditions' => array('key' => 'git_test_repo_url')));
                if (isset($gitUrlS)){
                    $gitUrl = unserialize($gitUrlS->value);
                    $gitUserNameS = GeneralSettings::find('first', array('conditions' => array('key' => 'git_test_repo_username')));
                    $gitUserName = unserialize($gitUserNameS->value);
                    $gitPasswordS = GeneralSettings::find('first', array('conditions' => array('key' => 'git_test_repo_password')));
                    $gitPassword = unserialize($gitPasswordS->value);
                }
                break;
            case 'solution_files':
                $gitUrlS = GeneralSettings::find('first', array('conditions' => array('key' => 'git_solution_repo_url')));
                if (isset($gitUrlS)){
                    $gitUrl = unserialize($gitUrlS->value);
                    $gitUserNameS = GeneralSettings::find('first', array('conditions' => array('key' => 'git_solution_repo_username')));
                    $gitUserName = unserialize($gitUserNameS->value);
                    $gitPasswordS = GeneralSettings::find('first', array('conditions' => array('key' => 'git_solution_repo_password')));
                    $gitPassword = unserialize($gitPasswordS->value);
                }
                break;
        }
        return !empty($gitUrl) && !empty($gitUserName) && !empty($gitPassword);
    }
    
}
