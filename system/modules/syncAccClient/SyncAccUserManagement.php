<?php
if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  MEN AT WORK 2011
 * @package    syncAccClient
 * @license    GNU/LGPL
 * @filesource
 */
class SyncAccUserManagement extends Backend
{

    private $arrDefaultUserFields = array();

    /**
     * Initialize the object
     */
    public function __construct()
    {
        parent::__construct();
        $this->arrDefaultUserFields = array(
            'language' => $GLOBALS['TL_LANGUAGE'],
            'showHelp' => 1,
            'thumbnails' => 1,
            'useRTE' => 1,
            'useCE' => 1,
            'inherit' => 'group',
            'alpty' => array('regular', 'redirect', 'forward'),
            'fop' => array('f1', 'f2', 'f3')
        );
    }

    /**
     * Create associative database array from all users and return it
     * 
     * @return array
     */
    public function getUsers()
    {
        $arrUsers = array();

        $objDb = $this->Database->prepare("SELECT * FROM `tl_user`")->execute();
        $arrUsers = $objDb->fetchAllAssoc();

        return $arrUsers;
    }

    /**
     * Set and update the users array
     * 
     * @param array $arrUsers 
     */
    public function setUsers($arrUsers)
    {
        $this->setAccData('user', $arrUsers, $this->arrDefaultUserFields);
    }

    /**
     * Create associative database array from all members and return it
     * 
     * @return array
     */
    public function getMembers()
    {
        $arrUsers = array();

        $objDb = $this->Database->prepare("SELECT * FROM `tl_member`")->execute();
        $arrUsers = $objDb->fetchAllAssoc();

        return $arrUsers;
    }

    /**
     * Set and update the members array
     * 
     * @param type $arrMembers 
     */
    public function setMembers($arrMembers)
    {
        $this->setAccData('member', $arrMembers);
    }

    /**
     * Set and update the given account information into the database and
     * delete all accounts which are not more needed 
     * 
     * @param string $strAccType
     * @param array $arrAccData 
     */
    protected function setAccData($strAccType, $arrAccData, $default = FALSE)
    {   
        $serverID = base64_decode($arrAccData['meta']['sync_acc_master']);
        $arrAccFromOtherMasterSystems = $this->Database
                ->prepare("
                    SELECT * 
                    FROM `tl_user`
                    WHERE sync_acc_master 
                    NOT IN ('',?)")
                ->execute($serverID)
                ->fetchAllAssoc();

        foreach ($arrAccData['data'] AS $arrAcc)
        {
            $arrAcc['sync_acc_master'] = $serverID;
            $arrAcc['syncacc'] = TRUE;

            $arrUpdateQuery = array();
            foreach ($arrAcc AS $field => $value)
            {
                $arrUpdateQuery[] = " $field = '$value' ";
            }

            if ($default)
            {
                $arrAcc = array_merge($default, $arrAcc);
            }

            $boolUpdateInsert = TRUE;
            foreach ($arrAccFromOtherMasterSystems AS $arrFOMSAcc)
            {
                if ($arrAcc['username'] == $arrFOMSAcc['username'] && $arrAcc['email'] == $arrFOMSAcc['email'])
                {
                    $boolUpdateInsert = FALSE;
                }
            }

            if ($boolUpdateInsert)
            {
                $test = $this->Database
                        ->prepare("INSERT INTO `tl_$strAccType` %s ON DUPLICATE KEY UPDATE " . implode(', ', $arrUpdateQuery))
                        ->set($arrAcc)
                        ->execute();
            }
        }

    }
    
    public function deleteUsers($arrUsers)
    {
        foreach ($arrUsers as $value)
        {
            $this->Database
                    ->prepare("DELETE FROM `tl_user` WHERE username=?")
                    ->execute($value['username'], $value['email']);
        }
    }
    
    public function deleteMembers($arrMembers)
    {
        foreach ($arrMembers as $value)
        {
            $this->Database
                    ->prepare("DELETE FROM `tl_member` WHERE username=?")
                    ->execute($value['username'], $value['email']);
        }
    }

}

?>