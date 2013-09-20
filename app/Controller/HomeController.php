<?php

class HomeController extends AppController {

	public $helpers = array('Facebook.Facebook');
	public $components = array('Facebook.Connect');
	public $uses = array('User', 'Album', 'Collection', 'Wishlist');

	public function beforeFilter() {
		//$this->Auth->allow('index');
		parent::beforeFilter();
	}

	public function index() {
		$options = array(
			'order' => 'Album.created DESC',
			'limit' => 6,
			'contain' => array('Artist'),
		);
		$latestAlbums = $this->Album->find('all', $options);
		$this->set('latestAlbums', $latestAlbums);
		
		$userId = $this->Connect->user('id');
		$params = array(
			'method' => 'fql.query',
			'query' => "SELECT uid, name, pic FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = $userId)
			AND is_app_user = 1",
		);
		$friends = $this->Connect->FB->api($params);
		$this->set('friends', $friends);
	
		
	}

	public function index2() {
		//Create Queryž
		$userId = $this->Connect->user('id');
		$params = array(
			'method' => 'fql.query',
			'query' => "SELECT uid, name, pic FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = $userId)
			AND is_app_user = 1",
		);
		$friends = $this->Connect->FB->api($params);
		debug($friends);
	}
}

?>
