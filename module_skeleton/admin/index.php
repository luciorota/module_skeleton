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
include_once dirname(__FILE__) . '/admin_header.php';

define('INDEX_FILE_PATH', XOOPS_ROOT_PATH . '/uploads/index.html');
define('BLANK_FILE_PATH', XOOPS_ROOT_PATH . '/uploads/blank.gif');

include_once MODULE_SKELETON_ROOT_PATH . '/class/common/directorychecker.php';
include_once MODULE_SKELETON_ROOT_PATH . '/class/common/filechecker.php';

// admin navigation
xoops_cp_header();
$indexAdmin = new ModuleAdmin();
$indexAdmin->addInfoBox(_AM_MODULE_SKELETON_MINDEX_DOWNSUMMARY);
// Itemcategories
$itemcategoryCount = $module_skeleton->getHandler('itemcategory')->getCount();
if ($itemcategoryCount > 0) {
    $indexAdmin->addInfoBoxLine(
        _AM_MODULE_SKELETON_MINDEX_DOWNSUMMARY,
        '<infolabel><a href="itemcategory.php">' . _AM_MODULE_SKELETON_ITEMCATEGORIES_COUNT . '</a></infolabel>',
        $itemcategoryCount,
        'green'
    );
} else {
    $indexAdmin->addInfoBoxLine(
        _AM_MODULE_SKELETON_MINDEX_DOWNSUMMARY,
        '<infolabel><a href="itemcategory.php">' . _AM_MODULE_SKELETON_ITEMCATEGORIES_COUNT . '</a></infolabel>',
        $itemcategoryCount,
        'green'
    );
}
// Items
$itemCount = $module_skeleton->getHandler('item')->getCount();
if ($itemCount > 0) {
    $indexAdmin->addInfoBoxLine(
        _AM_MODULE_SKELETON_MINDEX_DOWNSUMMARY,
        '<infolabel><a href="item.php">' . _AM_MODULE_SKELETON_ITEMS_COUNT . '</a><b></infolabel>',
        $itemCount,
        'green'
    );
} else {
    $indexAdmin->addInfoBoxLine(
        _AM_MODULE_SKELETON_MINDEX_DOWNSUMMARY,
        '<infolabel><a href="item.php">' . _AM_MODULE_SKELETON_ITEMS_COUNT . '</a></infolabel>',
        $itemCount,
        'green'
    );
}
// Itemfieldcategories
$itemfieldcategoryCount = $module_skeleton->getHandler('itemfieldcategory')->getCount();
if ($itemfieldcategoryCount > 0) {
    $indexAdmin->addInfoBoxLine(
        _AM_MODULE_SKELETON_MINDEX_DOWNSUMMARY,
        '<infolabel><a href="itemfieldcategory.php">' . _AM_MODULE_SKELETON_ITEMFIELDCATEGORIES_COUNT . '</a></infolabel>',
        $itemfieldcategoryCount,
        'green'
    );
} else {
    $indexAdmin->addInfoBoxLine(
        _AM_MODULE_SKELETON_MINDEX_DOWNSUMMARY,
        '<infolabel><a href="itemfieldcategory.php">' . _AM_MODULE_SKELETON_ITEMFIELDCATEGORIES_COUNT . '</a></infolabel>',
        $itemfieldcategoryCount,
        'green'
    );
}
// Itemfields
$itemfieldCount = $module_skeleton->getHandler('itemfield')->getCount();
if ($itemfieldCount > 0) {
    $indexAdmin->addInfoBoxLine(
        _AM_MODULE_SKELETON_MINDEX_DOWNSUMMARY,
        '<infolabel><a href="itemfield.php">' . _AM_MODULE_SKELETON_ITEMFIELDS_COUNT . '</a><b></infolabel>',
        $itemfieldCount,
        'green'
    );
} else {
    $indexAdmin->addInfoBoxLine(
        _AM_MODULE_SKELETON_MINDEX_DOWNSUMMARY,
        '<infolabel><a href="itemfield.php">' . _AM_MODULE_SKELETON_ITEMFIELDS_COUNT . '</a></infolabel>',
        $itemCount,
        'green'
    );
}
// module max file size
$indexAdmin->addInfoBoxLine(
    _AM_MODULE_SKELETON_MINDEX_DOWNSUMMARY,
    '<infolabel>' . _AM_MODULE_SKELETON_DOWN_MODULE_MAXFILESIZE . '</infolabel>',
    module_skeleton_bytesToSize1024($module_skeleton->getConfig('uploadMaxFileSize')),
    'green'
);
// upload file size limit
// get max file size (setup and php.ini)
$phpiniMaxFileSize = (min((int) (ini_get('upload_max_filesize')), (int) (ini_get('post_max_size')), (int) (ini_get('memory_limit')))) * 1024 * 1024; // bytes
$maxFileSize = module_skeleton_bytesToSize1024(min($module_skeleton->getConfig('uploadMaxFileSize'), $phpiniMaxFileSize));
$indexAdmin->addInfoBoxLine(
    _AM_MODULE_SKELETON_MINDEX_DOWNSUMMARY,
    '<infolabel>' .  _AM_MODULE_SKELETON_UPLOAD_MAXFILESIZE . '</infolabel>',
    $maxFileSize,
    'green'
);
// check directories
$indexAdmin->addConfigBoxLine('');
$redirectFile = $_SERVER['PHP_SELF'];
$indexAdmin->addConfigBoxLine('');
$path = $module_skeleton->getConfig('uploadPath') . '/';
$indexAdmin->addConfigBoxLine(DirectoryChecker::getDirectoryStatus($path, 0777, $redirectFile));
$indexAdmin->addConfigBoxLine('');
echo $indexAdmin->addNavigation('index.php');
echo $indexAdmin->renderIndex();
echo module_skeleton_serverStats();

include 'admin_footer.php';
