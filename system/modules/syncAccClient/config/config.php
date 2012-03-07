<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

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
    "parameter" => array('member'),
);

// Delete Member
$GLOBALS["CTOCOM_FUNCTIONS"]["SYNCACC_DELETE_MEMBERS"] = array(
    "class" => "SyncAccUserManagement",
    "function" => "deleteMembers",
    "typ" => "POST",
    "parameter" => array('members'),
);

?>