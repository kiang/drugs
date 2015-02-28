<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php
        echo implode(' > ', array(
            $this->Html->link('健康存摺', array('controller' => 'accounts', 'action' => 'index')),
            $this->Html->link($account['Account']['name'] . ' 的就醫記錄', array('action' => 'view', $account['Account']['id'])),
            '匯入健保局健康存摺',
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
                    <div class="accounts form">
                        <?php echo $this->Form->create('Account', array('type' => 'file')); ?>
                        <?php
                        echo $this->Form->input('password', array(
                            'type' => 'text',
                            'div' => 'form-group',
                            'label' => '密碼',
                            'class' => 'form-control',
                            'placeholder' => '預設是本人的身份證字號',
                        ));
                        echo $this->Form->input('file', array(
                            'type' => 'file',
                            'div' => 'form-group',
                            'label' => '檔案',
                            'class' => 'form-control',
                            'placeholder' => '',
                        ));
                        echo $this->Form->submit('儲存', array('class' => 'btn btn-primary', 'div' => false));
                        echo $this->Html->link('取消', array('action' => 'view', $account['Account']['id']), array('class' => 'btn btn-default'));
                        echo $this->Form->end();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>