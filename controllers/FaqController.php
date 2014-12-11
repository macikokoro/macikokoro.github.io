<?php
/**
 * Created by IntelliJ IDEA.
 * User: rsalota
 * Date: 10/20/13
 * Time: 10:51 AM
 * To change this template use File | Settings | File Templates.
 */

namespace app\controllers;


class FaqController  extends \lithium\action\Controller {

    public function index() {
        $controller="faq";
        return compact("controller");
    }
}