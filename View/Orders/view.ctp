<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php echo __('Order'); ?></h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                </div>
                <div class="box-body">
                    <div class="orders view">
                        <dl>
                            <dt><?php echo __('Id'); ?></dt>
<dd>
<?php echo h($order['Order']['id']); ?>
&nbsp;
</dd>
<dt><?php echo __('Account'); ?></dt>
<dd>
<?php echo $this->Html->link($order['Account']['name'], array('controller' => 'accounts', 'action' => 'view', $order['Account']['id'])); ?>
&nbsp;
</dd>
<dt><?php echo __('Nhi Area'); ?></dt>
<dd>
<?php echo h($order['Order']['nhi_area']); ?>
&nbsp;
</dd>
<dt><?php echo __('Point'); ?></dt>
<dd>
<?php echo $this->Html->link($order['Point']['name'], array('controller' => 'points', 'action' => 'view', $order['Point']['id'])); ?>
&nbsp;
</dd>
<dt><?php echo __('Point'); ?></dt>
<dd>
<?php echo h($order['Order']['point']); ?>
&nbsp;
</dd>
<dt><?php echo __('Order Date'); ?></dt>
<dd>
<?php echo h($order['Order']['order_date']); ?>
&nbsp;
</dd>
<dt><?php echo __('Note Date'); ?></dt>
<dd>
<?php echo h($order['Order']['note_date']); ?>
&nbsp;
</dd>
<dt><?php echo __('Nhi Sn'); ?></dt>
<dd>
<?php echo h($order['Order']['nhi_sn']); ?>
&nbsp;
</dd>
<dt><?php echo __('Nhi Sort'); ?></dt>
<dd>
<?php echo h($order['Order']['nhi_sort']); ?>
&nbsp;
</dd>
<dt><?php echo __('Disease Code'); ?></dt>
<dd>
<?php echo h($order['Order']['disease_code']); ?>
&nbsp;
</dd>
<dt><?php echo __('Disease'); ?></dt>
<dd>
<?php echo h($order['Order']['disease']); ?>
&nbsp;
</dd>
<dt><?php echo __('Process Code'); ?></dt>
<dd>
<?php echo h($order['Order']['process_code']); ?>
&nbsp;
</dd>
<dt><?php echo __('Process'); ?></dt>
<dd>
<?php echo h($order['Order']['process']); ?>
&nbsp;
</dd>
<dt><?php echo __('Money Order'); ?></dt>
<dd>
<?php echo h($order['Order']['money_order']); ?>
&nbsp;
</dd>
<dt><?php echo __('Money Register'); ?></dt>
<dd>
<?php echo h($order['Order']['money_register']); ?>
&nbsp;
</dd>
<dt><?php echo __('Nhi Points'); ?></dt>
<dd>
<?php echo h($order['Order']['nhi_points']); ?>
&nbsp;
</dd>
<dt><?php echo __('Created'); ?></dt>
<dd>
<?php echo h($order['Order']['created']); ?>
&nbsp;
</dd>
<dt><?php echo __('Modified'); ?></dt>
<dd>
<?php echo h($order['Order']['modified']); ?>
&nbsp;
</dd>
                        </dl>
                    </div>
                    <div class="actions">
                        <h3><?php echo __('Actions'); ?></h3>
                        <ul>
                            <li><?php echo $this->Html->link(__('Edit Order'), array('action' => 'edit', $order['Order']['id'])); ?> </li>
<li><?php echo $this->Form->postLink(__('Delete Order'), array('action' => 'delete', $order['Order']['id']), array(), __('Are you sure you want to delete # %s?', $order['Order']['id'])); ?> </li>
<li><?php echo $this->Html->link(__('List Orders'), array('action' => 'index')); ?> </li>
<li><?php echo $this->Html->link(__('New Order'), array('action' => 'add')); ?> </li>
<li><?php echo $this->Html->link(__('List Accounts'), array('controller' => 'accounts', 'action' => 'index')); ?> </li>
<li><?php echo $this->Html->link(__('New Account'), array('controller' => 'accounts', 'action' => 'add')); ?> </li>
<li><?php echo $this->Html->link(__('List Points'), array('controller' => 'points', 'action' => 'index')); ?> </li>
<li><?php echo $this->Html->link(__('New Point'), array('controller' => 'points', 'action' => 'add')); ?> </li>
<li><?php echo $this->Html->link(__('List Order Lines'), array('controller' => 'order_lines', 'action' => 'index')); ?> </li>
<li><?php echo $this->Html->link(__('New Order Line'), array('controller' => 'order_lines', 'action' => 'add')); ?> </li>
                        </ul>
                    </div>
                                            <div class="related">
                            <h3><?php echo __('Related Order Lines'); ?></h3>
                            <?php if (!empty($order['OrderLine'])): ?>
                            <table cellpadding = "0" cellspacing = "0">
                                <tr>
                                    <th><?php echo __('Id'); ?></th>
<th><?php echo __('Order Id'); ?></th>
<th><?php echo __('Code'); ?></th>
<th><?php echo __('Note'); ?></th>
<th><?php echo __('Quantity'); ?></th>
<th><?php echo __('Model'); ?></th>
<th><?php echo __('Foreign Key'); ?></th>
<th><?php echo __('Created'); ?></th>
<th><?php echo __('Modified'); ?></th>
                                    <th class="actions"><?php echo __('Actions'); ?></th>
                                </tr>
                                <?php foreach ($order['OrderLine'] as $orderLine): ?>
<tr>
<td><?php echo $orderLine['id']; ?></td>
<td><?php echo $orderLine['order_id']; ?></td>
<td><?php echo $orderLine['code']; ?></td>
<td><?php echo $orderLine['note']; ?></td>
<td><?php echo $orderLine['quantity']; ?></td>
<td><?php echo $orderLine['model']; ?></td>
<td><?php echo $orderLine['foreign_key']; ?></td>
<td><?php echo $orderLine['created']; ?></td>
<td><?php echo $orderLine['modified']; ?></td>
<td class="actions">
<?php echo $this->Html->link(__('View'), array('controller' => 'order_lines', 'action' => 'view', $orderLine['id'])); ?>
<?php echo $this->Html->link(__('Edit'), array('controller' => 'order_lines', 'action' => 'edit', $orderLine['id'])); ?>
<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'order_lines', 'action' => 'delete', $orderLine['id']), array(), __('Are you sure you want to delete # %s?', $orderLine['id'])); ?>
</td>
</tr>
<?php endforeach; ?>
                            </table>
                            <?php endif; ?>

                            <div class="actions">
                                <ul>
                                    <li><?php echo $this->Html->link(__('New Order Line'), array('controller' => 'order_lines', 'action' => 'add')); ?> </li>
                                </ul>
                            </div>
                        </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>
