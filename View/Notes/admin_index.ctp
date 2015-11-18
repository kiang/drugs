<!-- Content Header (Page header) -->
<h4>藥物補充資訊</h4>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                </div>
                <div class="box-body">
                    <div class="notes index">
                        <div class="paging"><?php echo $this->element('paginator'); ?></div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th><?php echo $this->Paginator->sort('license_id'); ?></th>
                                    <th><?php echo $this->Paginator->sort('member_id'); ?></th>
                                    <th><?php echo $this->Paginator->sort('info'); ?></th>
                                    <th><?php echo $this->Paginator->sort('notices'); ?></th>
                                    <th><?php echo $this->Paginator->sort('side_effects'); ?></th>
                                    <th><?php echo $this->Paginator->sort('interactions'); ?></th>
                                    <th><?php echo $this->Paginator->sort('created'); ?></th>
                                    <th><?php echo $this->Paginator->sort('modified'); ?></th>
                                    <th class="actions"><?php echo __('Actions'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($notes as $note): ?>
                                    <tr>
                                        <td>
                                            <?php echo $this->Html->link($note['License']['license_id'], array('controller' => 'licenses', 'action' => 'view', $note['License']['id'], 'admin' => false), array('target' => '_blank')); ?>
                                        </td>
                                        <td>
                                            <?php echo $this->Html->link($note['Member']['username'], array('controller' => 'members', 'action' => 'view', $note['Member']['id'])); ?>
                                        </td>
                                        <td><?php echo h($note['Note']['info']); ?>&nbsp;</td>
                                        <td><?php echo h($note['Note']['notices']); ?>&nbsp;</td>
                                        <td><?php echo h($note['Note']['side_effects']); ?>&nbsp;</td>
                                        <td><?php echo h($note['Note']['interactions']); ?>&nbsp;</td>
                                        <td><?php echo h($note['Note']['created']); ?>&nbsp;</td>
                                        <td><?php echo h($note['Note']['modified']); ?>&nbsp;</td>
                                        <td class="actions">
                                            <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $note['Note']['id']), array('class' => 'btn btn-default')); ?>
                                            <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $note['Note']['id']), array('class' => 'btn btn-default'), __('Are you sure you want to delete # %s?', $note['Note']['id'])); ?>
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