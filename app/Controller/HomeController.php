<?php

class HomeController extends AppController {

	public $uses = array('User', 'Album', 'Collection', 'Wishlist');

	public function beforeFilter() {

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
		
		$facebook = new Facebook(array(
			'appId' => Configure::read('facebook.app_id'),
			'secret' => Configure::read('facebook.app_secret')
		));

		$userId = $this->Auth->user('facebook_user_id');
		$userToken = $this->Auth->user('facebook_access_token');
		$params = array(
			'access_token' => $userToken,
			'method' => 'fql.query',
			'query' => "SELECT uid, name, pic FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = $userId)
		AND is_app_user = 1",
		);

		try {
			$friends = $facebook->api($params);
		} catch (FacebookApiException $e) {

			throw $e;
		}
		$this->set('friends', $friends);
	}
}

?>
