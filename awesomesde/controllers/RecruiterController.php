<?php
/**
 * Created by IntelliJ IDEA.
 * User: rsalota
 * Date: 10/19/13
 * Time: 3:12 PM
 * To change this template use File | Settings | File Templates.
 */

namespace app\controllers;


class RecruiterController extends \lithium\action\Controller {

    public function index() {
        $controller="recruiter";
        return compact("controller");
    }

    public function to_string() {
        return "Hello World";
    }

    public function to_json() {
        return $this->render(array('json' => 'Hello World'));
    }

}