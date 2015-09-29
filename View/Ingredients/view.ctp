<h4><?php echo $ingredient['Ingredient']['name']; ?></h4>
<ol class="breadcrumb">
    <li><?php echo $this->Html->link('藥物成份', '/ingredients/index'); ?></li>
    <li class="active"><?php echo $ingredient['Ingredient']['name']; ?></li>
</ol>
<?php
$pos = strpos($ingredient['Ingredient']['name'], '(');
if (false === $pos) {
    $query = str_replace(' ', '+', $ingredient['Ingredient']['name']);
} else {
    $query = str_replace(' ', '+', trim(substr($ingredient['Ingredient']['name'], 0, $pos)));
}
?>

<div class="row">
    <div class="col-xs-12 col-md-12">
        <div class="well ingredient-event-wrapper" data-query="<?php echo $query; ?>">
            <div class="ingredient-event-loading">
                <div class="loading-indicator"></div>
                <p>正在查詢美國FDA不良反應資訊…</p>
            </div>
            <div class="ingredient-event-result" style="display:none;">
                <h5 style="text-align: center;"><i class="fa fa-warning text-danger"></i>&nbsp;美國 FDA 最近一年已知不良反應</h5>
                <p class="ingredient-event-statistic" style="text-align: center;"></p>
                <div class="full-content">
                    <div class="ingredient-event-list"></div>
                    <div class="clearfix"></div>
                    <p>&nbsp;</p>
                    <div class="content-footer">
                        括弧中的數字為 openFDA 提供的通報數量，資料來自美國 FDA<br>個別詞彙使用 MedDRA 定義，點選連結後即透過此定義搜尋 MeSH 資料庫(因 MedDRA 需要額外付費)，搜尋結果僅供參考<br />
                        <p>&nbsp;</p>
                    </div>
                    <div class="full-content-mask">
                        <button class="btn btn-info btn-read-more">展開全部內容</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <p>&nbsp;</p>
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
                        <strong>許可證字號</strong> <?php echo $item['License']['license_id']; ?><br>
                        <?php
                            $now_date = new DateTime();
                            $expired_date = new DateTime($item['License']['expired_date']);
                            $date_between = intval($expired_date->diff($now_date)->y);
                        ?>
                        <strong>許可證<span class="hidden-xs">有效日期</span></strong>&nbsp;
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
            <div class="clearfix"></div>
        </ul>
        <div class="paginator-wrapper">
            <?php echo $this->element('paginator'); ?>
        </div>
    </div>
</div>

<?php
echo $this->Html->script('c/ingredients/view', array('inline' => false));
?>