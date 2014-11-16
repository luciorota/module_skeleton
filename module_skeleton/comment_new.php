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

$currentFile = basename(__FILE__);
include_once __DIR__ . 'header.php';

$com_item_id = Module_skeletonRequest::getInt('com_item_id', 0);
if ($com_itemid > 0) {
    // Get item title
    $item = $module_skeleton->getHandler('item')->get($com_item_id);
    $com_replytitle = $item->getVar('item_title');
    include XOOPS_ROOT_PATH . '/include/comment_new.php';
}
