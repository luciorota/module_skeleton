<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */
/**
 * Module_skeleton module
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @package         module_skeleton
 * @since           1.00
 * @author          Xoops Development Team
 * @version         svn:$id$
 */

/**
 * Module_skeleton module
 *
 * @param string            $itemcategory
 * @param int               $item_id
 * @return null
 */
function module_skeleton_notify_iteminfo($itemcategory, $id)
{
    global $xoopsModule, $xoopsModuleConfig, $xoopsConfig, $xoopsDB;

    if (empty($xoopsModule) || $xoopsModule->dirname() != 'module_skeleton') {
        $module_handler = xoops_gethandler('module');
        $module = $module_handler->getByDirname('module_skeleton');
        $config_handler = xoops_gethandler('config');
        $config = $config_handler->getConfigsByCat(0,intval($module->mid()));
    } else {
        $module = $xoopsModule;
        $config = $xoopsModuleConfig;
    }

    if ($itemcategory == 'global') {
        $item['name'] = '';
        $item['url'] = '';
        return $item;
    }

    if ($itemcategory == 'itemcategory') {
        // assume we have a valid itemcategory id
        $sql = "SELECT itemcategory_title FROM " . $xoopsDB->prefix('module_skeleton_itemcategories') . " WHERE itemcategory_id = '" . intval($id) . "'";
        $result = $xoopsDB->query($sql); // TODO: error check
        $result_array = $xoopsDB->fetchArray($result);
        $item['name'] = $result_array['itemcategory_title'];
        $item['url'] = MODULE_SKELETON_URL . '/itemcategory.php?itemcategory_id=' . (int) $id;
        return $item;
    }
    if ($itemcategory == 'item') {
        // Assume we have a valid file id
        $sql = "SELECT item_category_id, item_title FROM " . $xoopsDB->prefix('module_skeleton_items') . " WHERE item_id = '" . (int) $id . "'";
        $result = $xoopsDB->query($sql); // TODO: error check
        $result_array = $xoopsDB->fetchArray($result);
        $item['name'] = $result_array['item_title'];
        $item['url'] = MODULE_SKELETON_URL . '/item.php?itemcategory_id=' . (int) $result_array['item_category_id'] . '&amp;item_id=' . (int) $id;
        return $item;
    }
    return null;
}
