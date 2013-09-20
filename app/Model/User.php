<?php



/**
 * User model
 */
class User extends AppModel {
	public $primaryKey = 'facebook_id'; 
	
	 public $hasMany = array(
        'Comment' => array(
            'className' => 'Comment',
            'foreignKey' => 'user_id',
            'dependent' => false));
}