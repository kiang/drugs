<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>檢視文章</h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                </div>
                <div class="box-body">
                    <dl>
                        <dt><?php echo __('Id'); ?></dt>
                        <dd>
                            <?php echo h($article['Article']['id']); ?>
                            &nbsp;
                        </dd>
                        <dt><?php echo __('Title'); ?></dt>
                        <dd>
                            <?php echo h($article['Article']['title']); ?>
                            &nbsp;
                        </dd>
                        <dt><?php echo __('Body'); ?></dt>
                        <dd>
                            <?php echo h($article['Article']['body']); ?>
                            &nbsp;
                        </dd>
                        <dt><?php echo __('Created'); ?></dt>
                        <dd>
                            <?php echo h($article['Article']['created']); ?>
                            &nbsp;
                        </dd>
                        <dt><?php echo __('Modified'); ?></dt>
                        <dd>
                            <?php echo h($article['Article']['modified']); ?>
                            &nbsp;
                        </dd>
                        <dt><?php echo __('Url'); ?></dt>
                        <dd>
                            <?php echo h($article['Article']['url']); ?>
                            &nbsp;
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</section>