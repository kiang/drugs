<?php
App::uses('AppController', 'Controller');
/**
 * OrderLines Controller
 *
 * @property OrderLine $OrderLine
 * @property PaginatorComponent $Paginator
 */
class OrderLinesController extends AppController {

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
		$this->OrderLine->recursive = 0;
		$this->set('orderLines', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->OrderLine->exists($id)) {
			throw new NotFoundException(__('Invalid order line'));
		}
		$options = array('conditions' => array('OrderLine.' . $this->OrderLine->primaryKey => $id));
		$this->set('orderLine', $this->OrderLine->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->OrderLine->create();
			if ($this->OrderLine->save($this->request->data)) {
				$this->Session->setFlash(__('The order line has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The order line could not be saved. Please, try again.'));
			}
		}
		$orders = $this->OrderLine->Order->find('list');
		$this->set(compact('orders'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->OrderLine->exists($id)) {
			throw new NotFoundException(__('Invalid order line'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->OrderLine->save($this->request->data)) {
				$this->Session->setFlash(__('The order line has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The order line could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('OrderLine.' . $this->OrderLine->primaryKey => $id));
			$this->request->data = $this->OrderLine->find('first', $options);
		}
		$orders = $this->OrderLine->Order->find('list');
		$this->set(compact('orders'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->OrderLine->id = $id;
		if (!$this->OrderLine->exists()) {
			throw new NotFoundException(__('Invalid order line'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->OrderLine->delete()) {
			$this->Session->setFlash(__('The order line has been deleted.'));
		} else {
			$this->Session->setFlash(__('The order line could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
