<?php
/**
 * Created by IntelliJ IDEA.
 * User: rsalota
 * Date: 10/19/13
 * Time: 3:06 PM
 * To change this template use File | Settings | File Templates.
 */

namespace app\controllers;


class EmployerController extends \lithium\action\Controller {

    public function index() {
        $controller="employer";
        return compact("controller");
    }

    public function to_string() {
        return "Hello World";
    }

    public function to_json() {
        return $this->render(array('json' => 'Hello World'));
    }


}