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

// module info/menu
$xoopsTpl->assign('moduleInfoSub', $module_skeleton->getModule()->subLink());
// module admin
$xoopsTpl->assign("isAdmin", module_skeleton_userIsAdmin());
$xoopsTpl->assign("module_skeleton_adminpage", "<a href='" . MODULE_SKELETON_URL . "/admin/index.php'>" . _MD_MODULE_SKELETON_ADMIN_PAGE . "</a>");

include_once XOOPS_ROOT_PATH . '/footer.php';
