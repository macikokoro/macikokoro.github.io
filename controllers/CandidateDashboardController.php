<?php
/**
 * Created by IntelliJ IDEA.
 * User: rsalota
 * Date: 5/25/14
 * Time: 8:04 PM
 * To change this template use File | Settings | File Templates.
 */

namespace app\controllers;


class CandidateDashboardController  extends \lithium\action\Controller{

    public function index() {
        $controller="CandidateDashboard";
        return compact("controller");
    }
}