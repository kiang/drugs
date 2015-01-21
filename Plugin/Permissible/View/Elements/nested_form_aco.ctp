<?php
/**
 * Produces a form for managing permissions for an aco on aros, and their children
 *
 * @filesource
 * @package permissible
 * @subpackage permissible.views.elements
 */
?><ul>
<?php foreach ($aros as $aro) { ?>
<li><?php echo $this->Form->input($aro['full_alias'], array('type' => 'checkbox', 'checked' => $aro['allowed'], 'onchange' => "cascade(this);")); ?>
<?php if (isset($aro['sub-menu'])) { ?>
<?php echo $this->element('nested_form_aco', array('aros' => $aro['sub-menu'])); ?>
<?php } ?></li>
<?php } ?>
</ul>
