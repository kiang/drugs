<?php

App::uses('AppModel', 'Model');

/**
 * Account Model
 *
 * @property Member $Member
 * @property Order $Order
 */
class Account extends AppModel {

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'name' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'gender' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'dob' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Member' => array(
            'className' => 'Member',
            'foreignKey' => 'member_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Order' => array(
            'className' => 'Order',
            'foreignKey' => 'account_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );

    public function beforeDelete($cascade = true) {
        /*
         * to delete related orders/orderlines
         */
        $this->query("DELETE o.*, l.* FROM {$this->Order->table} AS o "
                . "LEFT JOIN {$this->Order->OrderLine->table} AS l ON l.order_id = o.id "
                . "WHERE o.account_id = '{$this->id}'");
        $tmpPath = TMP . 'zip/' . $this->id;
        exec("/bin/rm -Rf {$tmpPath}");
        return parent::beforeDelete($cascade);
    }

    public function zipExtract($id, $zipFile, $password) {
        $tmpPath = TMP . 'zip/' . $id . '/' . date('YmdHis');
        if (!file_exists($tmpPath)) {
            mkdir($tmpPath, 0777, true);
        }
        if (!empty($password)) {
            $password = trim(strtoupper($password));
            copy($zipFile, $tmpPath . '/' . $password . '.zip');
            exec("/usr/bin/unzip -P{$password} {$zipFile} -d {$tmpPath}");
        } else {
            copy($zipFile, $tmpPath . '/orig.zip');
            exec("/usr/bin/unzip {$zipFile} -d {$tmpPath}");
        }
        return $tmpPath;
    }

    public function importPath($id, $path) {
        $count = 0;
        foreach (glob($path . '/*.html') AS $htmlFile) {
            $count += $this->importFile($id, $htmlFile);
        }
        return $count;
    }

    public function importFile($id, $htmlFile, $saveFile = false) {
        if ($saveFile) {
            $tmpPath = TMP . 'zip/' . $id . '/' . date('YmdHis');
            if (!file_exists($tmpPath)) {
                mkdir($tmpPath, 0777, true);
            }
            copy($htmlFile, $tmpPath . '/orig.html');
        }
        $count = 0;
        $html = file_get_contents($htmlFile);
        if (false !== strpos($html, '門診資料')) {
            $lines = explode('</tr>', $html);
            /*
             * example:
             * Array
              (
              [0] => 臺北              //健保署服務單位
              [1] => 江幸蓉皮膚         //醫事機構
              [2] => 103/05/05        //就醫日期
              [3] =>                  //交付調劑、檢查或復健治療日期
              [4] => 0001             //健保卡就醫序號
              [5] => 6908             //疾病分類碼
              [6] => 其他紅斑脫屑皮膚病  //疾病分類名稱
              [7] =>                  //處置碼
              [8] =>                  //處置名稱
              [9] => 50               //部分負擔金額
              [10] => 200             //健保支付點數
              [11] =>
              )
              Array
              (
              [0] =>
              [1] => 00223C            //醫囑代碼
              [2] => 一般門診診察費      //醫囑名稱
              [3] => 1                 //醫囑總量
              [4] =>
              )
             */
            $currentOrderId = false;
            $pointPool = $licensePool = $nhiSortPool = array();
            foreach ($lines AS $line) {
                $line = str_replace('&nbsp;', '', $line);
                $cols = explode('</td>', $line);
                switch (count($cols)) {
                    case 12:
                        foreach ($cols AS $k => $v) {
                            $cols[$k] = trim(strip_tags($v));
                        }
                        if (!isset($pointPool[$cols[1]])) {
                            $pointPool[$cols[1]] = '';
                            $pointList = $this->Order->Point->find('list', array(
                                'fields' => array('id', 'id'),
                                'conditions' => array('name' => $cols[1]),
                            ));
                            if (count($pointList) === 1) {
                                $pointPool[$cols[1]] = array_pop($pointList);
                            }
                        }
                        $orderDate = explode('/', $cols[2]);
                        $nhiYear = $orderDate[0] += 1911;
                        $orderDate = implode('-', $orderDate);
                        $noteDate = explode('/', $cols[3]);
                        if (count($noteDate) === 3) {
                            $noteDate[0] += 1911;
                            $noteDate = implode('-', $noteDate);
                        } else {
                            $noteDate = '';
                        }
                        $nhiSortKey = $nhiYear . $cols[4];
                        if (!isset($nhiSortPool[$nhiSortKey])) {
                            $nhiSortPool[$nhiSortKey] = 1;
                        } else {
                            ++$nhiSortPool[$nhiSortKey];
                        }
                        $this->Order->create();
                        if ($this->Order->save(array('Order' => array(
                                        'account_id' => $id,
                                        'nhi_area' => $cols[0],
                                        'point' => $cols[1],
                                        'point_id' => $pointPool[$cols[1]],
                                        'order_date' => $orderDate,
                                        'note_date' => $noteDate,
                                        'nhi_year' => $nhiYear,
                                        'nhi_sn' => $cols[4],
                                        'nhi_sort' => $nhiSortPool[$nhiSortKey],
                                        'disease_code' => $cols[5],
                                        'disease' => $cols[6],
                                        'process_code' => $cols[7],
                                        'process' => $cols[8],
                                        'money_order' => $cols[9],
                                        'nhi_points' => $cols[10],
                            )))) {
                            ++$count;
                            $currentOrderId = $this->Order->getInsertID();
                        } else {
                            $currentOrderId = false;
                        }
                        break;
                    case 5:
                        foreach ($cols AS $k => $v) {
                            $cols[$k] = trim(strip_tags($v));
                        }
                        if (false !== $currentOrderId) {
                            if (!isset($licensePool[$cols[1]])) {
                                $licensePool[$cols[1]] = $this->Order->License->Price->field('license_id', array(
                                    'nhi_id' => $cols[1],
                                ));
                                if (empty($licensePool[$cols[1]])) {
                                    $licensePool[$cols[1]] = $this->Order->License->field('id', array(
                                        'nhi_id' => $cols[1],
                                    ));
                                }
                            }
                            if (!empty($licensePool[$cols[1]])) {
                                $model = 'License';
                            } else {
                                $model = '';
                            }
                            $this->Order->OrderLine->create();
                            $this->Order->OrderLine->save(array('OrderLine' => array(
                                    'order_id' => $currentOrderId,
                                    'code' => $cols[1],
                                    'note' => $cols[2],
                                    'quantity' => $cols[3],
                                    'model' => $model,
                                    'foreign_id' => $licensePool[$cols[1]],
                            )));
                        }
                        break;
                }
            }
        }
        return $count;
    }

}
