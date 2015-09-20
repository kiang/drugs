<h3><?php echo h($article['Article']['title']); ?></h3>

<div class="row">
    <div class="col-md-12">
        <p>&nbsp;</p>
        <p>
            <?php echo nl2br($article['Article']['body']); ?>
        </p>
        <p>&nbsp;</p>
        <p>
            <span class="fui-time text-muted"></span>&nbsp;
            <?php echo h($article['Article']['date_published']); ?>
        </p>
        <?php if (!empty($article['Article']['url'])) { ?>
            <p>
                <span class="fui-info-circle text-muted"></span>&nbsp;
                <?php echo $this->Html->link(
                    $article['Article']['url'],
                    $article['Article']['url'],
                    array('target' => '_blank', 'class' => 'article-link')
                ); ?>
            </p>
        <?php } ?>
        <p>&nbsp;</p>
        <div class="alert alert-success article-permalink">
            本文分享連結&nbsp;
            <br class="hidden-md hidden-lg">
            <?php echo $this->Html->link(
                    $this->html->url('/articles/view/' . $article['Article']['id'], true),
                    '/articles/view/' . $article['Article']['id']
                );
            ?>
        </div>
        <p>&nbsp;</p>
        <?php
        if (!empty($article['Drug'])) { ?>
            <div>
                <h4>藥物證書</h4><?php
                    foreach ($article['Drug'] AS $drug) {
                        ?><div class="col-md-4 col-xs-12">
                            <span class="fui-tag text-muted"></span>
                            <?php echo $this->Html->link($drug['License']['name'], '/drugs/view/' . $drug['Drug']['id']); ?>
                            <br>
                            <?php echo $drug['License']['disease']; ?>
                        </div><?php
                    }
                    ?>
                    <div class="clearfix"></div>
            </div><?php
        }
        if (!empty($article['Ingredient'])) {
            ?>
                <p>&nbsp;</p>
                <h4>藥物成份</h4><?php
                foreach ($article['Ingredient'] AS $ingredient) {
                    ?>
                    <div class="col-md-4 col-xs-12">
                        <span class="fui-tag text-muted"></span>
                        <?php echo $this->Html->link($ingredient['Ingredient']['name'], '/ingredients/view/' . $ingredient['Ingredient']['id']); ?>
                        <br>
                        有 <?php echo $ingredient['Ingredient']['count_licenses']; ?> 個相關藥證資料
                    </div><?php
                }
                ?>
                <div class="clearfix"></div>
            <?php
        }
        if (!empty($article['Point'])) {
            ?>
                <p>&nbsp;</p>
                <h4>醫事機構</h4><?php
                    foreach ($article['Point'] AS $point) {
                        ?><div class="col-md-4 col-xs-12">
                                <span class="fui-tag text-muted"></span>
                                <?php echo $this->Html->link($point['Point']['name'], '/points/view/' . $point['Point']['id']); ?>
                                <br>
                                <i class="fa fa-phone"></i> <?php echo $point['Point']['phone']; ?>
                                <br>
                                <?php echo "{$point['Point']['city']}{$point['Point']['town']}{$point['Point']['address']}"; ?>
                            </div>
                                <?php
                    }
                    ?>
                    <div class="clearfix"></div>
                </div>
            </div><?php
        }
        if (!empty($article['Vendor'])) {
            ?>
                <p>&nbsp;</p>
                <h4>藥物廠商</h4>
                <?php
                foreach ($article['Vendor'] AS $vendor) {
                ?>
                    <div class="col-md-4 col-xs-12">
                        <span class="fui-tag text-muted"></span>
                        <?php echo $this->Html->link($vendor['Vendor']['name'], '/vendors/view/' . $vendor['Vendor']['id']); ?>
                        <br>
                        <?php echo $this->Olc->showCountry($vendor['Vendor']['country']) . '&nbsp;' . "{$vendor['Vendor']['address']}"; ?>
                    </div>
                <?php } ?>
            <div class="clearfix"></div>
        <?php } ?>
    </div>
</div>