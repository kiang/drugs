<?php
require_once App::pluginPath('Permissible') . 'config/init.php';
App::import('Component', 'Auth');
/**
 * Permissible Plugin PAuth Component class
 *
 * Sets up Auth in such a way to use the PAuth system
 *
 * @package permissible
 * @subpackage permissible.controllers.components
 */
class PAuthComponent extends AuthComponent
{
/**
 * Tracking variable to optimise knowing if the user is logged in or not
 *
 * @var boolean
 * @access protected
 */
    public $_unlogged = false;
/**
 * Over-ride of startup function. Adds 'User' with id of 0 if not logged in for use in ACL
 *
 * @return null
 * @access public
 */
    public function startup (&$controller)
    {
        $user = ClassRegistry::init(Configure::read('Permissible.UserModel'));
        $this->actionPath = 'app/';
        $this->authorize = 'actions';
        if ($this->user($user->primaryKey) === null) {
            $this->_unlogged = true;
            $this->Session->write($this->sessionKey, array(
                $user->primaryKey => 0
            ));
        }
        parent::startup($controller);
        if ($this->_unlogged) {
            $this->Session->delete($this->sessionKey);
        }
    }
/**
 * 'Logout' a non-logged in user if the startup function redirects too soon
 *
 * @return null
 * @access public
 */
    public function __destruct()
    {
        if ($this->_unlogged) {
            $this->Session->delete($this->sessionKey);
        }
    }
}
