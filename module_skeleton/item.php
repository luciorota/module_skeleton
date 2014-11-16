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
include __DIR__ . '/header.php';

// load template
$xoopsOption['template_main'] = "{$module_skeleton->getModule()->dirname()}_item.tpl";
include XOOPS_ROOT_PATH . '/header.php';

$xoTheme->addScript(XOOPS_URL . '/browse.php?Frameworks/jquery/jquery.js');
$xoTheme->addStylesheet(MODULE_SKELETON_URL . '/assets/css/module.css');

$xoopsTpl->assign('module_skeleton_url', MODULE_SKELETON_URL . '/');

// Breadcrumb
$breadcrumb = new Module_skeletonBreadcrumb();
$breadcrumb->addLink($module_skeleton->getModule()->getVar('name'), MODULE_SKELETON_URL);

$xoopsTpl->assign('module_skeleton_breadcrumb', $breadcrumb->render());

// IN PROGRESS
// IN PROGRESS
// IN PROGRESS

$op = Module_skeletonRequest::getString('op', 'items.list');
switch ($op) {
    default:
    case 'items.list':
    case 'items.filter':
        // get itemcategory
        $itemcategory_id = Module_skeletonRequest::getInt('itemcategory_id', 0);
        $itemcategoryObj = $module_skeleton->getHandler('itemcategory')->get($itemcategory_id);
        if (empty($itemcategoryObj)) {
            redirect_header('index.php', 3, _CO_MODULE_SKELETON_ERROR_NOITEMCATEGORY);
        }
        //
        include __DIR__ . '/footer.php';
        break;

    case 'item.view':
        // get item
        $item_id = Module_skeletonRequest::getInt('item_id', 0);
        $itemObj = $module_skeleton->getHandler('item')->get($item_id);
        if (empty($itemObj) || $itemObj->isNew()) {
            redirect_header('index.php', 3, _CO_MODULE_SKELETON_ERROR_NOITEM);
        }
        // get itemcategory
        $itemcategory_id = Module_skeletonRequest::getInt('itemcategory_id', $itemObj->getVar('item_category_id'));
        $itemcategoryObj = $module_skeleton->getHandler('itemcategory')->get($itemcategory_id);
        if (empty($itemcategoryObj)) {
            redirect_header('index.php', 3, _CO_MODULE_SKELETON_ERROR_NOITEMCATEGORY);
        }
        // check permissions
        $groups = is_object($xoopsUser) ? $xoopsUser->getGroups() : array(0 => XOOPS_GROUP_ANONYMOUS);
        if (!$groupperm_handler->checkRight('itemcategory_read', $itemcategory_id, $groups, $module_skeleton->getModule()->mid())) {
            if (in_array(XOOPS_GROUP_ANONYMOUS, $groups)) {
                redirect_header(XOOPS_URL . '/user.php', 3, _MD_MODULE_SKELETON_NEEDLOGINVIEW);
            } else {
                redirect_header('index.php', 3, _NOPERM);
            }
        }
        //
        $info = $itemObj->getInfo();

// IN PROGRESS
// IN PROGRESS
// IN PROGRESS

        echo print_r($info,true);
        //
        include __DIR__ . '/footer.php';
        break;

    case 'item.new':
    case 'item.add':
    case 'item.edit':
        // get item
        $item_id = Module_skeletonRequest::getInt('item_id', 0);
        $itemObj = $module_skeleton->getHandler('item')->get($item_id);
        if (empty($itemObj) || $itemObj->isNew()) {
            redirect_header('index.php', 3, _CO_MODULE_SKELETON_ERROR_NOITEM);
        }
        // get itemcategory
        $itemcategory_id = Module_skeletonRequest::getInt('itemcategory_id', $itemObj->getVar('item_category_id'));
        $itemcategoryObj = $module_skeleton->getHandler('itemcategory')->get($itemcategory_id);
        if (empty($itemcategoryObj)) {
            redirect_header('index.php', 3, _CO_MODULE_SKELETON_ERROR_NOITEMCATEGORY);
        }
        // check permissions
        $groups = is_object($xoopsUser) ? $xoopsUser->getGroups() : array(0 => XOOPS_GROUP_ANONYMOUS);
        if (!$groupperm_handler->checkRight('itemcategory_read', $itemcategory_id, $groups, $module_skeleton->getModule()->mid())) {
            if (in_array(XOOPS_GROUP_ANONYMOUS, $groups)) {
                redirect_header(XOOPS_URL . '/user.php', 3, _MD_MODULE_SKELETON_NEEDLOGINVIEW);
            } else {
                redirect_header('index.php', 3, _NOPERM);
            }
        }
        $form = $itemObj->getForm();
        $form->display();
        //
        include __DIR__ . '/footer.php';
        break;

    case 'item.save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            //redirect_header($currentFile, 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        $item_id = Module_skeletonRequest::getInt('item_id', 0, 'POST');
        $isNewItem = ($item_id == 0) ? true : false;
        $item_category_id = Module_skeletonRequest::getInt('item_category_id', 0, 'POST');
        $item_title = Module_skeletonRequest::getString('item_title', '', 'POST');

        $item_weight = Module_skeletonRequest::getInt('item_weight', 0, 'POST');
        $item_status = 0; // IN PROGRESS
        $item_version = 0; // IN PROGRESS
        $item_owner_uid = Module_skeletonRequest::getInt('item_owner_uid', 0, 'POST');
        $item_date = time();
        //
        $itemObj = $module_skeleton->getHandler('item')->get($item_id);
        //
        $itemObj->setVar('item_category_id', $item_category_id);
        $itemObj->setVar('item_title', $item_title);
        //
        $itemObj->setVar('item_weight', $item_weight);
        $itemObj->setVar('item_status', $item_status); // IN PROGRESS
        $itemObj->setVar('item_version', $item_version); // IN PROGRESS
        $itemObj->setVar('item_owner_uid', $item_owner_uid);
        $itemObj->setVar('item_date', $item_date);
        //
        $itemfieldObjs = $module_skeleton->getHandler('itemfield')->getObjects();
        //
        foreach ($itemfieldObjs as $itemfieldObj) {
            $value = $itemfieldObj->getValueForSave($itemObj, $_REQUEST[$itemfieldObj->getVar('itemfield_name')]);
            $itemObj->setVar($itemfieldObj->getVar('itemfield_name'), $value);
        }
        //
        if(!$module_skeleton->getHandler('item')->insert($itemObj)) {
            // ERROR
            xoops_cp_header();
            echo $itemObj->getHtmlErrors();
            xoops_cp_footer();
            exit();
        }
        $item_id = (int) $itemObj->getVar('item_id');
        //
        if ($isNewItem) {
            // Notify of new item
// IN PROGRESS
// IN PROGRESS
// IN PROGRESS
        } else {
            // Notify of item modified
// IN PROGRESS
// IN PROGRESS
// IN PROGRESS
        }
        //
        redirect_header($currentFile, 3, _CO_MODULE_SKELETON_ITEM_STORED);
        break;

    case 'item.delete':
        $item_id = Module_skeletonRequest::getInt('item_id', 0);
        $itemObj = $module_skeleton->getHandler('item')->get($item_id);
        if (!$itemObj) {
            redirect_header($currentFile, 3, _CO_MODULE_SKELETON_ERROR_NOITEM);
            exit();
        }
        if (Module_skeletonRequest::getBool('ok', false, 'POST') == true) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header($currentFile, 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($module_skeleton->getHandler('item')->delete($itemObj)) {
                redirect_header($currentFile, 3, _CO_MODULE_SKELETON_ITEM_DELETED);
            } else {
                // ERROR
                xoops_cp_header();
                echo $itemObj->getHtmlErrors();
                xoops_cp_footer();
                exit();
            }
        } else {
            xoops_cp_header();
            xoops_confirm(
                array('ok' => true, 'op' => 'item.delete', 'item_id' => $item_id),
                $_SERVER['REQUEST_URI'],
                _CO_MODULE_SKELETON_ITEM_DELETE_AREUSURE,
                _DELETE
            );
            xoops_cp_footer();
        }
        break;
    case 'item.delete.file':
        $item_id = Module_skeletonRequest::getInt('item_id', 0);
        $itemObj = $module_skeleton->getHandler('item')->get($item_id);
        // get item field name and file key
        $file_name_key = Module_skeletonRequest::getArray('delete_file_name_key', 0); // form value: delete_file_name_key[$itemfield_name][$file_key]
        $itemfield_names = array_keys($file_name_key);
        $itemfield_name = $itemfield_names[0];
        $file_keys = array_keys($file_name_key[$itemfield_name]);
        $file_key = $file_keys[0];
        // get file
        $files = json_decode($itemObj->getVar($itemfield_name), true);
        $file = $files[$file_key];
        // delete file from filesystem and from field
        $uploadDir = $module_skeleton->getConfig('uploadPath') . '/';
        @unlink($uploadDir . $file['savedfilename']);
        // delete file from field
        unset($files[$file_key]);
        $files = array_values($files);
        $itemObj->setVar($itemfield_name, json_encode($files));
        $module_skeleton->getHandler('item')->insert($itemObj);
        //
        $form = $itemObj->getForm();
        $form->display();
        //
        include __DIR__ . '/footer.php';
        break;
}
