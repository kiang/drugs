<h4>醫事機構管理</h4>
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
                                    <th><?php echo $this->Paginator->sort('nhi_id'); ?></th>
                                    <th><?php echo $this->Paginator->sort('name'); ?></th>
                                    <th><?php echo $this->Paginator->sort('type'); ?></th>
                                    <th><?php echo $this->Paginator->sort('category'); ?></th>
                                    <th><?php echo $this->Paginator->sort('biz_type'); ?></th>
                                    <th><?php echo $this->Paginator->sort('city'); ?></th>
                                    <th><?php echo $this->Paginator->sort('town'); ?></th>
                                    <th><?php echo $this->Paginator->sort('phone'); ?></th>
                                    <th class="actions"><?php echo __('Actions'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($points as $point): ?>
                                    <tr>
                                        <td><?php
                                            if (!empty($point['Point']['url'])) {
                                                echo $this->Html->link($point['Point']['nhi_id'], $point['Point']['url'], array('target' => '_blank'));
                                            } else {
                                                echo h($point['Point']['nhi_id']);
                                            }
                                            ?>&nbsp;</td>
                                        <td><?php echo h($point['Point']['name']); ?>&nbsp;</td>
                                        <td><?php echo h($point['Point']['type']); ?>&nbsp;</td>
                                        <td><?php echo h($point['Point']['category']); ?>&nbsp;</td>
                                        <td><?php echo h($point['Point']['biz_type']); ?>&nbsp;</td>
                                        <td><?php echo h($point['Point']['city']); ?>&nbsp;</td>
                                        <td><?php echo h($point['Point']['town']); ?>&nbsp;</td>
                                        <td><?php echo h($point['Point']['phone']); ?>&nbsp;</td>
                                        <td>
                                            <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $point['Point']['id']), array('class' => 'btn btn-default')); ?>
                                            <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $point['Point']['id']), array('class' => 'btn btn-default'), __('Are you sure you want to delete # %s?', $point['Point']['id'])); ?>
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
                </div>
            </div>
        </div>
    </div>
</section>