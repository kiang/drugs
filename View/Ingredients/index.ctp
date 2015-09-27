<h2>藥物成份</h2>
<div class="paginator-wrapper">
    <?php echo $this->element('paginator'); ?>
</div>

<small class="pull-right"><span class="badge">藍色方框</span>&nbsp;表示此藥證數量</small>
<p>&nbsp;</p>
<?php
$i = 0;
foreach ($items as $item) {
    ?>
    <ul class="col-md-12 col-xs-12">
        <?php
        echo $this->Html->tag(
                'li',
                $this->Html->link($item['Ingredient']['name'], array('action' => 'view', $item['Ingredient']['id'])) . 
                $this->Html->tag('span', $item['Ingredient']['count_licenses'], array('class' => 'badge')) . 
                $this->Html->tag('div', '', array('class' => 'clearfix')),
                array('class' => 'list-group-item')
            )
        ?>
    </ul>
<?php }; // End of foreach ($items as $item) {  ?>

<div class="clearfix"></div>
<div class="paginator-wrapper">
    <?php echo $this->element('paginator'); ?>
</div>
