<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>新增會員</h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                </div>
                <div class="box-body">
                    <div class="members form">
                        <?php echo $this->Form->create('Member'); ?>
                        <fieldset>
                            <?php
                            echo $this->Form->input('group_id', array(
                                'type' => 'select',
                                'div' => 'form-group',
                                'label' => '群組',
                                'class' => 'form-control',
                            ));
                            echo $this->Form->input('username', array(
                                'type' => 'text',
                                'div' => 'form-group',
                                'label' => '帳號',
                                'class' => 'form-control',
                            ));
                            echo $this->Form->input('password', array(
                                'type' => 'password',
                                'div' => 'form-group',
                                'label' => '密碼',
                                'class' => 'form-control',
                            ));
                            echo $this->Form->input('user_status', array(
                                'type' => 'radio',
                                'legend' => '狀態',
                                'div' => 'form-group',
                                'before' => '<div class="radio">',
                                'after' => '</div>',
                                'separator' => ' &nbsp; &nbsp; ',
                                'options' => array('Y' => 'Y', 'N' => 'N'),
                                'value' => 'Y'));
                            echo $this->Form->input('Member.nickname', array(
                                'type' => 'text',
                                'div' => 'form-group',
                                'class' => 'form-control',
                                'label' => '暱稱 (如果沒有輸入就會以個人帳號展示)',
                            ));
                            echo $this->Form->input('Member.email', array(
                                'type' => 'text',
                                'div' => 'form-group',
                                'class' => 'form-control',
                                'label' => '信箱 (這個信箱只用來聯繫，不對外展示)',
                            ));
                            echo $this->Form->input('Member.ext_image', array(
                                'type' => 'text',
                                'div' => 'form-group',
                                'class' => 'form-control',
                                'label' => '圖片網址 (這可以輸入您自有網站上的圖片網址，藉此在個人頁面展示)',
                            ));
                            echo $this->Form->input('Member.ext_url', array(
                                'type' => 'text',
                                'div' => 'form-group',
                                'class' => 'form-control',
                                'label' => '圖片連結外部網址 (如果上述圖片網址存在，這裡會進一步設定點選圖片後連結的網址，一般是您自有網站)',
                            ));
                            echo $this->Form->input('Member.intro', array(
                                'type' => 'textarea',
                                'div' => 'form-group',
                                'class' => 'form-control',
                                'label' => h('個人介紹 (可以用文字方式做些介紹，允許使用 <a><p><ul><ol><li><img> 等 HTML 標籤)'),
                            ));
                            ?>
                        </fieldset>
                        <?php echo $this->Form->end(__('Submit', true)); ?>
                    </div>

                </div>
                <div class="box-footer clearfix">
                </div>
            </div>
        </div>
    </div>
</section><!-- /.content -->
