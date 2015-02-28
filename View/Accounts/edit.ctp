<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php echo __('Edit Account'); ?></h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                </div>
                <div class="box-body">
                    <div class="accounts form">
                        <?php echo $this->Form->create('Account'); ?>
                        <?php
                        echo $this->Form->input('id');
                        echo $this->Form->input('member_id');
                        echo $this->Form->input('name');
                        echo $this->Form->input('dob');
                        echo $this->Form->input('gender');
                        echo $this->Form->input('note');
                        ?>
                        <?php echo $this->Form->end(__('Submit')); ?>
                    </div>
                    <div class="actions">
                        <h3><?php echo __('Actions'); ?></h3>
                        <ul>

                            <li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Account.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('Account.id'))); ?></li>
                            <li><?php echo $this->Html->link(__('List Accounts'), array('action' => 'index')); ?></li>
                            <li><?php echo $this->Html->link(__('List Members'), array('controller' => 'members', 'action' => 'index')); ?> </li>
                            <li><?php echo $this->Html->link(__('New Member'), array('controller' => 'members', 'action' => 'add')); ?> </li>
                            <li><?php echo $this->Html->link(__('List Orders'), array('controller' => 'orders', 'action' => 'index')); ?> </li>
                            <li><?php echo $this->Html->link(__('New Order'), array('controller' => 'orders', 'action' => 'add')); ?> </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>