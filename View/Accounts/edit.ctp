<?php
echo $this->Html->script('c/accounts/edit', array('inline' => false));
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>編輯健康存摺</h1>
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
                        <?php echo $this->Form->create('Account'); ?>
                        <?php
                        echo $this->Form->input('name', array(
                            'type' => 'text',
                            'div' => 'form-group',
                            'label' => '名稱',
                            'class' => 'form-control',
                            'placeholder' => '家人或自己的名稱或暱稱',
                        ));
                        echo $this->Form->input('gender', array(
                            'type' => 'select',
                            'label' => '性別',
                            'options' => array(
                                'm' => '男',
                                'f' => '女',
                            ),
                            'div' => 'form-group',
                            'class' => 'form-control',
                        ));
                        echo $this->Form->input('dob', array(
                            'type' => 'text',
                            'div' => 'form-group',
                            'label' => '生日',
                            'class' => 'form-control',
                            'placeholder' => '',
                        ));
                        echo $this->Form->input('note', array(
                            'type' => 'textarea',
                            'div' => 'form-group',
                            'label' => '備註',
                            'class' => 'form-control',
                            'placeholder' => '關於家人或自己的備註，像是過敏情況或偏好等等',
                        ));
                        echo $this->Form->submit('儲存', array('class' => 'btn btn-primary', 'div' => false));
                        echo $this->Html->link('取消', array('action' => 'index'), array('class' => 'btn btn-default'));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>