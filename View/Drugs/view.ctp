<div id="DrugsView">
    <h3><?php echo $this->data['Drug']['name']; ?></h3>
    <?php if (!empty($this->data['Drug']['image'])) { ?>
        <div class="row">
            <img src="<?php echo $this->Html->url('/') . $this->data['Drug']['image']; ?>" class="img-thumbnail col-md-4" />
        </div>
    <?php } ?>
    <div class="row">
        <div class="col-md-2">許可證字號</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['license_id']; ?>&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-md-2">註銷狀態</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['cancel_status']; ?>&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-md-2">註銷日期</div>
        <div class="col-md-10"><?php echo ($this->data['Drug']['cancel_date'] === '0000-00-00') ? '' : $this->data['Drug']['cancel_date']; ?>&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-md-2">註銷理由</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['cancel_reason']; ?>&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-md-2">有效日期</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['expired_date']; ?>&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-md-2">發證日期</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['license_date']; ?>&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-md-2">許可證種類</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['license_type']; ?>&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-md-2">舊證字號</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['old_id']; ?>&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-md-2">通關簽審文件編號</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['document_id']; ?>&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-md-2">中文品名</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['name']; ?>&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-md-2">英文品名</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['name_english']; ?>&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-md-2">適應症</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['disease']; ?>&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-md-2">劑型</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['formulation']; ?>&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-md-2">包裝</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['package']; ?>&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-md-2">藥品類別</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['type']; ?>&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-md-2">管制藥品分類級別</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['class']; ?>&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-md-2">主成分略述</div>
        <div class="col-md-10"><?php
            $majorIngredients = explode(';;', $this->data['Drug']['ingredient']);
            foreach ($majorIngredients AS $ingredient) {
                echo $this->Html->link($ingredient, '/drugs/index/' . $ingredient, array('class' => 'btn btn-default'));
            }
            ?>&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-md-2">申請商名稱</div>
        <div class="col-md-10"><?php
            echo $this->Html->link($this->data['Drug']['vendor'], '/drugs/index/' . $this->data['Drug']['vendor'], array('class' => 'btn btn-default'));
            ?>&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-md-2">申請商地址</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['vendor_address']; ?>&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-md-2">申請商統一編號</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['vendor_id']; ?>&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-md-2">製造商名稱</div>
        <div class="col-md-10"><?php
            echo $this->Html->link($this->data['Drug']['manufacturer'], '/drugs/index/' . $this->data['Drug']['manufacturer'], array('class' => 'btn btn-default'));
            ?>&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-md-2">製造廠廠址</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['manufacturer_address']; ?>&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-md-2">製造廠公司地址</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['manufacturer_office']; ?>&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-md-2">製造廠國別</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['manufacturer_country']; ?>&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-md-2">製程</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['manufacturer_description']; ?>&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-md-2">異動日期</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['submitted']; ?>&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-md-2">用法用量</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['usage']; ?>&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-md-2">包裝</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['package_note']; ?>&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-md-2">國際條碼</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['barcode']; ?>&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-md-2">健保代碼</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['nhi_id']; ?>&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-md-2">形狀</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['shape']; ?>&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-md-2">特殊劑型</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['s_type']; ?>&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-md-2">顏色</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['color']; ?>&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-md-2">特殊氣味</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['odor']; ?>&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-md-2">刻痕</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['abrasion']; ?>&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-md-2">外觀尺寸</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['size']; ?>&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-md-2">標註一</div>
        <div class="col-md-10"><?php echo $this->data['Drug']['note_1']; ?>&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-md-2">標註二 </div>
        <div class="col-md-10"><?php echo $this->data['Drug']['note_2']; ?>&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-md-2">相關連結 </div>
        <div class="col-md-10"><?php
            foreach ($links AS $link) {
                echo $this->Html->link($link['Link']['title'], $link['Link']['url'], array('class' => 'btn btn-default', 'target' => '_blank'));
            }
            ?>&nbsp;</div>
    </div>
    <div class="clearfix"><br /></div>
    <h3>成份表</h3>
    <div class="clearfix"><br /></div>
    <?php
    if (!empty($ingredients)) {
        ?><table class="table table-bordered">
            <thead>
                <tr>
                    <th>處方標示</th>
                    <th>成分名稱</th>
                    <th>含量描述</th>
                    <th>含量單位</th>
                </tr>
            </thead>
            <tbody><?php
                foreach ($ingredients AS $ingredient) {
                    ?><tr>
                        <td><?php echo $ingredient['Ingredient']['remark']; ?></td>
                        <td><?php echo $ingredient['Ingredient']['name']; ?></td>
                        <td><?php echo!empty($ingredient['Ingredient']['dosage_text']) ? $ingredient['Ingredient']['dosage_text'] : $ingredient['Ingredient']['dosage']; ?></td>
                        <td><?php echo $ingredient['Ingredient']['unit']; ?></td>
                    </tr><?php
                }
                ?></tbody>
        </table><?php
    }
    ?>
    <?php if (!empty($this->data['Category'])) { ?>
        <div class="clearfix"><br /></div>
        <h3>ATC 分類</h3>
        <div class="clearfix"><br /></div>
        <ul>
            <?php
            foreach ($this->data['Category'] AS $category) {
                $tree = array();
                foreach ($categoryNames[$category['CategoriesDrug']['category_id']] AS $item) {
                    /*
                     * @todo: have a category page to view related drugs
                     */
                    $tree[] = $this->Html->link($item['Category']['name'], '/drugs/category/' . $item['Category']['id']);
                }
                echo '<li>';
                echo " [{$category['CategoriesDrug']['type']}] ";
                echo $this->Html->link($category['code'], 'http://www.whocc.no/atc_ddd_index/?code=' . $category['code'] . '&showdescription=yes', array('target' => '_blank'));
                echo " {$category['name_chinese']}<br />";
                echo implode(' > ', $tree);
                echo '</li>';
            }
            ?>
        </ul>
    <?php } ?>
    <div class="clearfix"><br /></div>
    <h3>異動記錄</h3>
    <div class="clearfix"><br /></div>
    <div class="row">
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
    <h3>健保價格記錄</h3>
    <div class="clearfix"><br /></div>
    <div class="row">
        <ul>
            <?php
            $currentNhiId = false;
            foreach ($prices AS $price) {
                if (false === $currentNhiId) {
                    echo "<li><strong>[{$price['Price']['nhi_id']}] {$price['Price']['nhi_dosage']} {$price['Price']['nhi_unit']}</strong></li>";
                    $currentNhiId = $price['Price']['nhi_id'];
                } elseif ($currentNhiId != $price['Price']['nhi_id']) {
                    echo '</ul><ul>';
                    echo "<li><strong>[{$price['Price']['nhi_id']}] {$price['Price']['nhi_dosage']} {$price['Price']['nhi_unit']}</strong></li>";
                    $currentNhiId = $price['Price']['nhi_id'];
                }
                echo '<li>' . "{$price['Price']['date_begin']} ~ {$price['Price']['date_end']} - > &nbsp; &nbsp; &nbsp; \${$price['Price']['nhi_price']}</li>";
            }
            ?>
        </ul>
    </div>
</div>