<?php

App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

class VendorsController extends AppController {

    public $name = 'Vendors';
    public $uses = array('Vendor');
    public $paginate = array();
    public $helpers = array();

    public function beforeFilter() {
        parent::beforeFilter();
        if (isset($this->Auth)) {
            $this->Auth->allow('index', 'view');
        }
    }

    public function beforeRender() {
        $path = "/api/{$this->request->params['controller']}/{$this->request->params['action']}";
        if (!empty($this->request->params['pass'][0])) {
            $path .= '/' . $this->request->params['pass'][0];
        }
        if (!empty($this->request->params['named'])) {
            foreach ($this->request->params['named'] AS $k => $v) {
                if ($k !== 'page') {
                    $path .= "/{$k}:{$v}";
                }
            }
        }
        if (!empty($this->request->params['paging']['Vendor']['page'])) {
            $path .= '/page:' . $this->request->params['paging']['Vendor']['page'];
        } elseif (!empty($this->request->params['paging']['License']['page'])) {
            $path .= '/page:' . $this->request->params['paging']['License']['page'];
        }
        $this->set('apiRoute', $path);
    }

    public function index($name = null) {
        $cPage = isset($this->request->params['named']['page']) ? $this->request->params['named']['page'] : '1';
        $cacheKey = "VendorsIndex{$name}{$cPage}";
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
                            'Vendor.name LIKE' => "%{$keyword}%",
                            'Vendor.address LIKE' => "%{$keyword}%",
                            'Vendor.address_office LIKE' => "%{$keyword}%",
                            'Vendor.country LIKE' => "%{$keyword}%",
                            'Vendor.tax_id' => "{$keyword}",
                        );
                    }
                }
            }
            $this->paginate['Vendor'] = array(
                'limit' => 20,
                'order' => array(
                    'Vendor.count_daily' => 'DESC',
                    'Vendor.count_all' => 'DESC',
                ),
            );

            $result['items'] = $this->paginate($this->Vendor, $scope);
            $result['paging'] = $this->request->params['paging'];
            Cache::write($cacheKey, $result, 'long');
        } else {
            $this->request->params['paging'] = $result['paging'];
        }


        $this->set('url', array($name));
        $title = '';
        if (!empty($name)) {
            $title = "{$name} 相關";
        }
        $this->set('title_for_layout', $title . '藥品廠商一覽 @ ');
        $this->set('items', $result['items']);
        $this->set('keyword', $name);
    }

    public function view($id = null) {
        if (!empty($id)) {
            $vendor = $this->Vendor->find('first', array(
                'conditions' => array('id' => $id),
                'contain' => array(
                    'Article' => array(
                        'fields' => array('id', 'title', 'date_published', 'url'),
                        'order' => array('date_published' => 'DESC'),
                        'limit' => 10,
                    ),
                ),
            ));
        }
        if (!empty($vendor)) {
            $this->Vendor->counterIncrement($id);

            $this->set('vendor', $vendor);
            $this->paginate['License'] = array(
                'fields' => array(
                    'License.*', 'Drug.id'
                ),
                'limit' => 20,
                'joins' => array(
                    array(
                        'table' => 'drugs',
                        'alias' => 'Drug',
                        'type' => 'INNER',
                        'conditions' => array(
                            'License.id = Drug.license_id',
                        ),
                    ),
                ),
            );
            $this->set('title_for_layout', "{$vendor['Vendor']['name']} 相關藥物 @ ");
            $this->set('items', $this->paginate($this->Vendor->License, array('OR' => array(
                            'License.vendor_id' => $id,
                            'Drug.vendor_id' => $id,
            ))));
            $this->set('url', array($id));
        } else {
            $this->redirect(array('action' => 'index'));
        }
    }

}
