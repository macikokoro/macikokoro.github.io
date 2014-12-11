<?php

namespace app\models;

use app\models\Questions;
use app\models\QuestionCategory;

class Categories extends \lithium\data\Model {
    
    public static function getQuestions($id, $page, $limit)
    {
        $cat = Categories::find('first', array('conditions' => array('id' => $id)));
        
        if(empty($cat->id)) return null;
        
        $question_count = QuestionCategory::count(array(
            'conditions' => array(
                'category_id' => $cat->id
            )
        ));
        
        $last_page = ceil($question_count / $limit) - 1;
        if($page > $last_page) return array('last_page' => $last_page, 'list' => array());
        
        $question_categories = QuestionCategory::find('all', array(
            'conditions' => array(
                'category_id' => $cat->id
            ),
            'limit' => $limit,
            'offset' => $page * $limit
        ));
        
        $question_ids = array();
        foreach($question_categories as $qCat) $question_ids[] = $qCat->question_id;
        
        return array(
            "last_page" => $last_page,
            "list" => Questions::find('all',
                array('conditions' => array(
                        'id' => $question_ids
                    )
                )
            )
        );
    }
    
}

