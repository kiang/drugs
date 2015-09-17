<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php echo __('Admin Add License'); ?></h1>
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
                        echo $this->Form->input('license_id');
                        echo $this->Form->input('code');
                        echo $this->Form->input('source');
                        echo $this->Form->input('nhi_id');
                        echo $this->Form->input('shape');
                        echo $this->Form->input('s_type');
                        echo $this->Form->input('color');
                        echo $this->Form->input('odor');
                        echo $this->Form->input('abrasion');
                        echo $this->Form->input('size');
                        echo $this->Form->input('note_1');
                        echo $this->Form->input('note_2');
                        echo $this->Form->input('image');
                        echo $this->Form->input('cancel_status');
                        echo $this->Form->input('cancel_date');
                        echo $this->Form->input('cancel_reason');
                        echo $this->Form->input('expired_date');
                        echo $this->Form->input('license_date');
                        echo $this->Form->input('license_type');
                        echo $this->Form->input('old_id');
                        echo $this->Form->input('document_id');
                        echo $this->Form->input('name');
                        echo $this->Form->input('name_english');
                        echo $this->Form->input('disease');
                        echo $this->Form->input('formulation');
                        echo $this->Form->input('package');
                        echo $this->Form->input('type');
                        echo $this->Form->input('class');
                        echo $this->Form->input('ingredient');
                        echo $this->Form->input('vendor_id');
                        echo $this->Form->input('submitted');
                        echo $this->Form->input('usage');
                        echo $this->Form->input('package_note');
                        echo $this->Form->input('barcode');
                        echo $this->Form->input('count_daily');
                        echo $this->Form->input('count_all');
                        echo $this->Form->input('Category');
                        echo $this->Form->input('Ingredient');
                        echo $this->Form->input('Article');
                        ?>
                        <?php echo $this->Form->end(__('Submit')); ?>
                    </div>
                    <div class="actions">
                        <h3><?php echo __('Actions'); ?></h3>
                        <ul>

                            <li><?php echo $this->Html->link(__('List Licenses'), array('action' => 'index')); ?></li>
                            <li><?php echo $this->Html->link(__('List Vendors'), array('controller' => 'vendors', 'action' => 'index')); ?> </li>
                            <li><?php echo $this->Html->link(__('New Vendor'), array('controller' => 'vendors', 'action' => 'add')); ?> </li>
                            <li><?php echo $this->Html->link(__('List Drugs'), array('controller' => 'drugs', 'action' => 'index')); ?> </li>
                            <li><?php echo $this->Html->link(__('New Drug'), array('controller' => 'drugs', 'action' => 'add')); ?> </li>
                            <li><?php echo $this->Html->link(__('List Prices'), array('controller' => 'prices', 'action' => 'index')); ?> </li>
                            <li><?php echo $this->Html->link(__('New Price'), array('controller' => 'prices', 'action' => 'add')); ?> </li>
                            <li><?php echo $this->Html->link(__('List Links'), array('controller' => 'links', 'action' => 'index')); ?> </li>
                            <li><?php echo $this->Html->link(__('New Link'), array('controller' => 'links', 'action' => 'add')); ?> </li>
                            <li><?php echo $this->Html->link(__('List Ingredients Licenses'), array('controller' => 'ingredients_licenses', 'action' => 'index')); ?> </li>
                            <li><?php echo $this->Html->link(__('New Ingredients License'), array('controller' => 'ingredients_licenses', 'action' => 'add')); ?> </li>
                            <li><?php echo $this->Html->link(__('List Attachments'), array('controller' => 'attachments', 'action' => 'index')); ?> </li>
                            <li><?php echo $this->Html->link(__('New Attachment'), array('controller' => 'attachments', 'action' => 'add')); ?> </li>
                            <li><?php echo $this->Html->link(__('List Categories'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
                            <li><?php echo $this->Html->link(__('New Category'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
                            <li><?php echo $this->Html->link(__('List Ingredients'), array('controller' => 'ingredients', 'action' => 'index')); ?> </li>
                            <li><?php echo $this->Html->link(__('New Ingredient'), array('controller' => 'ingredients', 'action' => 'add')); ?> </li>
                            <li><?php echo $this->Html->link(__('List Articles'), array('controller' => 'articles', 'action' => 'index')); ?> </li>
                            <li><?php echo $this->Html->link(__('New Article'), array('controller' => 'articles', 'action' => 'add')); ?> </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>