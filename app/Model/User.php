<?php



/**
 * User model
 */
class User extends AppModel {

	 public $hasMany = array(
		'Artist',
		'Album',
		'Wishlist',
		'Collection',
        'Comment' => array(
            'className' => 'Comment',
            'foreignKey' => 'user_id',
            'dependent' => false));
}