<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php
        echo implode(' > ', array(
            $this->Html->link('健康存摺', array('controller' => 'accounts', 'action' => 'index')),
            $this->Html->link($account['Account']['name'] . ' 的就醫記錄', array('controller' => 'accounts', 'action' => 'view', $account['Account']['id'])),
            '用藥統計'
        ));
        ?></h1>
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
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>圖片</th>
                                    <th>藥品名稱</th>
                                    <th>適應症</th>
                                    <th>使用量</th>
                                    <th>使用次數</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orderLines as $orderLine): ?>
                                    <tr>
                                        <td>
                                            <?php if (!empty($licenses[$orderLine['OrderLine']['foreign_id']]['image'])) { ?>
                                                <img src="<?php echo $this->Html->url('/') . $licenses[$orderLine['OrderLine']['foreign_id']]['image']; ?>" class="img-thumbnail" style="width: 120px;" />
                                                <div class="clearfix"></div>
                                            <?php } ?>
                                        </td>
                                        <td><?php echo $this->Html->link($licenses[$orderLine['OrderLine']['foreign_id']]['name'], '/drugs/view/' . $drugs[$orderLine['OrderLine']['foreign_id']], array('target' => '_blank')); ?></td>
                                        <td><?php echo $licenses[$orderLine['OrderLine']['foreign_id']]['disease']; ?></td>
                                        <td><?php echo $orderLine[0]['total']; ?></td>
                                        <td><?php echo $orderLine[0]['count']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>