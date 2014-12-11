<?php

namespace app\models;
class QuestionHints extends \lithium\data\Model {

    public static function findByQuestionId($questionId)
    {


        $records = QuestionHints::find('all', array(
            'conditions' => array(
                'question_id' => $questionId
            )
        ));

        var_dump("REahu". $questionId);
        return $records;
    }


}
