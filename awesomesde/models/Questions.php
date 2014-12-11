<?php
namespace app\models;

use lithium\data\Model;
use app\models\compiler;

/**
 * Class Question
 * @property $id;
 * @property $question_id;
 * @property $description;
 * @property $language;
 * @property $categories;
 * @property $hints;
 * @property $solutions;
 * @property $files;
 * @property $prop;
 * @property $title;
 * @property $level;
 */
class Questions extends \lithium\data\Model
{
    public $hasMany = array('QuestionCategory', 'QuestionFiles', 'QuestionHints', 'QuestionSolutions');
    
    public $validates = array(
        'title' => 'Please enter a title',
        'description' => array(
            array('notEmpty', 'message' => 'Email is empty.')
        ),
        'level' => 'Select a level for the question',
        'language' => 'Select a programming language for the question'
    );

    /**
     * @param $id
     * @return mixed Questions
     */
    public static function findById($id)
    {
        $question = Questions::find('first', array(
            'conditions' => array(
                'id' => $id
            ),
            'with' => ['QuestionCategory','QuestionFiles','QuestionHints','QuestionSolutions']
        ));
        return $question;
    }

    public static function loadAllQuestions()
    {
        return Questions::find("all");
    }

    public static function compile($question,$qFile)
    {
        $output = compiler\JavaCompiler::compile($question,$qFile);
        return $output;
    }

    public  function runUnitTests()
    {

    }

    public function resetFromRepository($customer, $record)
    {
    }


}
