<?php

echo $this->Form->create('Member', array('action' => 'setup'));
echo $this->Form->input('username');
echo $this->Form->input('password', array('type' => 'password', 'value' => ''));
echo $this->Form->end(__('Create Administrator', true));
