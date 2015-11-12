<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>會員管理</h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                </div>
                <div class="box-body">
                    <div id="MembersAdminIndex">
                        <div class="btn-group">
                            <?php echo $this->Html->link('新增', array('action' => 'add'), array('class' => 'btn dialogControl')); ?>
                            <?php echo $this->Html->link('群組', array('controller' => 'groups'), array('class' => 'btn')); ?>
                            <?php echo $this->Html->link('更新權限', array('action' => 'acos'), array('class' => 'btn')); ?>
                        </div>
                        <?php
                        echo 'Filter: ' . $this->Form->text('Member.filter', array(
                            'id' => 'memberFilter',
                            'value' => $keyword,
                        ));
                        ?>
                        <div class="paging"><?php echo $this->element('paginator'); ?></div>
                        <table class="table table-bordered" id="MembersAdminIndexTable">
                            <tr>
                                <th><?php echo $this->Paginator->sort('username', '帳號'); ?></th>
                                <th><?php echo $this->Paginator->sort('group_id', '群組'); ?></th>
                                <th><?php echo $this->Paginator->sort('nickname', '暱稱'); ?></th>
                                <th><?php echo $this->Paginator->sort('email', '信箱'); ?></th>
                                <th><?php echo $this->Paginator->sort('user_status', '狀態'); ?></th>
                                <th><?php echo $this->Paginator->sort('created', '建立時間'); ?></th>
                                <th><?php echo $this->Paginator->sort('modified', '更新時間'); ?></th>
                                <th class="actions">操作</th>
                            </tr>
                            <?php
                            $i = 0;
                            foreach ($members as $member):
                                $class = null;
                                if ($i++ % 2 == 0) {
                                    $class = ' class="altrow"';
                                }
                                ?>
                                <tr<?php echo $class; ?>>
                                    <td>
                                        <?php echo $member['Member']['username']; ?>
                                    </td>
                                    <td>
                                        <?php echo $member['Group']['name']; ?>
                                    </td>
                                    <td>
                                        <?php echo $member['Member']['nickname']; ?>
                                    </td>
                                    <td>
                                        <?php echo $member['Member']['email']; ?>
                                    </td>
                                    <td>
                                        <?php echo $member['Member']['user_status']; ?>
                                    </td>
                                    <td>
                                        <?php echo $member['Member']['created']; ?>
                                    </td>
                                    <td>
                                        <?php echo $member['Member']['modified']; ?>
                                    </td>
                                    <td class="actions">
                                        <?php echo $this->Html->link('編輯', array('action' => 'edit', $member['Member']['id']), array('class' => 'dialogControl')); ?> 
                                        <?php echo $this->Html->link('刪除', array('action' => 'delete', $member['Member']['id']), null, __('Delete the item, sure?', true)); ?>  
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                        <div class="paging"><?php echo $this->element('paginator'); ?></div>
                        <div id="MembersAdminIndexPanel"></div>
                        <?php
                        $jsUri = $this->Html->url() . '/index';
                        echo $this->Html->scriptBlock('
$(function() {
    $(\'#MembersAdminIndexTable th a, #MembersAdminIndex div.paging a\').click(function() {
        $(\'#MembersAdminIndex\').parent().load(this.href);
        return false;
    });
    $(\'#memberFilter\').autocomplete({
        delay: 1000,
        minLength: 0,
        search: function(event, ui) {
            var targetUri = \'' . $jsUri . '/keyword:\' + $(this).val();
            $(\'#MembersAdminIndex\').parent().load(encodeURI(targetUri));
            return false;
        }
    });
});
');
                        ?>
                    </div>

                </div>
                <div class="box-footer clearfix">
                </div>
            </div>
        </div>
    </div>
</section><!-- /.content -->