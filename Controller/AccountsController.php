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
                        $zipPath = $this->Account->zipExtract($this->request->data['Account']['file']['tmp_name'], $this->request->data['Account']['password']);
                        $count = $this->Account->importPath($id, $zipPath);
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
            $options = array('conditions' => array('Account.' . $this->Account->primaryKey => $id));
            $this->set('account', $this->Account->find('first', $options));
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
