<?php

App::uses('AppModel', 'Model');

class Comment extends AppModel {

	public $belongsTo = array(
		'User' => array(
			'counterCache' => true,
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Album' => array(
			'counterCache' => true,
			'className' => 'Album',
			'foreignKey' => 'album_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}

?>
