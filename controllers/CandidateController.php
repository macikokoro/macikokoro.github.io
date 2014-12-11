<?php
/**
 * Created by IntelliJ IDEA.
 * User: rsalota
 * Date: 10/19/13
 * Time: 2:17 PM
 * To change this template use File | Settings | File Templates.
 */

namespace app\controllers;


class CandidateController extends \lithium\action\Controller {
    public function index() {
        $controller="candidate";
        return compact("controller");
    }

    public function to_string() {
        return "Hello World";
    }

    public function to_json() {
        return $this->render(array('json' => 'Hello World'));
    }


}