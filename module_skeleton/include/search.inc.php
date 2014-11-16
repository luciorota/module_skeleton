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
include_once dirname(dirname(__FILE__)) . '/include/common.php';

/**
 * @param                   $queryArray
 * @param                   $andor
 * @param                   $limit
 * @param                   $offset
 * @param int               $userId
 * @param array             $categories
 * @param int               $sortBy
 * @param string            $searchIn
 * @param string            $extra
 * @return array
 */
function module_skeleton_search($queryArray, $andor, $limit, $offset, $userId = 0, $categories = array(), $sortBy = 0, $searchIn = '', $extra = '')
{
    global $xoopsUser;
    $module_skeleton = Module_skeletonModule_skeleton::getInstance();

    $groups = is_object($xoopsUser) ? $xoopsUser->getGroups() : array(0 => XOOPS_GROUP_ANONYMOUS);
    $groupperm_handler = xoops_gethandler('groupperm');

// IN PROGRESS
// IN PROGRESS
// IN PROGRESS

    return $ret;
}
