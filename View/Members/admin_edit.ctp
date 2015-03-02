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
                            <?php
                            echo $this->Form->input('id');
                            echo $this->Form->input('group_id', array(
                                'type' => 'select',
                                'div' => 'form-group',
                                'label' => '群組',
                                'class' => 'form-control',
                            ));
                            echo $this->Form->input('username', array(
                                'type' => 'text',
                                'div' => 'form-group',
                                'label' => '帳號',
                                'class' => 'form-control',
                            ));
                            echo $this->Form->input('password', array(
                                'type' => 'password',
                                'div' => 'form-group',
                                'label' => '密碼',
                                'class' => 'form-control',
                                'value' => '',
                            ));
                            echo $this->Form->input('user_status', array(
                                'type' => 'radio',
                                'legend' => '狀態',
                                'div' => 'form-group',
                                'before' => '<div class="radio">',
                                'after' => '</div>',
                                'separator' => ' &nbsp; &nbsp; ',
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