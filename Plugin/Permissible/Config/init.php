<?php
require App::pluginPath('Permissible') . 'Config/bootstrap.php';
# Ensure Permissible array exists
if (Configure::read('Permissible') === null) {
    Configure::write('Permissible', array());
}
# Merge defaults
Configure::write('Permissible', array_merge(array(
    'Realm' => 'Permissible Plugin',
    'Users' => array(
    ),
    'GroupModel' => 'Group',
    'UserModel' => 'User',
    'Cascade' => true
), Configure::read('Permissible')));
# Set up the Group model/alias
if (strpos(Configure::read('Permissible.GroupModel'), '.') === false) {
    Configure::write('Permissible.GroupModelAlias', Configure::read('Permissible.GroupModel'));
} else {
    $alias = explode('.', Configure::read('Permissible.GroupModel'));
    Configure::write('Permissible.GroupModelAlias', array_pop($alias));
}
# Set up the User model/alias
if (strpos(Configure::read('Permissible.UserModel'), '.') === false) {
    Configure::write('Permissible.UserModelAlias', Configure::read('Permissible.UserModel'));
} else {
    $alias = explode('.', Configure::read('Permissible.UserModel'));
    Configure::write('Permissible.UserModelAlias', array_pop($alias));
}
# Set the Group foreign key
if (Configure::read('Permissible.GroupForeignKey') === null) {
    Configure::write('Permissible.GroupForeignKey', strtolower(Configure::read('Permissible.GroupModelAlias')) . '_id');
}
