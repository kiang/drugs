<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php echo __('Accounts'); ?></h1>
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
                                    <th><?php echo $this->Paginator->sort('id'); ?></th>
                                    <th><?php echo $this->Paginator->sort('member_id'); ?></th>
                                    <th><?php echo $this->Paginator->sort('name'); ?></th>
                                    <th><?php echo $this->Paginator->sort('dob'); ?></th>
                                    <th><?php echo $this->Paginator->sort('gender'); ?></th>
                                    <th><?php echo $this->Paginator->sort('note'); ?></th>
                                    <th><?php echo $this->Paginator->sort('created'); ?></th>
                                    <th><?php echo $this->Paginator->sort('modified'); ?></th>
                                    <th class="actions"><?php echo __('Actions'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($accounts as $account): ?>
                                    <tr>
                                        <td><?php echo h($account['Account']['id']); ?>&nbsp;</td>
                                        <td>
                                            <?php echo $this->Html->link($account['Member']['id'], array('controller' => 'members', 'action' => 'view', $account['Member']['id'])); ?>
                                        </td>
                                        <td><?php echo h($account['Account']['name']); ?>&nbsp;</td>
                                        <td><?php echo h($account['Account']['dob']); ?>&nbsp;</td>
                                        <td><?php echo h($account['Account']['gender']); ?>&nbsp;</td>
                                        <td><?php echo h($account['Account']['note']); ?>&nbsp;</td>
                                        <td><?php echo h($account['Account']['created']); ?>&nbsp;</td>
                                        <td><?php echo h($account['Account']['modified']); ?>&nbsp;</td>
                                        <td class="actions">
                                            <?php echo $this->Html->link(__('View'), array('action' => 'view', $account['Account']['id'])); ?>
                                            <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $account['Account']['id'])); ?>
                                            <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $account['Account']['id']), array(), __('Are you sure you want to delete # %s?', $account['Account']['id'])); ?>
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
                            <li><?php echo $this->Html->link(__('New Account'), array('action' => 'add')); ?></li>
                            <li><?php echo $this->Html->link(__('List Members'), array('controller' => 'members', 'action' => 'index')); ?> </li>
                            <li><?php echo $this->Html->link(__('New Member'), array('controller' => 'members', 'action' => 'add')); ?> </li>
                            <li><?php echo $this->Html->link(__('List Orders'), array('controller' => 'orders', 'action' => 'index')); ?> </li>
                            <li><?php echo $this->Html->link(__('New Order'), array('controller' => 'orders', 'action' => 'add')); ?> </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>