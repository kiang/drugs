<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>編輯藥證</h1>
</section>

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
                        <?php
                        foreach($this->request->data['Image'] AS $image) {
                            $imageUrl = $this->Media->url('s/' . $image['path']);
                            echo '<div class="col-xs-2">';
                            echo $this->Html->link($this->Media->embed('s/' . $image['path']), $this->Media->url($image['path'], true), array('target' => '_blank', 'escape' => false));
                            echo '<br />' . $this->Form->checkbox('ImageDelete.' . $image['id']) . '刪除';
                            echo '</div>';
                        }
                        echo '<div class="clearfix"></div>';
                        echo $this->Form->input('id');
                        echo $this->Form->hidden('Image.0.model', array('value' => 'License'));
                        echo $this->Form->hidden('Image.0.group', array('value' => 'Image'));
                        echo $this->Form->input('Image.0.file', array('type' => 'file'));
                        echo $this->Form->hidden('Image.1.model', array('value' => 'License'));
                        echo $this->Form->hidden('Image.1.group', array('value' => 'Image'));
                        echo $this->Form->input('Image.1.file', array('type' => 'file'));
                        echo $this->Form->hidden('Image.2.model', array('value' => 'License'));
                        echo $this->Form->hidden('Image.2.group', array('value' => 'Image'));
                        echo $this->Form->input('Image.2.file', array('type' => 'file'));
                        ?>
                        <div class="clearfix"></div>
                        <?php echo $this->Form->end(__('Submit')); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>