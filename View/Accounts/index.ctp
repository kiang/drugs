<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php
        echo implode(' > ', array(
            '健康存摺',
            $this->Html->link('新增健康存摺', array('action' => 'add'), array('class' => 'btn btn-primary')),
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
                    <div class="accounts index">
                        <div class="paging"><?php echo $this->element('paginator'); ?></div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>名稱</th>
                                    <th>性別</th>
                                    <th>生日</th>
                                    <th>備註</th>
                                    <th><?php echo $this->Paginator->sort('created', '建立時間'); ?></th>
                                    <th><?php echo $this->Paginator->sort('modified', '更新時間'); ?></th>
                                    <th class="actions">操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($accounts as $account): ?>
                                    <tr>
                                        <td><?php echo h($account['Account']['name']); ?>&nbsp;</td>
                                        <td><?php echo h($account['Account']['gender']); ?>&nbsp;</td>
                                        <td><?php echo h($account['Account']['dob']); ?>&nbsp;</td>
                                        <td><?php echo nl2br(h($account['Account']['note'])); ?>&nbsp;</td>
                                        <td><?php echo h($account['Account']['created']); ?>&nbsp;</td>
                                        <td><?php echo h($account['Account']['modified']); ?>&nbsp;</td>
                                        <td class="actions">
                                            <?php echo $this->Html->link('檢視', array('action' => 'view', $account['Account']['id']), array('class' => 'btn btn-default')); ?>
                                            <?php echo $this->Html->link('編輯', array('action' => 'edit', $account['Account']['id']), array('class' => 'btn btn-default')); ?>
                                            <?php echo $this->Form->postLink('刪除', array('action' => 'delete', $account['Account']['id']), array('class' => 'btn btn-default'), '一旦刪除所有相關記錄都會清空，確定要刪除？'); ?>
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