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

class SyncAccGroupManagement extends Backend {
    
    public function __construct()
    {
        parent::__construct();        
    }
    
    public function getUserGroups()
    {
        $arrGroups = array();
        
        $objDb = $this->Database->prepare("SELECT * FROM `tl_user_group`")->execute();
        $arrGroups = $objDb->fetchAllAssoc();
        
        return $arrGroups;        
    }
    
    public function getMemberGroups()
    {
        $arrGroups = array();
        
        $objDb = $this->Database->prepare("SELECT * FROM `tl_member_group`")->execute();
        $arrGroups = $objDb->fetchAllAssoc();
        
        return $arrGroups;          
    }
    
}

?>