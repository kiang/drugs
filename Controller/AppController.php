<?php

App::uses('Controller', 'Controller');

class AppController extends Controller {

    public $helpers = array('Html', 'Form', 'Js', 'Session');
    public $components = array('Acl', 'Auth', 'RequestHandler', 'Session');

    public function beforeFilter() {
        if (isset($this->Auth)) {
            $this->Auth->authenticate = array(
                'Form' => array(
                    'userModel' => 'Member',
                    'scope' => array('Member.user_status' => 'Y'),
                )
            );
            $this->Auth->loginAction = '/members/login';
            $this->Auth->loginRedirect = '/';
            $this->Auth->authorize = array(
                'Actions' => array(
                    'userModel' => 'Member',
                )
            );
        }
        $this->loginMember = $this->Session->read('Auth.User');
        if (empty($this->loginMember)) {
            $this->loginMember = array(
                'id' => 0,
                'group_id' => 0,
                'username' => '',
            );
        }
        Configure::write('loginMember', $this->loginMember);
    }

}
