<?php
echo $this->Html->script('c/vendors/index', array('inline' => false));
?>
<h2>藥物廠商</h2>
<div class="paginator-wrapper">
    <?php echo $this->element('paginator'); ?>
</div>
<!-- Main content -->
<section class="content">
    <div id="VendorsIndex" class="row">
        <div class="col-xs-12">
            <div class="box">
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
                                    <td><?php echo $this->Olc->showCountry($item['Vendor']['country']); ?></td>
                                </tr>
                            <?php }; // End of foreach ($items as $item) {  ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div id="VendorsIndexPanel"></div>
    </div>
</section><!-- /.content -->
<div class="clearfix paginator-wrapper">
    <?php echo $this->element('paginator'); ?>
</div>