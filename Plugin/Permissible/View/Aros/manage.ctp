<?php
/**
 * Manager page for Permissible Plugin Aro controller
 * Has a list of ACOs and their permissions on this ARO
 *
 * @filesource
 * @package permissible
 * @subpackage permissible.views.aros
 */
echo $this->Form->create('PermissibleAro', array('url' => array('plugin' => 'permissible', 'controller' => 'aros', 'action' => 'manage', $aro['PermissibleAro']['id'])));?>
<h2>Allow <?php echo $alias; ?> (and children AROs) access to:</h2>
<?php echo $this->element('nested_form_aro', array('acos' => $acos)); ?>
<?php echo $this->Form->input('cascade', array('type' => 'checkbox', 'label' => 'Cascade to lower ACOs?', 'checked' => Configure::read('Permissible.Cascade'))); ?>
<?php echo $this->Form->end('Update'); ?>
<?php
$this->Html->script('/permissible/js/cascade.min', array('inline' => false));
$this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js', array('inline' => false));
?>
