<?php

namespace SyncAccClientBundle\Management;

use Contao\Database;

class Group
{

    /**
     * Get a list with all user groups
     *
     * @return array
     */
    public function getUserGroups()
    {
        return Database::getInstance()
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
        return Database::getInstance()
            ->prepare("SELECT * FROM `tl_member_group`")
            ->execute()
            ->fetchAllAssoc();
    }
}
