<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php echo h($account['Account']['name']); ?> 的就醫記錄</h1>
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
                        <div class="actions">
                            <?php echo $this->Html->link('新增就醫記錄', array('controller' => 'orders', 'action' => 'add', $account['Account']['id']), array('class' => 'btn btn-primary')); ?>
                        </div>
                        <div class="paging"><?php echo $this->element('paginator'); ?></div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>醫事機構</th>
                                    <th><?php echo $this->Paginator->sort('order_date', '就醫日期'); ?></th>
                                    <th><?php echo $this->Paginator->sort('note_date', '交付調劑、檢查或復健治療日期'); ?></th>
                                    <th><?php echo $this->Paginator->sort('nhi_sn', '健保卡就醫序號'); ?></th>
                                    <th>疾病分類名稱</th>
                                    <th>處置名稱</th>
                                    <th><?php echo $this->Paginator->sort('modified', '更新時間'); ?></th>
                                    <th class="actions">操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <td>
                                            <?php
                                            if (!empty($order['Order']['point_id'])) {
                                                echo $this->Html->link($order['Order']['point'], array('controller' => 'points', 'action' => 'view', $order['Order']['point_id']));
                                            } else {
                                                echo $order['Order']['point'];
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo h($order['Order']['order_date']); ?>&nbsp;</td>
                                        <td><?php echo h($order['Order']['note_date']); ?>&nbsp;</td>
                                        <td><?php echo h($order['Order']['nhi_sn']); ?>&nbsp;</td>
                                        <td><?php echo h($order['Order']['disease']); ?>&nbsp;</td>
                                        <td><?php echo h($order['Order']['process']); ?>&nbsp;</td>
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