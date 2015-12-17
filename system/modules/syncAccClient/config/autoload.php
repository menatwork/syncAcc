<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2013 Leo Feyer
 *
 * @package SyncAccClient
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
    // Contao - Table
    'SyncAcc\Client\Contao\Table\Member' => 'system/modules/syncAccClient/src/SyncAcc/Client/Contao/Table/Member.php',
    'SyncAcc\Client\Contao\Table\User'   => 'system/modules/syncAccClient/src/SyncAcc/Client/Contao/Table/User.php',
    // Management
    'SyncAcc\Client\Management\User'     => 'system/modules/syncAccClient/src/SyncAcc/Client/Management/User.php',
    'SyncAcc\Client\Management\Group'    => 'system/modules/syncAccClient/src/SyncAcc/Client/Management/Group.php'
));
