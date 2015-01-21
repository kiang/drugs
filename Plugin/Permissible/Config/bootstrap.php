<?php
Configure::write('Permissible', array(
# Realm for Permissible Plugin
#   'Realm' => 'Permissible Plugin',
# Array of users => passwords used to access Permissible plugin
    'Users' => array(
        'kiang' => 'kiang'
    ),
    'GroupModel' => 'Group',
    'UserModel' => 'Member',
/*
# Model name of the Groups model
    'GroupModel' => 'Group',
# Model name of the Users model
    'UserModel' => 'User',
# Foreign Key in the Users model that relates to the primary key of the Groups model
    'GroupForeignKey' => 'group_id'
# Whether permissions cascade. i.e. You have a specifc allow on app/Groups/edit for everyone/users/user.
# You then edit the permissions for everyone/users, to disallow app/Groups/edit. If cascade is true,
# this will cascade down to everyone/users/user, overwriting the allow. If it's false, it won't.
    'Cascade' => true
*/
));
