<?php

/**
 * Contao Open Source CMS

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
        return $this->Database
                        ->prepare("SELECT * FROM `tl_user`")
                        ->execute()
                        ->fetchAllAssoc();
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
        return $this->Database
                        ->prepare("SELECT * FROM `tl_member`")
                        ->execute()
                        ->fetchAllAssoc();
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
            $arrAcc['syncacc']         = TRUE;

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