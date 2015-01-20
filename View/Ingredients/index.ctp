<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>藥物成份</h1>
</section>

<!-- Main content -->
<section class="content">
    <div id="IngredientsIndex" class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                <?php echo $this->element('paginator'); ?>
                </div>
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover" id="IngredientsIndexTable">
                        <thead>
                            <tr>
                                <th>成份名稱</th>
                                <th><?php echo $this->Paginator->sort('Ingredient.count_licenses', '藥證數量', array('url' => $url)); ?></th>
                            </tr>
                        </thead>
                        <tbody>
            <?php
            $i = 0;
            foreach ($items as $item) {
                ?>
                            <tr>
                                <td>
                        <?php echo $this->Html->link($item['Ingredient']['name'], array('action' => 'view', $item['Ingredient']['id'])); ?></td>
                                <td><?php
                        echo $item['Ingredient']['count_licenses'];
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
        <div id="IngredientsIndexPanel"></div>
    </div>
</section><!-- /.content -->
