<?php

namespace app\controllers;

use lithium\security\Auth;
use lithium\security\Password;
use app\models\Users;

class AdminController extends \lithium\action\Controller {
    
    public function index() {
    }
    
    public function login() {
    //$this->request->data['password'] = Password::hash($this->request->data['password']);
    var_dump(!!$this->request->data, Auth::check('default', $this->request));exit;
        if($this->request->data && Auth::check('default', $this->request)) {
            $this->redirect('/admin');
        }
        //var_dump($this->request->data);
        //$user = Users::find(1);
        //$user->password = Password::hash('123456789');
        //$user->save();
        //var_dump($user);exit;
        return compact('login');
    }
    
}
