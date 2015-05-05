<?php
echo $this->Html->script('c/drugs/outward', array('inline' => false));
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <form id="form-find-outward">
        <h1>藥物外觀</h1>
        <ol class="breadcrumb">
            <li class="col-xs-8"><input type="text" id="drugKeyword" value="<?php echo isset($drugKeyword) ? $drugKeyword : ''; ?>" class="form-control" placeholder="搜尋..."/></li>
            <li><a href="#" class="btn btn-default btn-find-drug">搜尋</a></li>
        </ol>
    </form>
</section>
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
                                <th>圖片</th>
                                <th>品名</th>
                                <th>許可證字號</th>
                                <th>形狀</th>
                                <th>顏色</th>
                                <th>刻痕</th>
                                <th>標註一</th>
                                <th>標註二</th>
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
                                        <?php if (!empty($item['License']['image'])) { ?>
                                            <img src="<?php echo $this->Html->url('/') . $item['License']['image']; ?>" class="img-thumbnail" style="width: 120px;" />
                                            <div class="clearfix"></div>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php echo $this->Html->link($name, array('action' => 'view', $item['Drug']['id'])); ?></td>
                                    <td><?php
                                        echo $item['License']['license_id'];
                                        ?></td>
                                    <td><?php
                                        echo $item['License']['shape'];
                                        ?></td>
                                    <td><?php
                                        echo $item['License']['color'];
                                        ?></td>
                                    <td><?php
                                        echo $item['License']['abrasion'];
                                        ?></td>
                                    <td><?php
                                        echo $item['License']['note_1'];
                                        ?></td>
                                    <td><?php
                                        echo $item['License']['note_2'];
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