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
if (TL_MODE == 'BE') {
    $GLOBALS['TL_DCA']['tl_member']['config']['onload_callback'][] = array(
        'SyncAccClientBundle\Contao\Table\Member',
        'disableSpecialFieldsFromSyncMember'
    );
}

/**
 * Listing
 */
$GLOBALS['TL_DCA']['tl_member']['list']['label']['label_callback'] = array(
    'SyncAccClientBundle\Contao\Table\Member',
    'addIconExt'
);
