<?php
echo $this->Html->script('c/order_lines/add', array('inline' => false));
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php
        echo implode(' > ', array(
            $this->Html->link('健康存摺', array('controller' => 'accounts', 'action' => 'index')),
            $this->Html->link($order['Account']['name'] . ' 的就醫記錄', array('controller' => 'accounts', 'action' => 'view', $order['Account']['id'])),
            $this->Html->link($order['Order']['order_date'], array('controller' => 'orders', 'action' => 'view', $order['Order']['id'])),
            '新增記錄明細',
        ));
        ?></h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                </div>
                <div class="box-body">
                    <div class="orderLines form">
                        <?php echo $this->Form->create('OrderLine'); ?>
                        <?php
                        echo $this->Form->input('code', array(
                            'type' => 'text',
                            'div' => 'form-group',
                            'label' => '醫囑代碼',
                            'class' => 'form-control',
                            'placeholder' => '醫囑代碼',
                        ));
                        echo $this->Form->input('note', array(
                            'type' => 'text',
                            'div' => 'form-group',
                            'label' => '醫囑名稱',
                            'class' => 'form-control',
                            'placeholder' => '醫囑名稱',
                        ));
                        echo $this->Form->input('quantity', array(
                            'type' => 'text',
                            'div' => 'form-group',
                            'label' => '醫囑總量',
                            'class' => 'form-control',
                            'placeholder' => '醫囑總量',
                        ));
                        echo $this->Form->hidden('model');
                        echo $this->Form->hidden('foreign_id');
                        echo $this->Form->submit('儲存', array('class' => 'btn btn-primary', 'div' => false));
                        echo $this->Html->link('取消', array('controller' => 'orders', 'action' => 'view', $order['Order']['id']), array('class' => 'btn btn-default'));
                        echo $this->Form->end();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>