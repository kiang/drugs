<?php
require_once App::pluginPath('Permissible') . 'Config/init.php';
/**
 * Permissible Plugin App Controller class
 *
 * Provides the basics for the Permissible Plugin
 *
 * @package permissible
 * @subpackage permissible
 */
class PermissibleAppController extends AppController
{
/**
 * Array containing the names of components this plugin uses.
 *
 * @var array
 * @access public
 */
    public $components = array(
        'Security',
        'Acl',
        'Session'
    );
/**
 * Array containing the names of helpers this plugin uses.
 *
 * @var array
 * @access public
 */
    public $helpers = array(
        'Javascript',
        'Js'
    );
/**
 * Common beforeFilter for plugin. Allow all controllers/actions
 * to PAuth and set up basic authentication
 *
 * @return null
 * @access public
 */
    public function beforeFilter()
    {
        parent::beforeFilter();
    }
}
