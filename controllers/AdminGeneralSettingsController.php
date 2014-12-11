<?php

namespace app\controllers;

use lithium\security\Auth;
use app\models\GeneralSettings;

class AdminGeneralSettingsController extends \lithium\action\Controller {
    
    public function index() {
        $settings = GeneralSettings::all();
        $general_settings = array();
        foreach($settings as $obj) $general_settings[$obj->key] = unserialize($obj->value);
        $controller = 'gen_settings';
        return compact('general_settings', 'controller');
    }
    
    public function save() {
        $data = $this->request->data;
        if($data) {
            // update/init git for test repo
            if(!empty($data['git_test_repo_url']) && !empty($data['git_test_repo_username']) && !empty($data['git_test_repo_password'])) {
                $gitUrlS = GeneralSettings::find('first', array('conditions' => array('key' => 'git_test_repo_url')));
                $gitUrl = unserialize($gitUrlS->value);
                $gitUserNameS = GeneralSettings::find('first', array('conditions' => array('key' => 'git_test_repo_username')));
                $gitUserName = unserialize($gitUserNameS->value);
                $gitPasswordS = GeneralSettings::find('first', array('conditions' => array('key' => 'git_test_repo_password')));
                $gitPassword = unserialize($gitPasswordS->value);
                if($data['git_test_repo_url'] != $gitUrl || $data['git_test_repo_username'] != $gitUserName ||
                                $data['git_test_repo_password'] != $gitPassword) {
                    $this->reinitGit('test_files', $data['git_test_repo_url'], $data['git_test_repo_username'], $data['git_test_repo_password']);
                }
            }
            if(!empty($data['git_solution_repo_url']) && !empty($data['git_solution_repo_username']) && !empty($data['git_solution_repo_password'])) {
                $gitUrlS = GeneralSettings::find('first', array('conditions' => array('key' => 'git_solution_repo_url')));
                $gitUrl = unserialize($gitUrlS->value);
                $gitUserNameS = GeneralSettings::find('first', array('conditions' => array('key' => 'git_solution_repo_username')));
                $gitUserName = unserialize($gitUserNameS->value);
                $gitPasswordS = GeneralSettings::find('first', array('conditions' => array('key' => 'git_solution_repo_password')));
                $gitPassword = unserialize($gitPasswordS->value);
                if($data['git_solution_repo_url'] != $gitUrl || $data['git_solution_repo_username'] != $gitUserName ||
                                $data['git_solution_repo_password'] != $gitPassword) {
                    $this->reinitGit('solution_files', $data['git_solution_repo_url'], $data['git_solution_repo_username'], $data['git_solution_repo_password']);
                }
            }
            //$this->reinitGit('solution_files', $data['git_solution_repo_url'], $data['git_solution_repo_username'], $data['git_solution_repo_password']);
            foreach($data as $key => $value) {
                $set = GeneralSettings::find('first', array(
                    'conditions' => array(
                        'key' => $key
                    )
                ));
                if(empty($set->key)) {
                    $set = GeneralSettings::create();
                    $set->key = $key;
                }
                $set->value = serialize($value);
                $set->save();
            }
        }
        $gitUserNameS = GeneralSettings::find('first', array(
            'conditions' => array(
                'key' => 'git_user_name'
            )
        ));
        $gitUserName = unserialize($gitUserNameS->value);
        $gitUserEmailS = GeneralSettings::find('first', array(
            'conditions' => array(
                'key' => 'git_user_email'
            )
        ));
        $gitUserEmail = unserialize($gitUserEmailS->value);
        if(!empty($gitUserName) && !empty($gitUserEmail)) $this->setGitGlobalSettings($gitUserName, $gitUserEmail);
        $this->redirect('AdminGeneralSettings::index');
    }
    
    private function setGitGlobalSettings($userName, $userEmail)
    {
        $command = "git config --global user.name \"{$userName}\"";
        $descriptorspec = array(
           0 => array("pipe", "r"),
           1 => array("pipe", "w"),
           2 => array("pipe", "w")
        );
        $process = proc_open($command, $descriptorspec, $pipes, GIT_HOME, array("HOME" => GIT_HOME));
        if(is_resource($process)) {
            $return1 =  stream_get_contents($pipes[1]);
            $return2 =  stream_get_contents($pipes[2]);
            foreach($pipes as &$pipe) fclose($pipe);
            proc_close($process);
        }
        
        $command = "git config --global user.email '{$userEmail}'";
        $process = proc_open($command, $descriptorspec, $pipes, GIT_HOME, array("HOME" => GIT_HOME));
        if(is_resource($process)) {
            $return1 =  stream_get_contents($pipes[1]);
            $return2 =  stream_get_contents($pipes[2]);
            foreach($pipes as &$pipe) fclose($pipe);
            proc_close($process);
        }
    }
    
    private function reinitGit($type, $url, $username, $password)
    {
        $dirname = dirname(dirname(__DIR__)) . "/{$type}";
        $descriptorspec = array(
           0 => array("pipe", "r"),
           1 => array("pipe", "w"),
           2 => array("pipe", "w")
        );
        if(!file_exists($dirname)) mkdir($dirname);
        if(!file_exists($dirname . '/.git')) {
            // init git
            $command = "git init";
            
            $process = proc_open($command, $descriptorspec, $pipes, $dirname, array('HOME' => GIT_HOME));
            
            if(is_resource($process)) {
                $return1 =  stream_get_contents($pipes[1]);
                $return2 =  stream_get_contents($pipes[2]);
                foreach($pipes as &$pipe) fclose($pipe);
                proc_close($process);
            }
        }
        
        // add remote repo
        $remote_repo = preg_replace('/^(.+?:\/\/)(.+?)$/', '$1' . urlencode($username) . ':' . urlencode($password) . '@$2', $url);
        
        $command = "git remote add origin {$remote_repo}";
        
        $process = proc_open($command, $descriptorspec, $pipes, $dirname);
        
        if(is_resource($process)) {
            $return1 =  stream_get_contents($pipes[1]);
            $return2 =  stream_get_contents($pipes[2]);
            foreach($pipes as &$pipe) fclose($pipe);
            proc_close($process);
        }
        
        // commit changes and push
        $command = "git add -A";
        $process = proc_open($command, $descriptorspec, $pipes, $dirname, array('HOME' => GIT_HOME));
        if(is_resource($process)) {
            $return1 =  stream_get_contents($pipes[1]);
            $return2 =  stream_get_contents($pipes[2]);
            foreach($pipes as &$pipe) fclose($pipe);
            proc_close($process);
        }
        
        $command = "git commit -m 'auto commit'";
        $process = proc_open($command, $descriptorspec, $pipes, $dirname, array('HOME' => GIT_HOME));
        if(is_resource($process)) {
            $return1 =  stream_get_contents($pipes[1]);
            $return2 =  stream_get_contents($pipes[2]);
            foreach($pipes as &$pipe) fclose($pipe);
            proc_close($process);
        }
        
        // push
        $command = "git push -u origin master";
        $process = proc_open($command, $descriptorspec, $pipes, $dirname, array('HOME' => GIT_HOME));
        if(is_resource($process)) {
            $return1 =  stream_get_contents($pipes[1]);
            $return2 =  stream_get_contents($pipes[2]);
            //var_dump($return1, $return2);exit;
            foreach($pipes as &$pipe) fclose($pipe);
            proc_close($process);
        }
    }
    
}
