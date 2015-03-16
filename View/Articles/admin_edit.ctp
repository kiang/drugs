<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>編輯文章</h1>
</section>

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
                    echo $this->Form->hidden('id');
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
                        <ul id="relatedDrug"><?php
                            if (!empty($this->data['Drug'])) {
                                foreach ($this->data['Drug'] AS $itemId => $itemLabel) {
                                    echo '<li data-id="' . $itemId . '">' . $itemLabel . '</li>';
                                }
                            }
                            ?></ul>
                    </div>
                    <div class="form-group">
                        <label for="relatedIngredient">相關成份</label>
                        <ul id="relatedIngredient"><?php
                            if (!empty($this->data['Ingredient'])) {
                                foreach ($this->data['Ingredient'] AS $itemId => $itemLabel) {
                                    echo '<li data-id="' . $itemId . '">' . $itemLabel . '</li>';
                                }
                            }
                            ?></ul>
                    </div>
                    <div class="form-group">
                        <label for="relatedPoint">相關醫事機構</label>
                        <ul id="relatedPoint"><?php
                            if (!empty($this->data['Point'])) {
                                foreach ($this->data['Point'] AS $itemId => $itemLabel) {
                                    echo '<li data-id="' . $itemId . '">' . $itemLabel . '</li>';
                                }
                            }
                            ?></ul>
                    </div>
                    <div class="form-group">
                        <label for="relatedVendor">相關藥廠</label>
                        <ul id="relatedVendor"><?php
                            if (!empty($this->data['Vendor'])) {
                                foreach ($this->data['Vendor'] AS $itemId => $itemLabel) {
                                    echo '<li data-id="' . $itemId . '">' . $itemLabel . '</li>';
                                }
                            }
                            ?></ul>
                    </div>
                    <?php echo $this->Form->end(__('Submit')); ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
echo $this->Html->script('c/articles/admin_edit', array('inline' => false));
?>