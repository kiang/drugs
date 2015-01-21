<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>會員編輯</h1>
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
                            <legend><?php echo __('Edit Member', true); ?></legend>
                            <?php
                            echo $this->Form->input('id');
                            echo $this->Form->input('username');
                            echo $this->Form->input('group_id');
                            echo $this->Form->input('password', array('value' => ''));
                            echo $this->Form->input('user_status', array(
                                'type' => 'radio',
                                'options' => array('Y' => 'Y', 'N' => 'N')));
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