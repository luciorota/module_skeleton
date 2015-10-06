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
include_once __DIR__ . '/admin_header.php';

define('INDEX_FILE_PATH', XOOPS_ROOT_PATH . '/uploads/index.html');
define('BLANK_FILE_PATH', XOOPS_ROOT_PATH . '/uploads/blank.gif');

include_once MODULE_SKELETON_ROOT_PATH . '/class/common/directorychecker.php';
include_once MODULE_SKELETON_ROOT_PATH . '/class/common/filechecker.php';

// admin navigation
xoops_cp_header();

$indexAdmin = \Xmf\Module\Admin::getInstance();
$indexAdmin->displayNavigation($currentFile);

$indexAdmin->addInfoBox(_AM_MODULE_SKELETON_MINDEX_DOWNSUMMARY);
// Itemcategories
$itemcategoryCount = $module_skeletonHelper->getHandler('itemcategory')->getCount();
$indexAdmin->addInfoBoxLine('<infolabel><a href="itemcategory.php">' . _AM_MODULE_SKELETON_ITEMCATEGORIES_COUNT . '</a></infolabel>' . $itemcategoryCount);
// Items
$itemCount = $module_skeletonHelper->getHandler('item')->getCount();
$indexAdmin->addInfoBoxLine('<infolabel><a href="item.php">' . _AM_MODULE_SKELETON_ITEMS_COUNT . '</a></infolabel>' . $itemCount);
// Itemfieldcategories
$itemfieldcategoryCount = $module_skeletonHelper->getHandler('itemfieldcategory')->getCount();
$indexAdmin->addInfoBoxLine('<infolabel><a href="itemfieldcategory.php">' . _AM_MODULE_SKELETON_ITEMFIELDCATEGORIES_COUNT . '</a></infolabel>' . $itemfieldcategoryCount);
// Itemfields
$itemfieldCount = $module_skeletonHelper->getHandler('itemfield')->getCount();
$indexAdmin->addInfoBoxLine('<infolabel><a href="itemfield.php">' . _AM_MODULE_SKELETON_ITEMFIELDS_COUNT . '</a></infolabel>' . $itemfieldCount);
// module max file size
$indexAdmin->addInfoBoxLine('<infolabel>' . _AM_MODULE_SKELETON_DOWN_MODULE_MAXFILESIZE . '</infolabel>' . module_skeleton_bytesToSize1024($module_skeletonHelper->getConfig('uploadMaxFileSize')));
// upload file size limit
// get max file size (setup and php.ini)
$phpiniMaxFileSize = (min((int) (ini_get('upload_max_filesize')), (int) (ini_get('post_max_size')), (int) (ini_get('memory_limit')))) * 1024 * 1024; // bytes
$maxFileSize = module_skeleton_bytesToSize1024(min($module_skeletonHelper->getConfig('uploadMaxFileSize'), $phpiniMaxFileSize));
$indexAdmin->addInfoBoxLine('<infolabel>' .  _AM_MODULE_SKELETON_UPLOAD_MAXFILESIZE . '</infolabel>' . $maxFileSize);

// check directories
$indexAdmin->addConfigBoxLine('');
$redirectFile = $_SERVER['PHP_SELF'];
$indexAdmin->addConfigBoxLine('');
$path = $module_skeletonHelper->getConfig('uploadPath') . '/';
$indexAdmin->addConfigBoxLine(DirectoryChecker::getDirectoryStatus($path, 0777, $redirectFile));
$indexAdmin->addConfigBoxLine('');

$indexAdmin->displayIndex();
//echo $indexAdmin->addNavigation('index.php');
//echo $indexAdmin->renderIndex();
echo module_skeleton_serverStats();

include 'admin_footer.php';
