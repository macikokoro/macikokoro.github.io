<?php

namespace app\controllers;

use lithium\analysis\Logger;
use app\models\Categories;
use app\models\QuestionCategory;


/**
 * @package app\controllers
 */
class CategoryController extends BaseRestController {

    private $items_per_page = 2;
    
    public function get()
    {
        $category = Categories::find($this->request->params['id']);
        //var_dump($category, $this->request->params[id]);exit;
        if(!empty($category->id)) {
            return $this->success(self::HTTP_STATUS_OK, $category->to('array'));
        } else {
            return $this->error(self::HTTP_STATUS_NOT_FOUND, array(
                'code'  => '404',
                'message'   => 'Category not found'));
        }
    }
    
    public function getList()
    {
        $categories = Categories::find('all', array(
            'limit' => $this->items_per_page,
            'offset' => (int) ($this->request->params['id'] * $this->items_per_page)
        ));
        $categoriesCount = Categories::count();
        $last_page = ceil($categoriesCount / $this->items_per_page) - 1;
        return $this->success(self::HTTP_STATUS_OK, array(
            'list'  => $this->listToArray($categories),
            'last_page' => $last_page
        ));
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
                $conditionsOr[] = array('name' => array('like' => '%' . $s . '%'));
            }
        }
        $categories = Categories::find('all', array(
            'conditions'    => array(
                'OR' => $conditionsOr
            ),
            'limit'         => $this->items_per_page,
            'offset'        => (int) ($args[1] * $this->items_per_page)
        ));
        
        $categoriesCount = Categories::count(array(
            'conditions'    => array(
                'OR' => $conditionsOr
            )
        ));
        $last_page = ceil($categoriesCount / $this->items_per_page) - 1;
        return $this->success(self::HTTP_STATUS_OK, array(
            'list'  => $this->listToArray($categories),
            'last_page' => $last_page
        ));
    }
    
    public function getQuestions()
    {
        $category_id = $this->request->params['args'][0];
        $page = $this->request->params['args'][1];
        
        $category = Categories::find($category_id);
        if(empty($category->id)) {
            return $this->error(self::HTTP_STATUS_NOT_FOUND, array('message' => "Category not found"));
        }
        
        $questions = Categories::getQuestions($category->id, $page, $this->items_per_page);
        return $this->error(self::HTTP_STATUS_OK, array(
            "list" => $this->listToArray($questions['list']),
            "last_page" => $questions["last_page"]
        ));
    }
    
    private function listToArray($category_list)
    {
        $arr = array();
        foreach($category_list as $category) $arr[] = $category->to('array');
        return $arr;
    }
}
