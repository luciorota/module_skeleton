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

$op = Module_skeletonRequest::getString('op', 'categories.list');
switch ($op) {
    default:
    case 'categories.list':
        //  admin navigation
        xoops_cp_header();
        $indexAdmin = new ModuleAdmin();
        echo $indexAdmin->addNavigation($currentFile);
        // buttons
        $adminMenu = new ModuleAdmin();
        $adminMenu->addItemButton(_CO_MODULE_SKELETON_BUTTON_ITEMCATEGORY_ADD, "{$currentFile}?op=itemcategory.add", 'add');
        echo $adminMenu->renderButton();
        //
        $itemcategoryCount = $module_skeleton->getHandler('itemcategory')->getCount();
        $GLOBALS['xoopsTpl']->assign('categories_count', $itemcategoryCount);
        if ($itemcategoryCount > 0) {
            $sortedItemcategories = module_skeleton_sortItemcategories(); // as array
            $GLOBALS['xoopsTpl']->assign('sorted_categories', $sortedItemcategories);
            $GLOBALS['xoopsTpl']->assign('token', $GLOBALS['xoopsSecurity']->getTokenHTML() );
        }
        $GLOBALS['xoopsTpl']->display("db:{$module_skeleton->getModule()->dirname()}_admin_itemcategories_list.tpl");
        //
        include 'admin_footer.php';
        break;

    case 'itemcategory.new':
    case 'itemcategory.add':
    case 'itemcategory.edit':
        //  admin navigation
        xoops_cp_header();
        $indexAdmin = new ModuleAdmin();
        echo $indexAdmin->addNavigation($currentFile);
        // buttons
        $adminMenu = new ModuleAdmin();
        $adminMenu->addItemButton(_CO_MODULE_SKELETON_BUTTON_ITEMCATEGORIES_LIST, "{$currentFile}?op=categories.list", 'list');
        echo $adminMenu->renderButton();
        //
        $itemcategory_id = Module_skeletonRequest::getInt('itemcategory_id', 0);
        if (!$itemcategoryObj = $module_skeleton->getHandler('itemcategory')->get($itemcategory_id)) {
            // ERROR
            redirect_header($currentFile, 3, _CO_MODULE_SKELETON_ERROR_NOITEMCATEGORY);
            exit();
        }
        $form = $itemcategoryObj->getForm();
        $form->display();
        //
        include 'admin_footer.php';
        break;

    case 'itemcategory.save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header($currentFile, 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        $itemcategory_id = Module_skeletonRequest::getInt('itemcategory_id', 0, 'POST');
        $isNewCategory = ($itemcategory_id == 0) ? true : false;
        $itemcategory_pid = Module_skeletonRequest::getInt('itemcategory_pid', 0, 'POST');
        $itemcategory_title = Module_skeletonRequest::getString('itemcategory_title', '', 'POST');
        $itemcategory_description = $_REQUEST['itemcategory_description']; //Module_skeletonRequest::getString('itemcategory_description', '', 'POST');
        //
        $itemcategory_weight = Module_skeletonRequest::getInt('itemcategory_weight', 0, 'POST');
        $itemcategory_status = 0; // IN PROGRESS
        $itemcategory_version = 0; // IN PROGRESS
        $itemcategory_owner_uid = Module_skeletonRequest::getInt('itemcategory_owner_uid', 0, 'POST');
        $itemcategory_date = time();
        //
        $itemcategoryObj = $module_skeleton->getHandler('itemcategory')->get($itemcategory_id);
        // a itemcategory can not be a child of itself
        if (!$itemcategoryObj->isNew()) {
            $itemcategoryObjs = $module_skeleton->getHandler('itemcategory')->getObjects();
            $itemcategoryObjsTree = new Module_skeletonObjectTree($itemcategoryObjs, 'itemcategory_id', 'itemcategory_pid');
            $childCategoryObjs = $itemcategoryObjsTree->getAllChild($itemcategory_id);
            //$childcats = $module_skeleton->getHandler('itemcategory')->getChildItemcategories($childitemcategoryObjs);
            if ($itemcategory_pid == $itemcategory_id || in_array($itemcategory_pid, array_keys($childCategoryObjs))) {
                // ERROR
                xoops_cp_header();
                $itemcategoryObj->setErrors(_AM_MODULE_SKELETON_ERROR_ITEMCATEGORY_CHILDASPARENT);
                echo $itemcategoryObj->getHtmlErrors();
                xoops_cp_footer();
                exit();
            }
        }
        //
        $itemcategoryObj->setVar('itemcategory_title', $itemcategory_title);
        $itemcategoryObj->setVar('itemcategory_description', $itemcategory_description);
        $itemcategoryObj->setVar('dohtml', isset($_POST['dohtml']));
        $itemcategoryObj->setVar('dosmiley', isset($_POST['dosmiley']));
        $itemcategoryObj->setVar('doxcode', isset($_POST['doxcode']));
        $itemcategoryObj->setVar('doimage', isset($_POST['doimage']));
        $itemcategoryObj->setVar('dobr', isset($_POST['dobr']));
        $itemcategoryObj->setVar('itemcategory_pid', $itemcategory_pid);
        //
        $itemcategoryObj->setVar('itemcategory_weight', $itemcategory_weight);
        $itemcategoryObj->setVar('itemcategory_status', $itemcategory_status); // IN PROGRESS
        $itemcategoryObj->setVar('itemcategory_version', $itemcategory_version); // IN PROGRESS
        $itemcategoryObj->setVar('itemcategory_owner_uid', $itemcategory_owner_uid);
        $itemcategoryObj->setVar('itemcategory_date', $itemcategory_date);
        //
        if (!$module_skeleton->getHandler('itemcategory')->insert($itemcategoryObj)) {
            // ERROR
            xoops_cp_header();
            echo $itemcategoryObj->getHtmlErrors();
            xoops_cp_footer();
            exit();
        }
        $itemcategory_id = (int) $itemcategoryObj->getVar('itemcategory_id');
        // save permissions
        $read_groups = Module_skeletonRequest::getArray('itemcategory_read', array(), 'POST');
        module_skeleton_savePermissions($read_groups, $itemcategory_id, 'itemcategory_read');
        $write_groups = Module_skeletonRequest::getArray('itemcategory_write', array(), 'POST');
        module_skeleton_savePermissions($write_groups, $itemcategory_id, 'itemcategory_write');
        //
        if ($isNewCategory) {
            // Notify of new itemcategory
// IN PROGRESS
// IN PROGRESS
// IN PROGRESS
        } else {
            // Notify of itemcategory modified
// IN PROGRESS
// IN PROGRESS
// IN PROGRESS
        }
        //
        redirect_header($currentFile, 3, _CO_MODULE_SKELETON_ITEMCATEGORY_STORED);
        break;

    case 'itemcategory.delete':
        $itemcategory_id = Module_skeletonRequest::getInt('itemcategory_id', 0);
        $itemcategoryObj = $module_skeleton->getHandler('itemcategory')->get($itemcategory_id);
        if (!$itemcategoryObj) {
            redirect_header($currentFile, 3, _CO_MODULE_SKELETON_ERROR_NOITEMCATEGORY);
            exit();
        }
        if (Module_skeletonRequest::getBool('ok', false, 'POST') == true) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header($currentFile, 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($module_skeleton->getHandler('itemcategory')->delete($itemcategoryObj)) {
                redirect_header($currentFile, 3, _CO_MODULE_SKELETON_ITEMCATEGORY_DELETED);
            } else {
                // ERROR
                xoops_cp_header();
                echo $itemcategoryObj->getHtmlErrors();
                xoops_cp_footer();
                exit();
            }
        } else {
            xoops_cp_header();
            xoops_confirm(
                array('ok' => true, 'op' => 'itemcategory.delete', 'itemcategory_id' => $itemcategory_id),
                $_SERVER['REQUEST_URI'],
                _CO_MODULE_SKELETON_ITEMCATEGORY_DELETE_AREUSURE,
                _DELETE
            );
            xoops_cp_footer();
        }
        break;

    case 'itemcategory.move':
        $itemcategory_id = Module_skeletonRequest::getInt('itemcategory_id', 0);
        if (Module_skeletonRequest::getBool('ok', false, 'POST') == true) {
            $source_category_id = Module_skeletonRequest::getInt('source_category_id', 0, 'POST');
            $target_category_id = Module_skeletonRequest::getInt('target_category_id', 0, 'POST');
            if ($target_category_id == $source_category_id) {
                redirect_header($currentFile . "?op=itemcategory.move&amp;ok=0&amp;itemcategory_id={$source_category_id}", 3, _AM_MODULE_SKELETON_ITEMCATEGORY_MODIFY_FAILED);
            }
            if (!$target_category_id) {
                redirect_header($currentFile . "?op=itemcategory.move&amp;ok=0&amp;itemcategory_id={$source_category_id}", 3, _AM_MODULE_SKELETON_ITEMCATEGORY_MODIFY_FAILEDT);
            }
            $move = $module_skeleton->getHandler('item')->updateAll("item_category_id", $target_category_id, new Criteria('item_category_id', $source_category_id), true);
            if (!$move) {
                $error = _AM_MODULE_SKELETON_DBERROR;
                trigger_error($error, E_USER_ERROR);
            }
            redirect_header($currentFile, 3, _AM_MODULE_SKELETON_ITEMCATEGORY_MODIFY_MOVED);
            exit();
        } else {
            xoops_cp_header();
            //
            xoops_load('XoopsFormLoader');
            //
            $form = new XoopsThemeForm(_CO_MODULE_SKELETON_BUTTON_ITEMS_MOVE, 'itemcategorymoveform', xoops_getenv('PHP_SELF'));
            // move: target_category_id
            $sourceItemcategoryObj = $module_skeleton->getHandler('itemcategory')->get($itemcategory_id);
            $itemcategoryObjs = $module_skeleton->getHandler('itemcategory')->getObjects();
            $itemcategoryObjsTree = new Module_skeletonObjectTree($itemcategoryObjs, 'itemcategory_id', 'itemcategory_pid');
            $target_category_id_select = new XoopsFormLabel(_CO_MODULE_SKELETON_ITEMCATEGORY_MOVE_ITEMS_TO, $itemcategoryObjsTree->makeSelBox('target_category_id', 'itemcategory_title'));
            $target_category_id_select->setDescription(_CO_MODULE_SKELETON_ITEMCATEGORY_MOVE_ITEMS_TO_DESC);
            $form->addElement($target_category_id_select);
            // form: button tray
            $button_tray = new XoopsFormElementTray('', '');
            $button_tray->addElement(new XoopsFormHidden('source_category_id', $itemcategory_id));
            $button_tray->addElement(new XoopsFormHidden('ok', true));
            $button_tray->addElement(new XoopsFormHidden('op', 'itemcategory.move'));
            //
            $button_save = new XoopsFormButton('', '',_CO_MODULE_SKELETON_BUTTON_ITEMS_MOVE, 'submit');
            $button_save->setExtra('onclick="this.form.elements.op.value=\'itemcategory.move\'"');
            $button_tray->addElement($button_save);
            //
            $button_cancel = new XoopsFormButton('', '', _CANCEL, 'submit');
            $button_cancel->setExtra('onclick="this.form.elements.op.value=\'cancel\'"');
            $button_tray->addElement($button_cancel);
            //
            $form->addElement($button_tray);
            $form->display();
            //
            xoops_cp_footer();
        }
        break;

    case 'categories.reorder':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header($currentFile, 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors() ));
        }

        if (isset($_POST['new_itemcategory_weights']) && count($_POST['new_itemcategory_weights']) > 0) {
            $new_itemcategory_weights = $_POST['new_itemcategory_weights'];
            $ids = array();
            foreach ($new_itemcategory_weights as $itemcategory_id => $new_itemcategory_weight) {
                $itemcategoryObj = $module_skeleton->getHandler('itemcategory')->get($itemcategory_id);
                $itemcategoryObj->setVar('itemcategory_weight', $new_itemcategory_weight);
                if (!$module_skeleton->getHandler('itemcategory')->insert($itemcategoryObj)) {
                    redirect_header($currentFile, 3, $itemcategoryObj->getErrors());
                }
                unset($itemcategoryObj);
            }
            redirect_header($currentFile, 3, _CO_MODULE_SKELETON_ITEMCATEGORIES_REORDERED);
            exit();
        }
        break;
}
