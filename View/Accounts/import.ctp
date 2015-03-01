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
                    <div class="alert alert-info alert-dismissable">
                        <i class="fa fa-info"></i>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <ul>
                            <li>一般取得的檔案名稱像是 "健康存摺_1040210.zip" ，這個壓縮檔案需要透過身份證字號解壓縮</li>
                            <li>也可以匯入個別網頁檔案，像是 "門診及交付機構資料+醫令明細表_10312_1040210.html"</li>
                            <li>目前程式只處理 醫令明細表 中的資料，處理完成後會告知匯入的醫囑數量</li>
                        </ul>
                    </div>

                    <div class="accounts form">
                        <?php echo $this->Form->create('Account', array('type' => 'file')); ?>
                        <?php
                        echo $this->Form->input('password', array(
                            'type' => 'text',
                            'div' => 'form-group',
                            'label' => '密碼',
                            'class' => 'form-control',
                            'placeholder' => '預設是本人的身份證字號，如果是匯入 html 格式則不需要輸入密碼',
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