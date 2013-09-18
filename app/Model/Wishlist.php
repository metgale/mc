<?php

class Wishlist extends AppModel {

	public $belongsTo = array(
		'Album' => array(
			'className' => 'Album',
			'foreignKey' => 'album_id',
			'dependent' => false,
		)
	);

}

?>
