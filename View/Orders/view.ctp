<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php
        echo implode(' > ', array(
            $this->Html->link('健康存摺', array('controller' => 'accounts', 'action' => 'index')),
            $this->Html->link($order['Account']['name'] . ' 的就醫記錄', array('controller' => 'accounts', 'action' => 'view', $order['Account']['id'])),
            h($order['Order']['order_date']),
            $this->Html->link('新增記錄明細', array('controller' => 'order_lines', 'action' => 'add', $order['Order']['id']), array('class' => 'btn btn-primary')),
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
                    <div class="orders view">
                        <dl>
                            <dt>就醫日期</dt>
                            <dd>
                                <?php echo h($order['Order']['order_date']); ?>
                                &nbsp;
                            </dd>
                            <dt>醫事機構</dt>
                            <dd>
                                <?php
                                if (!empty($order['Order']['point_id'])) {
                                    echo $this->Html->link($order['Order']['point'], array('controller' => 'points', 'action' => 'view', $order['Order']['point_id']), array('target' => '_blank'));
                                } else {
                                    echo $order['Order']['point'];
                                }
                                ?>
                                &nbsp;
                            </dd>
                            <dt>醫事機構電話</dt>
                            <dd>
                                <?php echo h($order['Order']['phone']); ?>
                                &nbsp;
                            </dd>
                            <dt>醫事機構住址</dt>
                            <dd>
                                <?php echo h($order['Order']['address']); ?>
                                &nbsp;
                            </dd>
                            <dt>交付調劑、檢查或復健治療日期</dt>
                            <dd>
                                <?php echo h($order['Order']['note_date']); ?>
                                &nbsp;
                            </dd>
                            <dt>掛號費</dt>
                            <dd>
                                <?php echo h($order['Order']['money_register']); ?>
                                &nbsp;
                            </dd>
                            <dt>部分負擔金額</dt>
                            <dd>
                                <?php echo h($order['Order']['money_order']); ?>
                                &nbsp;
                            </dd>
                            <dt>健保卡就醫序號</dt>
                            <dd>
                                <?php echo h($order['Order']['nhi_sn']); ?>
                                &nbsp;
                            </dd>
                            <dt>健保卡就醫序號排序</dt>
                            <dd>
                                <?php echo h($order['Order']['nhi_sort']); ?>
                                &nbsp;
                            </dd>
                            <dt>疾病分類碼</dt>
                            <dd>
                                <?php echo h($order['Order']['disease_code']); ?>
                                &nbsp;
                            </dd>
                            <dt>疾病分類名稱</dt>
                            <dd>
                                <?php echo h($order['Order']['disease']); ?>
                                &nbsp;
                            </dd>
                            <dt>處置碼</dt>
                            <dd>
                                <?php echo h($order['Order']['process_code']); ?>
                                &nbsp;
                            </dd>
                            <dt>處置名稱</dt>
                            <dd>
                                <?php echo h($order['Order']['process']); ?>
                                &nbsp;
                            </dd>
                            <dt>健保署服務單位</dt>
                            <dd>
                                <?php echo h($order['Order']['nhi_area']); ?>
                                &nbsp;
                            </dd>
                            <dt>健保支付點數</dt>
                            <dd>
                                <?php echo h($order['Order']['nhi_points']); ?>
                                &nbsp;
                            </dd>
                            <dt>建立時間</dt>
                            <dd>
                                <?php echo h($order['Order']['created']); ?>
                                &nbsp;
                            </dd>
                            <dt>更新時間</dt>
                            <dd>
                                <?php echo h($order['Order']['modified']); ?>
                                &nbsp;
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="box">
                <div class="box-header">
                </div>
                <div class="box-body">
                    <div class="orderLines index">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>醫囑代碼</th>
                                    <th>醫囑名稱</th>
                                    <th>醫囑總量</th>
                                    <th class="actions">操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orderLines as $orderLine): ?>
                                    <tr>
                                        <td><?php echo h($orderLine['OrderLine']['code']); ?>&nbsp;</td>
                                        <td><?php
                                        if(!empty($orderLine['OrderLine']['foreign_key'])) {
                                            switch($orderLine['OrderLine']['model']) {
                                                case 'Drug':
                                                    echo $this->Html->link($orderLine['OrderLine']['note'], array('controller' => 'drugs', 'action' => 'view', $orderLine['OrderLine']['foreign_key']), array('target' => '_blank'));
                                                    break;
                                            }
                                        } else {
                                            echo h($orderLine['OrderLine']['note']);
                                        }
                                        
                                        ?>&nbsp;</td>
                                        <td><?php echo h($orderLine['OrderLine']['quantity']); ?>&nbsp;</td>
                                        <td class="actions">
                                            <?php echo $this->Form->postLink('刪除', array('controller' => 'order_lines', 'action' => 'delete', $orderLine['OrderLine']['id']), array(), '確定要刪除？'); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
