<?php

namespace app\controllers;

class AwesomesdeController extends \lithium\action\Controller {

    public function index() {
        $controller="awesomesde";
        return compact("controller");
    }
    
    public function login() {
    	
    	return compact("controller");
    }



	public function do_login()
	{
		$data = $this->request->data;
		
		if($this->request->data){
			
			$data = $this->request->data;
			
			echo "User Created!";
			echo $data;
		}
		
		$this->set(compact('data'));
		
		$this->redirect('Jobmatch::welcome');
	}
	
	public function welcome()
	{
		return compact("controller");
	
	}
	
}

?>