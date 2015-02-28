<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php echo __('Order Lines'); ?></h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                </div>
                <div class="box-body">
                    <div class="orderLines index">
                        <div class="paging"><?php echo $this->element('paginator'); ?></div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                                                            <th><?php echo $this->Paginator->sort('id'); ?></th>
                                                                            <th><?php echo $this->Paginator->sort('order_id'); ?></th>
                                                                            <th><?php echo $this->Paginator->sort('code'); ?></th>
                                                                            <th><?php echo $this->Paginator->sort('note'); ?></th>
                                                                            <th><?php echo $this->Paginator->sort('quantity'); ?></th>
                                                                            <th><?php echo $this->Paginator->sort('model'); ?></th>
                                                                            <th><?php echo $this->Paginator->sort('foreign_key'); ?></th>
                                                                            <th><?php echo $this->Paginator->sort('created'); ?></th>
                                                                            <th><?php echo $this->Paginator->sort('modified'); ?></th>
                                                                        <th class="actions"><?php echo __('Actions'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orderLines as $orderLine): ?>
<tr>
<td><?php echo h($orderLine['OrderLine']['id']); ?>&nbsp;</td>
<td>
<?php echo $this->Html->link($orderLine['Order']['id'], array('controller' => 'orders', 'action' => 'view', $orderLine['Order']['id'])); ?>
</td>
<td><?php echo h($orderLine['OrderLine']['code']); ?>&nbsp;</td>
<td><?php echo h($orderLine['OrderLine']['note']); ?>&nbsp;</td>
<td><?php echo h($orderLine['OrderLine']['quantity']); ?>&nbsp;</td>
<td><?php echo h($orderLine['OrderLine']['model']); ?>&nbsp;</td>
<td><?php echo h($orderLine['OrderLine']['foreign_key']); ?>&nbsp;</td>
<td><?php echo h($orderLine['OrderLine']['created']); ?>&nbsp;</td>
<td><?php echo h($orderLine['OrderLine']['modified']); ?>&nbsp;</td>
<td class="actions">
<?php echo $this->Html->link(__('View'), array('action' => 'view', $orderLine['OrderLine']['id'])); ?>
<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $orderLine['OrderLine']['id'])); ?>
<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $orderLine['OrderLine']['id']), array(), __('Are you sure you want to delete # %s?', $orderLine['OrderLine']['id'])); ?>
</td>
</tr>
<?php endforeach; ?>
                            </tbody>
                        </table>
                        <p>
                            <?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>                        </p>
                        <div class="paging"><?php echo $this->element('paginator'); ?></div>
                    </div>
                    <div class="actions">
                        <h3><?php echo __('Actions'); ?></h3>
                        <ul>
                            <li><?php echo $this->Html->link(__('New Order Line'), array('action' => 'add')); ?></li>
                            <li><?php echo $this->Html->link(__('List Orders'), array('controller' => 'orders', 'action' => 'index')); ?> </li>
<li><?php echo $this->Html->link(__('New Order'), array('controller' => 'orders', 'action' => 'add')); ?> </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>