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
    <li><?php echo $this->Html->link($this->data['License']['name'], array('admin' => false, 'action' => 'view', $this->data['License']['id']));; ?></li>
    <li class="active">編輯</li>
</ol>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                </div>
                <div class="box-body">
                    <div class="licenses form">
                        <?php echo $this->Form->create('License', array('enctype' => 'multipart/form-data')); ?>
                        <h4>圖片</h4>
                        <?php
                        foreach($this->request->data['Image'] AS $image) {
                            $imageUrl = $this->Media->url('s/' . $image['path']);
                            echo '<div class="col-xs-2">';
                            echo $this->Html->link($this->Media->embed('s/' . $image['path']), $this->Media->url($image['path'], true), array('target' => '_blank', 'escape' => false));
                            echo '<br />' . $this->Form->checkbox('ImageDelete.' . $image['id']) . '刪除';
                            echo '</div>';
                        }
                        echo '<div class="clearfix"></div>';
                        echo $this->Form->hidden('Image.0.model', array('value' => 'License'));
                        echo $this->Form->hidden('Image.0.group', array('value' => 'Image'));
                        echo $this->Form->input('Image.0.file', array('type' => 'file', 'label' => false));
                        echo $this->Form->hidden('Image.1.model', array('value' => 'License'));
                        echo $this->Form->hidden('Image.1.group', array('value' => 'Image'));
                        echo $this->Form->input('Image.1.file', array('type' => 'file', 'label' => false));
                        echo $this->Form->hidden('Image.2.model', array('value' => 'License'));
                        echo $this->Form->hidden('Image.2.group', array('value' => 'Image'));
                        echo $this->Form->input('Image.2.file', array('type' => 'file', 'label' => false));
                        ?>
                        <div class="clearfix"></div>
                        * 每次可以上傳三張圖片，目前沒有限制單一藥物可以上傳的圖片數量
                        <hr />
                        <?php
                        echo $this->Form->input('Note.info', array(
                            'div' => 'form-group',
                            'class' => 'form-control',
                            'label' => '藥物介紹',
                            ));
                        echo $this->Form->input('Note.notices', array(
                            'div' => 'form-group',
                            'class' => 'form-control',
                            'label' => '注意事項',
                            ));
                        echo $this->Form->input('Note.side_effects', array(
                            'div' => 'form-group',
                            'class' => 'form-control',
                            'label' => '副作用',
                            ));
                        echo $this->Form->input('Note.interactions', array(
                            'div' => 'form-group',
                            'class' => 'form-control',
                            'label' => '交互作用',
                            ));
                        ?>
                        <?php echo $this->Form->end('送出'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>