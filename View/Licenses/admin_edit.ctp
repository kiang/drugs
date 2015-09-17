<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>編輯藥證</h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                </div>
                <div class="box-body">
                    <div class="licenses form">
                        <?php echo $this->Form->create('License'); ?>
                        <?php
                        echo $this->Form->input('id');
                        echo $this->Form->input('license_id', array(
                            'type' => 'text',
                            'class' => 'col-md-8',
                            'div' => 'col-md-6',
                        ));
                        echo $this->Form->input('nhi_id', array(
                            'type' => 'text',
                            'class' => 'col-md-8',
                            'div' => 'col-md-6',
                        ));
                        echo $this->Form->input('shape', array(
                            'type' => 'text',
                            'class' => 'col-md-8',
                            'div' => 'col-md-6',
                        ));
                        echo $this->Form->input('s_type', array(
                            'type' => 'text',
                            'class' => 'col-md-8',
                            'div' => 'col-md-6',
                        ));
                        echo $this->Form->input('color', array(
                            'type' => 'text',
                            'class' => 'col-md-8',
                            'div' => 'col-md-6',
                        ));
                        echo $this->Form->input('odor', array(
                            'type' => 'text',
                            'class' => 'col-md-8',
                            'div' => 'col-md-6',
                        ));
                        echo $this->Form->input('abrasion', array(
                            'type' => 'text',
                            'class' => 'col-md-8',
                            'div' => 'col-md-6',
                        ));
                        echo $this->Form->input('size', array(
                            'type' => 'text',
                            'class' => 'col-md-8',
                            'div' => 'col-md-6',
                        ));
                        echo $this->Form->input('note_1', array(
                            'type' => 'text',
                            'class' => 'col-md-8',
                            'div' => 'col-md-6',
                        ));
                        echo $this->Form->input('note_2', array(
                            'type' => 'text',
                            'class' => 'col-md-8',
                            'div' => 'col-md-6',
                        ));
                        echo $this->Form->input('image', array(
                            'type' => 'text',
                            'class' => 'col-md-8',
                            'div' => 'col-md-6',
                        ));
                        echo $this->Form->input('cancel_status', array(
                            'type' => 'text',
                            'class' => 'col-md-8',
                            'div' => 'col-md-6',
                        ));
                        echo $this->Form->input('cancel_date', array(
                            'type' => 'text',
                            'class' => 'col-md-8',
                            'div' => 'col-md-6',
                        ));
                        echo $this->Form->input('cancel_reason', array(
                            'type' => 'text',
                            'class' => 'col-md-8',
                            'div' => 'col-md-6',
                        ));
                        echo $this->Form->input('expired_date', array(
                            'type' => 'text',
                            'class' => 'col-md-8',
                            'div' => 'col-md-6',
                        ));
                        echo $this->Form->input('license_date', array(
                            'type' => 'text',
                            'class' => 'col-md-8',
                            'div' => 'col-md-6',
                        ));
                        echo $this->Form->input('license_type', array(
                            'type' => 'text',
                            'class' => 'col-md-8',
                            'div' => 'col-md-6',
                        ));
                        echo $this->Form->input('old_id', array(
                            'type' => 'text',
                            'class' => 'col-md-8',
                            'div' => 'col-md-6',
                        ));
                        echo $this->Form->input('document_id', array(
                            'type' => 'text',
                            'class' => 'col-md-8',
                            'div' => 'col-md-6',
                        ));
                        echo $this->Form->input('name', array(
                            'type' => 'text',
                            'class' => 'col-md-8',
                            'div' => 'col-md-6',
                        ));
                        echo $this->Form->input('name_english', array(
                            'type' => 'text',
                            'class' => 'col-md-8',
                            'div' => 'col-md-6',
                        ));
                        echo $this->Form->input('disease', array(
                            'type' => 'textarea',
                            'class' => 'col-md-12',
                            'div' => 'col-md-12',
                        ));
                        echo $this->Form->input('formulation', array(
                            'type' => 'text',
                            'class' => 'col-md-8',
                            'div' => 'col-md-6',
                        ));
                        echo $this->Form->input('package', array(
                            'type' => 'text',
                            'class' => 'col-md-8',
                            'div' => 'col-md-6',
                        ));
                        echo $this->Form->input('type', array(
                            'type' => 'text',
                            'class' => 'col-md-8',
                            'div' => 'col-md-6',
                        ));
                        echo $this->Form->input('class', array(
                            'type' => 'text',
                            'class' => 'col-md-8',
                            'div' => 'col-md-6',
                        ));
                        echo $this->Form->input('ingredient', array(
                            'type' => 'text',
                            'class' => 'col-md-8',
                            'div' => 'col-md-6',
                        ));
                        echo $this->Form->input('vendor_id', array(
                            'type' => 'text',
                            'class' => 'col-md-8',
                            'div' => 'col-md-6',
                        ));
                        echo $this->Form->input('submitted', array(
                            'type' => 'text',
                            'class' => 'col-md-8',
                            'div' => 'col-md-6',
                        ));
                        echo $this->Form->input('usage', array(
                            'type' => 'textarea',
                            'class' => 'col-md-12',
                            'div' => 'col-md-12',
                        ));
                        echo $this->Form->input('package_note', array(
                            'type' => 'text',
                            'class' => 'col-md-8',
                            'div' => 'col-md-6',
                        ));
                        echo $this->Form->input('barcode', array(
                            'type' => 'text',
                            'class' => 'col-md-8',
                            'div' => 'col-md-6',
                        ));
                        ?>
                        <div class="clearfix"></div>
                        <?php echo $this->Form->end(__('Submit')); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>