<?php
/**
 * Permissible Plugin Aros Controller class
 *
 * Provides the basics for controlling AROs
 *
 * @package permissible
 * @subpackage permissible.controllers
 */
class ArosController extends PermissibleAppController
{
/**
 * Name of the controller
 *
 * @var string
 * @access public
 */
    public $name = 'Aros';
/**
 * Name of model used by the controller
 *
 * @var array
 * @access public
 */
    public $uses = array(
        'Permissible.PermissibleAro'
    );
/**
 * Index for AROs - list all aros to be selected for management
 *
 * @return null
 * @access public
 */
    public function index()
    {
        $this->set('aros', $this->PermissibleAro->generateList());
    }
/**
 * Refresh the ARO list
 *
 * @return null
 * @access public
 */
    public function refresh()
    {
        $this->PermissibleAro->refresh();
        $this->Session->setFlash('The ARO list has been refreshed');
        $this->redirect(array('plugin' => 'permissible', 'controller' => 'aros', 'action' => 'index'));
    }
/**
 * Reset the ARO list
 *
 * @return null
 * @access public
 */
    public function reset()
    {
        if ($this->PermissibleAro->reset()) {
            $this->Acl->deny('everyone', 'app');
        }
        $this->Session->setFlash('The ARO list has been reset');
        $this->redirect(array('plugin' => 'permissible', 'controller' => 'aros', 'action' => 'index'));
    }
/**
 * Provides a form to manage the selected ARO, and changes permissions as required
 *
 * @return null
 * @access public
 */
    public function manage($id = null)
    {
        $this->PermissibleAro->id = $id;
        $aro = $this->PermissibleAro->read();
        if ($aro === false) {
            $this->redirect(array('plugin' => 'permissible', 'controller' => 'aros', 'action' => 'index'));
        }
        $this->set('aro', $aro);
        $alias = $aro['PermissibleAro']['alias'];
        while ($aro['PermissibleAro']['parent_id'] !== null) {
           $aro = $this->PermissibleAro->getparentnode();
           $this->PermissibleAro->id = $aro['PermissibleAro']['id'];
           $alias = $aro['PermissibleAro']['alias'] . '/' . $alias;
        }
        if (!empty($this->request->data)) {
            $cascade = (isset($this->request->data['PermissibleAro']['cascade']) && $this->request->data['PermissibleAro']['cascade'] === '1');
            unset($this->request->data['PermissibleAro']['cascade']);
            foreach ($this->request->data['PermissibleAro'] as $aco_alias => $perm) {
                $perm = ((int) $perm === 1);
                if ($perm) {
                    if ($cascade) {
                        $this->_multiAllow($alias, $aco_alias);
                    } elseif (!$this->Acl->check($alias, $aco_alias)) {
                        $this->Acl->allow($alias, $aco_alias);
                    }
                } else {
                    if ($cascade) {
                        $this->_multiDeny($alias, $aco_alias);
                    } elseif ($this->Acl->check($alias, $aco_alias)) {
                        $this->Acl->deny($alias, $aco_alias);
                    }
                }
            }
            $this->Session->setFlash('The permissions list has been updated');
            $this->request->data = array();
        }
        $this->set('alias', $alias);
        $this->loadModel('Permissible.PermissibleAco');
        $this->set('acos', $this->PermissibleAco->generateListPerms($this->Acl, $alias));
    }
/**
 * Used when permissions are cascading - allows the current level and cascades to lower AROs
 *
 * @return null
 * @access protected
 */
    public function _multiAllow($aro, $aco)
    {
        $this->Acl->allow($aro, $aco);
        $aro_info = $this->Acl->Aro->node($aro);
        $this->PermissibleAro->id = $aro_info[0]['Aro']['id'];
        foreach ($this->PermissibleAro->children() as $child) {
            $this->_multiAllow($aro . '/' . $child['PermissibleAro']['alias'], $aco);
        }
    }
/**
 * Used when permissions are cascading - denies the current level and cascades to lower AROs
 *
 * @return null
 * @access protected
 */
    public function _multiDeny($aro, $aco)
    {
        $this->Acl->deny($aro, $aco);
        $aro_info = $this->Acl->Aro->node($aro);
        $this->PermissibleAro->id = $aro_info[0]['Aro']['id'];
        foreach ($this->PermissibleAro->children() as $child) {
            $this->_multiDeny($aro . '/' . $child['PermissibleAro']['alias'], $aco);
        }
    }
}
