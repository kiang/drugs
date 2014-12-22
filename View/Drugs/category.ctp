<div id="DrugsIndex">
    <h4>
        <?php
        if (!empty($parents)) {
            $links = array();
            foreach ($parents AS $parent) {
                $links[] = $this->Html->link($parent['Category']['name'], '/drugs/category/' . $parent['Category']['id']);
            }
            echo implode(' > ', $links);
        }
        ?>
    </h4>
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
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
    <table class="table table-bordered" id="DrugsIndexTable">
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
                $class = null;
                if ($i++ % 2 == 0) {
                    $class = ' class="altrow"';
                }
                ?>
                <tr<?php echo $class; ?>>
                    <td>
                        <?php echo $this->Html->link("{$item['Drug']['name']}({$item['Drug']['name_english']})", array('action' => 'view', $item['Drug']['id'])); ?></td>
                    <td><?php
                        echo $item['Drug']['license_id'];
                        ?></td>
                    <td><?php
                        $majorIngredients = explode(';;', $item['Drug']['ingredient']);
                        foreach ($majorIngredients AS $ingredient) {
                            echo $this->Html->link($ingredient, '/drugs/index/' . $ingredient, array('class' => 'btn btn-default'));
                        }
                        ?></td>
                    <td><?php
                        echo $item['Drug']['submitted'];
                        ?></td>
                </tr>
            <?php }; // End of foreach ($items as $item) {  ?>
        </tbody>
    </table>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
    <div id="DrugsIndexPanel"></div>
</div>