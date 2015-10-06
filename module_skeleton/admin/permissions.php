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
if (!is_dir($module_skeletonHelper->getConfig('uploadPath'))) {
    redirect_header('index.php', 3, _CO_MODULE_SKELETON_WARNING_NOUPLOADDIR);
    exit();
}
// Check categories
$itemcategoryCount = $module_skeletonHelper->getHandler('itemcategory')->getCount();
if ($itemcategoryCount == 0) {
    redirect_header('itemcategory.php', 3, _CO_MODULE_SKELETON_ERROR_NOITEMCATEGORY);
    exit();
}
//  admin navigation
xoops_cp_header();
$indexAdmin = \Xmf\Module\Admin::getInstance();
$indexAdmin->displayNavigation($currentFile);
//
xoops_load('XoopsFormLoader');
include_once $GLOBALS['xoops']->path('/class/xoopsform/grouppermform.php');

$op = XoopsRequest::getString('op', 'global');

$permission_select_form = new XoopsSimpleForm('', 'opform', $currentFile, 'get');
$op_select = new XoopsFormSelect('', 'op', $op);
$op_select->setExtra('onchange="document.forms.opform.submit()"');
$op_select->addOption('global',  _CO_MODULE_SKELETON_PERM_GLOBAL);
$op_select->addOption('itemcategoryRead', _CO_MODULE_SKELETON_PERM_ITEMCATEGORY_READ);
$op_select->addOption('itemcategoryWrite', _CO_MODULE_SKELETON_PERM_ITEMCATEGORY_WRITE);
$op_select->addOption('itemfieldcategoryRead', _CO_MODULE_SKELETON_PERM_ITEMFIELDCATEGORY_READ);
$op_select->addOption('itemfieldcategoryWrite', _CO_MODULE_SKELETON_PERM_ITEMFIELDCATEGORY_WRITE);
/*
$op_select->addOption('itemfieldRead', _CO_MODULE_SKELETON_PERM_ITEMFIELD_READ);
$op_select->addOption('itemfieldWrite', _CO_MODULE_SKELETON_PERM_ITEMFIELD_WRITE);
$op_select->addOption('itemfieldSearch', _CO_MODULE_SKELETON_PERM_ITEMFIELD_SEARCH);
*/
$permission_select_form->addElement($op_select);

switch ($op) {
    default:
    case 'global':
        $title_of_form =  _CO_MODULE_SKELETON_PERM_GLOBAL;
        $perm_name = 'global';
        $perm_desc =  _CO_MODULE_SKELETON_PERM_GLOBAL_DESC;
        $restriction = '';
        $anonymous = true;
        break;
    case 'itemcategoryRead':
        $title_of_form = _CO_MODULE_SKELETON_PERM_ITEMCATEGORY_READ;
        $perm_name = 'itemcategoryRead';
        $perm_desc = _CO_MODULE_SKELETON_PERM_ITEMCATEGORY_READ_DESC;
        $restriction = '';
        $anonymous = true;
        break;
    case 'itemcategoryWrite':
        $title_of_form = _CO_MODULE_SKELETON_PERM_ITEMCATEGORY_WRITE;
        $perm_name = 'itemcategoryWrite';
        $perm_desc = _CO_MODULE_SKELETON_PERM_ITEMCATEGORY_WRITE_DESC;
        $restriction = '';
        $anonymous = true;
        break;
    case 'itemfieldcategoryRead':
        $title_of_form = _CO_MODULE_SKELETON_PERM_ITEMFIELDCATEGORY_READ;
        $perm_name = 'itemfieldcategoryRead';
        $perm_desc = _CO_MODULE_SKELETON_PERM_ITEMFIELDCATEGORY_READ_DESC;
        $restriction = '';
        $anonymous = true;
        break;
    case 'itemfieldcategoryWrite':
        $title_of_form = _CO_MODULE_SKELETON_PERM_ITEMFIELDCATEGORY_WRITE;
        $perm_name = 'itemfieldcategoryWrite';
        $perm_desc = _CO_MODULE_SKELETON_PERM_ITEMFIELDCATEGORY_WRITE_DESC;
        $restriction = '';
        $anonymous = true;
        break;
/*
    case 'itemfieldRead':
        $title_of_form = _CO_MODULE_SKELETON_PERM_ITEMFIELD_READ;
        $perm_name = 'itemfieldRead';
        $perm_desc = _CO_MODULE_SKELETON_PERM_ITEMFIELD_READ_DESC;
        $restriction = '';
        $anonymous = true;
        break;
    case 'itemfieldWrite':
        $title_of_form = _CO_MODULE_SKELETON_PERM_ITEMFIELD_WRITE;
        $perm_name = 'itemfieldWrite';
        $perm_desc = _CO_MODULE_SKELETON_PERM_ITEMFIELD_READ_DESC;
        $restriction = 'itemfield_edit';
        $anonymous = false;
        break;
    case 'itemfieldSearch':
        $title_of_form = _CO_MODULE_SKELETON_PERM_ITEMFIELD_SEARCH;
        $perm_name = 'itemfieldSearch';
        $perm_desc = _CO_MODULE_SKELETON_PERM_ITEMFIELD_SEARCH_DESC;
        $restriction = '';
        $anonymous = true;
        break;
*/
}

$permissions_form = new XoopsGroupPermForm($title_of_form, $module_skeletonHelper->getModule()->mid(), $perm_name, $perm_desc, "admin/{$currentFile}?op={$op}", $anonymous);

/**
 *
 * How to check global permissions
 *
 * $groups = is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getGroups() : array(0 => XOOPS_GROUP_ANONYMOUS);
 * if (!$groupperm_handler->checkRight('global', _MODULE_SKELETON_PERM_1, $groups, $module_skeletonHelper->getModule()->mid())) {
 *    redirect_header('javascript:history.go(-1)', 3, _NOPERM);
 * }
 *
 */

switch ($op) {
    default:
    default:
    case 'global':
        // defined in include/costants.php
        $form_options = array(
            _MODULE_SKELETON_PERM_1 => _AM_MODULE_SKELETON_PERM_1,
            _MODULE_SKELETON_PERM_2 => _AM_MODULE_SKELETON_PERM_2
        );
        $permissions_form = new XoopsGroupPermForm($title_of_form, $module_skeletonHelper->getModule()->mid(), $perm_name, $perm_desc, "admin/{$currentFile}?op={$op}", $anonymous);
        foreach ($form_options as $key => $value) {
            $permissions_form->addItem($key, $value);
        }
        break;
    case 'itemcategoryRead':
    case 'itemcategoryWrite':
        $itemcategoryObjs = $module_skeletonHelper->getHandler('itemcategory')->getObjects();
        if (count($itemcategoryObjs) < 1) {
            unset($permissions_form);
            $permissions_form = new XoopsFormLabel('', _CO_MODULE_SKELETON_WARNING_NOITEMCATEGORIES);
            break;
        }
        foreach($itemcategoryObjs as $itemcategoryObj) {
            $permissions_form->addItem($itemcategoryObj->getVar('itemcategory_id'), $itemcategoryObj->getVar('itemcategory_title'), $itemcategoryObj->getVar('itemcategory_pid'));
        }
        break;
    case 'itemfieldcategoryRead':
    case 'itemfieldcategoryWrite':
        $itemfieldcategoryObjs = $module_skeletonHelper->getHandler('itemfieldcategory')->getObjects();
        if (count($itemfieldcategoryObjs) < 1) {
            unset($permissions_form);
            $permissions_form = new XoopsFormLabel('', _CO_MODULE_SKELETON_WARNING_NOITEMFIELDCATEGORIES);
            break;
        }
        foreach($itemfieldcategoryObjs as $itemfieldcategoryObj) {
            $permissions_form->addItem($itemfieldcategoryObj->getVar('itemfieldcategory_id'), $itemfieldcategoryObj->getVar('itemfieldcategory_title'), $itemfieldcategoryObj->getVar('itemfieldcategory_pid'));
        }
        break;
    case 'itemfieldRead':
    case 'itemfieldWrite':
    case 'itemfieldSearch':
        $itemfieldObjs = $module_skeletonHelper->getHandler('itemfield')->getObjects();
        if (count($itemfieldObjs) < 1) {
            unset($permissions_form);
            $permissions_form = new XoopsFormLabel('', _CO_MODULE_SKELETON_WARNING_NOITEMFIELDS);
            break;
        }
        if ($op != 'itemfieldSearch') {
            foreach($itemfieldObjs as $itemfieldObj) {
                if ($restriction == '' || $itemfieldObj->getVar($restriction) == true) {
                    $permissions_form->addItem($itemfieldObj->getVar('itemfield_id'), xoops_substr($itemfieldObj->getVar('itemfield_title'), 0, 25));
                }
            }
        } else {
            foreach($itemfieldObjs as $itemfieldObj) {
                if (in_array($itemfieldObj->getVar('itemfield_type'), $module_skeletonHelper->getHandler('itemfield')->getSearchableTypes())) {
                    $permissions_form->addItem($itemfieldObj->getVar('itemfield_id'), xoops_substr($itemfieldObj->getVar('itemfield_title'), 0, 25));
                }
            }
        }
        break;
}

$GLOBALS['xoopsTpl']->assign('permission_select_form', $permission_select_form->render());
$GLOBALS['xoopsTpl']->assign('permissions_form', $permissions_form->render());

$GLOBALS['xoopsTpl']->display("db:{$module_skeletonHelper->getModule()->dirname()}_am_permissions.tpl");

include __DIR__ . '/admin_footer.php';
