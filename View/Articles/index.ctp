<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>醫事新知</h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <div class="paging"><?php echo $this->element('paginator'); ?></div>
                    <?php foreach ($articles as $article): ?>
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs pull-right">
                                <li class="active"><a href="#<?php echo $article['Article']['id']; ?>-1" data-toggle="tab">內容</a></li>
                                <li><a href="#<?php echo $article['Article']['id']; ?>-2" data-toggle="tab">關聯</a></li>
                                <li class="pull-left header"><?php
                                    echo $this->Html->link('<i class="fa fa-book"></i> ' . "{$article['Article']['date_published']} {$article['Article']['title']}", '/articles/view/' . $article['Article']['id'], array('escape' => false));
                                    ?></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="<?php echo $article['Article']['id']; ?>-1">
                                    <?php
                                    if (!empty($article['Article']['url'])) {
                                        echo '<p>';
                                        echo $this->Html->link('<i class="fa fa-external-link"></i> ' . $article['Article']['url'], $article['Article']['url'], array('target' => '_blank', 'style' => 'padding: 0px;', 'escape' => false));
                                        echo '</p>';
                                    }
                                    echo nl2br($article['Article']['body']);
                                    ?>
                                </div><!-- /.tab-pane -->
                                <div class="tab-pane" id="<?php echo $article['Article']['id']; ?>-2">
                                    <?php
                                    if (!empty($article['Drug'])) {
                                        echo '<div class="clearfix"></div><h3 class="page-header">藥物證書</h3>';
                                        foreach ($article['Drug'] AS $itemId => $itemLabel) {
                                            ?><div class="col-md-4">
                                                <div class="box box-solid">
                                                    <div class="box-header">
                                                        <i class="fa fa-tag"></i>
                                                        <h3 class="box-title"><?php echo $this->Html->link($itemLabel, '/drugs/view/' . $itemId, array('target' => '_blank')); ?></h3>
                                                    </div>
                                                </div>
                                            </div><?php
                                        }
                                    }
                                    if (!empty($article['Ingredient'])) {
                                        echo '<div class="clearfix"></div><h3 class="page-header">藥物成份</h3>';
                                        foreach ($article['Ingredient'] AS $itemId => $itemLabel) {
                                            ?><div class="col-md-4">
                                                <div class="box box-solid">
                                                    <div class="box-header">
                                                        <i class="fa fa-tag"></i>
                                                        <h3 class="box-title"><?php echo $this->Html->link($itemLabel, '/ingredients/view/' . $itemId, array('target' => '_blank')); ?></h3>
                                                    </div>
                                                </div>
                                            </div><?php
                                        }
                                    }
                                    if (!empty($article['Point'])) {
                                        echo '<div class="clearfix"></div><h3 class="page-header">醫事機構</h3>';
                                        foreach ($article['Point'] AS $itemId => $itemLabel) {
                                            ?><div class="col-md-4">
                                                <div class="box box-solid">
                                                    <div class="box-header">
                                                        <i class="fa fa-tag"></i>
                                                        <h3 class="box-title"><?php echo $this->Html->link($itemLabel, '/points/view/' . $itemId, array('target' => '_blank')); ?></h3>
                                                    </div>
                                                </div>
                                            </div><?php
                                        }
                                    }
                                    ?>
                                    <div class="clearfix"></div>
                                </div><!-- /.tab-pane -->
                            </div><!-- /.tab-content -->
                        </div>
                    <?php endforeach; ?>
                    <div class="paging"><?php echo $this->element('paginator'); ?></div>
                </div>
            </div>
        </div>
    </div>
</section>