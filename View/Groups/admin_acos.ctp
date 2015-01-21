<div id="GroupsAdminAcos">
    <h2><?php echo __('Permission Settings', true); ?></h2>
    <p>
        <?php
        $urlArray = array('url' => array($groupId));
        ?>
    </p>
    <table cellpadding="0" cellspacing="0" id="GroupsAdminAcosTable">
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
                        echo '<input type="checkbox" name="ctrl' . $aco['Aco']['alias'] . '" class="acoController">';
                        echo '<hr /><div id="sub' . $aco['Aco']['alias'] . '">';
                        foreach ($aco['Aco']['Aco'] AS $actionAco) {
                            echo '<div class="col-md-5"><input type="checkbox" name="' . $aco['Aco']['alias'] . '___' . $actionAco['alias'] . '"';
                            if ($actionAco['permitted'] == 1) {
                                echo ' checked="checked"';
                            }
                            echo ' class="acoPermitted">';
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
    echo $this->Html->scriptBlock('
$(function() {
	$(\'input.acoPermitted\').click(function() {
		if($(\'#p\' + this.name).size() > 0) {
			$(\'#p\' + this.name).remove();
		} else {
			var itemValue = \'+\';
			if(!this.checked) {
				itemValue = \'-\';
			}
			$(\'#permissionStack\').append(\'<li id="p\' + this.name + \'">\' +
			itemValue + this.name.replace(\'___\', \'/\') +
			\'<input type="hidden" name="\' + this.name + \'" value="\' + itemValue + \'">\'+
			\'</li>\');
		}
	});
	$(\'.acoController\').click(function() {
		var controllerChecked = this.checked;
		$(\'div#\' + this.name.replace(\'ctrl\', \'sub\') + \' input.acoPermitted\').each(function() {
			if(this.checked != controllerChecked) {
				this.click();
			}
		});
	});
});
');
    ?>
    <div class="actions">
        <ul>
            <li><?php echo $this->Html->link(__('List', true), array('action' => 'index')); ?></li>
        </ul>
    </div>
</div>
