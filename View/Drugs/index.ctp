<?php
echo $this->Html->script('c/drugs/index', array('inline' => false));
?>
<h2>藥物證書</h2>
<div class="paginator-wrapper">
    <?php echo $this->element('paginator'); ?>
</div>
<div class="box-body table-responsive no-padding">
    <table class="table table-hover" id="DrugsIndexTable">
        <thead>
            <tr>
                <th>品名</th>
                <th>許可證字號</th>
                <th>製造商</th>
                <th>國別</th>
                <th><?php echo $this->Paginator->sort('License.expired_date', '有效日期', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('License.license_date', '發證日期', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('License.submitted', '更新日期', array('url' => $url)); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($items as $item) {
                $name = $item['License']['name'];
                if (!empty($item['License']['name_english'])) {
                    $name .= "({$item['License']['name_english']})";
                }
                ?>
                <tr>
                    <td>
                        <?php echo $this->Html->link($name, array('action' => 'view', $item['Drug']['id'])); ?></td>
                    <td><?php
                        echo $item['License']['license_id'];
                        ?></td>
                    <td><?php
                        echo $item['Vendor']['name'];
                        ?></td>
                    <td><?php
                        echo $this->Olc->showCountry($item['Vendor']['country']);
                        ?></td>
                    <td><?php
                        echo $item['License']['expired_date'];
                        ?></td>
                    <td><?php
                        echo $item['License']['license_date'];
                        ?></td>
                    <td><?php
                        echo $item['License']['submitted'];
                        ?></td>
                </tr>
            <?php }; // End of foreach ($items as $item) {  ?>
        </tbody>
    </table>
</div>
<div class="clearfix paginator-wrapper">
    <?php echo $this->element('paginator'); ?>
</div>
