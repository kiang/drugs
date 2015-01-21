<?php

echo $this->Form->create('Member', array('action' => 'login'));
echo $this->Form->input('username');
echo $this->Form->input('password');
echo $this->Form->end(__('Login', true));
