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

// Check directories
if (!is_dir($module_skeleton->getConfig('uploadPath'))) {
    redirect_header('index.php', 3, _CO_MODULE_SKELETON_WARNING_NOUPLOADDIR);
    exit();
}
// Check categories
$itemcategoryCount = $module_skeleton->getHandler('itemcategory')->getCount();
if ($itemcategoryCount == 0) {
    redirect_header('itemcategory.php', 3, _CO_MODULE_SKELETON_ERROR_NOITEMCATEGORY);
    exit();
}
//  admin navigation
xoops_cp_header();
$indexAdmin = new ModuleAdmin();
echo $indexAdmin->addNavigation($currentFile);
//
xoops_load('XoopsFormLoader');
include_once $GLOBALS['xoops']->path('/class/xoopsform/grouppermform.php');

$op = XoopsRequest::getString('op', 'itemcategory_read');

$permission_select_form = new XoopsSimpleForm('', 'opform', $currentFile, 'get');
$op_select = new XoopsFormSelect('', 'op', $op);
$op_select->setExtra('onchange="document.forms.opform.submit()"');
$op_select->addOption('itemcategory_read', _CO_MODULE_SKELETON_PERM_ITEMCATEGORY_READ);
$op_select->addOption('itemcategory_write', _CO_MODULE_SKELETON_PERM_ITEMCATEGORY_WRITE);
$op_select->addOption('itemfieldcategory_read', _CO_MODULE_SKELETON_PERM_ITEMFIELDCATEGORY_READ);
$op_select->addOption('itemfieldcategory_write', _CO_MODULE_SKELETON_PERM_ITEMFIELDCATEGORY_WRITE);
/*
$op_select->addOption('itemfield_read', _CO_MODULE_SKELETON_PERM_ITEMFIELD_READ);
$op_select->addOption('itemfield_write', _CO_MODULE_SKELETON_PERM_ITEMFIELD_WRITE);
$op_select->addOption('itemfield_search', _CO_MODULE_SKELETON_PERM_ITEMFIELD_SEARCH);
*/
$permission_select_form->addElement($op_select);

switch ($op) {
    default:
    case 'itemcategory_read':
        $title_of_form = _CO_MODULE_SKELETON_PERM_ITEMCATEGORY_READ;
        $perm_name = 'itemcategory_read';
        $perm_desc = _CO_MODULE_SKELETON_PERM_ITEMCATEGORY_READ_DESC;
        $restriction = '';
        $anonymous = true;
        break;
    case 'itemcategory_write':
        $title_of_form = _CO_MODULE_SKELETON_PERM_ITEMCATEGORY_WRITE;
        $perm_name = 'itemcategory_write';
        $perm_desc = _CO_MODULE_SKELETON_PERM_ITEMCATEGORY_WRITE_DESC;
        $restriction = '';
        $anonymous = true;
        break;
    case 'itemfieldcategory_read':
        $title_of_form = _CO_MODULE_SKELETON_PERM_ITEMFIELDCATEGORY_READ;
        $perm_name = 'itemfieldcategory_read';
        $perm_desc = _CO_MODULE_SKELETON_PERM_ITEMFIELDCATEGORY_READ_DESC;
        $restriction = '';
        $anonymous = true;
        break;
    case 'itemfieldcategory_write':
        $title_of_form = _CO_MODULE_SKELETON_PERM_ITEMFIELDCATEGORY_WRITE;
        $perm_name = 'itemfieldcategory_write';
        $perm_desc = _CO_MODULE_SKELETON_PERM_ITEMFIELDCATEGORY_WRITE_DESC;
        $restriction = '';
        $anonymous = true;
        break;
/*
    case 'itemfield_read':
        $title_of_form = _CO_MODULE_SKELETON_PERM_ITEMFIELD_READ;
        $perm_name = 'itemfield_read';
        $perm_desc = _CO_MODULE_SKELETON_PERM_ITEMFIELD_READ_DESC;
        $restriction = '';
        $anonymous = true;
        break;
    case 'itemfield_write':
        $title_of_form = _CO_MODULE_SKELETON_PERM_ITEMFIELD_WRITE;
        $perm_name = 'itemfield_write';
        $perm_desc = _CO_MODULE_SKELETON_PERM_ITEMFIELD_READ_DESC;
        $restriction = 'itemfield_edit';
        $anonymous = false;
        break;
    case 'itemfield_search':
        $title_of_form = _CO_MODULE_SKELETON_PERM_ITEMFIELD_SEARCH;
        $perm_name = 'itemfield_search';
        $perm_desc = _CO_MODULE_SKELETON_PERM_ITEMFIELD_SEARCH_DESC;
        $restriction = '';
        $anonymous = true;
        break;
*/
}

$permissions_form = new XoopsGroupPermForm($title_of_form, $module_skeleton->getModule()->mid(), $perm_name, $perm_desc, "admin/{$currentFile}?op={$op}", $anonymous);

switch ($op) {
    default:
    case 'itemcategory_read':
    case 'itemcategory_write':
        $itemcategoryObjs = $module_skeleton->getHandler('itemcategory')->getObjects();
        if (count($itemcategoryObjs) < 1) {
            unset($permissions_form);
            $permissions_form = new XoopsFormLabel('', _CO_MODULE_SKELETON_WARNING_NOITEMCATEGORIES);
            break;
        }
        foreach($itemcategoryObjs as $itemcategoryObj) {
            $permissions_form->addItem($itemcategoryObj->getVar('itemcategory_id'), $itemcategoryObj->getVar('itemcategory_title'), $itemcategoryObj->getVar('itemcategory_pid'));
        }
        break;
    case 'itemfieldcategory_read':
    case 'itemfieldcategory_write':
        $itemfieldcategoryObjs = $module_skeleton->getHandler('itemfieldcategory')->getObjects();
        if (count($itemfieldcategoryObjs) < 1) {
            unset($permissions_form);
            $permissions_form = new XoopsFormLabel('', _CO_MODULE_SKELETON_WARNING_NOITEMFIELDCATEGORIES);
            break;
        }
        foreach($itemfieldcategoryObjs as $itemfieldcategoryObj) {
            $permissions_form->addItem($itemfieldcategoryObj->getVar('itemfieldcategory_id'), $itemfieldcategoryObj->getVar('itemfieldcategory_title'), $itemfieldcategoryObj->getVar('itemfieldcategory_pid'));
        }
        break;
    case 'itemfield_read':
    case 'itemfield_write':
    case 'itemfield_search':
        $itemfieldObjs = $module_skeleton->getHandler('itemfield')->getObjects();
        if (count($itemfieldObjs) < 1) {
            unset($permissions_form);
            $permissions_form = new XoopsFormLabel('', _CO_MODULE_SKELETON_WARNING_NOITEMFIELDS);
            break;
        }
        if ($op != 'itemfield_search') {
            foreach($itemfieldObjs as $itemfieldObj) {
                if ($restriction == '' || $itemfieldObj->getVar($restriction) == true) {
                    $permissions_form->addItem($itemfieldObj->getVar('itemfield_id'), xoops_substr($itemfieldObj->getVar('itemfield_title'), 0, 25));
                }
            }
        } else {
            foreach($itemfieldObjs as $itemfieldObj) {
                if (in_array($itemfieldObj->getVar('itemfield_type'), $module_skeleton->getHandler('itemfield')->getSearchableTypes())) {
                    $permissions_form->addItem($itemfieldObj->getVar('itemfield_id'), xoops_substr($itemfieldObj->getVar('itemfield_title'), 0, 25));
                }
            }
        }
        break;
}

$GLOBALS['xoopsTpl']->assign('permission_select_form', $permission_select_form->render());
$GLOBALS['xoopsTpl']->assign('permissions_form', $permissions_form->render());

$GLOBALS['xoopsTpl']->display("db:{$module_skeleton->getModule()->dirname()}_admin_permissions.tpl");

include __DIR__ . '/admin_footer.php';
