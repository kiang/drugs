<?php
require_once App::pluginPath('Permissible') . 'Config/init.php';
/**
 * Permissible Plugin PermissibleUser Model class
 *
 * Adds functions/variables required for ACL to work.
 *
 * @package permissible
 * @subpackage permissible.models
 */
class PermissibleUser extends AppModel
{
/**
 * Array containing the names of behaviours this model uses
 *
 * @var array
 * @access public
 */
    public $actsAs = array('Acl' => array('requester'));
/**
 * Default display field for this model.
 *
 * @var array
 * @access public
 */
    public $displayField = 'id';
/**
 * Returns the parent node of a user - the group id
 *
 * @return array Group array
 * @access public
 */
    public function parentNode()
    {
        if (!$this->id && empty($this->data)) {
            return null;
        }
        $data = $this->data;
        if (empty($this->data)) {
            $data = $this->read();
        }
        if (!$data[Configure::read('Permissible.UserModelAlias')][Configure::read('Permissible.GroupForeignKey')]) {
            return null;
        } else {
            return array(Configure::read('Permissible.GroupModelAlias') => array(
                $this->{Configure::read('Permissible.GroupModelAlias')}->primaryKey => $data[Configure::read('Permissible.UserModelAlias')][Configure::read('Permissible.GroupForeignKey')])
            );
        }
    }
}
