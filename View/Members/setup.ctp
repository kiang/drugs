<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>會員</h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                </div>
                <div class="box-body">
                    <?php
                    echo $this->Form->create('Member', array('action' => 'setup'));
                    echo $this->Form->input('username');
                    echo $this->Form->input('password', array('type' => 'password', 'value' => ''));
                    echo $this->Form->end(__('Create Administrator', true));
                    ?>
                </div>
                <div class="box-footer clearfix">
                </div>
            </div>
        </div>
    </div>
</section><!-- /.content -->