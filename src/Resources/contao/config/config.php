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
    "class" => 'SyncAcc\Client\Management\Group',
    "function" => "getUserGroups",
    "typ" => "POST",
    "parameter" => FALSE,
);

// Get Member Group
$GLOBALS["CTOCOM_FUNCTIONS"]["SYNCACC_MEMBERGROUP"] = array(
    "class" => 'SyncAcc\Client\Management\Group',
    "function" => "getMemberGroups",
    "typ" => "POST",
    "parameter" => FALSE,
);

// Get User
$GLOBALS["CTOCOM_FUNCTIONS"]["SYNCACC_GET_USERS"] = array(
    "class" => 'SyncAcc\Client\Management\User',
    "function" => "getUsers",
    "typ" => "POST",
    "parameter" => FALSE,
);

// Get Member
$GLOBALS["CTOCOM_FUNCTIONS"]["SYNCACC_GET_MEMBERS"] = array(
    "class" => 'SyncAcc\Client\Management\User',
    "function" => "getMembers",
    "typ" => "POST",
    "parameter" => FALSE,
);

// Set User
$GLOBALS["CTOCOM_FUNCTIONS"]["SYNCACC_SET_USERS"] = array(
    "class" => 'SyncAcc\Client\Management\User',
    "function" => "setUsers",
    "typ" => "POST",
    "parameter" => array('user', 'singleUpdate'),
);

// Delete Users
$GLOBALS["CTOCOM_FUNCTIONS"]["SYNCACC_DELETE_USERS"] = array(
    "class" => 'SyncAcc\Client\Management\User',
    "function" => "deleteUsers",
    "typ" => "POST",
    "parameter" => array('users'),
);

// Set Member
$GLOBALS["CTOCOM_FUNCTIONS"]["SYNCACC_SET_MEMBERS"] = array(
    "class" => 'SyncAcc\Client\Management\User',
    "function" => "setMembers",
    "typ" => "POST",
    "parameter" => array('member', 'singleUpdate'),
);

// Delete Member
$GLOBALS["CTOCOM_FUNCTIONS"]["SYNCACC_DELETE_MEMBERS"] = array(
    "class" => 'SyncAcc\Client\Management\User',
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
