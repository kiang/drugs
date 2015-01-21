<?php
/**
 * Index for Permissible Plugin Aro controller
 * Has a list of AROs to be managed
 *
 * @filesource
 * @package permissible
 * @subpackage permissible.views.aros
 */
?><h2>Available AROs</h2>
<?php echo $this->element('nested_menu_aro', array('menu' => $aros)); ?>
<?php
if (Configure::read('debug') > 0) {
    $this->set('actions_for_layout', array('Refresh ARO list' => array('plugin' => 'permissible', 'controller' => 'aros', 'action' => 'refresh'), 'Reset ARO list' => array('plugin' => 'permissible', 'controller' => 'aros', 'action' => 'reset')));
} else {
    $this->set('actions_for_layout', array('Refresh ARO list' => array('plugin' => 'permissible', 'controller' => 'aros', 'action' => 'refresh')));
}
?>
