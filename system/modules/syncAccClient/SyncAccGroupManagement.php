<?php

/**
 * Contao Open Source CMS
 * 
 * PHP version 5
 * @copyright  MEN AT WORK 2013
 * @package    syncAccClient
 * @license    GNU/LGPL
 * @filesource
 */
class SyncAccGroupManagement extends \Backend
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get a list with all user groups
     * 
     * @return array
     */
    public function getUserGroups()
    {
        return $this->Database
                        ->prepare("SELECT * FROM `tl_user_group`")
                        ->execute()
                        ->fetchAllAssoc();
    }

    /**
     * Get a list with all member groups
     * 
     * @return array
     */
    public function getMemberGroups()
    {
        return $this->Database
                        ->prepare("SELECT * FROM `tl_member_group`")
                        ->execute()
                        ->fetchAllAssoc();
    }

}

?>