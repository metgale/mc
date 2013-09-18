<?php
App::uses('AppModel', 'Model');
/**
 * Artist Model
 *
 * @property Album $Album
 */
class Artist extends AppModel {

	public $displayField = 'title';

	public $hasMany = array(
		'Album' => array(
			'className' => 'Album',
			'foreignKey' => 'artist_id',
			'dependent' => false,
		)
	);

}
