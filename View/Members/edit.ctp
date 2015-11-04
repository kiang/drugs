<p>&nbsp;</p>
<section class="content">
    <?php echo $this->Form->create('Member'); ?>
    <h4>編輯資料</h4>
    <div class="row">
        <?php
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
        echo $this->Form->submit('更新');
        ?>
    </div>
    <h4>修改密碼</h4>
    <div class="row">
        <?php
        echo $this->Form->input('Member.orig_pass', array(
            'type' => 'password',
            'div' => 'form-group',
            'class' => 'form-control',
            'label' => '現有密碼',
            'value' => '',
        ));
        echo $this->Form->input('Member.new_pass', array(
            'type' => 'password',
            'div' => 'form-group',
            'class' => 'form-control',
            'label' => '新密碼',
            'value' => '',
        ));
        echo $this->Form->input('Member.retype_pass', array(
            'type' => 'password',
            'div' => 'form-group',
            'class' => 'form-control',
            'label' => '新密碼（再次輸入）',
            'value' => '',
        ));
        echo $this->Form->submit('更新');
        ?>
    </div>
    <?php echo $this->Form->end(); ?>
</section>