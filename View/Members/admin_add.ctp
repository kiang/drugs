<div class="members form">
    <?php echo $this->Form->create('Member'); ?>
    <fieldset>
        <legend><?php echo __('New Member', true); ?></legend>
        <?php
        echo $this->Form->input('group_id');
        echo $this->Form->input('username');
        echo $this->Form->input('password');
        echo $this->Form->input('user_status', array(
            'type' => 'radio',
            'options' => array('Y' => 'Y', 'N' => 'N'),
            'value' => 'Y'));
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit', true)); ?>
</div>
