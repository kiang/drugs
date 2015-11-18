<!-- Content Header (Page header) -->
<h4><?php printf("<?php echo __('%s %s'); ?>", Inflector::humanize($action), $singularHumanName); ?></h4>
<ol class="breadcrumb">
    <?php
    echo "<li><?php echo \$this->Html->link(__('List " . $singularHumanName . "'), array('action' => 'index')); ?> </li>\n";
    ?>
    <li class="active"><?php printf("<?php echo __('%s %s'); ?>", Inflector::humanize($action), $singularHumanName); ?></li>
</ol>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                </div>
                <div class="box-body">
                    <div class="<?php echo $pluralVar; ?> form">
                        <?php echo "<?php echo \$this->Form->create('{$modelClass}'); ?>\n"; ?>
                        <?php
                        echo "<?php\n";
                        foreach ($fields as $field) {
                            if (strpos($action, 'add') !== false && $field === $primaryKey) {
                                continue;
                            } elseif (!in_array($field, array('created', 'modified', 'updated'))) {
                                echo "echo \$this->Form->input('{$field}');\n";
                            }
                        }
                        if (!empty($associations['hasAndBelongsToMany'])) {
                            foreach ($associations['hasAndBelongsToMany'] as $assocName => $assocData) {
                                echo "echo \$this->Form->input('{$assocName}');\n";
                            }
                        }
                        echo "?>\n";
                        ?>
                        <?php
                        echo "<?php echo \$this->Form->end(__('Submit')); ?>\n";
                        ?>
                    </div>
                    <div class="actions">
                        <h3><?php echo "<?php echo __('Actions'); ?>"; ?></h3>
                        <ul>

                            <?php if (strpos($action, 'add') === false): ?>
                                <li><?php echo "<?php echo \$this->Form->postLink(__('Delete'), array('action' => 'delete', \$this->Form->value('{$modelClass}.{$primaryKey}')), array(), __('Are you sure you want to delete # %s?', \$this->Form->value('{$modelClass}.{$primaryKey}'))); ?>"; ?></li>
                            <?php endif; ?>
                            <li><?php echo "<?php echo \$this->Html->link(__('List " . $pluralHumanName . "'), array('action' => 'index')); ?>"; ?></li>
                            <?php
                            $done = array();
                            foreach ($associations as $type => $data) {
                                foreach ($data as $alias => $details) {
                                    if ($details['controller'] != $this->name && !in_array($details['controller'], $done)) {
                                        echo "<li><?php echo \$this->Html->link(__('List " . Inflector::humanize($details['controller']) . "'), array('controller' => '{$details['controller']}', 'action' => 'index')); ?> </li>\n";
                                        echo "<li><?php echo \$this->Html->link(__('New " . Inflector::humanize(Inflector::underscore($alias)) . "'), array('controller' => '{$details['controller']}', 'action' => 'add')); ?> </li>\n";
                                        $done[] = $details['controller'];
                                    }
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>