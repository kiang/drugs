<?php
/**
 * Index for Permissible Plugin Aco controller
 * Has a list of ACOs to be managed
 *
 * @filesource
 * @package permissible
 * @subpackage permissible.views.acos
 */
?><h2>Available ACOs</h2>
<?php echo $this->element('nested_menu_aco', array('menu' => $acos)); ?>
<?php
if (Configure::read('debug') > 0) {
    $this->set('actions_for_layout', array('Refresh ACO list' => array('plugin' => 'permissible', 'controller' => 'acos', 'action' => 'refresh'), 'Reset ACO list' => array('plugin' => 'permissible', 'controller' => 'acos', 'action' => 'reset')));
} else {
    $this->set('actions_for_layout', array('Refresh ACO list' => array('plugin' => 'permissible', 'controller' => 'acos', 'action' => 'refresh')));
}
?>
