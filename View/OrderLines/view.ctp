<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php echo __('Order Line'); ?></h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                </div>
                <div class="box-body">
                    <div class="orderLines view">
                        <dl>
                            <dt><?php echo __('Id'); ?></dt>
                            <dd>
                                <?php echo h($orderLine['OrderLine']['id']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Order'); ?></dt>
                            <dd>
                                <?php echo $this->Html->link($orderLine['Order']['id'], array('controller' => 'orders', 'action' => 'view', $orderLine['Order']['id'])); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Code'); ?></dt>
                            <dd>
                                <?php echo h($orderLine['OrderLine']['code']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Note'); ?></dt>
                            <dd>
                                <?php echo h($orderLine['OrderLine']['note']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Quantity'); ?></dt>
                            <dd>
                                <?php echo h($orderLine['OrderLine']['quantity']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Model'); ?></dt>
                            <dd>
                                <?php echo h($orderLine['OrderLine']['model']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Foreign Key'); ?></dt>
                            <dd>
                                <?php echo h($orderLine['OrderLine']['foreign_key']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Created'); ?></dt>
                            <dd>
                                <?php echo h($orderLine['OrderLine']['created']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Modified'); ?></dt>
                            <dd>
                                <?php echo h($orderLine['OrderLine']['modified']); ?>
                                &nbsp;
                            </dd>
                        </dl>
                    </div>
                    <div class="actions">
                        <h3><?php echo __('Actions'); ?></h3>
                        <ul>
                            <li><?php echo $this->Html->link(__('Edit Order Line'), array('action' => 'edit', $orderLine['OrderLine']['id'])); ?> </li>
                            <li><?php echo $this->Form->postLink(__('Delete Order Line'), array('action' => 'delete', $orderLine['OrderLine']['id']), array(), __('Are you sure you want to delete # %s?', $orderLine['OrderLine']['id'])); ?> </li>
                            <li><?php echo $this->Html->link(__('List Order Lines'), array('action' => 'index')); ?> </li>
                            <li><?php echo $this->Html->link(__('New Order Line'), array('action' => 'add')); ?> </li>
                            <li><?php echo $this->Html->link(__('List Orders'), array('controller' => 'orders', 'action' => 'index')); ?> </li>
                            <li><?php echo $this->Html->link(__('New Order'), array('controller' => 'orders', 'action' => 'add')); ?> </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
