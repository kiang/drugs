<?php

App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

class VendorsController extends ApiAppController {

    public $name = 'Vendors';
    public $uses = array('Vendor');
    public $paginate = array();
    public $helpers = array();

    public function index($name = null) {
        $scope = array();
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
        );
        $items = $this->paginate($this->Vendor, $scope);
        $this->jsonData = array(
            'meta' => array(
                'paging' => $this->request->params['paging'],
            ),
            'data' => $items,
        );
    }

    public function view($id = null) {
        if (!empty($id)) {
            $vendor = $this->Vendor->find('first', array(
                'conditions' => array('id' => $id),
            ));
        }
        if (!empty($vendor)) {
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
                            'License.id = Drug.license_uuid',
                        ),
                    ),
                ),
            );
            $items = $this->paginate($this->Vendor->License, array('OR' => array(
                    'License.vendor_id' => $id,
                    'Drug.vendor_id' => $id,
            )));
            $this->jsonData = array(
                'meta' => array(
                    'paging' => $this->request->params['paging'],
                ),
                'data' => $items,
            );
        } else {
            $this->jsonData = array(
                'meta' => array(),
                'data' => array(),
            );
        }
    }

    public function auto() {
        $this->jsonData = array();
        if (!empty($_GET['term'])) {
            $keyword = trim(Sanitize::clean($_GET['term']));
            $items = $this->Vendor->find('all', array(
                'fields' => array('id', 'name'),
                'conditions' => array(
                    'name LIKE' => "%{$keyword}%",
                ),
                'limit' => 20,
            ));
            foreach ($items AS $item) {
                $this->jsonData[] = array(
                    'label' => "{$item['Vendor']['name']}",
                    'value' => $item['Vendor']['id'],
                );
            }
        }
    }

}
