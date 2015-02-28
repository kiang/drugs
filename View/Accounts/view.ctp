<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php echo h($account['Account']['name']); ?></h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                </div>
                <div class="box-body">
                    <ul>
                        <li class="col-xs-3">性別：<?php echo $account['Account']['gender'] === 'm' ? '男' : '女'; ?> </li>
                        <li class="col-xs-3">生日：<?php echo h($account['Account']['dob']); ?></li>
                        <li class="col-xs-3">建立時間：<?php echo h($account['Account']['created']); ?> </li>
                        <li class="col-xs-3">更新時間：<?php echo h($account['Account']['modified']); ?></li>
                    </ul>
                    <div class="clearfix"></div>
                    <?php echo nl2br(h($account['Account']['note'])); ?>
                </div>
            </div>
            <div class="box">
                <div class="box-header">
                </div>
                <div class="box-body">
                    <div class="orders index">
                        <div class="paging"><?php echo $this->element('paginator'); ?></div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th><?php echo $this->Paginator->sort('id'); ?></th>
                                    <th><?php echo $this->Paginator->sort('account_id'); ?></th>
                                    <th><?php echo $this->Paginator->sort('nhi_area'); ?></th>
                                    <th><?php echo $this->Paginator->sort('point_id'); ?></th>
                                    <th><?php echo $this->Paginator->sort('point'); ?></th>
                                    <th><?php echo $this->Paginator->sort('order_date'); ?></th>
                                    <th><?php echo $this->Paginator->sort('note_date'); ?></th>
                                    <th><?php echo $this->Paginator->sort('nhi_sn'); ?></th>
                                    <th><?php echo $this->Paginator->sort('nhi_sort'); ?></th>
                                    <th><?php echo $this->Paginator->sort('disease_code'); ?></th>
                                    <th><?php echo $this->Paginator->sort('disease'); ?></th>
                                    <th><?php echo $this->Paginator->sort('process_code'); ?></th>
                                    <th><?php echo $this->Paginator->sort('process'); ?></th>
                                    <th><?php echo $this->Paginator->sort('money_order'); ?></th>
                                    <th><?php echo $this->Paginator->sort('money_register'); ?></th>
                                    <th><?php echo $this->Paginator->sort('nhi_points'); ?></th>
                                    <th><?php echo $this->Paginator->sort('created'); ?></th>
                                    <th><?php echo $this->Paginator->sort('modified'); ?></th>
                                    <th class="actions"><?php echo __('Actions'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <td><?php echo h($order['Order']['id']); ?>&nbsp;</td>
                                        <td>
                                            <?php echo $this->Html->link($order['Account']['name'], array('controller' => 'accounts', 'action' => 'view', $order['Account']['id'])); ?>
                                        </td>
                                        <td><?php echo h($order['Order']['nhi_area']); ?>&nbsp;</td>
                                        <td>
                                            <?php echo $this->Html->link($order['Point']['name'], array('controller' => 'points', 'action' => 'view', $order['Point']['id'])); ?>
                                        </td>
                                        <td><?php echo h($order['Order']['point']); ?>&nbsp;</td>
                                        <td><?php echo h($order['Order']['order_date']); ?>&nbsp;</td>
                                        <td><?php echo h($order['Order']['note_date']); ?>&nbsp;</td>
                                        <td><?php echo h($order['Order']['nhi_sn']); ?>&nbsp;</td>
                                        <td><?php echo h($order['Order']['nhi_sort']); ?>&nbsp;</td>
                                        <td><?php echo h($order['Order']['disease_code']); ?>&nbsp;</td>
                                        <td><?php echo h($order['Order']['disease']); ?>&nbsp;</td>
                                        <td><?php echo h($order['Order']['process_code']); ?>&nbsp;</td>
                                        <td><?php echo h($order['Order']['process']); ?>&nbsp;</td>
                                        <td><?php echo h($order['Order']['money_order']); ?>&nbsp;</td>
                                        <td><?php echo h($order['Order']['money_register']); ?>&nbsp;</td>
                                        <td><?php echo h($order['Order']['nhi_points']); ?>&nbsp;</td>
                                        <td><?php echo h($order['Order']['created']); ?>&nbsp;</td>
                                        <td><?php echo h($order['Order']['modified']); ?>&nbsp;</td>
                                        <td class="actions">
                                            <?php echo $this->Html->link(__('View'), array('action' => 'view', $order['Order']['id'])); ?>
                                            <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $order['Order']['id'])); ?>
                                            <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $order['Order']['id']), array(), __('Are you sure you want to delete # %s?', $order['Order']['id'])); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <div class="paging"><?php echo $this->element('paginator'); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>