<p>&nbsp;</p>
<h4><?php echo $member['Member']['username']; ?></h4>
<section class="content">
    <div class="row">
        <div class="col-md-6">main content</div>
        <div class="col-md-6">
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
        </div>
    </div>
</section>