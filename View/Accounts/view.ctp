<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php echo __('Account'); ?></h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                </div>
                <div class="box-body">
                    <div class="accounts view">
                        <dl>
                            <dt><?php echo __('Id'); ?></dt>
                            <dd>
                                <?php echo h($account['Account']['id']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Member'); ?></dt>
                            <dd>
                                <?php echo $this->Html->link($account['Member']['id'], array('controller' => 'members', 'action' => 'view', $account['Member']['id'])); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Name'); ?></dt>
                            <dd>
                                <?php echo h($account['Account']['name']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Dob'); ?></dt>
                            <dd>
                                <?php echo h($account['Account']['dob']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Gender'); ?></dt>
                            <dd>
                                <?php echo h($account['Account']['gender']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Note'); ?></dt>
                            <dd>
                                <?php echo h($account['Account']['note']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Created'); ?></dt>
                            <dd>
                                <?php echo h($account['Account']['created']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Modified'); ?></dt>
                            <dd>
                                <?php echo h($account['Account']['modified']); ?>
                                &nbsp;
                            </dd>
                        </dl>
                    </div>
                    <div class="actions">
                        <h3><?php echo __('Actions'); ?></h3>
                        <ul>
                            <li><?php echo $this->Html->link(__('Edit Account'), array('action' => 'edit', $account['Account']['id'])); ?> </li>
                            <li><?php echo $this->Form->postLink(__('Delete Account'), array('action' => 'delete', $account['Account']['id']), array(), __('Are you sure you want to delete # %s?', $account['Account']['id'])); ?> </li>
                            <li><?php echo $this->Html->link(__('List Accounts'), array('action' => 'index')); ?> </li>
                            <li><?php echo $this->Html->link(__('New Account'), array('action' => 'add')); ?> </li>
                            <li><?php echo $this->Html->link(__('List Members'), array('controller' => 'members', 'action' => 'index')); ?> </li>
                            <li><?php echo $this->Html->link(__('New Member'), array('controller' => 'members', 'action' => 'add')); ?> </li>
                            <li><?php echo $this->Html->link(__('List Orders'), array('controller' => 'orders', 'action' => 'index')); ?> </li>
                            <li><?php echo $this->Html->link(__('New Order'), array('controller' => 'orders', 'action' => 'add')); ?> </li>
                        </ul>
                    </div>
                    <div class="related">
                        <h3><?php echo __('Related Orders'); ?></h3>
                        <?php if (!empty($account['Order'])): ?>
                            <table cellpadding = "0" cellspacing = "0">
                                <tr>
                                    <th><?php echo __('Id'); ?></th>
                                    <th><?php echo __('Account Id'); ?></th>
                                    <th><?php echo __('Nhi Area'); ?></th>
                                    <th><?php echo __('Point Id'); ?></th>
                                    <th><?php echo __('Point'); ?></th>
                                    <th><?php echo __('Order Date'); ?></th>
                                    <th><?php echo __('Note Date'); ?></th>
                                    <th><?php echo __('Nhi Sn'); ?></th>
                                    <th><?php echo __('Nhi Sort'); ?></th>
                                    <th><?php echo __('Disease Code'); ?></th>
                                    <th><?php echo __('Disease'); ?></th>
                                    <th><?php echo __('Process Code'); ?></th>
                                    <th><?php echo __('Process'); ?></th>
                                    <th><?php echo __('Money Order'); ?></th>
                                    <th><?php echo __('Money Register'); ?></th>
                                    <th><?php echo __('Nhi Points'); ?></th>
                                    <th><?php echo __('Created'); ?></th>
                                    <th><?php echo __('Modified'); ?></th>
                                    <th class="actions"><?php echo __('Actions'); ?></th>
                                </tr>
                                <?php foreach ($account['Order'] as $order): ?>
                                    <tr>
                                        <td><?php echo $order['id']; ?></td>
                                        <td><?php echo $order['account_id']; ?></td>
                                        <td><?php echo $order['nhi_area']; ?></td>
                                        <td><?php echo $order['point_id']; ?></td>
                                        <td><?php echo $order['point']; ?></td>
                                        <td><?php echo $order['order_date']; ?></td>
                                        <td><?php echo $order['note_date']; ?></td>
                                        <td><?php echo $order['nhi_sn']; ?></td>
                                        <td><?php echo $order['nhi_sort']; ?></td>
                                        <td><?php echo $order['disease_code']; ?></td>
                                        <td><?php echo $order['disease']; ?></td>
                                        <td><?php echo $order['process_code']; ?></td>
                                        <td><?php echo $order['process']; ?></td>
                                        <td><?php echo $order['money_order']; ?></td>
                                        <td><?php echo $order['money_register']; ?></td>
                                        <td><?php echo $order['nhi_points']; ?></td>
                                        <td><?php echo $order['created']; ?></td>
                                        <td><?php echo $order['modified']; ?></td>
                                        <td class="actions">
                                            <?php echo $this->Html->link(__('View'), array('controller' => 'orders', 'action' => 'view', $order['id'])); ?>
                                            <?php echo $this->Html->link(__('Edit'), array('controller' => 'orders', 'action' => 'edit', $order['id'])); ?>
                                            <?php echo $this->Form->postLink(__('Delete'), array('controller' => 'orders', 'action' => 'delete', $order['id']), array(), __('Are you sure you want to delete # %s?', $order['id'])); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        <?php endif; ?>

                        <div class="actions">
                            <ul>
                                <li><?php echo $this->Html->link(__('New Order'), array('controller' => 'orders', 'action' => 'add')); ?> </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
