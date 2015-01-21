<div class="actions">
    <h3>Menu</h3>
    <ul>
        <li><?php echo $this->Html->link('Home', array('plugin' => 'permissible', 'controller' => 'permissible', 'action' => 'index')); ?></li>
        <li><?php echo $this->Html->link('Manage by user', array('plugin' => 'permissible', 'controller' => 'aros', 'action' => 'index')); ?></li>
        <li><?php echo $this->Html->link('Manage by action', array('plugin' => 'permissible', 'controller' => 'acos', 'action' => 'index')); ?></li>
        <li><?php echo $this->Html->link('Reset ACL', array('plugin' => 'permissible', 'controller' => 'permissible', 'action' => 'reset')); ?></li>
    </ul>
</div>
