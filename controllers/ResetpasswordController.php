<?php
/**
 * Created by IntelliJ IDEA.
 * User: rsalota
 * Date: 11/19/13
 * Time: 1:19 AM
 * To change this template use File | Settings | File Templates.
 */

namespace app\controllers;


use app\models\Customers;

class ResetpasswordController extends \lithium\action\Controller {

    public function index(){
        $data= $this->request->query;
        $error="Sorry the customer does not exist in our system";
        if (isset($data['username']){
            $customer = Customers::findByEmail($data['username']);
            if (isset($customer)){
                $customer->password_hash_1='welcome';
                return compact("customer");
            }else{
                return compact("error");
            }
        }
        //need to fix it at the top level.
    }
}