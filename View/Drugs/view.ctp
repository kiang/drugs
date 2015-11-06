<p>&nbsp;</p>
<h4>
    <?php
    $name = $this->data['License']['name'];
    if (!empty($this->data['License']['name_english'])) {
        $name .= "<br><small class=\"text-info\">{$this->data['License']['name_english']}</small>";
    }
    echo $name;
    ?>
</h4>
<ol class="breadcrumb">
    <li><?php echo $this->Html->link('藥物證書', '/drugs/index'); ?></li>
    <li class="active"><?php echo $this->data['License']['name']; ?></li>
    <?php if($editCheck) { ?>
    <li class="pull-right"><?php echo $this->Html->link('編輯', '/admin/licenses/edit/' . $this->data['License']['id']); ?></li>
    <?php } ?>
</ol>
<div class="ad-box">
    <a href="http://dts28280399.com/" target="_blank" class="no-hover-icon">
        <?php echo $this->Html->image('dts28280399.png'); ?>
    </a>
</div>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <?php
            if (!empty($this->data['License']['image'] || !empty($this->data['License']['Image']))) {
                $gallery = array();
                $mainImage = $this->data['License']['image'];
                if(!empty($mainImage)) {
                    $mainImage = $this->Html->url('/' . $mainImage);
                    $gallery[$mainImage] = array(
                        'small' => $mainImage,
                        'username' => '',
                        'userid' => '',
                    );
                } else {
                    $mainImage = $this->Media->url($this->data['License']['Image'][0]['path']);
                }
                foreach($this->data['License']['Image'] AS $img) {
                    $gallery[$this->Media->url($img['path'])] = array(
                        'small' => $this->Media->url('s/' . $img['path']),
                        'username' => $members[$img['member_id']],
                        'userid' => $img['member_id'],
                    );
                }
                ?>
            <div class="row">
                <div class="zoom col-md-8 col-md-offset-2">
                    <img src="<?php echo $mainImage; ?>" class="img-thumbnail" id="imgZoomBlock">
                </div>
            </div>
            <div style="text-align: center;" id="imgZoomUsername"></div>
            <div class="clearfix"></div>
            <?php
            if(count($gallery) > 1) {
                foreach($gallery AS $orig => $thumb) {
                    ?><a href="#" data-orig="<?php
                    echo $orig; ?>" data-username="<?php
                    echo $thumb['username']; ?>" data-userid="<?php
                    echo $thumb['userid']; ?>" class="imgZoomSwitch"><img src="<?php
                    echo $thumb['small']; ?>" class="img-thumbnail" style="width: 50px;" /></a><?php
                }
            }
            ?>
            <p>&nbsp;</p>
            <?php } ?>
            <dl class="dl-horizontal">
                <dt>適應症</dt>
                <dd><?php 
                    if (!empty($this->data['License']['disease'])) {
                        echo $this->data['License']['disease'];
                    } else {
                        echo '<span class="text-muted">無紀錄</span>';
                    } ?>&nbsp;
                </dd>
                <dt>劑型</dt>
                <dd><?php 
                    if (!empty($this->data['License']['formulation'])) {
                        echo $this->data['License']['formulation'];
                    } else {
                        echo '<span class="text-muted">無紀錄</span>';
                    } ?>&nbsp;
                </dd>
                <dt>包裝</dt>
                <dd><?php 
                    if (!empty($this->data['License']['package'])) {
                        echo $this->data['License']['package'];
                    } else {
                        echo '<span class="text-muted">無紀錄</span>';
                    } ?>&nbsp;
                </dd>
                <dt>用法用量</dt>
                <dd><?php 
                    if (!empty($this->data['License']['usage'])) {
                        echo $this->data['License']['usage'];
                    } else {
                        echo '<span class="text-muted">無紀錄</span>';
                    } ?>&nbsp;
                </dd>
                <dt>包裝</dt>
                <dd><?php 
                    if (!empty($this->data['License']['package_note'])) {
                        echo $this->data['License']['package_note'];
                    } else {
                        echo '<span class="text-muted">無紀錄</span>';
                    } ?>&nbsp;
                </dd>
                <dt>形狀</dt>
                <dd><?php 
                    if (!empty($this->data['License']['shape'])) {
                        echo $this->data['License']['shape'];
                    } else {
                        echo '<span class="text-muted">無紀錄</span>';
                    } ?>&nbsp;
                </dd>
                <dt>特殊劑型</dt>
                <dd><?php 
                    if (!empty($this->data['License']['s_type'])) {
                        echo $this->data['License']['s_type'];
                    } else {
                        echo '<span class="text-muted">無紀錄</span>';
                    } ?>&nbsp;
                </dd>
                <dt>顏色</dt>
                <dd><?php 
                    if (!empty($this->data['License']['color'])) {
                        echo $this->data['License']['color'];
                    } else {
                        echo '<span class="text-muted">無紀錄</span>';
                    } ?>&nbsp;
                </dd>
                <dt>特殊氣味</dt>
                <dd><?php 
                    if (!empty($this->data['License']['odor'])) {
                        echo $this->data['License']['odor'];
                    } else {
                        echo '<span class="text-muted">無紀錄</span>';
                    } ?>&nbsp;
                </dd>
                <dt>刻痕</dt>
                <dd><?php 
                    if (!empty($this->data['License']['abrasion'])) {
                        echo $this->data['License']['abrasion'];
                    } else {
                        echo '<span class="text-muted">無紀錄</span>';
                    } ?>&nbsp;
                </dd>
                <dt>外觀尺寸</dt>
                <dd><?php 
                    if (!empty($this->data['License']['size'])) {
                        echo $this->data['License']['size'];
                    } else {
                        echo '<span class="text-muted">無紀錄</span>';
                    } ?>&nbsp;
                </dd>
                <dt>標註一</dt>
                <dd><?php 
                    if (!empty($this->data['License']['note_1'])) {
                        echo $this->data['License']['note_1'];
                    } else {
                        echo '<span class="text-muted">無紀錄</span>';
                    } ?>&nbsp;
                </dd>
                <dt>標註二 </dt>
                <dd><?php 
                    if (!empty($this->data['License']['note_2'])) {
                        echo $this->data['License']['note_2'];
                    } else {
                        echo '<span class="text-muted">無紀錄</span>';
                    } ?>&nbsp;
                </dd>
            </dl>
        </div>
        <div class="col-md-6">
            <dl class="dl-horizontal">
                <dt>許可證字號</dt>
                <dd><?php
                    if ($this->data['License']['source'] === 'fda' && !empty($this->data['License']['code'])) {
                        echo $this->Html->link($this->data['License']['license_id'], 'http://www.fda.gov.tw/MLMS/H0001D.aspx?Type=Lic&LicId=' . $this->data['License']['code'], array('target' => '_blank'));
                    } else {
                        echo $this->data['License']['license_id'];
                    }
                    ?>&nbsp;
                </dd>
                <dt>註銷狀態</dt>
                <dd><?php 
                    if (!empty($this->data['License']['cancel_status'])) {
                        echo $this->data['License']['cancel_status'];
                    } else {
                        echo '<span class="text-muted">無紀錄</span>';
                    } ?>&nbsp;
                </dd>
                <dt>註銷日期</dt>
                <dd><?php if (!empty($this->data['License']['cancel_date'])) {
                            echo ($this->data['License']['cancel_date'] === '0000-00-00') ? '<span class="text-muted">無紀錄</span>' : $this->data['License']['cancel_date'];
                        } else {
                            echo '<span class="text-muted">無紀錄</span>';
                        }
                    ?>&nbsp;
                </dd>
                <dt>註銷理由</dt>
                <dd><?php 
                    if (!empty($this->data['License']['cancel_reason'])) {
                        echo $this->data['License']['cancel_reason'];
                    } else {
                        echo '<span class="text-muted">無紀錄</span>';
                    } ?>&nbsp;
                </dd>
                <dt>有效日期</dt>
                <dd><?php 
                    if (!empty($this->data['License']['expired_date'])) {
                        echo $this->data['License']['expired_date'];
                    } else {
                        echo '<span class="text-muted">無紀錄</span>';
                    } ?>&nbsp;
                </dd>
                <dt>發證日期</dt>
                <dd><?php 
                    if (!empty($this->data['License']['license_date'])) {
                        echo $this->data['License']['license_date'];
                    } else {
                        echo '<span class="text-muted">無紀錄</span>';
                    } ?>&nbsp;
                </dd>
                <dt>許可證種類</dt>
                <dd><?php 
                    if (!empty($this->data['License']['license_type'])) {
                        echo $this->data['License']['license_type'];
                    } else {
                        echo '<span class="text-muted">無紀錄</span>';
                    } ?>&nbsp;
                </dd>
                <dt>舊證字號</dt>
                <dd><?php 
                    if (!empty($this->data['License']['old_id'])) {
                        echo $this->data['License']['old_id'];
                    } else {
                        echo '<span class="text-muted">無紀錄</span>';
                    } ?>&nbsp;
                </dd>
                <dt>通關簽審文件編號</dt>
                <dd><?php 
                    if (!empty($this->data['License']['document_id'])) {
                        echo $this->data['License']['document_id'];
                    } else {
                        echo '<span class="text-muted">無紀錄</span>';
                    } ?>&nbsp;
                </dd>
                <dt>中文品名</dt>
                <dd><?php 
                    if (!empty($this->data['License']['name'])) {
                        echo $this->data['License']['name'];
                    } else {
                        echo '<span class="text-muted">無紀錄</span>';
                    } ?>&nbsp;
                </dd>
                <dt>英文品名</dt>
                <dd><?php 
                    if (!empty($this->data['License']['name_english'])) {
                        echo $this->data['License']['name_english'];
                    } else {
                        echo '<span class="text-muted">無紀錄</span>';
                    } ?>&nbsp;
                </dd>
                <dt>藥品類別</dt>
                <dd><?php 
                    if (!empty($this->data['License']['type'])) {
                        echo $this->data['License']['type'];
                    } else {
                        echo '<span class="text-muted">無紀錄</span>';
                    } ?>&nbsp;
                </dd>
                <dt>管制藥品分類級別</dt>
                <dd><?php 
                    if (!empty($this->data['License']['class'])) {
                        echo $this->data['License']['class'];
                    } else {
                        echo '<span class="text-muted">無紀錄</span>';
                    } ?>&nbsp;
                </dd>
                <dt>主成分略述</dt>
                <dd><?php
                    if (!empty($this->data['License']['ingredient'])) {
                        $majorIngredients = explode(';;', $this->data['License']['ingredient']);
                        foreach ($majorIngredients AS $ingredient) {
                            echo '<div class="drug-label">';
                            if (isset($ingredientKeys[$ingredient])) {
                                echo $this->Html->link(
                                    $this->Html->tag('label', $ingredient, array('class' => 'label label-default', 'style' => 'cursor: pointer')),
                                    '/ingredients/view/' . $ingredientKeys[$ingredient],
                                    array('class' => 'text-ellipsis', 'escape' => false)
                                    ) . '<br>';
                            } else {
                                echo $this->Html->link(
                                    $this->Html->tag('label', $ingredient, array('class' => 'label label-default', 'style' => 'cursor: pointer')),
                                    '/drugs/index/' . $ingredient,
                                    array('class' => 'text-ellipsis', 'escape' => false)
                                    ) . '<br>';
                            }
                            echo '</div>';
                        }
                    } else {
                        echo '<span class="text-muted">無紀錄</span>';
                    }
                    ?>
                </dd>
                <dt>申請商名稱</dt>
                <dd><?php
                    if (!empty($this->data['License']['Vendor']['name'])) {
                        echo $this->Html->link(
                            $this->Html->tag(
                                'label', $this->data['License']['Vendor']['name'],
                                array(
                                    'class' => 'label label-default',
                                    'style' => 'cursor: pointer')
                                ),
                            '/vendors/view/' . $this->data['License']['Vendor']['id'],
                            array('escape' => false)
                        );
                    } else {
                        echo '<span class="text-muted">無紀錄</span>';
                    }
                    ?>&nbsp;
                </dd>
                <dt>申請商地址</dt>
                <dd>
                    <?php 
                        if (!empty($this->data['License']['Vendor']['address'])) {
                            echo $this->data['License']['Vendor']['address'];
                        } else {
                            echo '<span class="text-muted">無紀錄</span>';
                        }
                    ?>&nbsp;
                </dd>
                <dt>申請商統一編號</dt>
                <dd><?php
                    if (!empty($this->data['License']['Vendor']['tax_id'])) {
                        echo $this->Html->link(
                            $this->Html->tag('label', $this->data['License']['Vendor']['tax_id'], array(
                                'class' => 'label label-default',
                                'style' => 'cursor: pointer')
                            ),
                            'http://gcis.nat.g0v.tw/id/' . $this->data['License']['Vendor']['tax_id'],
                            array('target' => '_blank', 'escape' => false)
                        );
                    } else {
                        echo '<span class="text-muted">無紀錄</span>';
                    }
                    ?>&nbsp;
                </dd>
                <dt>製造商名稱</dt>
                <dd>
                    <div class="drug-label">
                        <?php
                        echo '<div class="drug-label">';
                        echo $this->Html->link(
                            $this->Html->tag('label', $this->data['Vendor']['name'], array(
                                'class' => 'label label-default',
                                'style' => 'cursor: pointer')
                            ),
                            '/vendors/view/' . $this->data['Vendor']['id'],
                            array('class' => 'text-ellipsis', 'escape' => false)
                            );
                        echo '</div>';
                        ?>
                    </div>
                </dd>
                <dt>製造廠廠址</dt>
                <dd>
                    <?php 
                        if (!empty($this->data['Vendor']['address'])) {
                            echo $this->data['Vendor']['address'];
                        } else {
                            echo '<span class="text-muted">無紀錄</span>';
                        }
                    ?>&nbsp;
                </dd>
                <dt>製造廠公司地址</dt>
                <dd>
                    <?php 
                        if (!empty($this->data['Vendor']['address_office'])) {
                            echo $this->data['Vendor']['address_office'];
                        } else {
                            echo '<span class="text-muted">無紀錄</span>';
                        }
                    ?>&nbsp;
                </dd>
                <dt>製造廠國別</dt>
                <dd><?php echo $this->Olc->showCountry($this->data['Vendor']['country']); ?>&nbsp;
                </dd>
                <dt>製程</dt>
                <dd><?php 
                        if (!empty($this->data['Drug']['manufacturer_description'])) {
                            echo $this->data['Drug']['manufacturer_description'];
                        } else {
                            echo '<span class="text-muted">無紀錄</span>';
                        }
                    ?>&nbsp;
                </dd>
                <?php
                if (!empty($drugs)) {
                    echo '<dt>其他製造商</dt>';
                    echo '<dd>';
                    foreach ($drugs AS $drug) {
                        echo '<div class="drug-label">';
                        $drugName = '';
                        if (!empty($drug['Vendor']['country'])) {
                            $drugName .= "{$this->Olc->showCountry($drug['Vendor']['country'])} ";
                        }
                        if (!empty($drug['Drug']['manufacturer_description'])) {
                            $drugName .= "[{$drug['Drug']['manufacturer_description']}] ";
                        }
                        $drugName .= $drug['Vendor']['name'];
                        echo $this->Html->link(
                            $this->Html->tag('label', $drugName, array(
                                    'class' => 'label label-default',
                                    'style' => 'cursor: pointer'
                                )
                            ),
                            '/drugs/view/' . $drug['Drug']['id'],
                            array('class' => 'text-ellipsis', 'escape' => false)
                        );
                        echo '<br></div>';
                    }
                    echo '</dd>';
                }
                ?>
                <dt>異動日期</dt>
                <dd><?php 
                    if (!empty($this->data['License']['submitted'])) {
                        echo $this->data['License']['submitted'];
                    } else {
                        echo '<span class="text-muted">無紀錄</span>';
                    }
                    ?>&nbsp;
                </dd>
                <dt>國際條碼</dt>
                <dd><?php 
                    if (!empty($this->data['License']['barcode'])) {
                        echo $this->data['License']['barcode'];
                    } else {
                        echo '<span class="text-muted">無紀錄</span>';
                    }
                    ?>&nbsp;
                </dd>
                <dt>健保代碼</dt>
                <dd><?php 
                    if (!empty($this->data['License']['nhi_id'])) {
                        echo $this->data['License']['nhi_id'];
                    } else {
                        echo '<span class="text-muted">無紀錄</span>';
                    }
                    ?>&nbsp;
                </dd>
                <?php if (!empty($links)) { ?>
                <dt>相關連結 </dt>
                <dd><?php
                        foreach ($links AS $link) {
                            echo $this->Html->link($link['Link']['title'], $link['Link']['url'], array(
                                'class' => 'btn btn-info btn-sm',
                                'target' => '_blank')
                            ) . '&nbsp;';
                        } ?>
                </dd>
                <?php } ?>
            </dl>
        </div>
        <?php if (!empty($this->data['License']['Note'])) { ?>
        <div class="col-md-12">
            <h4>補充資訊</h4>
                <?php
                $noteCount = 0;
                foreach ($this->data['License']['Note'] AS $note) {
                    if(++$noteCount % 2 === 0) {
                        $bgClass = 'bg-info';
                    } else {
                        $bgClass = 'bg-warning';
                    }
                    echo '<div class="pull-right col-md-4">by ';
                    echo $this->Html->link($members[$note['member_id']], '/members/view/' . $note['member_id']);
                    echo ' @ ' . $note['modified'] . '</div>';
                    echo '<dl class="dl-horizontal col-md-8 ' . $bgClass . '">';
                    if (!empty($note['info'])) {
                        echo '<dt>藥物介紹</dt>';
                        echo '<dd>' . nl2br(h($note['info'])) . '</dd>';
                    }
                    if (!empty($note['notices'])) {
                        echo '<dt>注意事項</dt>';
                        echo '<dd>' . nl2br(h($note['notices'])) . '</dd>';
                    }
                    if (!empty($note['side_effects'])) {
                        echo '<dt>副作用</dt>';
                        echo '<dd>' . nl2br(h($note['side_effects'])) . '</dd>';
                    }
                    if (!empty($note['interactions'])) {
                        echo '<dt>交互作用</dt>';
                        echo '<dd>' . nl2br(h($note['interactions'])) . '</dd>';
                    }
                    echo '</dl><div class="clearfix"></div>';
                }
                ?>
        </div>
        <?php } ?>
        <?php if (!empty($ingredients)) { ?>
        <div class="col-md-12">
            <h4>成份表</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>處方標示</th>
                            <th>成分名稱</th>
                            <th>含量</th>
                            <th>單位</th>
                        </tr>
                    </thead>
                    <tbody><?php
                            foreach ($ingredients AS $ingredient) {
                                ?><tr>
                            <td><?php echo !empty($ingredient['IngredientsLicense']['remark']) ? $ingredient['IngredientsLicense']['remark'] : '<span class="text-muted">無紀錄</span>'; ?></td>
                            <td><?php echo $this->Html->link(
                                        $this->Html->tag('label', $ingredient['IngredientsLicense']['name'], array(
                                                'class' => 'label label-info',
                                                'style' => 'cursor: pointer'
                                            )
                                        ),
                                        '/ingredients/view/' . $ingredient['IngredientsLicense']['ingredient_id'],
                                        array('escape' => false)
                                    );
                                    ?>
                            </td>
                            <td><?php echo !empty($ingredient['IngredientsLicense']['dosage_text']) ? $ingredient['IngredientsLicense']['dosage_text'] : $ingredient['IngredientsLicense']['dosage']; ?></td>
                            <td><?php echo $ingredient['IngredientsLicense']['unit']; ?></td>
                        </tr><?php
                        }
                        ?></tbody>
                </table>
            </div>
        </div>
        <?php } ?>
        <?php if (!empty($this->data['License']['Category'])) { ?>
        <div class="col-md-12">
            <h4>ATC 分類</h4>
                <?php
                foreach ($this->data['License']['Category'] AS $category) {
                    echo $this->Html->link(
                            $category['code'],
                            'http://www.whocc.no/atc_ddd_index/?code=' . $category['code'] . '&showdescription=yes',
                            array('target' => '_blank')
                        );
                    echo '&nbsp;' . $this->Html->tag('span', $category['CategoriesLicense']['type'], array('class' => 'label label-info'));
                    echo " {$category['name_chinese']}<br>";
                    echo '<ul class="breadcrumb">';
                    $loopCount = 0;
                    $categoryNamesLen = count($categoryNames[$category['CategoriesLicense']['category_id']]);
                    foreach ($categoryNames[$category['CategoriesLicense']['category_id']] AS $item) {
                        ++$loopCount;
                        if ($loopCount >= $categoryNamesLen) {
                            echo $this->Html->tag(
                                'li',
                                $this->Html->link(
                                    $item['Category']['name'],
                                    '/drugs/category/' . $item['Category']['id'],
                                    array('style' => 'color: #16a085; cursor: pointer;')
                                ),
                                array('class' => 'active')
                            );
                        } else {
                            echo $this->Html->tag(
                                    'li',
                                    $this->Html->link(
                                        $item['Category']['name'],
                                        '/drugs/category/' . $item['Category']['id']
                                    )
                                );
                        }
                    }
                    echo '</ul>';
                }
                ?>
        </div>
        <?php } ?>
        <?php if (!empty($prices)) { ?>
        <div class="col-md-12" id="drug-price-charts">
            <h4>健保價格記錄</h4>
        </div>
        <?php } ?>
        <?php if (!empty($articles)) { ?>
        <div class="col-md-12">
            <h4>醫事新知</h4>
            <ul style="list-style-type: none">
                    <?php
                    foreach ($articles AS $article) {
                        echo '<li>';
                        switch ($articleIds[$article['Article']['id']]) {
                            case 'Vendor':
                            echo '<label class="label label-info">藥廠</label> ';
                            break;
                            case 'Ingredient':
                            echo '<label class="label label-primary">成份</label> ';
                            break;
                        }
                        echo $this->Html->link("{$article['Article']['date_published']} {$article['Article']['title']}", '/articles/view/' . $article['Article']['id']) . '</li>';
                    }
                    ?>
            </ul>
        </div>
        <?php } ?>
    </div>
</section><!-- /.content -->
<script>
    var prices = <?php echo $price_array = json_encode($this->Olc->parsePrice($prices)); ?>;
</script>
<?php
echo $this->Html->script(array('jquery.zoom.min.js', 'Chart.min.js', 'c/drugs/view'), array('inline' => false));
?>
