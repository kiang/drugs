<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php echo __('Point'); ?></h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                </div>
                <div class="box-body">
                    <div class="points view">
                        <dl>
                            <dt><?php echo __('Id'); ?></dt>
                            <dd>
                                <?php echo h($point['Point']['id']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Type'); ?></dt>
                            <dd>
                                <?php echo h($point['Point']['type']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Status'); ?></dt>
                            <dd>
                                <?php echo h($point['Point']['status']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Name'); ?></dt>
                            <dd>
                                <?php echo h($point['Point']['name']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('City'); ?></dt>
                            <dd>
                                <?php echo h($point['Point']['city']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Town'); ?></dt>
                            <dd>
                                <?php echo h($point['Point']['town']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Address'); ?></dt>
                            <dd>
                                <?php echo h($point['Point']['address']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Longitude'); ?></dt>
                            <dd>
                                <?php echo h($point['Point']['longitude']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Latitude'); ?></dt>
                            <dd>
                                <?php echo h($point['Point']['latitude']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Owner'); ?></dt>
                            <dd>
                                <?php echo h($point['Point']['owner']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Owner Gender'); ?></dt>
                            <dd>
                                <?php echo h($point['Point']['owner_gender']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Phone'); ?></dt>
                            <dd>
                                <?php echo h($point['Point']['phone']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Is Nhc'); ?></dt>
                            <dd>
                                <?php echo h($point['Point']['is_nhc']); ?>
                                &nbsp;
                            </dd>
                        </dl>
                    </div>
                    <div class="actions">
                        <h3><?php echo __('Actions'); ?></h3>
                        <ul>
                            <li><?php echo $this->Html->link(__('Edit Point'), array('action' => 'edit', $point['Point']['id'])); ?> </li>
                            <li><?php echo $this->Form->postLink(__('Delete Point'), array('action' => 'delete', $point['Point']['id']), array(), __('Are you sure you want to delete # %s?', $point['Point']['id'])); ?> </li>
                            <li><?php echo $this->Html->link(__('List Points'), array('action' => 'index')); ?> </li>
                            <li><?php echo $this->Html->link(__('New Point'), array('action' => 'add')); ?> </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
