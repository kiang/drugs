<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php echo __('Points'); ?></h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                </div>
                <div class="box-body">
                    <div class="points index">
                        <div class="paging"><?php echo $this->element('paginator'); ?></div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th><?php echo $this->Paginator->sort('id'); ?></th>
                                    <th><?php echo $this->Paginator->sort('nhi_id'); ?></th>
                                    <th><?php echo $this->Paginator->sort('nhi_end'); ?></th>
                                    <th><?php echo $this->Paginator->sort('type'); ?></th>
                                    <th><?php echo $this->Paginator->sort('category'); ?></th>
                                    <th><?php echo $this->Paginator->sort('biz_type'); ?></th>
                                    <th><?php echo $this->Paginator->sort('service'); ?></th>
                                    <th><?php echo $this->Paginator->sort('name'); ?></th>
                                    <th><?php echo $this->Paginator->sort('city'); ?></th>
                                    <th><?php echo $this->Paginator->sort('town'); ?></th>
                                    <th><?php echo $this->Paginator->sort('address'); ?></th>
                                    <th><?php echo $this->Paginator->sort('longitude'); ?></th>
                                    <th><?php echo $this->Paginator->sort('latitude'); ?></th>
                                    <th><?php echo $this->Paginator->sort('phone'); ?></th>
                                    <th><?php echo $this->Paginator->sort('url'); ?></th>
                                    <th class="actions"><?php echo __('Actions'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($points as $point): ?>
                                    <tr>
                                        <td><?php echo h($point['Point']['id']); ?>&nbsp;</td>
                                        <td><?php echo h($point['Point']['nhi_id']); ?>&nbsp;</td>
                                        <td><?php echo h($point['Point']['nhi_end']); ?>&nbsp;</td>
                                        <td><?php echo h($point['Point']['type']); ?>&nbsp;</td>
                                        <td><?php echo h($point['Point']['category']); ?>&nbsp;</td>
                                        <td><?php echo h($point['Point']['biz_type']); ?>&nbsp;</td>
                                        <td><?php echo h($point['Point']['service']); ?>&nbsp;</td>
                                        <td><?php echo h($point['Point']['name']); ?>&nbsp;</td>
                                        <td><?php echo h($point['Point']['city']); ?>&nbsp;</td>
                                        <td><?php echo h($point['Point']['town']); ?>&nbsp;</td>
                                        <td><?php echo h($point['Point']['address']); ?>&nbsp;</td>
                                        <td><?php echo h($point['Point']['longitude']); ?>&nbsp;</td>
                                        <td><?php echo h($point['Point']['latitude']); ?>&nbsp;</td>
                                        <td><?php echo h($point['Point']['phone']); ?>&nbsp;</td>
                                        <td><?php echo h($point['Point']['url']); ?>&nbsp;</td>
                                        <td class="actions">
                                            <?php echo $this->Html->link(__('View'), array('action' => 'view', $point['Point']['id'])); ?>
                                            <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $point['Point']['id'])); ?>
                                            <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $point['Point']['id']), array(), __('Are you sure you want to delete # %s?', $point['Point']['id'])); ?>
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
                            <li><?php echo $this->Html->link(__('New Point'), array('action' => 'add')); ?></li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>