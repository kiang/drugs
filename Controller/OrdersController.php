<?php

App::uses('AppController', 'Controller');

/**
 * Orders Controller
 *
 * @property Order $Order
 * @property PaginatorComponent $Paginator
 */
class OrdersController extends AppController {

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
        $this->Order->recursive = 0;
        $this->set('orders', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        $order = $this->Order->find('first', array(
            'conditions' => array(
                'Order.id' => $id,
                'Account.member_id' => Configure::read('loginMember.id'),
            ),
            'contain' => array('Account'),
        ));
        if (empty($order)) {
            throw new NotFoundException(__('Invalid order'));
        }
        $this->set('order', $order);
        $this->set('orderLines', $this->Order->OrderLine->find('all', array(
                    'conditions' => array('OrderLine.order_id' => $id),
        )));
        $this->set('url', array($id));
    }

    /**
     * add method
     *
     * @throws NotFoundException
     * @param string $accountId
     * @return void
     */
    public function add($accountId = null) {
        $account = $this->Order->Account->find('first', array(
            'conditions' => array(
                'id' => $accountId,
                'member_id' => Configure::read('loginMember.id'),
            ),
        ));
        if (empty($account)) {
            throw new NotFoundException(__('Invalid order'));
        }
        if ($this->request->is('post')) {
            $this->request->data['Order']['account_id'] = $accountId;
            $this->Order->create();
            if ($this->Order->save($this->request->data)) {
                $this->Session->setFlash(__('The order has been saved.'));
                return $this->redirect(array('action' => 'view', $this->Order->getInsertID()));
            } else {
                $this->Session->setFlash(__('The order could not be saved. Please, try again.'));
            }
        }
        $this->set('account', $account);
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        $order = $this->Order->find('first', array(
            'conditions' => array(
                'Order.id' => $id,
                'Account.member_id' => Configure::read('loginMember.id'),
            ),
            'contain' => array('Account'),
        ));
        if (empty($order)) {
            throw new NotFoundException(__('Invalid order'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Order->save($this->request->data)) {
                $this->Session->setFlash(__('The order has been saved.'));
                return $this->redirect(array('action' => 'view', $id));
            } else {
                $this->Session->setFlash(__('The order could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $order;
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
        $this->Order->id = $id;
        if (!$this->Order->exists()) {
            throw new NotFoundException(__('Invalid order'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Order->delete()) {
            $this->Session->setFlash(__('The order has been deleted.'));
        } else {
            $this->Session->setFlash(__('The order could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

}
