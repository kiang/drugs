<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>文章管理</h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <div class="paging"><?php echo $this->element('paginator'); ?></div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th><?php echo $this->Paginator->sort('id'); ?></th>
                                <th><?php echo $this->Paginator->sort('title'); ?></th>
                                <th><?php echo $this->Paginator->sort('body'); ?></th>
                                <th><?php echo $this->Paginator->sort('created'); ?></th>
                                <th><?php echo $this->Paginator->sort('modified'); ?></th>
                                <th><?php echo $this->Paginator->sort('url'); ?></th>
                                <th class="actions"><?php echo __('Actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($articles as $article): ?>
                                <tr>
                                    <td><?php echo h($article['Article']['id']); ?>&nbsp;</td>
                                    <td><?php echo h($article['Article']['title']); ?>&nbsp;</td>
                                    <td><?php echo h($article['Article']['body']); ?>&nbsp;</td>
                                    <td><?php echo h($article['Article']['created']); ?>&nbsp;</td>
                                    <td><?php echo h($article['Article']['modified']); ?>&nbsp;</td>
                                    <td><?php echo h($article['Article']['url']); ?>&nbsp;</td>
                                    <td class="actions">
                                        <?php echo $this->Html->link(__('View'), array('action' => 'view', $article['Article']['id'])); ?>
                                        <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $article['Article']['id'])); ?>
                                        <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $article['Article']['id']), array(), __('Are you sure you want to delete # %s?', $article['Article']['id'])); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="paging"><?php echo $this->element('paginator'); ?></div>
                </div>
            </div>
        </div>
    </div>
</section>