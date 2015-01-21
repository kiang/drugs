<?php

/**
 * Permissible Plugin PermissibleAco Model class
 *
 * Models the ACOs and provides various management functions
 *
 * @package permissible
 * @subpackage permissible.models
 */
class PermissibleAco extends PermissibleAppModel
{
    /**
     * Sets the name for the model
     *
     * @var array
     * @access public
     */
    public $name = 'PermissiableAco';

    /**
     * Sets the table name for the model
     *
     * @var array
     * @access public
     */
    public $useTable = 'acos';

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
     * Recursively saves a complete ACO tree
     *
     * @return null
     * @access public
     */
    public function completeTreeSave($tree, $parent_id = null)
    {
        if ($parent_id === null) {
            $this->truncate();
        }
        foreach ($tree as $aro => $tre) {
            $this->create();
            $this->save(array(
                'parent_id' => $parent_id,
                'alias' => $aro
            ));
            if (is_array($tre)) {
                $this->completeTreeSave($tre, $this->id);
            }
        }
    }

    /**
     * Recursively updates the ACO tree
     *
     * @return null
     * @access public
     */
    public function completeTreeUpdate($tree, $parent_id = null)
    {
        if (!is_array($tree)) {
            return;
        }
        $keys = array_keys($tree);
        sort($keys);
        $children = $this->find('list', array(
            'conditions' => array(
                'PermissibleAco.parent_id' => $parent_id
            ),
            'fields' => array(
                'PermissibleAco.alias'
            )
                ));
        sort($children);
        $same = ($children === $keys);
        $children = $this->find('list', array(
            'conditions' => array(
                'PermissibleAco.parent_id' => $parent_id
            ),
            'fields' => array(
                'PermissibleAco.alias'
            )
                ));
        if ($same) {
            foreach ($children as $id => $alias) {
                $this->completeTreeUpdate($tree[$alias], $id);
            }
        } else {
            foreach ($children as $id => $child) {
                if (!in_array($child, $keys)) {
                    $this->delete($id);
                    unset($children[$id]);
                }
            }
            foreach ($keys as $key) {
                if (!in_array($key, $children)) {
                    $this->create();
                    $this->save(array(
                        'PermissibleAco' => array(
                            'parent_id' => $parent_id,
                            'alias' => $key
                        )
                    ));
                }
            }
        }
    }

    /**
     * Automates finding of ARO aliases where possible
     *
     * @return array Results
     * @access public
     */
    public function afterFind($results, $primary)
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
     * Generates a list of ACOs
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
     * Generates a list of ACOs and whether an ARO can access them
     *
     * @return array List
     * @access public
     */
    public function generateListPerms($Acl, $aro_alias, $aco_alias = array(), $parent = null)
    {
        $temp = $this->generateTreeList(array(
            'parent_id' => $parent
                ), null, null, null, 1);
        $ret = array();
        foreach ($temp as $id => $name) {
            $this->id = $id;
            $item = $this->read();
            $aliases = $aco_alias;
            $aliases[] = $item[$this->alias]['alias'];
            $alias = implode('/', $aliases);
            $item[$this->alias]['allowed'] = $Acl->check($aro_alias, $alias);
            $item[$this->alias]['full_alias'] = $alias;
            $next = $this->generateListPerms($Acl, $aro_alias, $aliases, $id);
            if ($next !== array()) {
                $item[$this->alias]['sub-menu'] = $next;
            }
            $ret[] = $item[$this->alias];
        }

        return $ret;
    }

    /**
     * Wipes then resets the ACO tree
     *
     * @return boolean ACO/ARO tree valid
     * @access public
     */
    public function reset()
    {
        $this->completeTreeSave($this->getCompleteTree());
        $Aro = ClassRegistry::init('Permissible.PermissibleAro');
        $aro = $Aro->find('first', array(
            'conditions' => array(
                'PermissibleAro.parent_id' => null,
                'PermissibleAro.alias' => 'everyone'
            )
                ));

        return ($aro !== false);
    }

    /**
     * Refreshes the ACO tree
     *
     * @return null
     * @access public
     */
    public function refresh()
    {
        $this->completeTreeUpdate($this->getCompleteTree());
    }

    /**
     * Gets a complete list of plugins/controllers/actions
     *
     * @return array List
     * @access public
     */
    public function getCompleteTree()
    {
        App::uses('Folder', 'Utility');
        $acos = array(
            'app' => array()
        );
        $cont_fold = new Folder(APP . 'Controller' . DS);
        $controllers = $cont_fold->read();
        $app_cont = new AppController();
        $app_cont = get_class_methods($app_cont);
        foreach ($controllers[1] as $file) {
            if (substr($file, -14) === 'Controller.php') {
                $cont = Inflector::camelize(substr($file, 0, -4));
                $controllerName = substr($cont, 0, -10);
                if ($controllerName === 'App') {
                    continue;
                } else {
                    if (App::import('Controller', $controllerName)) {
                        $cont_clas = new $cont();
                        $methods = array_diff(get_class_methods($cont_clas), $app_cont);
                        foreach ($methods as $key => $method) {
                            if (substr($method, 0, 1) === '_') {
                                unset($methods[$key]);
                            }
                        }
                        sort($methods);
                        $acos['app'][Inflector::camelize(substr($cont, 0, -10))] = array_flip($methods);
                    }
                }
            }
        }
        foreach (App::objects('plugin') as $plugin) {
            $folder = new Folder(App::pluginPath($plugin) . 'Controller/');
            $controllers = $folder->read();
            if ($controllers[1] !== array() && App::import('Controller', $plugin . '.' . $plugin . 'App')) {
                $plug_cont = $plugin . 'AppController';
                $plug_cont = new $plug_cont();
                $plug_cont = get_class_methods($plug_cont);
                foreach ($controllers[1] as $file) {
                    if (substr($file, -14) === 'Controller.php') {
                        $cont = Inflector::camelize(substr($file, 0, -4));
                        if (App::import('Controller', $plugin . '.' . substr($cont, 0, -10))) {
                            $cont_clas = new $cont();
                            $methods = array_diff(get_class_methods($cont_clas), $plug_cont);
                            foreach ($methods as $key => $method) {
                                if (substr($method, 0, 1) === '_') {
                                    unset($methods[$key]);
                                }
                            }
                            sort($methods);
                            $acos['app'][Inflector::camelize($plugin)][Inflector::camelize(substr($cont, 0, -10))] = array_flip($methods);
                        }
                    }
                }
            }
        }

        return $acos;
    }

}
