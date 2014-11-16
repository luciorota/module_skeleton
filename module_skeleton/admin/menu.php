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

$module_handler = xoops_gethandler('module');
$module = $module_handler->getByDirname(basename(dirname(dirname(__FILE__))));
$pathIcon32 = '../../' . $module->getInfo('icons32');
//$pathIcon32 = '/assets/images/icons/32x32';

xoops_loadLanguage('modinfo', $module->dirname());

$adminmenu = array();
$i=0;
$adminmenu[$i]["title"] = _MI_MODULE_SKELETON_MENU_HOME;
$adminmenu[$i]['link'] = "admin/index.php";
$adminmenu[$i]["icon"]  = $pathIcon32 . '/home.png';
++$i;
$adminmenu[$i]['title'] = _MI_MODULE_SKELETON_MENU_ITEMCATEGORIES;
$adminmenu[$i]['link'] = "admin/itemcategory.php";
$adminmenu[$i]["icon"]  = $pathIcon32 . '/category.png';
++$i;
$adminmenu[$i]['title'] = _MI_MODULE_SKELETON_MENU_ITEMS;
$adminmenu[$i]['link'] = "admin/item.php";
$adminmenu[$i]["icon"]  = $pathIcon32 . '/block.png';
++$i;
$adminmenu[$i]['title'] = _MI_MODULE_SKELETON_MENU_ITEMFIELDCATEGORIES;
$adminmenu[$i]['link'] = "admin/itemfieldcategory.php";
$adminmenu[$i]["icon"]  = $pathIcon32 . '/category.png';
++$i;
$adminmenu[$i]['title'] = _MI_MODULE_SKELETON_MENU_ITEMFIELDS;
$adminmenu[$i]['link'] = "admin/itemfield.php";
$adminmenu[$i]["icon"]  = $pathIcon32 . '/index.png';
++$i;
$adminmenu[$i]['title'] = _MI_MODULE_SKELETON_MENU_PERMISSIONS;
$adminmenu[$i]['link'] = "admin/permissions.php";
$adminmenu[$i]["icon"]  = $pathIcon32 . '/permissions.png';
++$i;
$adminmenu[$i]['title'] = _MI_MODULE_SKELETON_MENU_CLONE;
$adminmenu[$i]['link'] = "admin/clone.php";
$adminmenu[$i]["icon"] = './assets/images/icons/32/editcopy.png';
++$i;
$adminmenu[$i]['title'] = _MI_MODULE_SKELETON_MENU_ABOUT;
$adminmenu[$i]['link'] =  "admin/about.php";
$adminmenu[$i]["icon"]  = $pathIcon32 . '/about.png';
