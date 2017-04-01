<!-- Content Header (Page header) -->
<h4>檔案</h4>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                </div>
                <div class="box-body">
                    <div class="attachments index">
                        <div class="paging"><?php echo $this->element('paginator'); ?></div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th><?php echo $this->Paginator->sort('model'); ?></th>
                                    <th><?php echo $this->Paginator->sort('foreign_key'); ?></th>
                                    <th><?php echo $this->Paginator->sort('member_id'); ?></th>
                                    <th>Thunbnail</th>
                                    <th><?php echo $this->Paginator->sort('alternative'); ?></th>
                                    <th><?php echo $this->Paginator->sort('group'); ?></th>
                                    <th><?php echo $this->Paginator->sort('created'); ?></th>
                                    <th><?php echo $this->Paginator->sort('modified'); ?></th>
                                    <th class="actions"><?php echo __('Actions'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($attachments as $attachment): ?>
                                    <tr>
                                        <td><?php echo h($attachment['Attachment']['model']); ?>&nbsp;</td>
                                        <td><?php
                                            if ($attachment['Attachment']['model'] === 'License' && isset($licenses[$attachment['Attachment']['foreign_key']])) {
                                                echo $this->Html->link($licenses[$attachment['Attachment']['foreign_key']], '/licenses/view/' . $attachment['Attachment']['foreign_key'], array('target' => '_blank'));
                                            } else {
                                                echo h($attachment['Attachment']['foreign_key']);
                                            }
                                            ?>&nbsp;</td>
                                        <td>
                                            <?php echo $this->Html->link($attachment['Member']['username'], array('controller' => 'members', 'action' => 'view', $attachment['Member']['id'])); ?>
                                        </td>
                                        <td><?php
                                            echo $this->Media->embed('m/' . $attachment['Attachment']['path']);
                                            echo '<br />';
                                            echo $this->Html->link('< 向左', array('action' => 'rotate', $attachment['Attachment']['id'], '270'));
                                            echo ' | ' . $this->Html->link('180 度翻轉', array('action' => 'rotate', $attachment['Attachment']['id'], '180'));
                                            echo ' | ' . $this->Html->link('向右 >', array('action' => 'rotate', $attachment['Attachment']['id'], '90'));
                                            ?>&nbsp;</td>
                                        <td><?php echo h($attachment['Attachment']['alternative']); ?>&nbsp;</td>
                                        <td><?php echo h($attachment['Attachment']['group']); ?>&nbsp;</td>
                                        <td><?php echo h($attachment['Attachment']['created']); ?>&nbsp;</td>
                                        <td><?php echo h($attachment['Attachment']['modified']); ?>&nbsp;</td>
                                        <td class="actions">
                                            <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $attachment['Attachment']['id']), array('class' => 'btn btn-default')); ?>
                                            <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $attachment['Attachment']['id']), array('class' => 'btn btn-default'), __('Are you sure you want to delete # %s?', $attachment['Attachment']['id'])); ?>
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