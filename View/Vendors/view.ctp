<h3><?php echo $vendor['Vendor']['name']; ?></h3>
<ul class="breadcrumb">
    <li><?php echo $this->Html->link('藥物廠商', '/vendors/index'); ?></li>
    <li class="active"><?php echo $vendor['Vendor']['name']; ?></li>
</ul>

<div class="row">
    <div class="col-md-12 col-xs-12">
        <h5>廠商基本資訊</h5>
        <?php if (empty($vendor['Vendor']['address'])) { ?>
            <p>
                國家：<?php echo $this->Olc->showCountry($vendor['Vendor']['country']); ?>
            </p>
        <?php } ?>
        <p>
            統一編號：
            <?php
            if (!empty($vendor['Vendor']['tax_id'])) {
                 echo $vendor['Vendor']['tax_id'];
            } else {
                echo $this->Html->tag('span', '無紀錄', array('class' => 'text-muted'));
            }
            ?>
        </p>
        <p>
            地址：
            <?php
                if (!empty($vendor['Vendor']['address'])) {
                    echo $this->Olc->showCountry($vendor['Vendor']['country']) . '&nbsp;';
                    echo '<br class="hidden-md hidden-lg">';
                    echo $this->Html->tag(
                        'span',
                        $vendor['Vendor']['address'] . '&nbsp;' .
                        $this->Html->tag(
                            'i',
                            '',
                            array(
                                'class' => 'fui-location',
                                'style' => 'color: #f35048;',
                            )
                        ),
                        array(
                            'class' => 'map-toggle-btn',
                            'style' => 'cursor: pointer;',
                        )
                    );
                    echo $this->Html->tag('div', '', array('class' => 'vendor-address-wrapper'));
                } else {
                    echo $this->Html->tag('span', '無紀錄', array('class' => 'text-muted'));
                }
            ?>
        </p>
        <p>
            辦公室：
             <?php
                if (!empty($vendor['Vendor']['address_office'])) {
                    echo $vendor['Vendor']['address_office'];
                } else {
                    echo $this->Html->tag('span', '無紀錄', array('class' => 'text-muted'));
                }
            ?>
        </p>
        <p>&nbsp;</p>
        <h5>廠商生產藥品</h5>
        <div class="paginator-wrapper">
            <?php echo $this->element('paginator'); ?>
        </div>
        <div class="box-body no-padding">
            <table class="table table-hover table-responsive">
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
        <div class="paginator-wrapper clearfix">
            <?php echo $this->element('paginator'); ?>
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
<?php
    if (!empty($vendor['Vendor']['address'])) {
?>
    <script src="//maps.googleapis.com/maps/api/js?sensor=false&extension=.js&output=embed"></script>
    <script>
        var verdor_address = "<?php echo $vendor['Vendor']['address']; ?>";
    </script>
<?php } ?>