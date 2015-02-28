<?php
echo $this->Html->script('c/orders/add', array('inline' => false));
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php
    echo implode(' > ', array(
        $this->Html->link('健康存摺', array('controller' => 'accounts', 'action' => 'index')),
        $this->Html->link($account['Account']['name'] . ' 的就醫記錄', array('controller' => 'accounts', 'action' => 'view', $account['Account']['id'])),
        '新增就醫記錄',
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
                    <div class="orders form">
                        <?php echo $this->Form->create('Order'); ?>
                        <?php
                        echo $this->Form->hidden('point_id');
                        echo $this->Form->input('order_date', array(
                            'type' => 'text',
                            'div' => 'form-group',
                            'label' => '就醫日期',
                            'class' => 'form-control',
                            'placeholder' => '就醫與領藥雖然經常是同一天發生，但如果在不同的醫事機構發生（像是到隔壁藥局領藥），建議建立兩筆資料',
                        ));
                        echo $this->Form->input('point', array(
                            'type' => 'text',
                            'div' => 'form-group',
                            'label' => '醫事機構',
                            'class' => 'form-control',
                            'placeholder' => '醫療院所的名稱',
                        ));
                        echo $this->Form->input('phone', array(
                            'type' => 'text',
                            'div' => 'form-group',
                            'label' => '醫事機構電話',
                            'class' => 'form-control',
                            'placeholder' => '醫療院所的電話',
                        ));
                        echo $this->Form->input('address', array(
                            'type' => 'text',
                            'div' => 'form-group',
                            'label' => '醫事機構住址',
                            'class' => 'form-control',
                            'placeholder' => '醫療院所的住址',
                        ));
                        echo $this->Form->input('note_date', array(
                            'type' => 'text',
                            'div' => 'form-group',
                            'label' => '交付調劑、檢查或復健治療日期',
                            'class' => 'form-control',
                            'placeholder' => '如果是藥局領藥，這裡需要刊載實際領藥日期，大部分是同一天',
                        ));
                        echo $this->Form->input('money_register', array(
                            'type' => 'text',
                            'div' => 'form-group',
                            'label' => '掛號費',
                            'class' => 'form-control',
                            'placeholder' => '掛號費',
                        ));
                        echo $this->Form->input('money_order', array(
                            'type' => 'text',
                            'div' => 'form-group',
                            'label' => '部分負擔金額',
                            'class' => 'form-control',
                            'placeholder' => '扣除掛號費之後實際支付金額',
                        ));
                        echo $this->Form->input('nhi_sn', array(
                            'type' => 'text',
                            'div' => 'form-group',
                            'label' => '健保卡就醫序號',
                            'class' => 'form-control',
                            'placeholder' => '',
                        ));
                        echo $this->Form->input('nhi_sort', array(
                            'type' => 'text',
                            'div' => 'form-group',
                            'label' => '健保卡就醫序號排序',
                            'class' => 'form-control',
                            'placeholder' => '同一個健保卡就醫序號可能有看診與領藥的分別，透過這個欄位可以設定順序',
                        ));
                        echo $this->Form->input('disease_code', array(
                            'type' => 'text',
                            'div' => 'form-group',
                            'label' => '疾病分類碼',
                            'class' => 'form-control',
                            'placeholder' => '健保使用的分類系統代碼',
                        ));
                        echo $this->Form->input('disease', array(
                            'type' => 'text',
                            'div' => 'form-group',
                            'label' => '疾病分類名稱',
                            'class' => 'form-control',
                            'placeholder' => '健保使用的分類系統名稱',
                        ));
                        echo $this->Form->input('process_code', array(
                            'type' => 'text',
                            'div' => 'form-group',
                            'label' => '處置碼',
                            'class' => 'form-control',
                            'placeholder' => '健保使用的處置代碼',
                        ));
                        echo $this->Form->input('process', array(
                            'type' => 'text',
                            'div' => 'form-group',
                            'label' => '處置名稱',
                            'class' => 'form-control',
                            'placeholder' => '健保使用的處置名稱',
                        ));
                        echo $this->Form->input('nhi_area', array(
                            'type' => 'text',
                            'div' => 'form-group',
                            'label' => '健保署服務單位',
                            'class' => 'form-control',
                            'placeholder' => '健保署服務單位',
                        ));
                        echo $this->Form->input('nhi_points', array(
                            'type' => 'text',
                            'div' => 'form-group',
                            'label' => '健保支付點數',
                            'class' => 'form-control',
                            'placeholder' => '健保支付點數',
                        ));
                        echo $this->Form->submit('儲存', array('class' => 'btn btn-primary', 'div' => false));
                        echo $this->Html->link('取消', array('controller' => 'accounts', 'action' => 'view', $account['Account']['id']), array('class' => 'btn btn-default'));
                        echo $this->Form->end();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>