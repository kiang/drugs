<h2>醫事新知</h2>
<div class="row">
    <div class="col-xs-12 col-md-12">
        <div class="paginator-wrapper"><?php echo $this->element('paginator'); ?></div>
        <p>&nbsp;</p>
        <?php foreach ($articles as $article): ?>
        <ul class="nav nav-tabs nav-append-content">
            <li class="pull-right"><a href="#" class="article-share-link" data-pane="#<?php echo $article['Article']['id']; ?>-link"><span class="fui-link"></span>&nbsp;分享</a></li>
            <li class="pull-right"><a href="#<?php echo $article['Article']['id']; ?>-tag" data-toggle="tab">相關標籤</a></li>
            <li class="pull-right active"><a href="#<?php echo $article['Article']['id']; ?>-content" data-toggle="tab">醫事新知</a></li>
        </ul>
        <div class="tab-content">
            <div class="alert alert-info article-permalink" id="<?php echo $article['Article']['id']; ?>-link" style="display: none">
                本文分享連結&nbsp;<br class="hidden-md hidden-lg">
                <?php echo $this->Html->link(
                        $this->html->url('/articles/view/' . $article['Article']['id'], true),
                        '/articles/view/' . $article['Article']['id']
                    );
                ?>
            </div>
            <div class="tab-pane active" id="<?php echo $article['Article']['id']; ?>-content">
                <?php
                echo $this->Html->tag('h5', "{$article['Article']['title']}") . '<hr>';
                echo nl2br($article['Article']['body']);
                if (!empty($article['Article']['url'])) {
                    echo '<p>&nbsp;</p><p><span class="fui-time text-muted"></span>&nbsp;' . $article['Article']['date_published'];
                    echo '</p>';
                    echo '<p><span class="fui-info-circle text-muted"></span>&nbsp;' . $this->Html->link($article['Article']['url'], $article['Article']['url'], array('target' => '_blank', 'class' => 'article-list-link', 'escape' => false));
                    echo '</p>';
                }
                ?>
            </div><!-- /.tab-pane -->
            <div class="tab-pane" id="<?php echo $article['Article']['id']; ?>-tag">
                <?php
                if (!empty($article['Drug'])) {
                    echo '<h4>藥物證書</h4><div class="row">';
                    foreach ($article['Drug'] AS $itemId => $itemLabel) {
                        ?><div class="col-md-4">
                            <i class="fui-tag text-muted"></i>
                            <?php echo $this->Html->link($itemLabel, '/drugs/view/' . $itemId, array('target' => '_blank')); ?>
                    </div>
                <?php
                    }
                    echo '</div>';
                }
                if (!empty($article['Ingredient'])) {
                    echo '<hr><h4>藥物成份</h4><div class="row">';
                    foreach ($article['Ingredient'] AS $itemId => $itemLabel) {
                ?>
                    <div class="col-md-4">
                        <i class="fui-tag text-muted"></i>
                        <?php echo $this->Html->link($itemLabel, '/ingredients/view/' . $itemId, array('target' => '_blank')); ?>
                    </div>
                <?php
                    }
                    echo '</div>';
                }
                if (!empty($article['Point'])) {
                    echo '<hr><h4>醫事機構</h4><div class="row">';
                    foreach ($article['Point'] AS $itemId => $itemLabel) {
                ?>
                    <div class="col-md-4">
                        <i class="fui-tag text-muted"></i>
                        <p><?php echo $this->Html->link($itemLabel, '/points/view/' . $itemId, array('target' => '_blank')); ?></p>
                    </div>
                <?php
                    }
                    echo '</div>';
                }
                if (!empty($article['Vendor'])) {
                    echo '<hr><h4>藥物廠商</h4><div class="row">';
                    foreach ($article['Vendor'] AS $itemId => $itemLabel) {
                ?>
                    <div class="col-md-4">
                        <i class="fui-tag text-muted"></i>
                        <?php echo $this->Html->link($itemLabel, '/vendors/view/' . $itemId, array('target' => '_blank')); ?>
                    </div>
                <?php
                    }
                    echo '</div>';
                }
                ?>
            <div class="clearfix"></div>
        </div><!-- /.tab-pane -->
    </div><!-- /.tab-content -->
    <p>&nbsp;</p>
    <?php endforeach; ?>
    <div class="paginator-wrapper"><?php echo $this->element('paginator'); ?></div>
    </div>
</div>