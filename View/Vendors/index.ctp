<h2>藥物廠商</h2>
<div class="paginator-wrapper">
    <?php echo $this->element('paginator'); ?>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <ul class="media-list">
            <p class="hidden-sm hidden-xs">&nbsp;</p>
            <?php
            foreach ($items as $item) {
            ?>
            <li class="media">
                <a href="<?php echo $this->Html->url('view/') . $item['Vendor']['id']; ?>" class="hidden-md hidden-lg">
                    <h6 class="media-heading">
                        <?php
                            if (!empty($item['Vendor']['name'])) {
                                echo $item['Vendor']['name'];
                            } else {
                                echo '<span class="text-muted">無紀錄</span>';
                            }
                        ?>
                    </h6>
                </a>
                <div class="media-body">
                    <a href="<?php echo $this->Html->url('view/') . $item['Vendor']['id']; ?>" class="hidden-sm hidden-xs">
                        <h6 class="media-heading"><?php echo $item['Vendor']['name']; ?></h6>
                    </a>
                    <hr>
                    <p>
                        <strong>統一編號</strong> 
                        <?php
                            if (!empty($item['Vendor']['tax_id'])) {
                                echo $item['Vendor']['tax_id'];
                            } else {
                                echo '<span class="text-muted">無紀錄</span>';
                            }
                        ?>
                        <br>
                        <strong>國家</strong> <?php echo $this->Olc->showCountry($item['Vendor']['country']); ?> <br>
                        <strong>地址</strong> <?php echo $item['Vendor']['address']; ?><br>
                        <br>
                    </p>
                </div>
            </li>
            <?php }; // End of foreach ($items as $item) {  ?>
        </ul>
    </div>
</div>

<div class="clearfix paginator-wrapper">
    <?php echo $this->element('paginator'); ?>
</div>