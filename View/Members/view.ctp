<p>&nbsp;</p>
<h4><?php echo !empty($member['Member']['nickname']) ? $member['Member']['nickname'] : $member['Member']['username']; ?></h4>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <?php
            if (!empty($member['Member']['ext_image'])) {
                $options = array();
                if (!empty($member['Member']['ext_url'])) {
                    echo '<a href="' . $member['Member']['ext_url'] . '" target="_blank"><img src="' . $member['Member']['ext_image'] . '" alt="" /></a>';
                } else {
                    echo '<img src="" alt="' . $member['Member']['ext_image'] . '" />';
                }
            }
            echo '<div class="clearfix"></div>' . $member['Member']['intro'];
            ?>
        </div>
        <div class="col-md-6">
            <?php if (!empty($member['Note'])) { ?>
                <h4>最近參與編輯</h4>
                <ul>
                    <?php
                    foreach ($member['Note'] AS $note) {
                        echo '<li>';
                        echo $this->Html->link("[{$note['modified']}] {$note['License']['license_id']}", '/licenses/view/' . $note['license_id']);
                        echo '</li>';
                    }
                    ?>
                </ul>
            <?php } ?>
        </div>
    </div>
</section>