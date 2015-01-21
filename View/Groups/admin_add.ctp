<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php echo __('Add group', true); ?></h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                </div>
                <div class="box-body">
                    <div class="groups form">
                        <?php echo $this->Form->create('Group', array('url' => array($parentId))); ?>
                        <fieldset>
                            <?php
                            echo $this->Form->input('name', array('label' => __('Name', true)));
                            ?>
                        </fieldset>
                        <?php echo $this->Form->end(__('Submit', true)); ?>
                    </div>
                </div>
                <div class="box-footer clearfix">
                </div>
            </div>
        </div>
    </div>
</section><!-- /.content -->