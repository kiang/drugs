<h4>新增文章</h4>
<ol class="breadcrumb">
    <li><?php echo $this->Html->link('列表', array('action' => 'index')); ?></li>
    <li class="active">新增文章</li>
</ol>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                </div>
                <div class="box-body">
                    <?php echo $this->Form->create('Article'); ?>
                    <?php
                    echo $this->Form->input('title', array(
                        'type' => 'text',
                        'div' => 'form-group',
                        'label' => '標題',
                        'class' => 'form-control',
                        'placeholder' => '標題',
                    ));
                    echo $this->Form->input('body', array(
                        'type' => 'textarea',
                        'div' => 'form-group',
                        'label' => '內容',
                        'class' => 'form-control',
                        'placeholder' => '內容',
                    ));
                    echo $this->Form->input('url', array(
                        'type' => 'text',
                        'div' => 'form-group',
                        'label' => '外部網址',
                        'class' => 'form-control',
                        'placeholder' => '外部網址',
                    ));
                    echo $this->Form->input('date_published', array(
                        'type' => 'text',
                        'div' => 'form-group',
                        'label' => '文章日期',
                        'class' => 'form-control',
                        'placeholder' => '',
                    ));
                    ?>
                    <div class="form-group">
                        <label for="relatedDrug">相關藥物</label>
                        <ul id="relatedDrug"></ul>
                    </div>
                    <div class="form-group">
                        <label for="relatedIngredient">相關成份</label>
                        <ul id="relatedIngredient"></ul>
                    </div>
                    <div class="form-group">
                        <label for="relatedPoint">相關醫事機構</label>
                        <ul id="relatedPoint"></ul>
                    </div>
                    <div class="form-group">
                        <label for="relatedVendor">相關藥廠</label>
                        <ul id="relatedVendor"></ul>
                    </div>
                    <?php echo $this->Form->end(__('Submit')); ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
echo $this->Html->script('c/articles/admin_add', array('inline' => false));
?>