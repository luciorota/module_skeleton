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

defined('XOOPS_ROOT_PATH') || die('XOOPS root path not defined');
include_once __DIR__ . '/common.php';

// comment callback functions

/**
 * @param     $item_id
 * @param int $total_num
 *
 * @internal param int $download_id
 */
function module_skeleton_com_update($item_id, $total_num)
{
    $module_skeleton = Module_skeletonModule_skeleton::getInstance();
    $module_skeleton->getHandler('item')->updateAll('comments', intval($total_num), new Criteria('item_id', (int) $item_id));
}

/**
 * @param                   $comment
 */
function module_skeleton_com_approve(&$comment)
{
    // notification mail here
}
