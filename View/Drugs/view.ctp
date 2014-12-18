<div id="DrugsView">
    <h3><?php echo $this->data['Drug']['name']; ?></h3>
    <div class="col-md-12">
        <div class="col-md-2">許可證字號</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['license_id']; ?>&nbsp;</div>
    </div>
    <div class="col-md-12">
        <div class="col-md-2">註銷狀態</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['cancel_status']; ?>&nbsp;</div>
    </div>
    <div class="col-md-12">
        <div class="col-md-2">註銷日期</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['cancel_date']; ?>&nbsp;</div>
    </div>
    <div class="col-md-12">
        <div class="col-md-2">註銷理由</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['cancel_reason']; ?>&nbsp;</div>
    </div>
    <div class="col-md-12">
        <div class="col-md-2">有效日期</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['expired_date']; ?>&nbsp;</div>
    </div>
    <div class="col-md-12">
        <div class="col-md-2">發證日期</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['license_date']; ?>&nbsp;</div>
    </div>
    <div class="col-md-12">
        <div class="col-md-2">許可證種類</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['license_type']; ?>&nbsp;</div>
    </div>
    <div class="col-md-12">
        <div class="col-md-2">舊證字號</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['old_id']; ?>&nbsp;</div>
    </div>
    <div class="col-md-12">
        <div class="col-md-2">通關簽審文件編號</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['document_id']; ?>&nbsp;</div>
    </div>
    <div class="col-md-12">
        <div class="col-md-2">中文品名</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['name']; ?>&nbsp;</div>
    </div>
    <div class="col-md-12">
        <div class="col-md-2">英文品名</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['name_english']; ?>&nbsp;</div>
    </div>
    <div class="col-md-12">
        <div class="col-md-2">適應症</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['disease']; ?>&nbsp;</div>
    </div>
    <div class="col-md-12">
        <div class="col-md-2">劑型</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['formulation']; ?>&nbsp;</div>
    </div>
    <div class="col-md-12">
        <div class="col-md-2">包裝</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['package']; ?>&nbsp;</div>
    </div>
    <div class="col-md-12">
        <div class="col-md-2">藥品類別</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['type']; ?>&nbsp;</div>
    </div>
    <div class="col-md-12">
        <div class="col-md-2">管制藥品分類級別</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['class']; ?>&nbsp;</div>
    </div>
    <div class="col-md-12">
        <div class="col-md-2">主成分略述</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['ingredient']; ?>&nbsp;</div>
    </div>
    <div class="col-md-12">
        <div class="col-md-2">申請商名稱</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['vendor']; ?>&nbsp;</div>
    </div>
    <div class="col-md-12">
        <div class="col-md-2">申請商地址</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['vendor_address']; ?>&nbsp;</div>
    </div>
    <div class="col-md-12">
        <div class="col-md-2">申請商統一編號</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['vendor_id']; ?>&nbsp;</div>
    </div>
    <div class="col-md-12">
        <div class="col-md-2">製造商名稱</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['manufacturer']; ?>&nbsp;</div>
    </div>
    <div class="col-md-12">
        <div class="col-md-2">製造廠廠址</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['manufacturer_address']; ?>&nbsp;</div>
    </div>
    <div class="col-md-12">
        <div class="col-md-2">製造廠公司地址</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['manufacturer_office']; ?>&nbsp;</div>
    </div>
    <div class="col-md-12">
        <div class="col-md-2">製造廠國別</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['manufacturer_country']; ?>&nbsp;</div>
    </div>
    <div class="col-md-12">
        <div class="col-md-2">製程</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['manufacturer_description']; ?>&nbsp;</div>
    </div>
    <div class="col-md-12">
        <div class="col-md-2">異動日期</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['submitted']; ?>&nbsp;</div>
    </div>
    <div class="col-md-12">
        <div class="col-md-2">用法用量</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['usage']; ?>&nbsp;</div>
    </div>
    <div class="col-md-12">
        <div class="col-md-2">包裝</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['package_note']; ?>&nbsp;</div>
    </div>
    <div class="col-md-12">
        <div class="col-md-2">國際條碼</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['barcode']; ?>&nbsp;</div>
    </div>
    <div class="clearfix"><br /></div>
    <h3>異動記錄</h3>
    <div class="clearfix"><br /></div>
    <div class="col-md-12">
        <?php
        $firstCol = true;
        foreach ($logs AS $id => $submitted) {
            if (!$firstCol) {
                echo '<div class="col-md-2">';
                if ($id !== $this->data['Drug']['id']) {
                    echo $this->Html->link($submitted, '/drugs/view/' . $id);
                } else {
                    echo '<strong>' . $submitted . '</strong>';
                }
                echo '</div>';
            } else {
                $firstCol = false;
                echo '<div class="col-md-12">';
                if ($id !== $this->data['Drug']['id']) {
                    echo $this->Html->link($submitted, '/drugs/view/' . $id);
                } else {
                    echo '<strong>' . $submitted . '</strong>';
                }
                echo '</div>';
            }
        }
        ?>
    </div>
    <div class="clearfix"><br /></div>
</div>