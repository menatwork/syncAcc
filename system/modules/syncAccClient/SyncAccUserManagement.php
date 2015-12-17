<?php

/**
 * Contao Open Source CMS
 * PHP version 5
 *
 * @copyright  MEN AT WORK 2011
 * @package    syncAccClient
 * @license    GNU/LGPL
 * @filesource
 */

class SyncAccUserManagement extends Backend
{

    protected  $arrDefaultUserFields = array();

    /**
     * Initialize the object
     */
    public function __construct()
    {
        parent::__construct();
        $this->arrDefaultUserFields = array(
            'language'   => $GLOBALS['TL_LANGUAGE'],
            'showHelp'   => 1,
            'thumbnails' => 1,
            'useRTE'     => 1,
            'useCE'      => 1,
            'inherit'    => 'group',
            'alpty'      => array('regular', 'redirect', 'forward'),
            'fop'        => array('f1', 'f2', 'f3')
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

        $objDb    = $this->Database->prepare("SELECT * FROM `tl_user`")->execute();
        $arrUsers = $objDb->fetchAllAssoc();

        return $arrUsers;
    }

    /**
     * Set and update the users array
     *
     * @param array $arrUsers
     */
    public function setUsers($arrUsers, $singleUpdate = false)
    {
        $this->setAccData('user', $arrUsers, $this->arrDefaultUserFields, $singleUpdate);
    }

    /**
     * Create associative database array from all members and return it
     *
     * @return array
     */
    public function getMembers()
    {
        $arrUsers = array();

        $objDb    = $this->Database->prepare("SELECT * FROM `tl_member`")->execute();
        $arrUsers = $objDb->fetchAllAssoc();

        return $arrUsers;
    }

    /**
     * Set and update the members array
     *
     * @param type $arrMembers
     */
    public function setMembers($arrMembers, $singleUpdate = false)
    {
        $this->setAccData('member', $arrMembers, false, $singleUpdate);
    }

    /**
     * Set and update the given account information into the database and
     * delete all accounts which are not more needed
     *
     * @param string $strAccType
     * @param array  $arrAccData
     */
    protected function setAccData($strAccType, $arrAccData, $default = false, $singleUpdate = false)
    {
       $serverID = base64_decode($arrAccData['meta']['sync_acc_master']);

        $arrAccFromOtherMasterSystems = \Database::getInstance()
            ->prepare("
                    SELECT *
                    FROM `tl_user`
                    WHERE sync_acc_master
                    NOT IN ('',?)")
            ->execute($serverID)
            ->fetchAllAssoc();

        foreach ($arrAccData['data'] AS $arrAcc) {
            $arrAcc['sync_acc_master'] = $serverID;
            $arrAcc['syncacc']         = true;

            $arrUpdateQuery = array();
            foreach ($arrAcc AS $field => $value) {
                $arrUpdateQuery[] = " $field = '$value' ";
            }

            if ($default) {
                $arrAcc = array_merge($default, $arrAcc);
            }

            $boolUpdateInsert = true;
            foreach ($arrAccFromOtherMasterSystems AS $arrFOMSAcc) {
                if ($arrAcc['username'] == $arrFOMSAcc['username'] && $arrAcc['email'] == $arrFOMSAcc['email']) {
                    $boolUpdateInsert = false;
                }
            }

            if ($boolUpdateInsert) {
                $test = \Database::getInstance()
                    ->prepare("INSERT INTO `tl_$strAccType` %s ON DUPLICATE KEY UPDATE " . implode(', ',
                            $arrUpdateQuery))
                    ->set($arrAcc)
                    ->execute();
            }
        }

        $objAcc = \Database::getInstance()
            ->prepare("SELECT id, username FROM `tl_$strAccType` WHERE syncacc = 1 AND sync_acc_master = ?")
            ->execute($serverID);

        $arrClientAcc = array();
        while ($objAcc->next()) {
            $arrClientAcc[$objAcc->username] = "'" . $objAcc->id . "'";
        }

        foreach ($arrAccData['data'] AS $arrAcc) {
            unset($arrClientAcc[$arrAcc['username']]);
        }

		// Only run this for the big update.
        if ($singleUpdate == false && count($arrClientAcc) > 0) {
            \Database::getInstance()
                ->prepare("DELETE FROM `tl_$strAccType` WHERE id IN (" . implode(',', $arrClientAcc) . ")")
                ->execute();
        }
    }
}