<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php echo __('Order'); ?></h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                </div>
                <div class="box-body">
                    <div class="orders view">
                        <dl>
                            <dt><?php echo __('Id'); ?></dt>
                            <dd>
                                <?php echo h($order['Order']['id']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Account'); ?></dt>
                            <dd>
                                <?php echo $this->Html->link($order['Account']['name'], array('controller' => 'accounts', 'action' => 'view', $order['Account']['id'])); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Nhi Area'); ?></dt>
                            <dd>
                                <?php echo h($order['Order']['nhi_area']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Point'); ?></dt>
                            <dd>
                                <?php echo $this->Html->link($order['Point']['name'], array('controller' => 'points', 'action' => 'view', $order['Point']['id'])); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Point'); ?></dt>
                            <dd>
                                <?php echo h($order['Order']['point']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Order Date'); ?></dt>
                            <dd>
                                <?php echo h($order['Order']['order_date']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Note Date'); ?></dt>
                            <dd>
                                <?php echo h($order['Order']['note_date']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Nhi Sn'); ?></dt>
                            <dd>
                                <?php echo h($order['Order']['nhi_sn']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Nhi Sort'); ?></dt>
                            <dd>
                                <?php echo h($order['Order']['nhi_sort']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Disease Code'); ?></dt>
                            <dd>
                                <?php echo h($order['Order']['disease_code']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Disease'); ?></dt>
                            <dd>
                                <?php echo h($order['Order']['disease']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Process Code'); ?></dt>
                            <dd>
                                <?php echo h($order['Order']['process_code']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Process'); ?></dt>
                            <dd>
                                <?php echo h($order['Order']['process']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Money Order'); ?></dt>
                            <dd>
                                <?php echo h($order['Order']['money_order']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Money Register'); ?></dt>
                            <dd>
                                <?php echo h($order['Order']['money_register']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Nhi Points'); ?></dt>
                            <dd>
                                <?php echo h($order['Order']['nhi_points']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Created'); ?></dt>
                            <dd>
                                <?php echo h($order['Order']['created']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Modified'); ?></dt>
                            <dd>
                                <?php echo h($order['Order']['modified']); ?>
                                &nbsp;
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
