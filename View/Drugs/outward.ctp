<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>藥物外觀</h1>
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