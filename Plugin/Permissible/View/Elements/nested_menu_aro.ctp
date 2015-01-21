<?php
/**
 * Produces a list of aros and their children
 *
 * @filesource
 * @package permissible
 * @subpackage permissible.views.elements
 */
?><ul>
<?php foreach ($menu as $men) { ?>
<li><?php echo $this->Html->link($men['alias'], array('plugin' => 'permissible', 'controller' => 'aros', 'action' => 'manage', $men['id'])); ?>
<?php if (isset($men['sub-menu'])) { ?>
<?php echo $this->element('nested_menu_aro', array('menu' => $men['sub-menu'])); ?>
<?php } ?></li>
<?php } ?>
</ul>
