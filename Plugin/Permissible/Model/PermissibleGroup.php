<?php
/**
 * Permissible Plugin PermissibleGroup Model class
 *
 * Adds functions/variables required for ACL to work.
 *
 * @package permissible
 * @subpackage permissible.models
 */
class PermissibleGroup extends AppModel
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
 * Returns the parent node of a group - everyone
 *
 * @return string 'everyone'
 * @access public
 */
    public function parentNode()
    {
        return 'everyone';
    }
}
