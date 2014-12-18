<div id="DrugsIndex">
    <p>
        <?php
        $url = array();
        ?></p>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
    <table class="table table-bordered" id="DrugsIndexTable">
        <thead>
            <tr>
                <th>品名</th>
                <th>許可證字號</th>
                <th>製造商</th>
                <th>國別</th>
                <th><?php echo $this->Paginator->sort('Drug.expired_date', '有效日期', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Drug.license_date', '發證日期', array('url' => $url)); ?></th>
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
                        echo $item['Drug']['manufacturer'];
                        ?></td>
                    <td><?php
                        echo $item['Drug']['manufacturer_country'];
                        ?></td>
                    <td><?php
                        echo $item['Drug']['expired_date'];
                        ?></td>
                    <td><?php
                        echo $item['Drug']['license_date'];
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