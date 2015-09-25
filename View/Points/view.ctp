<h4><?php echo h($point['Point']['name']); ?> - <?php echo h($point['Point']['phone']); ?></h4>

<div class="row">
    <div class="col-xs-12">
        <?php if (!empty($point['Point']['longitude']) && !empty($point['Point']['latitude'])) { ?>
            <div class="box">
                <div class="box-header">
                </div>
                <div class="box-body">
                    <div id="map" style="width: 100%; height: 400px;"></div>
                </div>
            </div>
        <?php } ?>
        <p>&nbsp;</p>
        <dl>
            <dt>醫事機構代碼</dt>
            <dd>
                <?php 
                if (!empty($point['Point']['nhi_id'])) {
                    echo $point['Point']['nhi_id'];
                } else {
                    echo '<span class="text-muted">無紀錄</span>';
                } ?>
                &nbsp;
            </dd>
            <dt>健保終止合約或歇業日期</dt>
            <dd>
                <?php 
                echo ($point['Point']['nhi_end'] !== '0000-00-00') ? $point['Point']['nhi_end'] : '<span class="text-muted">無紀錄</span>'; ?>
                &nbsp;
            </dd>
            <dt>健保特約類別</dt>
            <dd>
                <?php 
                if (!empty($point['Point']['type'])) {
                    echo $point['Point']['type'];
                } else {
                    echo '<span class="text-muted">無紀錄</span>';
                } ?>
                &nbsp;
            </dd>
            <dt>診療科別</dt>
            <dd>
                <?php 
                if (!empty($point['Point']['category'])) {
                    echo $point['Point']['category'];
                } else {
                    echo '<span class="text-muted">無紀錄</span>';
                } ?>
                &nbsp;
            </dd>
            <dt>醫事機構種類</dt>
            <dd>
                <?php 
                if (!empty($point['Point']['biz_type'])) {
                    echo $point['Point']['biz_type'];
                } else {
                    echo '<span class="text-muted">無紀錄</span>';
                } ?>
                &nbsp;
            </dd>
            <dt>服務項目</dt>
            <dd>
                <?php 
                if (!empty($point['Point']['service'])) {
                    echo $point['Point']['service'];
                } else {
                    echo '<span class="text-muted">無紀錄</span>';
                } ?>
                &nbsp;
            </dd>
            <dt>醫事機構名稱</dt>
            <dd>
                <?php 
                if (!empty($point['Point']['name'])) {
                    echo $point['Point']['name'];
                } else {
                    echo '<span class="text-muted">無紀錄</span>';
                } ?>
                &nbsp;
            </dd>
            <dt>地址</dt>
            <dd>
                <?php 
                if (!empty($point['Point']['address'])) {
                    echo $point['Point']['city'] . $point['Point']['town'] . $point['Point']['address'];
                } else {
                    echo '<span class="text-muted">無紀錄</span>';
                } ?>
                &nbsp;
            </dd>
            <dt>座標</dt>
            <dd>
                <?php 
                if (!empty($point['Point']['longitude'])) {
                    echo '經度&nbsp;' . $point['Point']['longitude'] . '<br>';
                } else {
                    echo '<span class="text-muted">無紀錄</span>';
                }

                if (!empty($point['Point']['latitude'])) {
                    echo '緯度&nbsp;' . $point['Point']['latitude'];
                }
                ?>
            </dd>
            <dt>電話</dt>
            <dd>
                <?php 
                if (!empty($point['Point']['phone'])) {
                    echo $this->Html->tag(
                            'span',
                            $point['Point']['phone'],
                            array('class' => 'hidden-sm hidden-xs')
                        );
                    echo $this->Html->tag(
                            'span',
                            $this->Html->link(
                                '<i class="fa fa-phone"></i>&nbsp;' . $point['Point']['phone'],
                                'tel:' . $point['Point']['phone'],
                                array('escape' => false)
                            ),
                            array('class' => 'hidden-md hidden-lg')
                        );
                } else {
                    echo '<span class="text-muted">無紀錄</span>';
                } ?>
                &nbsp;
            </dd>
            <dt>網址</dt>
            <dd>
                <?php echo $this->Html->link($point['Point']['url'], $point['Point']['url'], array('target' => '_blank')); ?>
                &nbsp;
            </dd>
        </dl>
        <?php if (!empty($nearPoints)) { ?>
            <h4>附近醫事機構</h4>
            <?php
            $nearPointsCount = 0;
            foreach ($nearPoints AS $nearPoint) {
                ++$nearPointsCount;
            ?>
            <div class="col-md-4 well">
                <i class="fa fa-medkit"></i>&nbsp;
                <?php echo $this->Html->link($nearPoint['Point']['name'], '/points/view/' . $nearPoint['Point']['id']); ?><br>
                <i class="fa fa-phone"></i>&nbsp;
                <?php 
                    echo $this->Html->tag(
                            'span',
                            $point['Point']['phone'],
                            array('class' => 'hidden-sm hidden-xs')
                        );
                    echo $this->Html->tag(
                            'span',
                            $this->Html->link(
                                $point['Point']['phone'],
                                'tel:' . $point['Point']['phone'],
                                array('escape' => false)
                            ),
                            array('class' => 'hidden-md hidden-lg')
                        );
                ?>
                <br>
                <i class="fa fa-home"></i> <?php echo $nearPoint['Point']['address']; ?> (~<?php echo round($nearPoint['Point']['distance'], 2); ?>公里)
            </div>
            <?php
                if ($nearPointsCount >= 3) {
                    echo '<div class="clearfix"></div>';
                    $nearPointsCount = 0;
                }
            }
            ?>
        <?php } ?>
        <div class="clearfix"></div>
        <?php if (!empty($point['Article'])) { ?>
            <h4>醫事新知</h4>
            <ul>
                <?php
                foreach ($point['Article'] AS $article) {
                    echo '<li>' . $this->Html->link("{$article['date_published']} {$article['title']}", '/articles/view/' . $article['id']) . '</li>';
                }
                ?>
            </ul>
        <?php } ?>
    </div>
</div>
<script>
    var point = <?php echo json_encode($point['Point']); ?>,
        address = '<?php echo $point['Point']['address']; ?>';
</script>
<?php
$this->Html->script('http://maps.google.com/maps/api/js?sensor=false', array('inline' => false));
$this->Html->script('c/points/view', array('inline' => false));
