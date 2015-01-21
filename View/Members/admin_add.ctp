<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>新增會員</h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                </div>
                <div class="box-body">
                    <div class="members form">
                        <?php echo $this->Form->create('Member'); ?>
                        <fieldset>
                            <?php
                            echo $this->Form->input('group_id');
                            echo $this->Form->input('username');
                            echo $this->Form->input('password');
                            echo $this->Form->input('user_status', array(
                                'type' => 'radio',
                                'options' => array('Y' => 'Y', 'N' => 'N'),
                                'value' => 'Y'));
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
