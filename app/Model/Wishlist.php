<?php

class Wishlist extends AppModel {

	public $belongsTo = array(
		'User',
		'Album' => array(
			'className' => 'Album',
			'foreignKey' => 'album_id',
			'dependent' => false,
		)
	);

}

?>
