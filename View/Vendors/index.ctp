<?php
echo $this->Html->script('c/vendors/index', array('inline' => false));
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <form id="form-find-vendor">
        <h1>藥物廠商</h1>
        <ol class="breadcrumb">
            <li class="col-xs-8"><input type="text" id="vendorKeyword" value="<?php echo isset($vendorKeyword) ? $vendorKeyword : ''; ?>" class="form-control" placeholder="搜尋..."/></li>
            <li><a href="#" class="btn btn-default btn-find-vendor">搜尋</a></li>
        </ol>
    </form>
</section>

<!-- Main content -->
<section class="content">
    <div id="VendorsIndex" class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <?php echo $this->element('paginator'); ?>
                </div>
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover" id="VendorsIndexTable">
                        <thead>
                            <tr>
                                <th>廠商名稱</th>
                                <th>統一編號</th>
                                <th>住址</th>
                                <th>國家</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($items as $item) {
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $this->Html->link($item['Vendor']['name'], array('action' => 'view', $item['Vendor']['id'])); ?></td>
                                    <td><?php echo $item['Vendor']['tax_id']; ?></td>
                                    <td><?php echo $item['Vendor']['address']; ?></td>
                                    <td><?php echo $item['Vendor']['country']; ?></td>
                                </tr>
                            <?php }; // End of foreach ($items as $item) {  ?>
                        </tbody>
                    </table>
                </div>
                <div class="box-footer clearfix">
                    <?php echo $this->element('paginator'); ?>
                </div>
            </div>
        </div>
        <div id="VendorsIndexPanel"></div>
    </div>
</section><!-- /.content -->
