<?php
App::uses('AppModel', 'Model');
/**
 * Album Model
 *
 * @property Artist $Artist
 */
class Album extends AppModel {

	public $displayField = 'title';

	public $belongsTo = array(
		'Artist' => array(
			'className' => 'Artist',
			'foreignKey' => 'artist_id',
		)
	);
	
	public $hasMany = array(
		'Collection' => array(
			'className' => 'Collection',
			'foreignKey' => 'album_id',
			'dependent' => false,
		),
		'Wishlist' => array(
			'className' => 'Wishlist',
			'foreignKey' => 'album_id',
			'dependent' => false,
		)		
	);
}
