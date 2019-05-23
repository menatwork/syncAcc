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

/**
 * Config
 */
$GLOBALS['TL_DCA']['tl_user']['config']['onload_callback'][] = array(
    'SyncAcc\Client\Contao\Table\User',
    'disableSpecialFieldsFromSyncUser'
);

/**
 * Listing
 */
$GLOBALS['TL_DCA']['tl_user']['list']['label']['label_callback'] = array(
    'SyncAcc\Client\Contao\Table\User',
    'addIconExt'
);
