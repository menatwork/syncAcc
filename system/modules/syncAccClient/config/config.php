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
 * Hooks
 */
$GLOBALS['TL_HOOKS']['checkCredentials'][] = array('ExtendedLogin', 'checkPassword');

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
    "parameter" => array('user', 'singleUpdate'),
);

// Delete Users
$GLOBALS["CTOCOM_FUNCTIONS"]["SYNCACC_DELETE_USERS"] = array(
    "class" => "SyncAccUserManagement",
    "function" => "deleteUsers",
    "typ" => "POST",
    "parameter" => array('users'),
);

// Set Member
$GLOBALS["CTOCOM_FUNCTIONS"]["SYNCACC_SET_MEMBERS"] = array(
    "class" => "SyncAccUserManagement",
    "function" => "setMembers",
    "typ" => "POST",
    "parameter" => array('member', 'singleUpdate'),
);

// Delete Member
$GLOBALS["CTOCOM_FUNCTIONS"]["SYNCACC_DELETE_MEMBERS"] = array(
    "class" => "SyncAccUserManagement",
    "function" => "deleteMembers",
    "typ" => "POST",
    "parameter" => array('members'),
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
