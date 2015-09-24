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
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <h5>廠商生產藥品</h5>
        <div class="order-btn-wrapper">
            <ul class="nav nav-pills">
                <li>
                    <?php echo $this->Paginator->sort('License.expired_date', '依有效日期排列', array('url' => $url)); ?>
                </li>
                <li>
                    <?php echo $this->Paginator->sort('License.license_date', '依發證日期排列', array('url' => $url)); ?>
                </li>
                <li>
                    <?php echo $this->Paginator->sort('License.submitted', '依更新日期排列', array('url' => $url)); ?>
                </li>
            </ul>
        </div>
        <div class="paginator-wrapper">
            <?php echo $this->element('paginator'); ?>
        </div>
        <ul class="media-list">
            <p class="hidden-sm hidden-xs">&nbsp;</p>
            <?php
            foreach ($items as $item) {
                $name = $item['License']['name'];
                if (!empty($item['License']['name_english'])) {
                    $name .= " <br class=\"hidden-md hidden-lg\"><small class=\"text-english-name hidden-xs\">{$item['License']['name_english']}</small>";
                }
            ?>
            <li class="media">
                <a href="<?php echo $this->Html->url('/') . 'drugs/view/' . $item['Drug']['id']; ?>" class="hidden-md hidden-lg">
                    <h6 class="media-heading"><?php echo $name; ?></h6>
                </a>
                <div class="media-left media-middle">
                    <a href="<?php echo $this->Html->url('/') . 'drugs/view/' . $item['Drug']['id']; ?>">
                        <?php if (!empty($item['License']['image'])) { ?>
                            <img src="<?php echo $this->Html->url('/') . $item['License']['image']; ?>" class="img-thumbnail drug-list-thumbnail" />
                        <?php } else {?>
                            <div class="img-thumbnail drug-list-thumbnail">
                                <p class="text-muted">沒有影像</p>
                            </div>
                        <?php } ?>
                    </a>
                </div>
                <div class="media-body">
                    <a href="<?php echo $this->Html->url('/') . 'drugs/view/' . $item['Drug']['id']; ?>" class="hidden-sm hidden-xs">
                        <h6 class="media-heading"><?php echo $name; ?></h6>
                    </a>
                    <hr>
                    <p>
                        <div><strong class="hidden-xs">許可證字號</strong> <?php echo $item['License']['license_id']; ?></div>
                        <?php
                            $now_date = new DateTime();
                            $expired_date = new DateTime($item['License']['expired_date']);
                            $date_between = intval($expired_date->diff($now_date)->y);
                        ?>
                        <strong>許可<span class="hidden-xs">證</span>有效日期</strong>&nbsp;
                        <?php
                            if ($date_between >= 3) {
                                echo $item['License']['expired_date'];
                            } else {
                                echo $this->Html->tag('span', $item['License']['expired_date'], array('class' => 'text-warning'));
                            }
                        ?>
                    </p>
                </div>
            </li>
            <?php }; // End of foreach ($items as $item) {  ?>
            <div class="paginator-wrapper">
                <?php echo $this->element('paginator'); ?>
            </div>
            <div class="clearfix"></div>
        </ul>

         <?php if (!empty($vendor['Article'])) { ?>
            <h4>醫事新知</h4>
            <ul>
                <?php
                foreach ($vendor['Article'] AS $article) {
                    echo '<li>' . $this->Html->link("{$article['date_published']} {$article['title']}", '/articles/view/' . $article['id']) . '</li>';
                }
                ?>
            </ul>
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