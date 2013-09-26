<?php

App::uses('AppController', 'Controller');

/**
 * Albums Controller
 *
 * @property Album $Album
 * @property PaginatorComponent $Paginator
 */
class AlbumsController extends AppController {

	public $uses = array('Album', 'Wishlist', 'Artist', 'Comment');

	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array('Paginator');

	/**
	 * index method
	 *
	 * Shows all albums
	 */
	public function index() {
		$this->paginate = array(
			'limit' => 9,
			'order' => 'Album.created DESC',
			'contain' => array('Artist'),
		);
		$this->set('albums', $this->paginate());
	}

	public function search() {
		$keyword = trim($this->request->query('keyword'));
		if (strlen($keyword) < 3) {
			$this->Session->setFlash(
					('Your search has to include at least three chars...'), 'alert', array(
				'plugin' => 'TwitterBootstrap',
				'class' => 'alert-danger'
					)
			);
			$this->redirect($this->request->referer());
		}

		$options = array(
			'contain' => array(
				'Artist'
			),
			'conditions' => array(
				'Album.title LIKE' => '%' . $keyword . '%'
			)
		);

		$albums = $this->Album->find('all', $options);
		$this->set('albums', $albums);

		$options = array(
			'conditions' => array(
				'Artist.title LIKE' => '%' . $keyword . '%'
			)
		);
		$artists = $this->Album->Artist->find('all', $options);
		$this->set('artists', $artists);
	}

	public function addToCollection($albumId) {
		$user_id = $this->Auth->user('id');
		$data['user_id'] = $user_id;
		$data['album_id'] = $albumId;
		$this->Album->Collection->create();
		$this->Album->Collection->save($data);

		$options = array(
			'conditions' => array(
				'Wishlist.user_id' => $user_id,
				'Wishlist.album_id' => $albumId
		));
		$wishlist = $this->Album->Wishlist->find('first', $options);
		if ($wishlist) {
			$this->Album->Wishlist->deleteAll(array(
				'user_id' => $user_id,
				'album_id' => $albumId
			));
		}
		$this->Session->setFlash(
				('Album added to your collection'), 'alert', array(
			'plugin' => 'TwitterBootstrap',
			'class' => 'alert-success'
				)
		);
		$this->redirect($this->request->referer());
	}

	public function deleteFromCollection($albumId) {
		$user_id = $this->Auth->user('id');

		$this->Album->Collection->deleteAll(array(
			'user_id' => $user_id,
			'album_id' => $albumId
		));
		$this->Session->setFlash(
				('Album removed from your collection'), 'alert', array(
			'plugin' => 'TwitterBootstrap',
			'class' => 'alert-success'
				)
		);
		$this->redirect($this->request->referer());
	}

	public function addToWishlist($albumId) {
		$data['user_id'] = $this->Auth->user('id');
		$data['album_id'] = $albumId;
		$this->Album->Wishlist->create();
		$this->Album->Wishlist->save($data);
		$this->Session->setFlash(
				('Album added to your wishlist'), 'alert', array(
			'plugin' => 'TwitterBootstrap',
			'class' => 'alert-success'
				)
		);
		$this->redirect($this->request->referer());
	}

	public function deleteFromWishlist($albumId) {
		$user_id = $this->Auth->user('id');

		$this->Album->Wishlist->deleteAll(array(
			'user_id' => $user_id,
			'album_id' => $albumId
		));
		$this->Session->setFlash(
				('Album removed from your wishlist'), 'alert', array(
			'plugin' => 'TwitterBootstrap',
			'class' => 'alert-success'
				)
		);
		$this->redirect($this->request->referer());
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function view($id) {
		$options = array(
			'conditions' => array(
				'Collection.user_id' => $this->Auth->user('id'),
				'Collection.album_id' => $id
			)
		);
		$coll = $this->Album->Collection->find('all', $options);
		$this->set('coll', $coll);


		$options = array(
			'conditions' => array(
				'Wishlist.user_id' => $this->Auth->user('id'),
				'Wishlist.album_id' => $id
			)
		);
		$wish = $this->Album->Wishlist->find('all', $options);
		$this->set('wish', $wish);




		if (!$this->Album->exists($id)) {
			throw new NotFoundException(__('Invalid album'));
		}
		$options = array(
			'contain' => array('Artist'),
			'conditions' => array('Album.' . $this->Album->primaryKey => $id));
		$album = $this->Album->find('first', $options);
		$this->set('album', $album);

		$options = array(
			'conditions' => array('Album.artist_id' => $album['Album']['artist_id'])
		);
		$relatedAlbums = $this->Album->find('all', $options);
		$this->set('relatedAlbums', $relatedAlbums);


		$this->paginate = array(
			'Comment' => array(
				'conditions' => array(
					'Comment.album_id' => $id),
				'order' => 'Comment.created DESC',
				'contain' => array('User'),
				'limit' => 10
		));
		$comments = $this->paginate('Comment');
		$this->set('comments', $comments);

		if (!$this->request->is('post')) {
			return false;
		}
		if (empty($this->request->data)) {
			$this->Session->setFlash('Niste unijeli komentar');
			return false;
		}
		$this->request->data['Comment']['user_id'] = $this->Auth->user('id');
		$this->request->data['Comment']['album_id'] = $id;
		if ($this->Album->Comment->save($this->request->data)) {
			$this->Session->setFlash(
					('Hvala na komentaru :)'), 'alert', array(
				'plugin' => 'TwitterBootstrap',
				'class' => 'alert-success'
					)
			);
			$this->redirect(array('controller' => 'albums', 'action' => 'view', $id, '#' => 'comments'));
		}
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Album->create();
			if ($this->Album->save($this->request->data)) {
				$this->Session->setFlash(__('The album has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The album could not be saved. Please, try again.'));
			}
		}
		$artists = $this->Album->Artist->find('list');
		$this->set(compact('artists'));
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function edit($id = null) {
		if (!$this->Album->exists($id)) {
			throw new NotFoundException(__('Invalid album'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Album->save($this->request->data)) {
				$this->Session->setFlash(__('The album has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The album could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Album.' . $this->Album->primaryKey => $id));
			$this->request->data = $this->Album->find('first', $options);
		}
		$artists = $this->Album->Artist->find('list');
		$this->set(compact('artists'));
	}

	/**
	 * delete method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function delete($id = null) {
		$this->Album->id = $id;
		if (!$this->Album->exists()) {
			throw new NotFoundException(__('Invalid album'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Album->delete()) {
			$this->Session->setFlash(__('The album has been deleted.'));
		} else {
			$this->Session->setFlash(__('The album could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

}
