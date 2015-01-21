<div class="groups form">
    <?php echo $this->Form->create('Group'); ?>
    <fieldset>
        <legend><?php echo __('Edit group', true); ?></legend>
        <?php
        echo $this->Form->input('id');
        echo $this->Form->input('name', array('label' => __('Name', true)));
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit', true)); ?>
</div>
<div class="actions">
    <ul>
        <li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Group.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Group.id'))); ?></li>
        <li><?php echo $this->Html->link(__('List', true), array('action' => 'index', $this->Form->value('Group.parent_id'))); ?></li>
    </ul>
</div>
