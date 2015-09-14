<?php
echo $this->Html->script('c/drugs/outward', array('inline' => false));
?>
<h2>藥物外觀</h2>
<div class="paginator-wrapper">
    <?php echo $this->element('paginator'); ?>
</div>

<div class="row">
    <div class="col-md-12 col-xs-12">
        <ul class="media-list">
            <p>&nbsp;</p>
            <?php
            $i = 0;
            foreach ($items as $item) {
                $name = $item['License']['name'];
                if (!empty($item['License']['name_english'])) {
                    $name .= " <small class=\"text-info\">{$item['License']['name_english']}</small>";
                }
            ?>
            <li class="media">
                <div class="media-left media-middle">
                    <a href="<?php echo $this->Html->url('/') . 'drugs/view/' . $item['Drug']['id']; ?>">
                        <?php if (!empty($item['License']['image'])) { ?>
                            <img src="<?php echo $this->Html->url('/') . $item['License']['image']; ?>" class="img-thumbnail outwrad-thumbnail" />
                        <?php } ?>
                    </a>
                </div>
                <div class="media-body">
                    <a href="<?php echo $this->Html->url('/') . 'drugs/view/' . $item['Drug']['id']; ?>">
                        <h6 class="media-heading"><?php echo $name; ?></h6>
                    </a>
                    <hr>
                    <p>
                        <br>
                        <strong>許可證字號</strong> <?php echo $item['License']['license_id']; ?><br>
                        <strong>適應症</strong> <?php echo $item['License']['disease']; ?>
                    </p>
                </div>
            </li>
            <?php }; // End of foreach ($items as $item) {  ?>
            <div class="clearfix"></div>
        </ul>
    </div>
</div>

<div class="paginator-wrapper">
    <?php echo $this->element('paginator'); ?>
</div>
