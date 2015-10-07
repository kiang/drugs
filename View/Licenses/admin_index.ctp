<?php
if (!isset($url)) {
    $url = array();
}
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php echo __('Licenses'); ?></h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                </div>
                <div class="box-body">
                    <div class="licenses index">
                        <div class="paging"><?php echo $this->element('paginator'); ?></div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>品名</th>
                                    <th>許可證字號</th>
                                    <th>製造商</th>
                                    <th>國別</th>
                                    <th><?php echo $this->Paginator->sort('License.expired_date', '有效日期', array('url' => $url)); ?></th>
                                    <th class="actions"><?php echo __('Actions'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($licenses as $license):
                                    $name = $license['License']['name'];
                                    if (!empty($license['License']['name_english'])) {
                                        $name .= "({$license['License']['name_english']})";
                                    }
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $this->Html->link($name, array('action' => 'view', $license['License']['id'])); ?></td>
                                        <td><?php
                                            echo $license['License']['license_id'];
                                            ?></td>
                                        <td><?php
                                            echo $license['Vendor']['name'];
                                            ?></td>
                                        <td><?php
                                            echo $this->Olc->showCountry($license['Vendor']['country']);
                                            ?></td>
                                        <td><?php
                                            echo $license['License']['expired_date'];
                                            ?></td>
                                        <td class="actions">
                                            <?php echo $this->Html->link(__('View'), array('action' => 'view', $license['License']['id'])); ?>
                                            <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $license['License']['id'])); ?>
                                        </td>
                                    </tr>
<?php endforeach; ?>
                            </tbody>
                        </table>
                        <p>
                            <?php
                            echo $this->Paginator->counter(array(
                                'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                            ));
                            ?>                        </p>
                        <div class="paging"><?php echo $this->element('paginator'); ?></div>
                    </div>
                    <div class="actions">
                        <h3><?php echo __('Actions'); ?></h3>
                        <ul>
                            <li><?php echo $this->Html->link(__('New License'), array('action' => 'add')); ?></li>
                            <li><?php echo $this->Html->link(__('List Vendors'), array('controller' => 'vendors', 'action' => 'index')); ?> </li>
                            <li><?php echo $this->Html->link(__('New Vendor'), array('controller' => 'vendors', 'action' => 'add')); ?> </li>
                            <li><?php echo $this->Html->link(__('List Drugs'), array('controller' => 'drugs', 'action' => 'index')); ?> </li>
                            <li><?php echo $this->Html->link(__('New Drug'), array('controller' => 'drugs', 'action' => 'add')); ?> </li>
                            <li><?php echo $this->Html->link(__('List Prices'), array('controller' => 'prices', 'action' => 'index')); ?> </li>
                            <li><?php echo $this->Html->link(__('New Price'), array('controller' => 'prices', 'action' => 'add')); ?> </li>
                            <li><?php echo $this->Html->link(__('List Links'), array('controller' => 'links', 'action' => 'index')); ?> </li>
                            <li><?php echo $this->Html->link(__('New Link'), array('controller' => 'links', 'action' => 'add')); ?> </li>
                            <li><?php echo $this->Html->link(__('List Ingredients Licenses'), array('controller' => 'ingredients_licenses', 'action' => 'index')); ?> </li>
                            <li><?php echo $this->Html->link(__('New Ingredients License'), array('controller' => 'ingredients_licenses', 'action' => 'add')); ?> </li>
                            <li><?php echo $this->Html->link(__('List Attachments'), array('controller' => 'attachments', 'action' => 'index')); ?> </li>
                            <li><?php echo $this->Html->link(__('New Attachment'), array('controller' => 'attachments', 'action' => 'add')); ?> </li>
                            <li><?php echo $this->Html->link(__('List Categories'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
                            <li><?php echo $this->Html->link(__('New Category'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
                            <li><?php echo $this->Html->link(__('List Ingredients'), array('controller' => 'ingredients', 'action' => 'index')); ?> </li>
                            <li><?php echo $this->Html->link(__('New Ingredient'), array('controller' => 'ingredients', 'action' => 'add')); ?> </li>
                            <li><?php echo $this->Html->link(__('List Articles'), array('controller' => 'articles', 'action' => 'index')); ?> </li>
                            <li><?php echo $this->Html->link(__('New Article'), array('controller' => 'articles', 'action' => 'add')); ?> </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>