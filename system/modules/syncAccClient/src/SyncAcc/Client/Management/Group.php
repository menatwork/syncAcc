<?php

/**
 * Contao Open Source CMS
 *
 * PHP version 5
 *
 * @copyright  MEN AT WORK 2013
 * @package    syncAccClient
 * @license    GNU/LGPL
 * @filesource
 */

namespace SyncAcc\Client\Management;

class Group
{

    /**
     * Get a list with all user groups
     *
     * @return array
     */
    public function getUserGroups()
    {
        return \Database::getInstance()
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
        return \Database::getInstance()
            ->prepare("SELECT * FROM `tl_member_group`")
            ->execute()
            ->fetchAllAssoc();
    }
}
