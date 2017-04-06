<?php

App::uses('AppController', 'Controller');

class ApiAppController extends AppController {

    var $jsonData = array();

    public function beforeFilter() {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        if (isset($this->Auth)) {
            $this->Auth->allow();
        }
    }

    public function beforeRender() {
        if(!isset($this->request->query['pretty'])) {
            echo json_encode($this->jsonData);
        } else {
            echo json_encode($this->jsonData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }
        exit();
    }

}
