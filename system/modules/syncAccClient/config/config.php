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

/**
 * CtoCommunication RPC Calls
 */

// Get User Group
$GLOBALS["CTOCOM_FUNCTIONS"]["SYNCACC_USERGROUP"] = array(
    "class" => "SyncAccGroupManagement",
    "function" => "getUserGroups",
    "typ" => "POST",
    "parameter" => FALSE,
);

// Get User Group
$GLOBALS["CTOCOM_FUNCTIONS"]["SYNCACC_MEMBERGROUP"] = array(
    "class" => "SyncAccGroupManagement",
    "function" => "getMemberGroups",
    "typ" => "POST",
    "parameter" => FALSE,
);

// Get User
$GLOBALS["CTOCOM_FUNCTIONS"]["SYNCACC_GET_USERS"] = array(
    "class" => "SyncAccUserManagement",
    "function" => "getUsers",
    "typ" => "POST",
    "parameter" => FALSE,
);

// Get Member
$GLOBALS["CTOCOM_FUNCTIONS"]["SYNCACC_GET_MEMBERS"] = array(
    "class" => "SyncAccUserManagement",
    "function" => "getMembers",
    "typ" => "POST",
    "parameter" => FALSE,
);

// Set User
$GLOBALS["CTOCOM_FUNCTIONS"]["SYNCACC_SET_USERS"] = array(
    "class" => "SyncAccUserManagement",
    "function" => "setUsers",
    "typ" => "POST",
    "parameter" => array('user'),
);

// Set Member
$GLOBALS["CTOCOM_FUNCTIONS"]["SYNCACC_SET_MEMBERS"] = array(
    "class" => "SyncAccUserManagement",
    "function" => "setMembers",
    "typ" => "POST",
    "parameter" => array('member'),
);

// Define all fields which whould synchronised
$GLOBALS['SYNCACC']['SYNC_FIELDS'] = array(
    'user' => array(
        'username',
        'name',
        'admin',
        'email',
        'password',
        'disable'
    ),
    'member' => array(
        'firstname',
        'lastname',
        'email',
        'language',
        'groups',
        'login',
        'username',
        'password',
        'disable',
        'locked'
    )
);

?>