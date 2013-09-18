<?php
App::uses('AppController', 'Controller');
/**
 * Artists Controller
 *
 * @property Artist $Artist
 * @property PaginatorComponent $Paginator
 */
class ArtistsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Artist->recursive = 0;
		$this->set('artists', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Artist->exists($id)) {
			throw new NotFoundException(__('Invalid artist'));
		}
		$options = array('conditions' => array('Artist.' . $this->Artist->primaryKey => $id));
		$this->set('artist', $this->Artist->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Artist->create();
			if ($this->Artist->save($this->request->data)) {
				$this->Session->setFlash(__('The artist has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The artist could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Artist->exists($id)) {
			throw new NotFoundException(__('Invalid artist'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Artist->save($this->request->data)) {
				$this->Session->setFlash(__('The artist has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The artist could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Artist.' . $this->Artist->primaryKey => $id));
			$this->request->data = $this->Artist->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Artist->id = $id;
		if (!$this->Artist->exists()) {
			throw new NotFoundException(__('Invalid artist'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Artist->delete()) {
			$this->Session->setFlash(__('The artist has been deleted.'));
		} else {
			$this->Session->setFlash(__('The artist could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
