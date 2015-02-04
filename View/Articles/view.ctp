<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php echo h($article['Article']['title']); ?></h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header"></div>
                <div class="box-body">
                    <dl>
                        <dt>日期</dt>
                        <dd>
                            <?php echo h($article['Article']['date_published']); ?>
                            &nbsp;
                        </dd>
                        <dt>內容</dt>
                        <dd>
                            <?php echo nl2br($article['Article']['body']); ?>
                            &nbsp;
                        </dd>
                        <?php if (!empty($article['Article']['url'])) { ?>
                            <dt>網址</dt>
                            <dd>
                                <?php echo $this->Html->link($article['Article']['url'], $article['Article']['url']); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>
                    </dl>
                </div>
            </div>
            <?php
            if (!empty($article['Drug'])) {
                ?><div class="box">
                    <div class="box-header"><h3 class="box-title">藥物證書</h3></div>
                    <div class="box-body"><?php
                        foreach ($article['Drug'] AS $drug) {
                            ?><div class="col-md-4">
                                <div class="box box-solid">
                                    <div class="box-header">
                                        <i class="fa fa-tag"></i>
                                        <h3 class="box-title"><?php echo $this->Html->link($drug['License']['name'], '/drugs/view/' . $drug['Drug']['id']); ?></h3>
                                    </div>
                                    <div class="box-body">
                                        <?php echo $drug['License']['disease']; ?>
                                    </div>
                                </div>
                            </div><?php
                        }
                        ?>
                        <div class="clearfix"></div>
                    </div>
                </div><?php
            }
            if (!empty($article['Ingredient'])) {
                ?><div class="box">
                    <div class="box-header"><h3 class="box-title">藥物成份</h3></div>
                    <div class="box-body"><?php
                        foreach ($article['Ingredient'] AS $ingredient) {
                            ?><div class="col-md-4">
                                <div class="box box-solid">
                                    <div class="box-header">
                                        <i class="fa fa-tag"></i>
                                        <h3 class="box-title"><?php echo $this->Html->link($ingredient['Ingredient']['name'], '/ingredients/view/' . $ingredient['Ingredient']['id']); ?></h3>
                                    </div>
                                    <div class="box-body">
                                        有 <?php echo $ingredient['Ingredient']['count_licenses']; ?> 個相關藥證資料
                                    </div>
                                </div>
                            </div><?php
                        }
                        ?>
                        <div class="clearfix"></div>
                    </div>
                </div><?php
            }
            if (!empty($article['Point'])) {
                ?><div class="box">
                    <div class="box-header"><h3 class="box-title">醫事機構</h3></div>
                    <div class="box-body"><?php
                        foreach ($article['Point'] AS $point) {
                            ?><div class="col-md-4">
                                <div class="box box-solid">
                                    <div class="box-header">
                                        <i class="fa fa-tag"></i>
                                        <h3 class="box-title"><?php echo $this->Html->link($point['Point']['name'], '/points/view/' . $point['Point']['id']); ?></h3>
                                    </div>
                                    <div class="box-body">
                                        <i class="fa fa-phone"></i> <?php echo $point['Point']['phone']; ?>
                                        <br /><i class="fa fa-home"></i> <?php echo "{$point['Point']['city']}{$point['Point']['town']}{$point['Point']['address']}"; ?>
                                    </div>
                                </div>
                            </div><?php
                        }
                        ?>
                        <div class="clearfix"></div>
                    </div>
                </div><?php
            }
            ?>
        </div>
    </div>
</section>