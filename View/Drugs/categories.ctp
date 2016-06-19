<h3>ATC分類</h3>
<div class="paginator-wrapper">
    <?php echo $this->element('paginator'); ?>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <table class="table table-hover" id="DrugsCategoriesTable">
            <thead>
                <tr>
                    <th>代碼</th>
                    <th>原文名稱</th>
                    <th>中文名稱</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                foreach ($items as $item) {
                    ?>
                    <tr>
                        <td><?php echo $this->Html->link($item['Category']['code'], array('action' => 'category', $item['Category']['id'])); ?></td>
                        <td><?php echo $this->Html->link($item['Category']['name'], array('action' => 'category', $item['Category']['id'])); ?></td>
                        <td><?php echo $this->Html->link($item['Category']['name_chinese'], array('action' => 'category', $item['Category']['id'])); ?></td>
                    </tr>
                <?php }; // End of foreach ($items as $item) {  ?>
            </tbody>
        </table>
    </div>
</div>

<div class="paginator-wrapper">
    <?php echo $this->element('paginator'); ?>
</div>