<h2>藥物證書</h2>
<div class="paginator-wrapper">
    <?php echo $this->element('paginator'); ?>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <ul class="media-list">
            <p class="hidden-sm hidden-xs">&nbsp;</p>
            <?php
            foreach ($items as $item) {
                $name = $item['License']['name'];
                if (!empty($item['License']['name_english'])) {
                    $name .= " <br class=\"hidden-md hidden-lg\"><small class=\"text-english-name hidden-xs\">{$item['License']['name_english']}</small>";
                }
            ?>
            <li class="media">
                <a href="<?php echo $this->Html->url('/') . 'drugs/view/' . $item['Drug']['id']; ?>" class="hidden-md hidden-lg">
                    <h6 class="media-heading"><?php echo $name; ?></h6>
                </a>
                <div class="media-left media-middle">
                    <a href="<?php echo $this->Html->url('/') . 'drugs/view/' . $item['Drug']['id']; ?>">
                        <?php if (!empty($item['License']['image'])) { ?>
                            <img src="<?php echo $this->Html->url('/') . $item['License']['image']; ?>" class="img-thumbnail drug-list-thumbnail" />
                        <?php } else {?>
                            <div class="img-thumbnail drug-list-thumbnail">
                                <p class="text-muted">沒有影像</p>
                            </div>
                        <?php } ?>
                    </a>
                </div>
                <div class="media-body">
                    <a href="<?php echo $this->Html->url('/') . 'drugs/view/' . $item['Drug']['id']; ?>" class="hidden-sm hidden-xs">
                        <h6 class="media-heading"><?php echo $name; ?></h6>
                    </a>
                    <hr>
                    <p>
                        <div class="hidden-xs"><strong>許可證字號</strong> <?php echo $item['License']['license_id']; ?><br></div>
                        <strong class="hidden-xs">製造商</strong> <?php echo $item['Vendor']['name'] . '&nbsp;' . $this->Olc->showCountry($item['Vendor']['country']); ?>
                        <br>
                        <?php
                            $now_date = new DateTime();
                            $expired_date = new DateTime($item['License']['expired_date']);
                            $date_between = intval($expired_date->diff($now_date)->y);
                        ?>
                        <strong>許可證<span class="hidden-xs">有效日期</span></strong>&nbsp;
                        <?php
                            if ($date_between >= 3) {
                                echo $item['License']['expired_date'];
                            } else {
                                echo $this->Html->tag('span', $item['License']['expired_date'], array('class' => 'text-warning'));
                            }
                        ?>
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
