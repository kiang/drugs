<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php echo __('Admin Edit Point'); ?></h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                </div>
                <div class="box-body">
                    <div class="points form">
                        <?php echo $this->Form->create('Point'); ?>
                        <?php
                        echo $this->Form->input('id');
                        echo $this->Form->input('type');
                        echo $this->Form->input('status');
                        echo $this->Form->input('name');
                        echo $this->Form->input('city');
                        echo $this->Form->input('town');
                        echo $this->Form->input('address');
                        echo $this->Form->input('longitude');
                        echo $this->Form->input('latitude');
                        echo $this->Form->input('owner');
                        echo $this->Form->input('owner_gender');
                        echo $this->Form->input('phone');
                        echo $this->Form->input('is_nhc');
                        ?>
                        <?php echo $this->Form->end(__('Submit')); ?>
                    </div>
                    <div class="actions">
                        <h3><?php echo __('Actions'); ?></h3>
                        <ul>

                            <li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Point.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('Point.id'))); ?></li>
                            <li><?php echo $this->Html->link(__('List Points'), array('action' => 'index')); ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>