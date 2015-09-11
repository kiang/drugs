<?php
echo $this->Html->script('c/drugs/outward', array('inline' => false));
?>
<h2>藥物外觀</h2>
<div class="paginator-wrapper">
    <?php echo $this->element('paginator'); ?>
</div>
<section class="content">
    <div id="DrugsIndex" class="row">
        <div class="col-xs-12">
            <div class="box">
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
            </div>
        </div>
        <div id="DrugsIndexPanel"></div>
    </div>
</section><!-- /.content -->

<div class="clearfix paginator-wrapper">
    <?php echo $this->element('paginator'); ?>
</div>
