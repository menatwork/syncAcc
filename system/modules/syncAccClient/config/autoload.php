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
	'SyncAccMember'          => 'system/modules/syncAccClient/SyncAccMember.php',
	'SyncAccUserManagement'  => 'system/modules/syncAccClient/SyncAccUserManagement.php',
	'SyncAccGroupManagement' => 'system/modules/syncAccClient/SyncAccGroupManagement.php',
));
