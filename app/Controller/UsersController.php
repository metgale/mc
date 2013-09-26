<?php

class UsersController extends AppController {

	//public $helpers = array('Facebook.Facebook');
	//public $components = array('Facebook.Connect');
	public $uses = array('User', 'Album', 'Collection', 'Wishlist', 'Artist');

	public function beforeFilter() {
		$this->Auth->allow(array('login', 'logout'));
		parent::beforeFilter();
	}

	public function login() {

		if (!$this->Auth->login()) {
			/**
			 * Get config for Facebook redirect
			 */
			$clientId = Configure::read('facebook.app_id');
			$permissions = implode(',', Configure::read('facebook.permissions'));
			$redirect = Router::url(false, true);
			$csrfToken = CakeSession::read('FacebookAuthCSRF');
			/**
			 * Redirect
			 */
			$this->redirect(Configure::read('facebook.oauth_dialg_url') . '?client_id=' . $clientId . '&redirect_uri=' . $redirect . '&scope=' . $permissions . '&state=' . $csrfToken);
		} else {
			$this->redirect('/');
		}
	}

	public function logout() {
		$this->Session->destroy();
		$this->Auth->logout();
		$this->redirect('/');
	}

	public function facebook_logout() {
		$this->autoRender = false;

		$localLogoutUrl = Router::url(array('controller' => 'users', 'action' => 'logout'), true);
		$accessToken = AuthComponent::user('facebook_access_token');
		$facebook = new Facebook(array(
			'appId' => Configure::read('facebook.app_id'),
			'secret' => Configure::read('facebook.app_secret')
		));
		// Redirect user to Facebook logout
		$this->redirect($facebook->getLogoutUrl(array('next' => $localLogoutUrl, 'access_token' => $accessToken)));
	}

	public function collection($user_id) {
		$options = array(
			'contain' => array('Collection' => array('User')),
			'conditions' => array(
				'User.facebook_user_id' => $user_id
		));
		$user = $this->User->find('first', $options);
		
		if ($user) {
			$user_id = $user['User']['id'];
			$this->set('user', $user);
		}

		$options = array(
			'contain' => array('Album' => array('Artist')),
			'conditions' => array(
				'Collection.user_id' => $user_id));

		$albums = $this->Collection->find('all', $options);
		$this->set('albums', $albums);	
	}

	public function wishlist($user_id) {
		$options = array(
			'contain' => array('Collection' => array('User')),
			'conditions' => array(
				'User.facebook_user_id' => $user_id
		));
		$user = $this->User->find('first', $options);

		if ($user) {
			$user_id = $user['User']['id'];
		} else {
			$user_id = $user_id;
		}
		$options = array(
			'contain' => array('Album' => array('Artist')),
			'conditions' => array(
				'Wishlist.user_id' => $user_id
			)
		);

		$albums = $this->Wishlist->find('all', $options);
		$this->set('albums', $albums);
	}

}
?>


