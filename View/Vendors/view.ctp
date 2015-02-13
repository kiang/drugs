<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php echo $vendor['Vendor']['name']; ?></h1>
    <ol class="breadcrumb">
        <li><?php echo $this->Html->link('藥物廠商', '/vendors/index'); ?></li>
        <li class="active"><?php echo $vendor['Vendor']['name']; ?></li>
    </ol>
</section>
<?php
$pos = strpos($vendor['Vendor']['name'], '(');
if (false === $pos) {
    $query = str_replace(' ', '+', $vendor['Vendor']['name']);
} else {
    $query = str_replace(' ', '+', trim(substr($vendor['Vendor']['name'], 0, $pos)));
}
?>
<!-- Main content -->
<section class="content">
    <div id="VendorsView" class="row">
        <div class="col-xs-12">
            <div class="box box-danger" id="vendorEventBox" style="display:none;" data-query="<?php echo $query; ?>">
                <div class="box-header">
                    <i class="fa fa-warning"></i>
                    <h4>常見不良反應</h4>
                </div>
                <div class="box-body">
                    <ul id="vendorEventList"></ul>
                    <div class="clearfix"></div>
                </div>
                <div class="box-footer">
                    括弧中的數字為 openFDA 提供的通報數量，資料來自美國 FDA ；個別詞彙是使用 MedDRA 定義，但點選連結後則是透過這個定義去搜尋 MeSH 資料庫(因為 MedDRA 的使用需要額外付費)，找到的資料僅供參考<br />
                </div>
            </div>
            <div class="box">
                <div class="box-header">
                    <?php echo $this->element('paginator'); ?>
                </div>
                <div class="box-body no-padding">
                    <table class="table table-hover table-responsive" id="DrugsIndexTable">
                        <thead>
                            <tr>
                                <th>品名</th>
                                <th>許可證字號</th>
                                <th><?php echo $this->Paginator->sort('License.expired_date', '有效日期', array('url' => $url)); ?></th>
                                <th><?php echo $this->Paginator->sort('License.license_date', '發證日期', array('url' => $url)); ?></th>
                                <th><?php echo $this->Paginator->sort('License.submitted', '更新日期', array('url' => $url)); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($items as $item) {
                                $name = $item['License']['name'];
                                if (!empty($item['License']['name_english'])) {
                                    $name .= "({$item['License']['name_english']})";
                                }
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $this->Html->link($name, array('controller' => 'drugs', 'action' => 'view', $item['Drug']['id'])); ?></td>
                                    <td><?php
                                        echo $item['License']['license_id'];
                                        ?></td>
                                    <td><?php
                                        echo $item['License']['expired_date'];
                                        ?></td>
                                    <td><?php
                                        echo $item['License']['license_date'];
                                        ?></td>
                                    <td><?php
                                        echo $item['License']['submitted'];
                                        ?></td>
                                </tr>
                            <?php }; // End of foreach ($items as $item) {  ?>
                        </tbody>
                    </table>
                </div>
                <div class="box-footer clearfix">
                    <?php echo $this->element('paginator'); ?>
                </div>
            </div>
            <?php if (!empty($vendor['Article'])) { ?>
                <div class="box">
                    <div class="box-header">
                        <h4>醫事新知</h4>
                    </div>
                    <div class="box-body">
                        <ul>
                            <?php
                            foreach ($vendor['Article'] AS $article) {
                                echo '<li>' . $this->Html->link("{$article['date_published']} {$article['title']}", '/articles/view/' . $article['id']) . '</li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            <?php } ?>
        </div>

    </div>
</section><!-- /.content -->
<?php
echo $this->Html->script('c/vendors/view', array('inline' => false));
?>