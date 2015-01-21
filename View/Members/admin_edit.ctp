<div class="members form">
    <?php echo $this->Form->create('Member'); ?>
    <fieldset>
        <legend><?php echo __('Edit Member', true); ?></legend>
        <?php
        echo $this->Form->input('id');
        echo $this->Form->input('username');
        echo $this->Form->input('group_id');
        echo $this->Form->input('password', array('value' => ''));
        echo $this->Form->input('user_status', array(
            'type' => 'radio',
            'options' => array('Y' => 'Y', 'N' => 'N')));
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit', true)); ?>
</div>
