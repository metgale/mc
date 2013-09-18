<?php

class UsersController extends AppController {
	
	public $helpers = array('Facebook.Facebook');
	public $components = array('Facebook.Connect');
	public $uses = array('User');
	
	public function login() {
		$u = $this->Connect->user();
		if ($u) {
			$this->Auth->login($u);
			$this->redirect('/home/index');
		}
	}
	public function logout() {
		$this->Auth->logout();
		$this->Session->destroy();
		$this->redirect('/home/index');
	}
}
?>
