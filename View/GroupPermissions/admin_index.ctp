<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php
        $this->Html->addCrumb(__('Group Permissions', true));
        if (empty($parent['GroupPermission']['id'])) {
            $this->Html->addCrumb(__('Categories', true));
        } else {
            $this->Html->addCrumb(__('Categories', true), '/admin/group_permissions/');
            $this->Html->addCrumb($parent['GroupPermission']['name']);
        }
        echo $this->Html->getCrumbs();
        $url = array($parent['GroupPermission']['id']);
        ?></h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                </div>
                <div class="box-body">
                    <div class="groupPermissions index" id="groupPermissionsIndex">
                        <div class="btn-group">
                            <?php
                            echo $this->Html->link(__('New Group Permission', true), array(
                                'action' => 'add'), array('class' => 'btn groupPermissionsIndexControl'));
                            ?>
                            <?php echo $this->Html->link(__('Members', true), array('controller' => 'members'), array('class' => 'btn')); ?>
                            <?php echo $this->Html->link(__('Groups', true), array('controller' => 'groups'), array('class' => 'btn')); ?>
                        </div>
                        <div class="paging"><?php echo $this->element('paginator', array('url' => $url)); ?></div>
                        <table class="table table-bordered">
                            <tr>
                                <th><?php echo $this->Paginator->sort('id', 'id', array('url' => $url)); ?></th>
                                <th><?php echo $this->Paginator->sort('order', 'order', array('url' => $url)); ?></th>
                                <th><?php echo $this->Paginator->sort('name', 'name', array('url' => $url)); ?></th>
                                <th><?php echo $this->Paginator->sort('description', 'description', array('url' => $url)); ?></th>
                                <th><?php echo $this->Paginator->sort('acos', 'acos', array('url' => $url)); ?></th>
                                <th class="actions"><?php __('Actions'); ?></th>
                            </tr>
                            <?php
                            $i = 0;
                            foreach ($groupPermissions as $groupPermission) {
                                $class = null;
                                if ($i++ % 2 == 0) {
                                    $class = ' class="altrow"';
                                }
                                ?>
                                <tr<?php echo $class; ?>>
                                    <td><?php echo $groupPermission['GroupPermission']['id']; ?>&nbsp;</td>
                                    <td><?php echo $groupPermission['GroupPermission']['order']; ?>&nbsp;</td>
                                    <td><?php echo $groupPermission['GroupPermission']['name']; ?>&nbsp;</td>
                                    <td><?php echo $groupPermission['GroupPermission']['description']; ?>&nbsp;</td>
                                    <td><?php echo nl2br($groupPermission['GroupPermission']['acos']); ?>&nbsp;</td>
                                    <td class="actions">
                                        <?php
                                        if (empty($parent['GroupPermission']['id'])) {
                                            echo $this->Html->link(__('Items', true), array(
                                                'action' => 'index', $groupPermission['GroupPermission']['id']
                                            ));
                                        }
                                        ?>
                                        <?php
                                        echo $this->Html->link(__('Edit', true), array(
                                            'action' => 'edit', $groupPermission['GroupPermission']['id']
                                                ), array('class' => 'groupPermissionsIndexControl'));
                                        ?>
                                        <?php
                                        echo $this->Html->link(__('Delete', true), array(
                                            'action' => 'delete', $groupPermission['GroupPermission']['id']
                                                ), null, __('Are you sure you want to delete?', true));
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                        <div class="paging"><?php echo $this->element('paginator'); ?></div>


                        <?php
                        $scripts = '
$(function() {
    $(\'#groupPermissionsIndex th a, #groupPermissionsIndex div.paging a\').click(function() {
        $(\'#groupPermissionsIndex\').parent().load(this.href);
        return false;
    });
    $(\'a.groupPermissionsIndexControl\').click(function() {
        dialogFull(this);
        return false;
    });
});';
                        echo $this->Html->scriptBlock($scripts);
                        ?>

                    </div>

                </div>
                <div class="box-footer clearfix">
                </div>
            </div>
        </div>
    </div>
</section><!-- /.content -->