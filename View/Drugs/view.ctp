<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php
        $name = $this->data['License']['name'];
        if (!empty($this->data['License']['name_english'])) {
            $name .= "({$this->data['License']['name_english']})";
        }
        echo $name;
        ?></h1>
    <ol class="breadcrumb">
        <li><?php echo $this->Html->link('藥物證書', '/drugs/index'); ?></li>
        <li class="active"><?php echo $this->data['License']['name']; ?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div id="DrugsView" class="row">
        <div class="col-md-6">
            <div class="box">
                <div class="box-body">
                    <?php if (!empty($this->data['License']['image'])) { ?>
                        <img src="<?php echo $this->Html->url('/') . $this->data['License']['image']; ?>" class="img-thumbnail col-md-8" />
                        <div class="clearfix"></div>
                    <?php } ?>
                    <dl class="dl-horizontal">
                        <dt>適應症</dt>
                        <dd><?php echo $this->data['License']['disease']; ?>&nbsp;
                        </dd>
                        <dt>劑型</dt>
                        <dd><?php echo $this->data['License']['formulation']; ?>&nbsp;
                        </dd>
                        <dt>包裝</dt>
                        <dd><?php echo $this->data['License']['package']; ?>&nbsp;
                        </dd>
                        <dt>用法用量</dt>
                        <dd><?php echo $this->data['License']['usage']; ?>&nbsp;
                        </dd>
                        <dt>包裝</dt>
                        <dd><?php echo $this->data['License']['package_note']; ?>&nbsp;
                        </dd>
                        <dt>形狀</dt>
                        <dd><?php echo $this->data['License']['shape']; ?>&nbsp;
                        </dd>
                        <dt>特殊劑型</dt>
                        <dd><?php echo $this->data['License']['s_type']; ?>&nbsp;
                        </dd>
                        <dt>顏色</dt>
                        <dd><?php echo $this->data['License']['color']; ?>&nbsp;
                        </dd>
                        <dt>特殊氣味</dt>
                        <dd><?php echo $this->data['License']['odor']; ?>&nbsp;
                        </dd>
                        <dt>刻痕</dt>
                        <dd><?php echo $this->data['License']['abrasion']; ?>&nbsp;
                        </dd>
                        <dt>外觀尺寸</dt>
                        <dd><?php echo $this->data['License']['size']; ?>&nbsp;
                        </dd>
                        <dt>標註一</dt>
                        <dd><?php echo $this->data['License']['note_1']; ?>&nbsp;
                        </dd>
                        <dt>標註二 </dt>
                        <dd><?php echo $this->data['License']['note_2']; ?>&nbsp;
                        </dd>
                    </dl>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
        <div class="col-md-6">
            <div class="box">
                <div class="box-body">
                    <dl class="dl-horizontal">                        <dt>許可證字號</dt>
                        <dd><?php
                            if ($this->data['License']['source'] === 'fda' && !empty($this->data['License']['code'])) {
                                echo $this->Html->link($this->data['License']['license_id'], 'http://www.fda.gov.tw/MLMS/H0001D.aspx?Type=Lic&LicId=' . $this->data['License']['code'], array('target' => '_blank', 'class' => 'btn btn-default'));
                            } else {
                                echo $this->data['License']['license_id'];
                            }
                            ?>&nbsp;
                        </dd>
                        <dt>註銷狀態</dt>
                        <dd><?php echo $this->data['License']['cancel_status']; ?>&nbsp;
                        </dd>
                        <dt>註銷日期</dt>
                        <dd><?php echo ($this->data['License']['cancel_date'] === '0000-00-00') ? '' : $this->data['License']['cancel_date']; ?>&nbsp;
                        </dd>
                        <dt>註銷理由</dt>
                        <dd><?php echo $this->data['License']['cancel_reason']; ?>&nbsp;
                        </dd>
                        <dt>有效日期</dt>
                        <dd><?php echo $this->data['License']['expired_date']; ?>&nbsp;
                        </dd>
                        <dt>發證日期</dt>
                        <dd><?php echo $this->data['License']['license_date']; ?>&nbsp;
                        </dd>
                        <dt>許可證種類</dt>
                        <dd><?php echo $this->data['License']['license_type']; ?>&nbsp;
                        </dd>
                        <dt>舊證字號</dt>
                        <dd><?php echo $this->data['License']['old_id']; ?>&nbsp;
                        </dd>
                        <dt>通關簽審文件編號</dt>
                        <dd><?php echo $this->data['License']['document_id']; ?>&nbsp;
                        </dd>
                        <dt>中文品名</dt>
                        <dd><?php echo $this->data['License']['name']; ?>&nbsp;
                        </dd>
                        <dt>英文品名</dt>
                        <dd><?php echo $this->data['License']['name_english']; ?>&nbsp;
                        </dd>
                        <dt>藥品類別</dt>
                        <dd><?php echo $this->data['License']['type']; ?>&nbsp;
                        </dd>
                        <dt>管制藥品分類級別</dt>
                        <dd><?php echo $this->data['License']['class']; ?>&nbsp;
                        </dd>
                        <dt>主成分略述</dt>
                        <dd><?php
                            $majorIngredients = explode(';;', $this->data['License']['ingredient']);
                            foreach ($majorIngredients AS $ingredient) {
                                if (isset($ingredientKeys[$ingredient])) {
                                    echo $this->Html->link($ingredient, '/ingredients/view/' . $ingredientKeys[$ingredient], array('class' => 'btn btn-default'));
                                } else {
                                    echo $this->Html->link($ingredient, '/drugs/index/' . $ingredient, array('class' => 'btn btn-default'));
                                }
                                echo '&nbsp;';
                            }
                            ?>
                        </dd>
                        <dt>申請商名稱</dt>
                        <dd><?php
                            echo $this->Html->link($this->data['License']['Vendor']['name'], '/vendors/view/' . $this->data['License']['Vendor']['id'], array('class' => 'btn btn-default'));
                            ?>&nbsp;
                        </dd>
                        <dt>申請商地址</dt>
                        <dd><?php echo $this->data['License']['Vendor']['address']; ?>&nbsp;
                        </dd>
                        <dt>申請商統一編號</dt>
                        <dd><?php
                            if (!empty($this->data['License']['Vendor']['tax_id'])) {
                                echo $this->Html->link($this->data['License']['Vendor']['tax_id'], 'http://gcis.nat.g0v.tw/id/' . $this->data['License']['Vendor']['tax_id'], array('class' => 'btn btn-default', 'target' => '_blank'));
                            }
                            ?>&nbsp;
                        </dd>
                        <dt>製造商名稱</dt>
                        <dd><?php
                            echo $this->Html->link($this->data['Vendor']['name'], '/vendors/view/' . $this->data['Vendor']['id'], array('class' => 'btn btn-default'));
                            ?>&nbsp;
                        </dd>
                        <dt>製造廠廠址</dt>
                        <dd><?php echo $this->data['Vendor']['address']; ?>&nbsp;
                        </dd>
                        <dt>製造廠公司地址</dt>
                        <dd><?php echo $this->data['Vendor']['address_office']; ?>&nbsp;
                        </dd>
                        <dt>製造廠國別</dt>
                        <dd><?php echo $this->Olc->showCountry($this->data['Vendor']['country']); ?>&nbsp;
                        </dd>
                        <dt>製程</dt>
                        <dd><?php echo $this->data['Drug']['manufacturer_description']; ?>&nbsp;
                            <?php
                            if (!empty($drugs)) {
                                echo '<dt>其他製造商</dt>';
                                echo '<dd><ul>';
                                foreach ($drugs AS $drug) {
                                    echo '<li>';
                                    $drugName = '';
                                    if (!empty($drug['Drug']['manufacturer_description'])) {
                                        $drugName .= "[{$drug['Drug']['manufacturer_description']}]";
                                    }
                                    $drugName .= $drug['Vendor']['name'];
                                    if (!empty($drug['Vendor']['country'])) {
                                        $drugName .= " ({$drug['Vendor']['country']})";
                                    }
                                    echo $this->Html->link($drugName, '/drugs/view/' . $drug['Drug']['id']);
                                    echo '</li>';
                                }
                                echo '</ul></dd>';
                            }
                            ?>                        </dd>
                        <dt>異動日期</dt>
                        <dd><?php echo $this->data['License']['submitted']; ?>&nbsp;
                        </dd>
                        <dt>國際條碼</dt>
                        <dd><?php echo $this->data['License']['barcode']; ?>&nbsp;
                        </dd>
                        <dt>健保代碼</dt>
                        <dd><?php echo $this->data['License']['nhi_id']; ?>&nbsp;
                        </dd>
                        <dt>相關連結 </dt>
                        <dd><?php
                            foreach ($links AS $link) {
                                echo $this->Html->link($link['Link']['title'], $link['Link']['url'], array('class' => 'btn btn-default', 'target' => '_blank'));
                            }
                            ?>&nbsp;
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <?php if (!empty($ingredients)) { ?>
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">成份表</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered">
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
                                        <td><?php echo $ingredient['IngredientsLicense']['remark']; ?></td>
                                        <td><?php echo $this->Html->link($ingredient['IngredientsLicense']['name'], '/ingredients/view/' . $ingredient['IngredientsLicense']['ingredient_id'], array('class' => 'btn btn-default')); ?></td>
                                        <td><?php echo!empty($ingredient['IngredientsLicense']['dosage_text']) ? $ingredient['IngredientsLicense']['dosage_text'] : $ingredient['IngredientsLicense']['dosage']; ?></td>
                                        <td><?php echo $ingredient['IngredientsLicense']['unit']; ?></td>
                                    </tr><?php
                                }
                                ?></tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        <?php } ?>
        <?php if (!empty($this->data['License']['Category'])) { ?>
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">ATC 分類</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <ul>
                            <?php
                            foreach ($this->data['License']['Category'] AS $category) {
                                $tree = array();
                                foreach ($categoryNames[$category['CategoriesLicense']['category_id']] AS $item) {
                                    $tree[] = $this->Html->link($item['Category']['name'], '/drugs/category/' . $item['Category']['id']);
                                }
                                echo '<li>';
                                echo " [{$category['CategoriesLicense']['type']}] ";
                                echo $this->Html->link($category['code'], 'http://www.whocc.no/atc_ddd_index/?code=' . $category['code'] . '&showdescription=yes', array('target' => '_blank'));
                                echo " {$category['name_chinese']}<br />";
                                echo implode(' > ', $tree);
                                echo '</li>';
                            }
                            ?>
                        </ul>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        <?php } ?>
        <?php if (!empty($prices)) { ?>
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">健保價格記錄</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
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
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        <?php } ?>
        <?php if (!empty($articles)) { ?>
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">醫事新知</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <ul>
                            <?php
                            foreach ($articles AS $article) {
                                echo '<li>';
                                switch ($articleIds[$article['Article']['id']]) {
                                    case 'Vendor':
                                        echo '藥廠 >> ';
                                        break;
                                    case 'Ingredient':
                                        echo '成份 >> ';
                                        break;
                                }
                                echo $this->Html->link("{$article['Article']['date_published']} {$article['Article']['title']}", '/articles/view/' . $article['Article']['id']) . '</li>';
                            }
                            ?>
                        </ul>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            <?php } ?>
        </div>
    </div>
</section><!-- /.content -->
