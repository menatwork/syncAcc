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
if(TL_MODE == 'BE')
{
    $GLOBALS['TL_DCA']['tl_member']['config']['onload_callback'][] = array('tl_member_syncAccClient', 'disableSpecialFieldsFromSyncMember');
}

/**
 * Listing
 */
$GLOBALS['TL_DCA']['tl_member']['list']['label']['label_callback'] = array('tl_member_syncAccClient', 'addIconExt');

class tl_member_syncAccClient extends \tl_member
{

    /**
     * Remove synchronised fields from palettes
     * 
     * @param DataContainer $dc 
     */
    public function disableSpecialFieldsFromSyncMember(DataContainer $dc)
    {
        $objMember = $this->Database
                ->prepare('SELECT * FROM `tl_member` WHERE id = ?')
                ->execute($dc->id);

        if ($objMember->syncacc == TRUE)
        {
            $arrDisableFields = $GLOBALS['SYNCACC']['SYNC_FIELDS']['member'];
            foreach ($arrDisableFields AS $field)
            {
                foreach ($GLOBALS['TL_DCA']['tl_member']['palettes'] AS $key => $palette)
                {
                    if (gettype($GLOBALS['TL_DCA']['tl_member']['palettes'][$key]) == 'string')
                    {
                        $GLOBALS['TL_DCA']['tl_member']['palettes'][$key] = str_replace(',' . $field, '', $GLOBALS['TL_DCA']['tl_member']['palettes'][$key]);
                    }
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
            $image = 'member';

            if ($row['disable'] || strlen($row['start']) && $row['start'] > time() || strlen($row['stop']) && $row['stop'] < time())
            {
                $image .= '_';
            }
            
            if (version_compare(VERSION, '2.10', '<'))
            {             
                return sprintf('<div class="list_icon" style="padding-left:26px;background-image:url(\'system/modules/syncAccClient/html/%s.gif\');">%s</div>', $image, $label);
            }
            elseif (version_compare(VERSION, '2.11', '<'))
            {
                return sprintf('<div class="list_icon" style="padding-left:26px;background-image:url(\'%ssystem/modules/syncAccClient/html/%s.gif\');">%s</div>', TL_SCRIPT_URL, $image, $label);
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