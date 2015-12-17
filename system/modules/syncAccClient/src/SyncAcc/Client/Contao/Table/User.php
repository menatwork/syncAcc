<?php
/**
 * Created by PhpStorm.
 * User: stefan.heimes
 * Date: 28.10.2015
 * Time: 11:10
 */

namespace SyncAcc\Client\Contao\Table;


class User
{
    /**
     * Remove synchronised fields from palettes
     *
     * @param \DataContainer $dc
     */
    public function disableSpecialFieldsFromSyncUser(\DataContainer $dc)
    {
        $objUser = \Database::getInstance()
            ->prepare('SELECT * FROM `tl_user` WHERE id = ?')
            ->execute($dc->id);

        if ($objUser->syncacc == true) {
			\Message::addInfo($GLOBALS['TL_LANG']['syncAcc']['under_sync']);
            $arrDisableFields = $GLOBALS['SYNCACC']['SYNC_FIELDS']['user'];
            foreach ($arrDisableFields AS $field) {
                $GLOBALS['TL_DCA']['tl_user']['fields'][$field]['eval']['readonly'] = true;
            }
        }
    }

    /**
     * Add an image to each record
     *
     * @param array
     *
     * @param string
     *
     * @return string
     */
    public function addIconExt($row, $label, $dc = null, $args = null)
    {
        if ($row['syncacc'] == true) {
            $image = $row['admin'] ? 'admin' : 'user';

            if ($row['disable'] || strlen($row['start']) && $row['start'] > time() || strlen($row['stop']) && $row['stop'] < time()) {
                $image .= '_';
            }

            if (version_compare(VERSION, '2.10', '<')) {
                return sprintf('<div class="list_icon wide" style="padding-left:26px;background-image:url(\'system/modules/syncAccClient/assets/images/%s.gif\');">%s</div>',
                    $image, $label);
            } elseif (version_compare(VERSION, '2.11', '<')) {
                return sprintf('<div class="list_icon wide" style="padding-left:26px;background-image:url(\'%ssystem/modules/syncAccClient/assets/images/%s.gif\');">%s</div>',
                    TL_SCRIPT_URL, $image, $label);
            } else {
                $args[0] = sprintf('<div class="list_icon_new" style="width:21px;background-image:url(\'%ssystem/modules/syncAccClient/assets/images/%s.gif\')">&nbsp;</div>',
                    TL_SCRIPT_URL, $image);
                return $args;
            }
        } else {
            $image = $row['admin'] ? 'admin' : 'user';

            if ($row['disable'] || strlen($row['start']) && $row['start'] > time() || strlen($row['stop']) && $row['stop'] < time()) {
                $image .= '_';
            }

            $args[0] = sprintf('<div class="list_icon_new" style="background-image:url(\'%ssystem/themes/%s/images/%s.gif\')" data-icon="%s.gif" data-icon-disabled="%s.gif">&nbsp;</div>',
                TL_ASSETS_URL, \Backend::getTheme(), $image, rtrim($image, '_'), rtrim($image, '_') . '_');

            return $args;
        }
    }
}
