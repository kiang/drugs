<?php
if (!isset($url)) {
    $url = array();
}
?>
<div id="DrugsAdminIndex">
    <h2><?php echo __('Drugs', true); ?></h2>
    <div class="btn-group">
        <?php echo $this->Html->link(__('Add', true), array('action' => 'add'), array('class' => 'btn dialogControl')); ?>
    </div>
    <div><?php
        echo $this->Paginator->counter(array(
            'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
        ));
        ?></div>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
    <table class="table table-bordered" id="DrugsAdminIndexTable">
        <thead>
            <tr>

                <th><?php echo $this->Paginator->sort('Drug.active_id', 'Active ID', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Drug.name', 'Name', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Drug.type', 'Type', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Drug.representative', 'Representative', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Drug.founded', 'Founded', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Drug.address', 'Address', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Drug.purpose', 'Purpose', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Drug.donation', 'Donation', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Drug.approved_by', 'Approved By', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Drug.fund', 'Fund', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Drug.closed', 'Closed', array('url' => $url)); ?></th>
                <th class="actions"><?php echo __('Action', true); ?></th>
            </tr>
        </thead>
        <tbody>
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
                    echo $item['Drug']['active_id'];
                    ?></td>
                    <td><?php
                    echo $item['Drug']['name'];
                    ?></td>
                    <td><?php
                    echo $item['Drug']['type'];
                    ?></td>
                    <td><?php
                    echo $item['Drug']['representative'];
                    ?></td>
                    <td><?php
                    echo $item['Drug']['founded'];
                    ?></td>
                    <td><?php
                    echo $item['Drug']['address'];
                    ?></td>
                    <td><?php
                    echo $item['Drug']['purpose'];
                    ?></td>
                    <td><?php
                    echo $item['Drug']['donation'];
                    ?></td>
                    <td><?php
                    echo $item['Drug']['approved_by'];
                    ?></td>
                    <td><?php
                    echo $item['Drug']['fund'];
                    ?></td>
                    <td><?php
                    echo $item['Drug']['closed'];
                    ?></td>
                    <td class="actions">
                        <?php echo $this->Html->link(__('View', true), array('action' => 'view', $item['Drug']['id']), array('class' => 'dialogControl')); ?>
                        <?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $item['Drug']['id']), array('class' => 'dialogControl')); ?>
                        <?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $item['Drug']['id']), null, __('Delete the item, sure?', true)); ?>
                    </td>
                </tr>
            <?php } // End of foreach ($items as $item) {  ?>
        </tbody>
    </table>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
    <div id="DrugsAdminIndexPanel"></div>
    <script type="text/javascript">
        //<![CDATA[
        $(function() {
            $('#DrugsAdminIndexTable th a, #DrugsAdminIndex div.paging a').click(function() {
                $('#DrugsAdminIndex').parent().load(this.href);
                return false;
            });
    });
    //]]>
    </script>
</div>