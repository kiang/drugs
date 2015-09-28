<?php

App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

class PointsController extends ApiAppController {

    public $name = 'Points';
    public $uses = array('Point');
    public $paginate = array();
    public $helpers = array();

    public function index($name = null) {
        $cPage = isset($this->request->params['named']['page']) ? $this->request->params['named']['page'] : '1';
        $cacheKey = "PointsIndex{$name}{$cPage}";
        $result = Cache::read($cacheKey, 'long');
        if (!$result) {
            $result = $scope = array();
            if (!empty($name)) {
                $name = Sanitize::clean($name);
                $keywords = explode(' ', $name);
                $keywordCount = 0;
                foreach ($keywords AS $keyword) {
                    if (++$keywordCount < 5) {
                        $scope[]['OR'] = array(
                            'Point.name LIKE' => "%{$keyword}%",
                            'Point.category LIKE' => "%{$keyword}%",
                            'Point.city LIKE' => "%{$keyword}%",
                            'Point.town LIKE' => "%{$keyword}%",
                            'Point.phone LIKE' => "%{$keyword}%",
                            'Point.nhi_id' => $keyword,
                        );
                    }
                }
            }
            $this->paginate['Point'] = array(
                'limit' => 20,
            );

            $result['items'] = $this->paginate($this->Point, $scope);
            $result['paging'] = $this->request->params['paging'];
            Cache::write($cacheKey, $result, 'long');
        } else {
            $this->request->params['paging'] = $result['paging'];
        }
        $this->jsonData = array(
            'meta' => array(
                'paging' => $this->request->params['paging'],
            ),
            'data' => $result['items'],
        );
    }

    public function view($id = null) {
        if (!empty($id)) {
            $this->jsonData = $this->Point->find('first', array(
                'conditions' => array('id' => $id),
            ));
        }
    }

    public function auto() {
        $this->jsonData = array();
        if (!empty($_GET['term'])) {
            $keyword = trim(Sanitize::clean($_GET['term']));
            $items = $this->Point->find('all', array(
                'fields' => array('id', 'nhi_id', 'name', 'city', 'town',
                    'address', 'phone'),
                'conditions' => array(
                    'OR' => array(
                        'name LIKE' => "%{$keyword}%",
                        'nhi_id LIKE' => "%{$keyword}%",
                    ),
                ),
                'limit' => 20,
            ));
            foreach ($items AS $item) {
                $this->jsonData[] = array(
                    'label' => "[{$item['Point']['nhi_id']}]{$item['Point']['name']} @ {$item['Point']['city']}{$item['Point']['town']}",
                    'value' => $item['Point']['id'],
                    'name' => $item['Point']['name'],
                    'nhi_id' => $item['Point']['nhi_id'],
                    'city' => $item['Point']['city'],
                    'town' => $item['Point']['town'],
                    'address' => $item['Point']['address'],
                    'phone' => $item['Point']['phone'],
                );
            }
        }
    }

}
