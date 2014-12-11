<?php
/**
 * Created by IntelliJ IDEA.
 * User: rsalota
 * Date: 10/20/13
 * Time: 11:04 AM
 * To change this template use File | Settings | File Templates.
 */

namespace app\controllers;
use app\models\FileManager;
use app\models\Questions;

/**
 * Class QuestionApiController
 * 1. CRUD a question
 * 2. Associate skills that will be tested with this question
 * 3.
 * @package app\controllers
 */
class QuestionController  extends BaseRestController
{

    public function get()
    {
        try {
            if (isset($this->request->params['id'])) {
                $question = Questions::findById($this->request->params['id']);
                return $this->success(self::HTTP_STATUS_OK, $this->toInterface($question));
            }
            throw new \InvalidArgumentException("Sorry - this is not supported");
        } catch (\InvalidArgumentException $ex) {
            return $this->error(self::HTTP_STATUS_BAD_REQUEST, array(
                'code' => 400,
                'message' => "Was not able to create the object " . $ex->getMessage()));
        } catch (\Exception $ex) {
            return $this->error(self::HTTP_STATUS_BAD_REQUEST, array(
                'code' => 500,
                'message' => "Was not able to create the object " . $ex->getMessage()));
        }

    }

    public function post(){
        try {
            $requestData = $this->request->data;
            $description = self::validateElement($requestData, 'description');
            $categories = self::validateElement($requestData, 'categories',true);
            $solutions = self::validateElement($requestData, 'solutions',true);
            $directory = self::validateElement($requestData, 'directory',true,"default");
            $fileName = self::validateElement($requestData, 'file_name');
            $repository_url = self::validateElement($requestData, 'repository_url',true);
            $language = self::validateElement($requestData, 'language');
            $junitDirectory = self::validateElement($requestData, 'junit_directory',true,"default");
            $questionId = self::validateElement($requestData, 'question_id');
            $prop = self::validateElement($requestData, 'prop');

            $oldQuestion = Questions::findByQuestionId($questionId);

            if (isset($oldQuestion->question_id)){
                return $this->success(self::HTTP_STATUS_OK, $this->toInterface($oldQuestion));
            }

            $question = Questions::create(array(
                'question_id' => $questionId,
                'description' => $description,
                'directory' => $directory,
                'repository_url' =>$repository_url,
                'file_name' => $fileName,
                'language'=> $language,
                'junit_directory' =>$junitDirectory,
                'prop' => $prop));

            $success = $question->save();
            return $this->success(self::HTTP_STATUS_OK, $this->toInterface($question));

        } catch (\InvalidArgumentException $ex) {
            return $this->error(self::HTTP_STATUS_BAD_REQUEST, array(
                'code' => 400,
                'message' => "Was not able to create the object " . $ex->getMessage()));
        } catch (\Exception $ex) {
            return $this->error(self::HTTP_STATUS_BAD_REQUEST, array(
                'code' => 500,
                'message' => "Was not able to create the object " . $ex->getMessage()));
        }
    }

    public function put(){
        try {
            $requestData = $this->request->data;
            var_dump($requestData);
            $questionId = self::validateElement($requestData, 'question_id');
            $description = self::validateElement($requestData, 'description',true);
            $categories = self::validateElement($requestData, 'question_categories',true);
            $solutions = self::validateElement($requestData, 'solutions',true);
            $directory = self::validateElement($requestData, 'directory',true);
            $fileName = self::validateElement($requestData, 'file_name',true);
            $repository_url = self::validateElement($requestData, 'repository_url',true);
            $language = self::validateElement($requestData, 'language',true);
            $junitDirectory = self::validateElement($requestData, 'junit_directory',true);
            $prop = self::validateElement($requestData, 'prop',true);

            $force = self::validateElement($requestData, 'force',true);

            $question = Questions::findByQuestionId($questionId);

            if (!isset($question->question_id)){
                throw new  \InvalidArgumentException("The question does not exists " . $questionId);
            }

            if(isset($description) || isset($force)){
                $question->description = $description;
            }

            if(isset($categories) || isset($force)){
                $question->categories = $categories;
            }

            if(isset($solutions) || isset($force)){
                $question->solutions = $solutions;
            }

            if(isset($directory) ||  isset($force)){
                $question->directory = $directory;
            }

            if(isset($fileName) ||  isset($force)){
                $question->file_name = $fileName;
            }

            if(isset($repository_url) ||  isset($force)){
                $question->repository_url = $repository_url;
            }

            if(isset($language) ||  isset($force)){
                $question->language = $language;
            }

            if(isset($junitDirectory) ||  isset($force)){
                $question->junit_directory = junit_directory;
            }
            if(isset($prop) ||  isset($force)){
                $question->prop = $prop;
            }


            $success = $question->save();
            return $this->success(self::HTTP_STATUS_OK, $this->toInterface($question));

        } catch (\InvalidArgumentException $ex) {
            return $this->error(self::HTTP_STATUS_BAD_REQUEST, array(
                'code' => 400,
                'message' => "Was not able to create the object " . $ex->getMessage()));
        } catch (\Exception $ex) {
            return $this->error(self::HTTP_STATUS_BAD_REQUEST, array(
                'code' => 500,
                'message' => "Was not able to create the object " . $ex->getMessage()));
        }
    }


    public function search()
    {
        $args = $this->request->params['args'];
        $conditionsOr = array();
        $keywordsStr = urldecode($args[0]);
        $tmp = explode(' ', $keywordsStr);
        foreach($tmp as $str) {
            $s = trim($str);
            if(mb_strlen($s, 'utf-8') > 3) {
                $conditionsOr[] = array('title' => array('like' => '%' . $s . '%'));
            }
        }
        $questions = Questions::find('all', array(
            'conditions'    => array(
                'OR' => $conditionsOr
            ),
            'limit'         => $this->items_per_page,
            'offset'        => (int) ($args[1] * $this->items_per_page)
        ));
        
        $questionsCount = Questions::count(array(
            'conditions'    => array(
                'OR' => $conditionsOr
            )
        ));
        $last_page = ceil($questionsCount / $this->items_per_page) - 1;
        return $this->success(self::HTTP_STATUS_OK, array(
            'list'  => $this->listToArray($categories),
            'last_page' => $last_page
        ));
    }

    /**
     * @param $question Questions
     * @return array
     */
    public function toInterface($question)
    {
        $array = array();
        $array['id'] = $question->id;
        $array['description'] = $question->description;
        $array['language'] = $question->language;
        $array['title'] = $question->title;
        $array['created_at'] = $question->created_at;
        $array['updated_at'] = $question->updated_at;
        $hints = $question->question_hints;
        foreach($hints as $hint){
            $array['hints'][] = array(
                'hint_id' => $hint->id,
                'hint' => $hint->hint
            );
        }

        foreach($question->question_categories as $qCat) {
            $array['categories'][] = array(
                'category_id' => $qCat->category_id,
            );
        }

        foreach($question->question_files as $qFile) {
            $array['tests'][] = array(
                'filename' => $qFile->filename,
                'filecontent'=>FileManager::getTestFile($question,$qFile)
            );
        }

        foreach($question->question_solutions as $qSolutionFile) {
            $array['solutions'][] = array(
                'filename' => $qSolutionFile->filename,
                'filecontent'=>FileManager::getSolutionsFile($question,$qSolutionFile)
            );
        }

        return $array;
    }
    
    private function listToArray($category_list)
    {
        $arr = array();
        foreach($category_list as $category) $arr[] = $category->to('array');
        return $arr;
    }

}
