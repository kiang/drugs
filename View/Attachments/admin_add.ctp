<!-- Content Header (Page header) -->
<h4>檔案新增</h4>
<ol class="breadcrumb">
    <li><?php echo $this->Html->link('列表', array('action' => 'index')); ?> </li>
    <li class="active">檔案新增</li>
</ol>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                </div>
                <div class="box-body">
                    <div class="attachments form">
                        <?php echo $this->Form->create('Attachment'); ?>
                        <?php
                        echo $this->Form->input('license_id', array(
                            'type' => 'text',
                            'div' => 'form-group',
                            'label' => 'License ID',
                            'class' => 'form-control',
                        ));
                        echo $this->Form->input('member_id', array(
                            'type' => 'text',
                            'div' => 'form-group',
                            'label' => 'Member ID',
                            'class' => 'form-control',
                        ));
                        echo $this->Form->input('Attachment.info', array(
                            'div' => 'form-group',
                            'class' => 'form-control',
                            'label' => '藥物介紹',
                        ));
                        echo $this->Form->input('Attachment.notices', array(
                            'div' => 'form-group',
                            'class' => 'form-control',
                            'label' => '注意事項',
                        ));
                        echo $this->Form->input('Attachment.side_effects', array(
                            'div' => 'form-group',
                            'class' => 'form-control',
                            'label' => '副作用',
                        ));
                        echo $this->Form->input('Attachment.interactions', array(
                            'div' => 'form-group',
                            'class' => 'form-control',
                            'label' => '交互作用',
                        ));
                        ?>
                        <?php echo $this->Form->end(__('Submit')); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>