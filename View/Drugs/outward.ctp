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
                <th>形狀</th>
                <th>顏色</th>
                <th>刻痕</th>
                <th>標註一</th>
                <th>標註二</th>
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
                        echo $item['License']['shape'];
                        ?></td>
                    <td><?php
                        echo $item['License']['color'];
                        ?></td>
                    <td><?php
                        echo $item['License']['abrasion'];
                        ?></td>
                    <td><?php
                        echo $item['License']['note_1'];
                        ?></td>
                    <td><?php
                        echo $item['License']['note_2'];
                        ?></td>
                </tr>
            <?php }; // End of foreach ($items as $item) {  ?>
        </tbody>
    </table>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
    <div id="DrugsIndexPanel"></div>
</div>