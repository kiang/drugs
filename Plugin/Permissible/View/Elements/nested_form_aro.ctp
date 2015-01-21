<?php
/**
 * Produces a form for managing permissions for an aro on acos, and their children
 *
 * @filesource
 * @package permissible
 * @subpackage permissible.views.elements
 */
?><ul>
<?php foreach ($acos as $aco) { ?>
<li><?php echo $this->Form->input($aco['full_alias'], array('type' => 'checkbox', 'checked' => $aco['allowed'], 'onchange' => "cascade(this);")); ?>
<?php if (isset($aco['sub-menu'])) { ?>
<?php echo $this->element('nested_form_aro', array('acos' => $aco['sub-menu'])); ?>
<?php } ?></li>
<?php } ?>
</ul>
