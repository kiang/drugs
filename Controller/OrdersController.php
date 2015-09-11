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
    public $paginate = array();

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
        $orderLines = $this->Order->OrderLine->find('all', array(
            'conditions' => array('OrderLine.order_id' => $id),
            'order' => array('OrderLine.code' => 'ASC'),
        ));
        $licenseIds = array();
        foreach ($orderLines AS $orderLine) {
            if ($orderLine['OrderLine']['model'] === 'License') {
                $licenseIds[] = $orderLine['OrderLine']['foreign_id'];
            }
        }
        $this->set('order', $order);
        $this->set('orderLines', $orderLines);
        $this->set('drugs', $this->Order->License->Drug->find('list', array(
                    'fields' => array('license_id', 'id'),
                    'conditions' => array(
                        'license_id' => $licenseIds,
                    ),
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
            $this->request->data['Order']['id'] = $id;
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
        $accountId = $this->Order->field('account_id');
        if (empty($accountId)) {
            throw new NotFoundException(__('Invalid order'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Order->delete()) {
            $this->Session->setFlash(__('The order has been deleted.'));
        } else {
            $this->Session->setFlash(__('The order could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('controller' => 'accounts', 'action' => 'view', $accountId));
    }

}
