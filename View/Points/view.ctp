<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php echo h($point['Point']['name']); ?> - <?php echo h($point['Point']['phone']); ?></h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                </div>
                <div class="box-body">
                    <div class="points view">
                        <dl>
                            <dt>醫事機構代碼</dt>
                            <dd>
                                <?php echo h($point['Point']['nhi_id']); ?>
                                &nbsp;
                            </dd>
                            <dt>健保終止合約或歇業日期</dt>
                            <dd>
                                <?php echo ($point['Point']['nhi_end'] !== '0000-00-00') ? $point['Point']['nhi_end'] : '--'; ?>
                                &nbsp;
                            </dd>
                            <dt>健保特約類別</dt>
                            <dd>
                                <?php echo h($point['Point']['type']); ?>
                                &nbsp;
                            </dd>
                            <dt>診療科別</dt>
                            <dd>
                                <?php echo h($point['Point']['category']); ?>
                                &nbsp;
                            </dd>
                            <dt>醫事機構種類</dt>
                            <dd>
                                <?php echo h($point['Point']['biz_type']); ?>
                                &nbsp;
                            </dd>
                            <dt>服務項目</dt>
                            <dd>
                                <?php echo h($point['Point']['service']); ?>
                                &nbsp;
                            </dd>
                            <dt>醫事機構名稱</dt>
                            <dd>
                                <?php echo h($point['Point']['name']); ?>
                                &nbsp;
                            </dd>
                            <dt>縣市</dt>
                            <dd>
                                <?php echo h($point['Point']['city']); ?>
                                &nbsp;
                            </dd>
                            <dt>鄉鎮市區</dt>
                            <dd>
                                <?php echo h($point['Point']['town']); ?>
                                &nbsp;
                            </dd>
                            <dt>住址</dt>
                            <dd>
                                <?php echo h($point['Point']['address']); ?>
                                &nbsp;
                            </dd>
                            <dt>經度</dt>
                            <dd>
                                <?php echo h($point['Point']['longitude']); ?>
                                &nbsp;
                            </dd>
                            <dt>緯度</dt>
                            <dd>
                                <?php echo h($point['Point']['latitude']); ?>
                                &nbsp;
                            </dd>
                            <dt>電話</dt>
                            <dd>
                                <?php echo h($point['Point']['phone']); ?>
                                &nbsp;
                            </dd>
                            <dt>網址</dt>
                            <dd>
                                <?php echo $this->Html->link($point['Point']['url'], $point['Point']['url'], array('target' => '_blank')); ?>
                                &nbsp;
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <?php if (!empty($point['Article'])) { ?>
                <div class="box">
                    <div class="box-header">
                        <h4>醫事新知</h4>
                    </div>
                    <div class="box-body">
                        <ul>
                            <?php
                            foreach ($point['Article'] AS $article) {
                                echo '<li>' . $this->Html->link("{$article['date_published']} {$article['title']}", $article['url'], array('target' => '_blank')) . '</li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
