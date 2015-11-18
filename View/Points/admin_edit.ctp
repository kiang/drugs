<h4>編輯醫事機構</h4>
<ol class="breadcrumb">
    <li><?php echo $this->Html->link('列表', array('action' => 'index')); ?></li>
    <li class="active">編輯醫事機構</li>
</ol>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                </div>
                <div class="box-body">
                    <div class="points form">
                        <?php echo $this->Form->create('Point'); ?>
                        <?php
                        echo $this->Form->input('id');
                        echo $this->Form->input('name', array(
                            'type' => 'text',
                            'div' => 'form-group',
                            'label' => '醫事機構名稱',
                            'class' => 'form-control',
                        ));
                        echo $this->Form->input('nhi_id', array(
                            'type' => 'text',
                            'div' => 'form-group',
                            'label' => '醫事機構代碼',
                            'class' => 'form-control',
                        ));
                        echo $this->Form->input('nhi_end', array(
                            'type' => 'text',
                            'div' => 'form-group',
                            'label' => '健保終止合約或歇業日期',
                            'class' => 'form-control',
                        ));
                        echo $this->Form->input('type', array(
                            'type' => 'text',
                            'div' => 'form-group',
                            'label' => '健保特約類別',
                            'class' => 'form-control',
                        ));
                        echo $this->Form->input('category', array(
                            'type' => 'text',
                            'div' => 'form-group',
                            'label' => '診療科別',
                            'class' => 'form-control',
                        ));
                        echo $this->Form->input('biz_type', array(
                            'type' => 'text',
                            'div' => 'form-group',
                            'label' => '醫事機構種類',
                            'class' => 'form-control',
                        ));
                        echo $this->Form->input('service', array(
                            'type' => 'text',
                            'div' => 'form-group',
                            'label' => '服務項目',
                            'class' => 'form-control',
                        ));
                        echo $this->Form->input('city', array(
                            'type' => 'text',
                            'div' => 'form-group',
                            'label' => '縣市',
                            'class' => 'form-control',
                        ));
                        echo $this->Form->input('town', array(
                            'type' => 'text',
                            'div' => 'form-group',
                            'label' => '鄉鎮市區',
                            'class' => 'form-control',
                        ));
                        echo $this->Form->input('address', array(
                            'type' => 'text',
                            'div' => 'form-group',
                            'label' => '住址',
                            'class' => 'form-control',
                        ));
                        echo $this->Form->input('longitude', array(
                            'type' => 'text',
                            'div' => 'form-group',
                            'label' => '經度',
                            'class' => 'form-control',
                        ));
                        echo $this->Form->input('latitude', array(
                            'type' => 'text',
                            'div' => 'form-group',
                            'label' => '緯度',
                            'class' => 'form-control',
                        ));
                        echo $this->Form->input('phone', array(
                            'type' => 'text',
                            'div' => 'form-group',
                            'label' => '電話',
                            'class' => 'form-control',
                        ));
                        echo $this->Form->input('url', array(
                            'type' => 'text',
                            'div' => 'form-group',
                            'label' => '網址',
                            'class' => 'form-control',
                        ));
                        ?>
                        <?php echo $this->Form->end(__('Submit')); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>