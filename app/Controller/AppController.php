<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');
App::uses('User', 'Model');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

	public $helpers = array(
		'Html' => array('className' => 'TwitterBootstrap.BootstrapHtml'),
		'Form' => array('className' => 'TwitterBootstrap.BootstrapForm'),
		'Paginator' => array('className' => 'TwitterBootstrap.BootstrapPaginator'),
	);
	
	public $components = array(
		'Session',
		'Auth' => array(
			'loginAction' => array(
				'controller' => 'users',
				'action' => 'login'
			),
			'loginRedirect' => array(
				'controller' => 'users',
				'action' => 'login'
			),
			'authError' => 'Did you really think you are allowed to see that?',
			'authenticate' => array(
				'FacebookAuth.Facebook' => array(
					'fields' => array(
						'username' => 'email',
						'password' => 'password'
					)
				)
			)
		)
	);

	public function isAuthorized() {
		return true;
	}

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->authenticate['FacebookAuth.Facebook']['application'] = array(
			'id' => Configure::read('facebook.app_id'),
			'secret' => Configure::read('facebook.app_secret')
		);
		//$this->Auth->allowedActions = array_merge($this->Auth->allowedActions, array('login'));
	}

}

