<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php
        echo implode(' > ', array(
            '暫存連結',
            implode(' | ', array(
                $this->Html->link('新增暫存連結', array('action' => 'tasks_add'), array('class' => 'btn btn-primary')),
            ))
        ));
        ?></h1>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                </div>
                <div class="box-body">
                    <?php
                    foreach ($tasks AS $task) {
                        echo '<div class="btn-group" style="margin-left: 10px;">';
                        echo $this->Html->link($task['filename'], array('action' => 'tasks', $task['filename']), array('class' => 'btn btn-default'));
                        echo $this->Html->link('刪除', array('action' => 'tasks', $task['filename'], 'delete'), array('class' => 'btn btn-default'));
                        echo '</div>';
                    }
                    ?>
                    <hr />
                    <?php
                    foreach ($links AS $link) {
                        ?>
                        <div class="box box-solid">
                            <div class="box-header">
                                <h3 class="box-title"><?php echo $link['title-tag']; ?></h3>
                            </div>
                            <div class="box-body"><?php
                                if (isset($link['description'])) {
                                    echo $link['description'];
                                }
                                ?>
                                <hr />
                                <div class="btn-group">
                                    <?php
                                    echo $this->Html->link('外部瀏覽', $link['url'], array('target' => '_blank', 'class' => 'btn btn-default'));
                                    echo $this->Html->link('建立文章', array('action' => 'add', $taskFileName, md5($link['url'])), array('target' => '_blank', 'class' => 'btn btn-default'));
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>