<!-- Content Header (Page header) -->
<h4>檔案編輯</h4>
<ol class="breadcrumb">
    <li><?php echo $this->Html->link('列表', array('action' => 'index')); ?> </li>
    <li class="active">檔案編輯</li>
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
                        echo $this->Media->embed('l/' . $this->data['Attachment']['path']);
                        echo '<br />';
                        echo $this->Html->link('< 向左', array('action' => 'rotate', $this->data['Attachment']['id'], '270'));
                        echo ' | ' . $this->Html->link('180 度翻轉', array('action' => 'rotate', $this->data['Attachment']['id'], '180'));
                        echo ' | ' . $this->Html->link('向右 >', array('action' => 'rotate', $this->data['Attachment']['id'], '90'));
                        echo $this->Form->input('id');
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