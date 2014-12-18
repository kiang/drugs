<div id="DrugsAdminView">
    <h3><?php echo __('View Drugs', true); ?></h3><hr />
    <div class="col-md-12">

        <div class="col-md-2">Active ID</div>
        <div class="col-md-9">&nbsp;<?php
            if ($this->data['Drug']['active_id']) {

                echo $this->data['Drug']['active_id'];
            }
?>&nbsp;
        </div>
        <div class="col-md-2">Name</div>
        <div class="col-md-9">&nbsp;<?php
            if ($this->data['Drug']['name']) {

                echo $this->data['Drug']['name'];
            }
?>&nbsp;
        </div>
        <div class="col-md-2">Type</div>
        <div class="col-md-9">&nbsp;<?php
            if ($this->data['Drug']['type']) {

                echo $this->data['Drug']['type'];
            }
?>&nbsp;
        </div>
        <div class="col-md-2">Representative</div>
        <div class="col-md-9">&nbsp;<?php
            if ($this->data['Drug']['representative']) {

                echo $this->data['Drug']['representative'];
            }
?>&nbsp;
        </div>
        <div class="col-md-2">Founded</div>
        <div class="col-md-9">&nbsp;<?php
            if ($this->data['Drug']['founded']) {

                echo $this->data['Drug']['founded'];
            }
?>&nbsp;
        </div>
        <div class="col-md-2">Address</div>
        <div class="col-md-9">&nbsp;<?php
            if ($this->data['Drug']['address']) {

                echo $this->data['Drug']['address'];
            }
?>&nbsp;
        </div>
        <div class="col-md-2">Purpose</div>
        <div class="col-md-9">&nbsp;<?php
            if ($this->data['Drug']['purpose']) {

                echo $this->data['Drug']['purpose'];
            }
?>&nbsp;
        </div>
        <div class="col-md-2">Donation</div>
        <div class="col-md-9">&nbsp;<?php
            if ($this->data['Drug']['donation']) {

                echo $this->data['Drug']['donation'];
            }
?>&nbsp;
        </div>
        <div class="col-md-2">Approved By</div>
        <div class="col-md-9">&nbsp;<?php
            if ($this->data['Drug']['approved_by']) {

                echo $this->data['Drug']['approved_by'];
            }
?>&nbsp;
        </div>
        <div class="col-md-2">Fund</div>
        <div class="col-md-9">&nbsp;<?php
            if ($this->data['Drug']['fund']) {

                echo $this->data['Drug']['fund'];
            }
?>&nbsp;
        </div>
        <div class="col-md-2">Closed</div>
        <div class="col-md-9">&nbsp;<?php
            if ($this->data['Drug']['closed']) {

                echo $this->data['Drug']['closed'];
            }
?>&nbsp;
        </div>
    </div>
    <hr />
    <div class="actions">
        <ul>
            <li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Drug.id')), null, __('Delete the item, sure?', true)); ?></li>
            <li><?php echo $this->Html->link(__('Drugs List', true), array('action' => 'index')); ?> </li>
            <li><?php echo $this->Html->link(__('View Related Directors', true), array('controller' => 'directors', 'action' => 'index', 'Drug', $this->data['Drug']['id']), array('class' => 'DrugsAdminViewControl')); ?></li>
        </ul>
    </div>
    <div id="DrugsAdminViewPanel"></div>
<?php
echo $this->Html->scriptBlock('

');
?>
    <script type="text/javascript">
        //<![CDATA[
        $(function() {
            $('a.DrugsAdminViewControl').click(function() {
                $('#DrugsAdminViewPanel').parent().load(this.href);
                return false;
            });
        });
        //]]>
    </script>
</div>