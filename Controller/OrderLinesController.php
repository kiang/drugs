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
     * add method
     *
     * @throws NotFoundException
     * @param string $orderId
     * @return void
     */
    public function add($orderId = null) {
        $order = $this->OrderLine->Order->find('first', array(
            'conditions' => array(
                'Order.id' => $orderId,
                'Account.member_id' => Configure::read('loginMember.id'),
            ),
            'contain' => array('Account'),
        ));
        if (empty($order)) {
            throw new NotFoundException(__('Invalid order'));
        }
        if ($this->request->is('post')) {
            $this->request->data['OrderLine']['order_id'] = $orderId;
            $this->OrderLine->create();
            if ($this->OrderLine->save($this->request->data)) {
                $this->Session->setFlash(__('The order line has been saved.'));
                return $this->redirect(array('controller' => 'orders', 'action' => 'view', $orderId));
            } else {
                $this->Session->setFlash(__('The order line could not be saved. Please, try again.'));
            }
        }
        $this->set('order', $order);
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $orderId = $this->OrderLine->field('order_id', array('id' => $id));
        if (empty($orderId)) {
            throw new NotFoundException(__('Invalid order line'));
        }
        $this->OrderLine->id = $id;
        $this->request->allowMethod('post', 'delete');
        if ($this->OrderLine->delete()) {
            $this->Session->setFlash(__('The order line has been deleted.'));
        } else {
            $this->Session->setFlash(__('The order line could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('controller' => 'orders', 'action' => 'view', $orderId));
    }

}
