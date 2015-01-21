<?php
/**
 * Manager page for Permissible Plugin Aco controller
 * Has a list of AROs and their permissions on this ACO
 *
 * @filesource
 * @package permissible
 * @subpackage permissible.views.acos
 */
echo $this->Form->create('PermissibleAco', array('url' => array('plugin' => 'permissible', 'controller' => 'acos', 'action' => 'manage', $aco['PermissibleAco']['id'])));
?>
<h2>Allow access to <?php echo $alias; ?> (and children AROs) for:</h2>
<?php echo $this->element('nested_form_aco', array('aros' => $aros)); ?>
<?php echo $this->Form->input('cascade', array('type' => 'checkbox', 'label' => 'Cascade to lower AROs?', 'checked' => Configure::read('Permissible.Cascade'))); ?>
<?php echo $this->Form->end('Update'); ?>
<?php
$this->Html->script('/permissible/js/cascade.min', array('inline' => false));
$this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js', array('inline' => false));
?>
