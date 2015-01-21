<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php echo $category['Category']['name']; ?></h1>
    <ol class="breadcrumb">
        <?php
        foreach ($parents AS $parent) {
            echo '<li>' . $this->Html->link($parent['Category']['name'], '/drugs/category/' . $parent['Category']['id']) . '</li>';
        }
        ?>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div>
        <?php
        if (!empty($children)) {
            echo '<h4>子分類</h4>';
            foreach ($children AS $child) {
                echo $this->Html->link($child['Category']['name'], '/drugs/category/' . $child['Category']['id'], array('class' => 'btn btn-default'));
            }
            echo '<div class="clearfix"><br /></div>';
        }
        ?>
    </div>
    <div id="DrugsIndex" class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                <?php echo $this->element('paginator'); ?>
                </div>
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover" id="DrugsIndexTable">
                        <thead>
                            <tr>
                                <th>品名</th>
                                <th>許可證字號</th>
                                <th>主成份</th>
                                <th><?php echo $this->Paginator->sort('Drug.submitted', '更新日期', array('url' => $url)); ?></th>
                            </tr>
                        </thead>
                        <tbody>
            <?php
            $i = 0;
            foreach ($items as $item) {
                ?>
                            <tr>
                                <td>
                        <?php echo $this->Html->link("{$item['License']['name']}({$item['License']['name_english']})", array('action' => 'view', $item['Drug']['id'])); ?></td>
                                <td><?php
                        echo $item['License']['license_id'];
                        ?></td>
                                <td><?php
                        $majorIngredients = explode(';;', $item['License']['ingredient']);
                        foreach ($majorIngredients AS $ingredient) {
                            echo $this->Html->link($ingredient, '/drugs/index/' . $ingredient, array('class' => 'btn btn-default'));
                        }
                        ?></td>
                                <td><?php
                        echo $item['License']['submitted'];
                        ?></td>
                            </tr>
            <?php }; // End of foreach ($items as $item) {  ?>
                        </tbody>
                    </table>
                </div>
                <div class="box-footer clearfix">
                <?php echo $this->element('paginator'); ?>
                </div>
            </div>
        </div>
        <div id="DrugsIndexPanel"></div>
    </div>
</section><!-- /.content -->