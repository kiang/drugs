<div class="members view">
    <h2><?php __('Member'); ?></h2>
    <dl><?php $i = 0;
$class = ' class="altrow"';
?>
        <dt<?php if ($i % 2 == 0)
            echo $class;
?>><?php __('Id'); ?></dt>
        <dd<?php if ($i++ % 2 == 0)
                echo $class;
?>>
            <?php echo $member['Member']['id']; ?>
            &nbsp;
        </dd>
        <dt<?php if ($i % 2 == 0)
                echo $class;
            ?>><?php __('Username'); ?></dt>
        <dd<?php if ($i++ % 2 == 0)
                    echo $class;
            ?>>
            <?php echo $member['Member']['username']; ?>
            &nbsp;
        </dd>
        <dt<?php if ($i % 2 == 0)
                echo $class;
            ?>><?php __('Password'); ?></dt>
        <dd<?php if ($i++ % 2 == 0)
                echo $class;
            ?>>
                <?php echo $member['Member']['password']; ?>
            &nbsp;
        </dd>
        <dt<?php if ($i % 2 == 0)
                    echo $class;
                ?>><?php __('User Status'); ?></dt>
        <dd<?php if ($i++ % 2 == 0)
                echo $class;
                ?>>
<?php echo $member['Member']['user_status']; ?>
            &nbsp;
        </dd>
        <dt<?php if ($i % 2 == 0)
    echo $class;
?>><?php __('Created'); ?></dt>
        <dd<?php if ($i++ % 2 == 0)
                    echo $class;
?>>
<?php echo $member['Member']['created']; ?>
            &nbsp;
        </dd>
        <dt<?php if ($i % 2 == 0)
    echo $class;
?>><?php __('Modified'); ?></dt>
        <dd<?php if ($i++ % 2 == 0)
    echo $class;
?>>
<?php echo $member['Member']['modified']; ?>
            &nbsp;
        </dd>
    </dl>
</div>
<div class="actions">
    <ul>
        <li><?php echo $this->Html->link(__('Edit Member', true), array('action' => 'edit', $member['Member']['id'])); ?> </li>
        <li><?php echo $this->Html->link(__('Delete Member', true), array('action' => 'delete', $member['Member']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $member['Member']['id'])); ?> </li>
        <li><?php echo $this->Html->link(__('List Members', true), array('action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__('New Member', true), array('action' => 'add')); ?> </li>
    </ul>
</div>
