<?php
echo $this->Html->script('c/drugs/index', array('inline' => false));
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <form id="form-find-drug">
        <h1>藥物證書</h1>
        <ol class="breadcrumb">
            <li class="col-xs-8"><input type="text" id="drugKeyword" value="<?php echo isset($drugKeyword) ? $drugKeyword : ''; ?>" class="form-control" placeholder="搜尋..."/></li>
            <li><a href="#" class="btn btn-default btn-find-drug">搜尋</a></li>
        </ol>
    </form>
</section>

<!-- Main content -->
<section class="content">
    <div id="DrugsIndex" class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <?php echo $this->element('paginator'); ?>
                </div>
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover" id="DrugsIndexTable">
                        <thead>
                            <tr>
                                <th>品名</th>
                                <th>許可證字號</th>
                                <th>製造商</th>
                                <th>國別</th>
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
                                        <?php echo $this->Html->link($name, array('action' => 'view', $item['Drug']['id'])); ?></td>
                                    <td><?php
                                        echo $item['License']['license_id'];
                                        ?></td>
                                    <td><?php
                                        echo $item['Vendor']['name'];
                                        ?></td>
                                    <td><?php
                                        echo $item['Vendor']['country'];
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
        </div>
        <div id="DrugsIndexPanel"></div>
    </div>
</section><!-- /.content -->
