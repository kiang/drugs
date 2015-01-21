<?php
/**
 * Permissible Plugin App Model class
 *
 * Provides the basics for the Permissible Plugin
 *
 * @package permissible
 * @subpackage permissible
 */
class PermissibleAppModel extends AppModel
{
/**
 * Common function to wipe all data from the current tables model
 *
 * @return boolean Success
 * @access public
 */
    public function truncate()
    {
        $db = ConnectionManager::getDataSource($this->useDbConfig);
        $tablename = $db->fullTableName($this);
        if (!empty($tablename)) {
            $db->query('SET FOREIGN_KEY_CHECKS=0;');
            $result = $db->query('TRUNCATE TABLE ' . $tablename . ';');
            $db->query('SET FOREIGN_KEY_CHECKS=1;');

            return $result;
        } else {
            return false;
        }
    }

}
