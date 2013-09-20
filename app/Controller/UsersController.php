<?php

class UsersController extends AppController {

	public $helpers = array('Facebook.Facebook');
	public $components = array('Facebook.Connect');
	public $uses = array('User', 'Album', 'Collection', 'Wishlist', 'Artist');

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
		$this->redirect('/users/index');
	}

	public function index($user_id) {
		if ($user_id) {
			$options = array(
				'limit' => 10,
				'contain' => array('Album' => array('Artist')),
				'conditions' => array(
					'Collection.facebook_id' => $user_id)
			);
		}else{
			$options = array(
			'limit' => 10,
			'contain' => array('Album' => array('Artist')),
			'conditions' => array(
				'Collection.facebook_id' => $this->Connect->user('id')));
		}
		



		$albums = $this->Collection->find('all', $options);
		$this->set('albums', $albums);

		$options = array(
			'limit' => 10,
			'contain' => array('Album' => array('Artist')),
			'conditions' => array(
				'Wishlist.facebook_id' => $this->Connect->user('id'))
		);
		$wishAlbums = $this->Wishlist->find('all', $options);
		$this->set('wishAlbums', $wishAlbums);
	}

}

?>
