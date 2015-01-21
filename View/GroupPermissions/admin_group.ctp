<div class="groupPermissions index">
    <h2><?php
        __('Permissions of ');
        echo $group['Group']['name'];
        ?></h2>
    <?php echo $this->Form->create('GroupPermission', array('url' => array('action' => 'group', $group['Group']['id']))); ?>
    <table>
        <tr>
            <th><div class="col-md-4">Category</div></th>
        <th>Permissions</th>
        </tr>
        <?php
        $i = 0;
        foreach ($items as $item) {
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            ?>
            <tr<?php echo $class; ?>>
                <td><?php
                    echo $item['category']['name'];
                    echo '<br /><br />' . $item['category']['description'];
                    ?>&nbsp;</td>
                <td><?php
                    if (!empty($item['items'])) {
                        foreach ($item['items'] AS $aco) {
                            echo '<div class="col-md-6"><input type="checkbox" name="data[GroupPermission][' . $aco['id'] . ']" value="1"';
                            if ($aco['acos'] == 1) {
                                echo ' checked="checked"';
                            }
                            echo ' class="acoPermitted">';
                            echo '<a href="#" onclick="dialogMessage(\'' . addslashes($aco['description']) . '\');return false;"><span class="acoName">' . $aco['name'] . '</span></a></div>';
                        }
                    }
                    ?>&nbsp;</td>
            </tr>
        <?php } ?>
    </table>
    <?php echo $this->Form->end(__('Update', true)); ?>
    <div class="actions">
        <ul>
            <li><?php echo $this->Html->link(__('Advanced', true), array(
        'controller' => 'groups', 'action' => 'acos', $group['Group']['id']));
    ?></li>
        </ul>
    </div>
</div>
