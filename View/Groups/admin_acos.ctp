<?php
echo $this->Html->script('c/groups/admin_acos', array('inline' => false));
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php echo __('Permission Settings', true); ?></h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                </div>
                <div class="box-body">
                    <div id="GroupsAdminAcos">
                        <p>
                            <?php
                            $urlArray = array('url' => array($groupId));
                            ?>
                        </p>
                        <table class="table table-bordered" id="GroupsAdminAcosTable">
                            <?php
                            $i = 0;
                            foreach ($acos as $aco) {
                                $class = null;
                                if ($i++ % 2 == 0) {
                                    $class = ' class="altrow"';
                                }
                                ?>
                                <tr<?php echo $class; ?>>
                                    <td style="text-align:left;"><?php
                                        echo $aco['Aco']['alias'];
                                        if (!empty($aco['Aco']['Aco'])) {
                                            echo '<input type="checkbox" name="ctrl' . $aco['Aco']['alias'] . '" class="acoController simple">';
                                            echo '<hr /><div id="sub' . $aco['Aco']['alias'] . '">';
                                            foreach ($aco['Aco']['Aco'] AS $actionAco) {
                                                echo '<div class="col-md-5"><input type="checkbox" name="' . $aco['Aco']['alias'] . '___' . $actionAco['alias'] . '"';
                                                if ($actionAco['permitted'] == 1) {
                                                    echo ' checked="checked"';
                                                }
                                                echo ' class="acoPermitted simple">';
                                                echo $actionAco['alias'] . '</div>';
                                            }
                                            echo '</div>';
                                        }
                                        ?></td>
                                </tr>
                            <?php } // End of foreach ($acos as $aco) { ?>
                        </table>
                        <?php
                        echo $this->Form->create('Group', array('url' => array('action' => 'acos', $groupId)));
                        echo '<ul id="permissionStack"></ul>';
                        echo $this->Form->end(__('Update', true));
                        ?>
                    </div>
                </div>
                <div class="box-footer clearfix">
                </div>
            </div>
        </div>
    </div>
</section><!-- /.content -->