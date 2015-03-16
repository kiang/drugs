<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php
        echo implode(' > ', array(
            $this->Html->link('暫存連結', array('action' => 'tasks')),
            '新增暫存連結',
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
                    <?php echo $this->Form->create('Article'); ?>
                    <?php
                    echo $this->Form->input('task_date', array(
                        'type' => 'text',
                        'div' => 'form-group',
                        'label' => '連結日期',
                        'class' => 'form-control',
                    ));
                    echo $this->Form->input('links', array(
                        'type' => 'textarea',
                        'rows' => '20',
                        'div' => 'form-group',
                        'label' => '連結',
                        'class' => 'form-control',
                    ));
                    ?>
                    <?php echo $this->Form->end(__('Submit')); ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
echo $this->Html->script('c/articles/admin_tasks_add', array('inline' => false));
?>