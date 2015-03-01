<?php

App::uses('AppController', 'Controller');

/**
 * Accounts Controller
 *
 * @property Account $Account
 * @property PaginatorComponent $Paginator
 */
class AccountsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');
    public $paginate = array();

    public function drugs($id = null) {
        $account = $this->Account->find('first', array(
            'conditions' => array(
                'Account.id' => $id,
                'Account.member_id' => Configure::read('loginMember.id'),
            ),
        ));
        if (empty($account)) {
            throw new NotFoundException('請依照網頁指示操作');
        } else {
            $orderLines = $this->Account->Order->OrderLine->find('all', array(
                'conditions' => array(
                    'OrderLine.model' => 'License',
                ),
                'order' => array('total' => 'DESC'),
                'fields' => array(
                    'OrderLine.foreign_id', '(SUM(OrderLine.quantity)) AS total',
                    '(COUNT(*)) AS count',
                ),
                'joins' => array(
                    array(
                        'table' => 'orders',
                        'alias' => 'Order',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Order.id = OrderLine.order_id',
                            'Order.account_id' => $id,
                        ),
                    ),
                ),
                'group' => array('OrderLine.foreign_id'),
            ));
            $licenseIds = Set::extract('{n}.OrderLine.foreign_id', $orderLines);
            $licenses = $this->Account->Order->License->find('all', array(
                'conditions' => array('License.id' => $licenseIds),
                'fields' => array('id', 'name', 'disease', 'image'),
            ));
            $licenses = Set::combine($licenses, '{n}.License.id', '{n}.License');
            $drugs = $this->Account->Order->License->Drug->find('list', array(
                'conditions' => array('Drug.license_id' => $licenseIds),
                'fields' => array('license_id', 'id'),
                'group' => array('Drug.license_id'),
            ));
            $this->set('account', $account);
            $this->set('orderLines', $orderLines);
            $this->set('licenses', $licenses);
            $this->set('drugs', $drugs);
            $this->set('url', array($id));
        }
    }

    public function import($id = null) {
        $account = $this->Account->find('first', array(
            'conditions' => array(
                'Account.id' => $id,
                'Account.member_id' => Configure::read('loginMember.id'),
            ),
        ));
        if (empty($account)) {
            throw new NotFoundException('請依照網頁指示操作');
        } else {
            if ($this->request->is('post') && !empty($this->request->data['Account']['file']['size'])) {
                $count = 0;
                switch ($this->request->data['Account']['file']['type']) {
                    case 'application/zip':
                        $zipPath = $this->Account->zipExtract($id, $this->request->data['Account']['file']['tmp_name'], $this->request->data['Account']['password']);
                        $count = $this->Account->importPath($id, $zipPath);
                        break;
                    case 'text/html':
                        $count = $this->Account->importFile($id, $this->request->data['Account']['file']['tmp_name'], true);
                        break;
                }
                $this->Session->setFlash("匯入了 {$count} 筆資料");
                return $this->redirect(array('action' => 'view', $id));
            }
            $options = array('conditions' => array('Account.' . $this->Account->primaryKey => $id));
            $this->set('account', $this->Account->find('first', $options));
        }
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Account->recursive = 0;
        $this->set('accounts', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        $account = $this->Account->find('first', array(
            'conditions' => array(
                'Account.id' => $id,
                'Account.member_id' => Configure::read('loginMember.id'),
            ),
        ));
        if (empty($account)) {
            throw new NotFoundException('請依照網頁指示操作');
        } else {
            $this->paginate['Order'] = array(
                'order' => array('Order.order_date' => 'DESC'),
            );
            $this->set('account', $account);
            $this->set('orders', $this->Paginator->paginate($this->Account->Order, array('Order.account_id' => $id)));
            $this->set('url', array($id));
        }
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->request->data['Account']['member_id'] = Configure::read('loginMember.id');
            $this->Account->create();
            if ($this->Account->save($this->request->data)) {
                $this->Session->setFlash(__('The account has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The account could not be saved. Please, try again.'));
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
        if (!$this->Account->exists($id)) {
            throw new NotFoundException(__('Invalid account'));
        }
        if ($this->request->is(array('post', 'put'))) {
            $this->request->data['Account']['id'] = $id;
            if ($this->Account->save($this->request->data)) {
                $this->Session->setFlash(__('The account has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The account could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Account.' . $this->Account->primaryKey => $id));
            $this->request->data = $this->Account->find('first', $options);
        }
        $members = $this->Account->Member->find('list');
        $this->set(compact('members'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->Account->id = $id;
        if (!$this->Account->exists()) {
            throw new NotFoundException(__('Invalid account'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Account->delete()) {
            $this->Session->setFlash(__('The account has been deleted.'));
        } else {
            $this->Session->setFlash(__('The account could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

}
