<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php echo __('Add Order'); ?></h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                </div>
                <div class="box-body">
                    <div class="orders form">
                        <?php echo $this->Form->create('Order'); ?>
                        <?php
echo $this->Form->input('account_id');
echo $this->Form->input('nhi_area');
echo $this->Form->input('point_id');
echo $this->Form->input('point');
echo $this->Form->input('order_date');
echo $this->Form->input('note_date');
echo $this->Form->input('nhi_sn');
echo $this->Form->input('nhi_sort');
echo $this->Form->input('disease_code');
echo $this->Form->input('disease');
echo $this->Form->input('process_code');
echo $this->Form->input('process');
echo $this->Form->input('money_order');
echo $this->Form->input('money_register');
echo $this->Form->input('nhi_points');
?>
                        <?php echo $this->Form->end(__('Submit')); ?>
                    </div>
                    <div class="actions">
                        <h3><?php echo __('Actions'); ?></h3>
                        <ul>

                                                        <li><?php echo $this->Html->link(__('List Orders'), array('action' => 'index')); ?></li>
                            <li><?php echo $this->Html->link(__('List Accounts'), array('controller' => 'accounts', 'action' => 'index')); ?> </li>
<li><?php echo $this->Html->link(__('New Account'), array('controller' => 'accounts', 'action' => 'add')); ?> </li>
<li><?php echo $this->Html->link(__('List Points'), array('controller' => 'points', 'action' => 'index')); ?> </li>
<li><?php echo $this->Html->link(__('New Point'), array('controller' => 'points', 'action' => 'add')); ?> </li>
<li><?php echo $this->Html->link(__('List Order Lines'), array('controller' => 'order_lines', 'action' => 'index')); ?> </li>
<li><?php echo $this->Html->link(__('New Order Line'), array('controller' => 'order_lines', 'action' => 'add')); ?> </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>