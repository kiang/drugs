<?php
/**
 * Permissible Plugin Acos Controller class
 *
 * Provides the basics for controlling ACOs
 *
 * @package permissible
 * @subpackage permissible.controllers
 */
class AcosController extends PermissibleAppController
{
/**
 * Name of the controller
 *
 * @var string
 * @access public
 */
    public $name = 'Acos';
/**
 * Name of model used by the controller
 *
 * @var array
 * @access public
 */
    public $uses = array('Permissible.PermissibleAco');
/**
 * Index for ACOs - list all acos to be selected for management
 *
 * @return null
 * @access public
 */
    public function index()
    {
        $this->set('acos', $this->PermissibleAco->generateList());
    }
/**
 * Refresh the ACO list
 *
 * @return null
 * @access public
 */
    public function refresh()
    {
        $this->PermissibleAco->refresh();
        $this->Session->setFlash('The ACO list has been refreshed');
        $this->redirect(array('plugin' => 'permissible', 'controller' => 'acos', 'action' => 'index'));
    }
/**
 * Reset the ACO list
 *
 * @return null
 * @access public
 */
    public function reset()
    {
        if ($this->PermissibleAco->reset()) {
            $this->Acl->deny('everyone', 'app');
        }
        $this->Session->setFlash('The ACO list has been reset');
        $this->redirect(array('plugin' => 'permissible', 'controller' => 'acos', 'action' => 'index'));
    }
/**
 * Provides a form to manage the selected ACO, and changes permissions as required
 *
 * @return null
 * @access public
 */
    public function manage($id = null)
    {
        $this->PermissibleAco->id = $id;
        $aco = $this->PermissibleAco->read();
        if ($aco === false) {
            $this->redirect(array('plugin' => 'permissible', 'controller' => 'acos', 'action' => 'index'));
        }
        $this->set('aco', $aco);
        $alias = $aco['PermissibleAco']['alias'];
        while ($aco['PermissibleAco']['parent_id'] !== null) {
           $aco = $this->PermissibleAco->getparentnode();
           $this->PermissibleAco->id = $aco['PermissibleAco']['id'];
           $alias = $aco['PermissibleAco']['alias'] . '/' . $alias;
        }
        if (!empty($this->request->data)) {
            $cascade = (isset($this->request->data['PermissibleAco']['cascade']) && $this->request->data['PermissibleAco']['cascade'] === '1');
            unset($this->request->data['PermissibleAco']['cascade']);
            foreach ($this->request->data['PermissibleAco'] as $aro_alias => $perm) {
                $perm = ((int) $perm === 1);
                if ($perm) {
                    if ($cascade) {
                        $this->_multiAllow($aro_alias, $alias);
                    } elseif (!$this->Acl->check($aro_alias, $alias)) {
                        $this->Acl->allow($aro_alias, $alias);
                    }
                } else {
                    if ($cascade) {
                        $this->_multiDeny($aro_alias, $alias);
                    } elseif ($this->Acl->check($aro_alias, $alias)) {
                        $this->Acl->deny($aro_alias, $alias);
                    }
                }
            }
            $this->Session->setFlash('The permissions list has been updated');
            $this->request->data = array();
        }
        $this->set('alias', $alias);
        $this->loadModel('Permissible.PermissibleAro');
        $this->set('aros', $this->PermissibleAro->generateListPerms($this->Acl, $alias));
    }
/**
 * Used when permissions are cascading - allows the current level and cascades to lower ACOs
 *
 * @return null
 * @access protected
 */
    public function _multiAllow($aro, $aco)
    {
        $this->Acl->allow($aro, $aco);
        $aco_info = $this->Acl->Aco->node($aco);
        $this->PermissibleAco->id = $aco_info[0]['Aco']['id'];
        foreach ($this->PermissibleAco->children() as $child) {
            $this->_multiAllow($aro, $aco . '/' . $child['PermissibleAco']['alias']);
        }
    }
/**
 * Used when permissions are cascading - denies the current level and cascades to lower ACOs
 *
 * @return null
 * @access protected
 */
    public function _multiDeny($aro, $aco)
    {
        $this->Acl->deny($aro, $aco);
        $aco_info = $this->Acl->Aco->node($aco);
        $this->PermissibleAco->id = $aco_info[0]['Aco']['id'];
        foreach ($this->PermissibleAco->children() as $child) {
            $this->_multiDeny($aro, $aco . '/' . $child['PermissibleAco']['alias']);
        }
    }
}
