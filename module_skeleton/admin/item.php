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

$op = Module_skeletonRequest::getString('op', 'items.list');
switch ($op) {
    default:
    case 'items.list':
    case 'items.filter':
        $filter_item_title_condition = Module_skeletonRequest::getString('filter_item_title_condition', '=');
        $filter_item_title = Module_skeletonRequest::getString('filter_item_title', '');
        $filter_itemcategory_title_condition = Module_skeletonRequest::getString('filter_itemcategory_title_condition', '=');
        $filter_itemcategory_title = Module_skeletonRequest::getString('filter_itemcategory_title', '');
        $filter_item_owner_uid = Module_skeletonRequest::getArray('filter_item_owner_uid', null);
        $filter_item_date = Module_skeletonRequest::getArray('filter_item_date', null);
        $filter_item_date_condition = Module_skeletonRequest::getString('filter_item_date_condition', '<');
        if ($op == 'items.filter') {
            if ($filter_item_title == '' && $filter_itemcategory_title == '' && is_null($filter_submitter)) {
                $op = 'items.list';
            }
        }
        //  admin navigation
        xoops_cp_header();
        $indexAdmin = new ModuleAdmin();
        echo $indexAdmin->addNavigation($currentFile);
        // buttons
        $adminMenu = new ModuleAdmin();
        $adminMenu->addItemButton(_CO_MODULE_SKELETON_BUTTON_ITEM_ADD, $currentFile . "?op=item.add", 'add');
        echo $adminMenu->renderButton();
        //
        xoops_load('xoopspagenav');
        $start = Module_skeletonRequest::getInt('start', 0);
        $itemcategoryCount = $module_skeleton->getHandler('itemcategory')->getCount();
        $categories = $module_skeleton->getHandler('itemcategory')->getObjects(null, true, false); // as array
        $itemCount = $module_skeleton->getHandler('item')->getCount();
        if ($itemCount > 0) {
            $itemCriteria = new CriteriaCompo();
            if ($op == 'items.filter') {
                // Evaluate item_title criteria
                if ($filter_item_title != '') {
                    if ($filter_item_title_condition == 'LIKE') {
                        $itemCriteria->add(new Criteria('item_title', "%{$filter_item_title}%", 'LIKE'));
                    } else {
                        $itemCriteria->add(new Criteria('item_title', $filter_item_title, '='));
                    }
                }
                // Evaluate item_category_id criteria
                if ($filter_itemcategory_title != '') {
                    if ($filter_itemcategory_title_condition == 'LIKE') {
                        $item_category_ids = $module_skeleton->getHandler('itemcategory')->getIds(new Criteria('itemcategory_title', "%{$filter_itemcategory_title}%", 'LIKE'));
                        $itemCriteria->add(new Criteria('item_category_id', '(' . implode(',', $item_category_ids) . ')', 'IN'));
                    } else {
                        $item_category_ids = $module_skeleton->getHandler('itemcategory')->getIds(new Criteria('itemcategory_title', $filter_itemcategory_title, '='));
                        $itemCriteria->add(new Criteria('item_category_id', '(' . implode(',', $item_category_ids) . ')', 'IN'));
                    }
                }
                // Evaluate item_owner_uid criteria
                if (!is_null($filter_item_owner_uid)) {
                    $itemCriteria->add(new Criteria('item_owner_uid', '(' . implode(',', $filter_item_owner_uid) . ')', 'IN'));
                }
                // Evaluate item_date criteria
                if (!empty($filter_item)) {
                    // TODO: IN PROGRESS
                }
            }
            $itemCriteria->setSort('item_date');
            $itemCriteria->setOrder('DESC');
            $itemCriteria->setStart($start);
            $itemCriteria->setLimit($module_skeleton->getConfig('admin_perpage'));
            $itemObjs = $module_skeleton->getHandler('item')->getObjects($itemCriteria, true, true);
            $itemCount = $module_skeleton->getHandler('item')->getCount();
            $GLOBALS['xoopsTpl']->assign('items_count', $itemCount);
            $pagenav = new XoopsPageNav($itemCount, $module_skeleton->getConfig('admin_perpage'), $start, 'start');
            $GLOBALS['xoopsTpl']->assign('items_pagenav', $pagenav->renderNav());
            if ($itemCount > 0) {
                foreach ($itemObjs as $item_id => $itemObj) {
                    $itemArray = $itemObj->getInfo();
                    $GLOBALS['xoopsTpl']->append('items', $itemArray);
                }
            }
            $GLOBALS['xoopsTpl']->assign('filter_item_title', $filter_item_title);
            $GLOBALS['xoopsTpl']->assign('filter_item_title_condition', $filter_item_title_condition);
            $GLOBALS['xoopsTpl']->assign('filter_itemcategory_title', $filter_itemcategory_title);
            $GLOBALS['xoopsTpl']->assign('filter_itemcategory_title_condition', $filter_itemcategory_title_condition);

            $item_owner_unameArrays = array();
            $item_owner_uidArrays = $module_skeleton->getHandler('item')->getAll(null, array('item_owner_uid'), false, false);
            foreach ($item_owner_uidArrays as $item_owner_uidArray) {
                $item_owner_unameArrays[$item_owner_uidArray['item_owner_uid']] = XoopsUserUtility::getUnameFromId($item_owner_uidArray['item_owner_uid']);
            }
            asort($item_owner_unameArrays);
            $item_owner_uid_select = new XoopsFormSelect('', 'filter_item_owner_uid', $filter_item_owner_uid, (count($item_owner_unameArrays) > 5) ? 5 : count($item_owner_unameArrays), true);
            foreach ($item_owner_unameArrays as $item_ownler_uid => $item_ownler_uname) {
                $item_owner_uid_select->addOption($item_ownler_uid, $item_ownler_uname);
            }
            $GLOBALS['xoopsTpl']->assign('filter_item_owner_uid_select', $item_owner_uid_select->render());

            $item_date_select = new XoopsFormDateTime (null, 'filter_date', 15, time(), false);
            $GLOBALS['xoopsTpl']->assign('filter_item_date_select', $item_date_select->render());
            $GLOBALS['xoopsTpl']->assign('filter_item_date_condition', $filter_item_date_condition);
        } else {
            // NOP
        }
        $GLOBALS['xoopsTpl']->display("db:{$module_skeleton->getModule()->dirname()}_admin_items_list.tpl");
        //
        include 'admin_footer.php';
        break;

    case 'item.new':
    case 'item.add':
    case 'item.edit':
        //  admin navigation
        xoops_cp_header();
        $indexAdmin = new ModuleAdmin();
        echo $indexAdmin->addNavigation($currentFile);
        // buttons
        $adminMenu = new ModuleAdmin();
        $adminMenu->addItemButton(_CO_MODULE_SKELETON_BUTTON_ITEMS_LIST, "{$currentFile}?op=items.list", 'list');
        echo $adminMenu->renderButton();
        //
        $item_id = Module_skeletonRequest::getInt('item_id', 0);
        if (!$itemObj = $module_skeleton->getHandler('item')->get($item_id)) {
            // ERROR
            redirect_header($currentFile, 3, _CO_MODULE_SKELETON_ERROR_NOITEM);
            exit();
        }
        $form = $itemObj->getForm();
        $form->display();
        //
        include 'admin_footer.php';
        break;

    case 'item.save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header($currentFile, 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        $item_id = Module_skeletonRequest::getInt('item_id', 0, 'POST');
        $isNewItem = ($item_id == 0) ? true : false;
        //
        $item_category_id = Module_skeletonRequest::getInt('item_category_id', 0, 'POST');
        $item_title = Module_skeletonRequest::getString('item_title', '', 'POST');
        $item_weight = Module_skeletonRequest::getInt('item_weight', 0, 'POST');
        $item_status = 0; // IN PROGRESS
        $item_version = 0; // IN PROGRESS
        $item_owner_uid = Module_skeletonRequest::getInt('item_owner_uid', 0, 'POST');
// IN PROGRESS
// IN PROGRESS
// IN PROGRESS
        $dateTimeObj = DateTime::createFromFormat(_SHORTDATESTRING, $_REQUEST['item_date']['date']);
        $dateTimeObj->setTime(0, 0, 0);
        $item_date = $dateTimeObj->getTimestamp() + $_REQUEST['item_date']['time'];
        unset($dateTimeObj);
// OR
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
        //  admin navigation
        xoops_cp_header();
        $indexAdmin = new ModuleAdmin();
        echo $indexAdmin->addNavigation($currentFile);
        // buttons
        $adminMenu = new ModuleAdmin();
        $adminMenu->addItemButton(_CO_MODULE_SKELETON_BUTTON_ITEMS_LIST, "{$currentFile}?op=items.list", 'list');
        echo $adminMenu->renderButton();
        //
        $form = $itemObj->getForm();
        $form->display();
        //
        include 'admin_footer.php';
        break;
}
