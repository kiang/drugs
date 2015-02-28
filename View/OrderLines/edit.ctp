<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php echo __('Edit Order Line'); ?></h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                </div>
                <div class="box-body">
                    <div class="orderLines form">
                        <?php echo $this->Form->create('OrderLine'); ?>
                        <?php
                        echo $this->Form->input('id');
                        echo $this->Form->input('order_id');
                        echo $this->Form->input('code');
                        echo $this->Form->input('note');
                        echo $this->Form->input('quantity');
                        echo $this->Form->input('model');
                        echo $this->Form->input('foreign_key');
                        ?>
                        <?php echo $this->Form->end(__('Submit')); ?>
                    </div>
                    <div class="actions">
                        <h3><?php echo __('Actions'); ?></h3>
                        <ul>

                            <li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('OrderLine.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('OrderLine.id'))); ?></li>
                            <li><?php echo $this->Html->link(__('List Order Lines'), array('action' => 'index')); ?></li>
                            <li><?php echo $this->Html->link(__('List Orders'), array('controller' => 'orders', 'action' => 'index')); ?> </li>
                            <li><?php echo $this->Html->link(__('New Order'), array('controller' => 'orders', 'action' => 'add')); ?> </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>