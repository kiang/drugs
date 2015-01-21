<?php
/**
 * Permissible Plugin PermissibleAro Model class
 *
 * Models the AROs and provides various management functions
 *
 * @package permissible
 * @subpackage permissible.models
 */
class PermissibleAro extends PermissibleAppModel
{
/**
 * Sets the name for the modelafterFind
 *
 * @var array
 * @access public
 */
    public $name = 'PermissibleAro';
/**
 * Sets the table name for the model
 *
 * @var array
 * @access public
 */
    public $useTable = 'aros';
/**
 * Array containing the names of behaviours this model uses
 *
 * @var array
 * @access public
 */
    public $actsAs = array('Tree');
/**
 * Sets the model to cache queries for optimisation
 *
 * @var array
 * @access public
 */
    public $cacheQueries = true;
/**
 * Automates finding of ACO aliases where possible
 *
 * @return array Results
 * @access public
 */
    public function afterFind($results, $primary = false)
    {
        foreach ($results as $key => $result) {
            if (!isset($result[$this->alias]['alias']) && isset($result[$this->alias]['model'])) {
                $model = ClassRegistry::init($result[$this->alias]['model']);
                $model->id = $result[$this->alias]['foreign_key'];
                switch ($result[$this->alias]['model']) {
                    case Configure::read('Permissible.UserModelAlias'):
                        $user = ClassRegistry::init(Configure::read('Permissible.UserModel'));
                        $alias = $model->read($user->displayField);
                        $alias = $alias[Configure::read('Permissible.UserModelAlias')][$user->displayField];
                        break;
                    case Configure::read('Permissible.GroupModelAlias'):
                        $group = ClassRegistry::init(Configure::read('Permissible.GroupModel'));
                        $alias = $model->read($group->displayField);
                        $alias = $alias[Configure::read('Permissible.GroupModelAlias')][$group->displayField];
                        break;
                }
                $this->save(array(
                    $this->alias => array(
                        'id' => $result[$this->alias]['id'],
                        'alias' => $alias
                    )
                ));
                $results[$key][$this->alias]['alias'] = $alias;
            }
        }

        return $results;
    }
/**
 * Generates a list of AROs
 *
 * @return array List
 * @access public
 */
    public function generateList($parent = null)
    {
        $temp = $this->generateTreeList(array(
            'parent_id' => $parent
        ), null, null, null, 1);
        $ret = array();
        foreach ($temp as $id => $name) {
            $this->id = $id;
            $item = $this->read();
            $next = $this->generateList($id);
            if ($next !== array()) {
                $item[$this->alias]['sub-menu'] = $next;
            }
            $ret[] = $item[$this->alias];
        }

        return $ret;
    }
/**
 * Generates a list of AROs and whether an ACO can access them
 *
 * @return array List
 * @access public
 */
    public function generateListPerms($Acl, $aco_alias, $aro_alias = array(), $parent = null)
    {
        $temp = $this->generateTreeList(array(
            'parent_id' => $parent
        ), null, null, null, 1);
        $ret = array();
        foreach ($temp as $id => $name) {
            $this->id = $id;
            $item = $this->read();
            $aliases = $aro_alias;
            $aliases[] = $item[$this->alias]['alias'];
            $alias = implode('/', $aliases);
            $item[$this->alias]['allowed'] = $Acl->check($alias, $aco_alias);
            $item[$this->alias]['full_alias'] = $alias;
            $next = $this->generateListPerms($Acl, $aco_alias, $aliases, $id);
            if ($next !== array()) {
                $item[$this->alias]['sub-menu'] = $next;
            }
            $ret[] = $item[$this->alias];
        }

        return $ret;
    }
/**
 * Wipes then resets the ARO tree
 *
 * @return boolean ACO/ARO tree valid
 * @access public
 */
    public function reset()
    {
        $this->truncate();
        $this->save(array(
            'PermissibleAro' => array(
                'alias' => 'everyone'
            )
        ));
        $model_id = $this->id;
        $groupModel = ClassRegistry::init(Configure::read('Permissible.GroupModel'));
        $groupName = Configure::read('Permissible.GroupModelAlias');
        $userModel = ClassRegistry::init(Configure::read('Permissible.UserModel'));
        $userName = Configure::read('Permissible.UserModelAlias');
        $groups = $groupModel->find('list', array(
            'fields' => array(
                $groupName . '.' . $groupModel->primaryKey,
                $groupName . '.' . $groupModel->displayField
            )
        ));
        $this->create();
        $this->save(array(
            'PermissibleAro' => array(
                'parent_id' => $model_id,
                'model' => $userName,
                'alias' => 'unknown',
                'foreign_key' => 0
            )
        ));
        foreach ($groups as $id => $group) {
            $this->create();
            $this->save(array(
                'PermissibleAro' => array(
                    'parent_id' => $model_id,
                    'model' => $groupName,
                    'alias' => $groupName . $id,
                    'foreign_key' => $id
                )
            ));
            $group_id = $this->id;
            $users = $userModel->find('list', array(
                'fields' => array(
                    $userName . '.' . $userModel->primaryKey,
                    $userName . '.' . $userModel->displayField
                ),
                'conditions' => array(
                    $userName . '.' . Configure::read('Permissible.GroupForeignKey') => $id
                )
            ));
            foreach ($users as $id => $user) {
                $this->create();
                $this->save(array(
                    'PermissibleAro' => array(
                        'parent_id' => $group_id,
                        'model' => $userName,
                        'alias' => $userName . $id,
                        'foreign_key' => $id
                    )
                ));
            }
        }
        $AroAco = ClassRegistry::init('Permissible.PermissibleAroAco');
        $AroAco->truncate();
        $Aco = ClassRegistry::init('Permissible.PermissibleAco');
        $aco = $Aco->find('first', array(
            'conditions' => array(
                'PermissibleAco.parent_id' => null,
                'PermissibleAco.alias' => 'app'
            )
        ));

        return ($aco !== false);
    }
/**
 * Refreshes the ARO tree
 *
 * @return boolean ACO/ARO tree valid
 * @access public
 */
    public function refresh()
    {
        $aros = $this->find('all', array(
            'conditions' => array(
                'PermissibleAro.model !=' => null,
                'PermissibleAro.foreign_key !=' => 0
            )
        ));
        $models = array();
        foreach ($aros as $aro) {
            if (!isset($models[$aro['PermissibleAro']['model']])) {
                $models[$aro['PermissibleAro']['model']] = ClassRegistry::init($aro['PermissibleAro']['model']);
            }
            $model = $models[$aro['PermissibleAro']['model']];
            $model->id = $aro['PermissibleAro']['foreign_key'];
            if ($model->read() === false) {
                $this->delete($aro['PermissibleAro']['id']);
            }
        }
        $top = $this->find('first', array(
            'conditions' => array(
                'PermissibleAro.alias' => 'everyone',
                'PermissibleAro.parent_id' => null
            )
        ));
        if ($top === false) {
            return ;
        }
        $top_id = $top['PermissibleAro']['id'];
        $groupModel = ClassRegistry::init(Configure::read('Permissible.GroupModel'));
        $groupName = Configure::read('Permissible.GroupModelAlias');
        $userModel = ClassRegistry::init(Configure::read('Permissible.UserModel'));
        $userName = Configure::read('Permissible.UserModelAlias');
        $groups = $groupModel->find('list');
        foreach ($groups as $id => $group) {
            $aro = $this->find('first', array(
                'conditions' => array(
                    'PermissibleAro.model' => $groupName,
                    'PermissibleAro.foreign_key' => $id
                )
            ));
            if ($aro === false) {
                $this->create();
                $this->save(array(
                    'PermissibleAro' => array(
                        'parent_id' => $top_id,
                        'model' => $groupName,
                        'foreign_key' => $id,
                        'alias' => $groupName . $id,
                    )
                ));
                $aro = $this->read();
            }
            $group_id = $aro['PermissibleAro']['foreign_key'];
            $users = $userModel->find('list', array(
                'conditions' => array(
                    $userName . '.' . Configure::read('Permissible.GroupForeignKey') => $id
                )
            ));
            foreach ($users as $id => $user) {
                if ($this->find('first', array(
                    'conditions' => array(
                        'PermissibleAro.model' => $userName,
                        'PermissibleAro.foreign_key' => $id,
                        'PermissibleAro.parent_id' => $group_id
                    )
                )) === false) {
                    $this->create();
                    $this->save(array(
                        'PermissibleAro' => array(
                            'parent_id' => $group_id,
                            'model' => $userName,
                            'foreign_key' => $id,
                            'alias' => $userName . $id,
                        )
                    ));
                }
            }
        }

        return ;
    }
}
