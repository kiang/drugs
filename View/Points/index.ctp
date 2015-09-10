<?php
echo $this->Html->script('c/points/index', array('inline' => false));
?>
<h2>醫事機構</h2>
<div class="paginator-wrapper">
    <?php echo $this->element('paginator'); ?>
</div>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                </div>
                <div class="box-body">
                    <div class="points index">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>名稱</th>
                                    <th><?php echo $this->Paginator->sort('type', '類別'); ?></th>
                                    <th>科別</th>
                                    <th>縣市</th>
                                    <th>鄉鎮市區</th>
                                    <th>住址</th>
                                    <th>電話</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($points as $point): ?>
                                    <tr>
                                        <td><?php echo $this->Html->link($point['Point']['name'], array('action' => 'view', $point['Point']['id'])); ?>&nbsp;</td>
                                        <td><?php echo h($point['Point']['type']); ?>&nbsp;</td>
                                        <td><?php echo h($point['Point']['category']); ?>&nbsp;</td>
                                        <td><?php echo h($point['Point']['city']); ?>&nbsp;</td>
                                        <td><?php echo h($point['Point']['town']); ?>&nbsp;</td>
                                        <td><?php echo h($point['Point']['address']); ?>&nbsp;</td>
                                        <td><?php echo h($point['Point']['phone']); ?>&nbsp;</td>
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
<div class="clearfix paginator-wrapper">
    <?php echo $this->element('paginator'); ?>
</div>
