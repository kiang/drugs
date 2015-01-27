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
                    <fieldset>
                        <?php
                        echo $this->Form->input('id');
                        echo $this->Form->input('title');
                        echo $this->Form->input('body');
                        echo $this->Form->input('url');
                        echo $this->Form->input('License');
                        echo $this->Form->input('Ingredient');
                        echo $this->Form->input('Point');
                        ?>
                    </fieldset>
                    <?php echo $this->Form->end(__('Submit')); ?>
                </div>
            </div>
        </div>
    </div>
</section>