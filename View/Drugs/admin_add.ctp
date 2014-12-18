<div id="DrugsAdminAdd">
        <?php echo $this->Form->create('Drug', array('type' => 'file')); ?>
    <div class="Drugs form">
        <fieldset>
            <legend><?php
                echo __('Add Drugs', true);
                ?></legend>
            <?php
            echo $this->Form->input('Drug.active_id', array(
                'label' => 'Active ID',
                'div' => 'form-group',
                'class' => 'form-control',
            ));
            echo $this->Form->input('Drug.name', array(
                'label' => 'Name',
                'div' => 'form-group',
                'class' => 'form-control',
            ));
            echo $this->Form->input('Drug.type', array(
                'label' => 'Type',
                'div' => 'form-group',
                'class' => 'form-control',
            ));
            echo $this->Form->input('Drug.representative', array(
                'label' => 'Representative',
                'div' => 'form-group',
                'class' => 'form-control',
            ));
            echo $this->Form->input('Drug.founded', array(
                'label' => 'Founded',
                'div' => 'form-group',
                'class' => 'form-control',
            ));
            echo $this->Form->input('Drug.address', array(
                'label' => 'Address',
                'div' => 'form-group',
                'class' => 'form-control',
            ));
            echo $this->Form->input('Drug.purpose', array(
                'rows' => '4',
                'cols' => '20',
                'label' => 'Purpose',
                'div' => 'form-group',
                'class' => 'form-control',
            ));
            echo $this->Form->input('Drug.donation', array(
                'label' => 'Donation',
                'div' => 'form-group',
                'class' => 'form-control',
            ));
            echo $this->Form->input('Drug.approved_by', array(
                'label' => 'Approved By',
                'div' => 'form-group',
                'class' => 'form-control',
            ));
            echo $this->Form->input('Drug.fund', array(
                'label' => 'Fund',
                'div' => 'form-group',
                'class' => 'form-control',
            ));
            echo $this->Form->input('Drug.closed', array(
                'label' => 'Closed',
                'div' => 'form-group',
                'class' => 'form-control',
            ));
            ?>
        </fieldset>
    </div>
        <?php
    echo $this->Form->end(__('Submit', true));
    ?>
</div>