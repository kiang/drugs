<h3>醫事機構</h3>
<div class="paginator-wrapper">
    <?php echo $this->element('paginator'); ?>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <ul class="media-list">
            <p class="hidden-sm hidden-xs">&nbsp;</p>
            <?php
            foreach ($points as $point) {
            ?>
            <li class="media">
                <a href="<?php echo $this->Html->url('view/') . $point['Point']['id']; ?>" class="hidden-md hidden-lg">
                    <h6 class="media-heading">
                        <?php echo $point['Point']['name']; ?>
                    </h6>
                </a>
                <div class="media-body">
                    <a href="<?php echo $this->Html->url('view/') . $point['Point']['id']; ?>" class="hidden-sm hidden-xs">
                        <h6 class="media-heading"><?php echo $point['Point']['name']; ?></h6>
                    </a>
                    <hr>
                    <strong>類別</strong>
                    <?php
                        if (!empty($point['Point']['type'])) {
                            echo $point['Point']['type'];
                        } else {
                            echo '<span class="text-muted">無紀錄</span>';
                        }
                    ?>
                    <br>
                    <span class="text-ellipsis">
                        <strong>科別</strong>&nbsp;<?php echo h($point['Point']['category']); ?> <br>
                    </span>
                        <strong>地址</strong>&nbsp;<?php echo h($point['Point']['city']) . h($point['Point']['town']) . h($point['Point']['address']); ?><br>
                    <strong>電話</strong>&nbsp;
                    <?php
                        echo $this->Html->tag('span', $point['Point']['phone'], array('class' => 'hidden-sm hidden-xs'));
                        echo $this->Html->link('<i class="fa fa-phone"></i>&nbsp;' . $point['Point']['phone'], 'tel:' . $point['Point']['phone'], array('class' => 'hidden-md hidden-lg', 'escape' => false));
                    ?>
                    <br>
                </div>
            </li>
            <?php }; // End of foreach ($items as $item) {  ?>
        </ul>
    </div>
</div>

<div class="clearfix paginator-wrapper">
    <?php echo $this->element('paginator'); ?>
</div>
