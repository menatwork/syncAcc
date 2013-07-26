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
 * Config
 */
$GLOBALS['TL_DCA']['tl_user']['config']['onload_callback'][] = array('tl_user_syncAccClient', 'disableSpecialFieldsFromSyncUser');

/**
 * Listing
 */
$GLOBALS['TL_DCA']['tl_user']['list']['label']['label_callback'] = array('tl_user_syncAccClient', 'addIconExt');

class tl_user_syncAccClient extends \tl_user
{

    /**
     * Remove synchronised fields from palettes
     * 
     * @param DataContainer $dc 
     */
    public function disableSpecialFieldsFromSyncUser(DataContainer $dc)
    {
        $objUser = $this->Database
                ->prepare('SELECT * FROM `tl_user` WHERE id = ?')
                ->execute($dc->id);

        if ($objUser->syncacc == TRUE)
        {
            $arrDisableFields = $GLOBALS['SYNCACC']['SYNC_FIELDS']['user'];
            foreach ($arrDisableFields AS $field)
                foreach ($GLOBALS['TL_DCA']['tl_user']['palettes'] AS $key => $palette)
                {
                    if (gettype($GLOBALS['TL_DCA']['tl_user']['palettes'][$key]) == 'string')
                    {
                        $GLOBALS['TL_DCA']['tl_user']['palettes'][$key] = str_replace(',' . $field, '', $GLOBALS['TL_DCA']['tl_user']['palettes'][$key]);
                    }
                }
        }
    }

    /**
     * Add an image to each record
     * @param array
     * @param string
     * @return string
     */
    public function addIconExt($row, $label, $dc = NULL, $args = NULL)
    {
        if ($row['syncacc'] == TRUE)
        {
            $image = $row['admin'] ? 'admin' : 'user';

            if ($row['disable'] || strlen($row['start']) && $row['start'] > time() || strlen($row['stop']) && $row['stop'] < time())
            {
                $image .= '_';
            }

            if (version_compare(VERSION, '2.10', '<'))
            {             
                return sprintf('<div class="list_icon wide" style="padding-left:26px;background-image:url(\'system/modules/syncAccClient/html/%s.gif\');">%s</div>', $image, $label);
            }
            elseif (version_compare(VERSION, '2.11', '<'))
            {
                return sprintf('<div class="list_icon wide" style="padding-left:26px;background-image:url(\'%ssystem/modules/syncAccClient/html/%s.gif\');">%s</div>', TL_SCRIPT_URL, $image, $label);
            }
            else
            {
                $args[0] = sprintf('<div class="list_icon_new" style="width:21px;background-image:url(\'%ssystem/modules/syncAccClient/html/%s.gif\')">&nbsp;</div>', TL_SCRIPT_URL, $image);
                return $args;
            }
        }
        else
        {
            return parent::addIcon($row, $label, $dc, $args);
        }
    }

}

?>