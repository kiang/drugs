<?php
echo $this->Html->script('c/drugs/outward', array('inline' => false));
?>
<h3>藥物外觀</h3>
<div class="paginator-wrapper">
    <?php echo $this->element('paginator'); ?>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <ul class="media-list">
            <p>&nbsp;</p>
            <?php
            $i = 0;
            foreach ($items as $item) {
                $name = $item['License']['name'];
                if (!empty($item['License']['name_english'])) {
                    $name .= " <br class=\"hidden-md hidden-lg\"><small class=\"text-english-name hidden-xs\">{$item['License']['name_english']}</small>";
                }
            ?>
            <li class="media">
                <div class="media-left media-middle">
                    <a href="<?php echo $this->Html->url('/') . 'drugs/view/' . $item['Drug'][0]['id']; ?>">
                        <?php if (!empty($item['License']['image'])) { ?>
                            <img src="<?php echo $this->Html->url('/') . $item['License']['image']; ?>" class="img-thumbnail drug-list-thumbnail" />
                        <?php } else {?>
                            <div class="img-thumbnail drug-list-thumbnail">
                                <p>沒有影像</p>
                            </div>
                        <?php } ?>
                    </a>
                </div>
                <div class="media-body">
                    <a href="<?php echo $this->Html->url('/') . 'drugs/view/' . $item['Drug'][0]['id']; ?>">
                        <h6 class="media-heading"><?php echo $name; ?></h6>
                    </a>
                    <hr>
                    <p>
                        <div class="hidden-xs"><strong>許可證字號</strong> <?php echo $item['License']['license_id']; ?><br></div>
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
