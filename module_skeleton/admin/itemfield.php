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

// IN PROGRESS
// IN PROGRESS
// IN PROGRESS
error_log(print_r($module_skeleton->getHandler('itemfield')->getExtraItemfieldTypesList(),true));

//$op = Module_skeletonRequest::getString('op', 'itemfields.list');
$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : (isset($_REQUEST['itemfield_id']) ? 'itemfield.edit' : 'itemfields.list');
switch ($op) {
    default:
    case 'itemfields.list':
        $datatypes = $module_skeleton->getHandler('itemfield')->getDataTypes(); // array of data types
        $itemfieldtypes = $module_skeleton->getHandler('itemfield')->getStandardItemfieldTypesList();  // array of itemfield types
        //  admin navigation
        xoops_cp_header();
        $indexAdmin = new ModuleAdmin();
        echo $indexAdmin->addNavigation($currentFile);
        // buttons
        $adminMenu = new ModuleAdmin();
        $adminMenu->addItemButton(_CO_MODULE_SKELETON_BUTTON_ITEMFIELD_ADD, $currentFile . "?op=itemfield.add", 'add');
        echo $adminMenu->renderButton();
        //
        $itemfieldCriteria = new CriteriaCompo();
        $itemfieldCriteria->setSort('itemfield_weight');
        $itemfieldCriteria->setOrder('DESC');
        $itemfieldCount = $module_skeleton->getHandler('itemfield')->getCount();
        $GLOBALS['xoopsTpl']->assign('itemfields_count', $itemfieldCount);
        //$itemfields = $module_skeleton->getHandler('itemfield')->getObjects($itemfieldCriteria, true, false); // as array
        $itemfieldObjs = $module_skeleton->getHandler('itemfield')->getObjects($itemfieldCriteria, true, true); // as array
/*
        foreach (array_keys($itemfields) as $i) {
            $itemfields[$i]['canEdit'] = $itemfields[$i]['itemfield_config'] || $itemfields[$i]['itemfield_show'] || $itemfields[$i]['itemfield_edit'];
            $itemfields[$i]['canDelete'] = $itemfields[$i]['itemfield_config'];
            $itemfields[$i]['itemfieldtype'] = $itemfieldtypes[$itemfields[$i]['itemfield_type']];
            $itemfields[$i]['datatype'] = $datatypes[$itemfields[$i]['itemfield_datatype']];
            $GLOBALS['xoopsTpl']->append('itemfields', $itemfields[$i]);
        }
*/
        if ($itemfieldCount > 0) {
            foreach ($itemfieldObjs as $itemfield_id => $itemfieldObj) {
                $itemfieldArray = $itemfieldObj->getInfo();
                $GLOBALS['xoopsTpl']->append('itemfields', $itemfieldArray);
            }
        }

        $GLOBALS['xoopsTpl']->assign('token', $GLOBALS['xoopsSecurity']->getTokenHTML());
        $GLOBALS['xoopsTpl']->display("db:{$module_skeleton->getModule()->dirname()}_admin_itemfields_list.tpl");
        //
        include 'admin_footer.php';
        break;

    case 'itemfield.new':
    case 'itemfield.add':
        //  admin navigation
        xoops_cp_header();
        $indexAdmin = new ModuleAdmin();
        echo $indexAdmin->addNavigation($currentFile);
        // buttons
        $adminMenu = new ModuleAdmin();
        $adminMenu->addItemButton(_CO_MODULE_SKELETON_BUTTON_ITEMFIELDS_LIST, "{$currentFile}?op=itemfields.list", 'list');
        echo $adminMenu->renderButton();
        //
        $itemfieldObj = $module_skeleton->getHandler('itemfield')->create();
        //include_once '../include/forms.php';
        $form = $itemfieldObj->getForm();//$form = module_skeleton_getFieldForm($itemfieldObj, $currentFile);
        $form->display();
        //
        include 'admin_footer.php';
        break;

    case 'itemfield.edit':
        //  admin navigation
        xoops_cp_header();
        $indexAdmin = new ModuleAdmin();
        echo $indexAdmin->addNavigation($currentFile);
        // buttons
        $adminMenu = new ModuleAdmin();
        $adminMenu->addItemButton(_CO_MODULE_SKELETON_BUTTON_ITEMFIELDS_LIST, "{$currentFile}?op=itemfields.list", 'list');
        echo $adminMenu->renderButton();
        //
        $itemfield_id = Module_skeletonRequest::getInt('itemfield_id', 0);
        if (!$itemfieldObj = $module_skeleton->getHandler('itemfield')->get($itemfield_id)) {
            // ERROR
            redirect_header($currentFile, 3, _CO_MODULE_SKELETON_ERROR_NOITEMFIELD);
            exit();
        }
        if (!$itemfieldObj->getVar('itemfield_config') && !$itemfieldObj->getVar('itemfield_show') && !$itemfieldObj->getVar('itemfield_edit')) {
            // if no configs exist
            redirect_header($currentFile, 3, _AM_MODULE_SKELETON_FIELDNOTCONFIGURABLE);
        }
        //include_once '../include/forms.php';
        $form = $itemfieldObj->getForm();//$form = module_skeleton_getFieldForm($itemfieldObj, $currentFile);
        $form->display();
        //
        include 'admin_footer.php';
        break;

    case 'itemfield.save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header($currentFile, 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        $redirectToEditForm = false;
        $itemfield_id = Module_skeletonRequest::getInt('itemfield_id', 0, 'POST');
        $isNewItemfield = ($itemfield_id == 0) ? true : false;
        //
        $itemfield_category_id = Module_skeletonRequest::getInt('itemfield_category_id', 0, 'POST');
        $itemfield_weight = Module_skeletonRequest::getInt('itemfield_weight', 0, 'POST');
        $itemfield_type = $_REQUEST['itemfield_type']; // IN PROGRESS
// IN PROGRESS
// IN PROGRESS
// IN PROGRESS
        //
        $itemfieldObj = $module_skeleton->getHandler('itemfield')->get($itemfield_id);
        //
        if ($isNewItemfield) {
            $itemfieldObj->setVar('itemfield_name', Module_skeletonRequest::getString('itemfield_name', ''));
            $itemfieldObj->setVar('itemfield_show', true);
            $itemfieldObj->setVar('itemfield_edit', true);
            $itemfieldObj->setVar('itemfield_config', true);
            $redirectToEditForm = true;
        } else {
// ???
            if (!$itemfieldObj->getVar('itemfield_config') && !$itemfieldObj->getVar('itemfield_show') && !$itemfieldObj->getVar('itemfield_edit')) { // If no configs exist
                redirect_header($currentFile, 3, _AM_MODULE_SKELETON_FIELDNOTCONFIGURABLE);
            }
        }
        $itemfieldObj->setVar('itemfield_title', Module_skeletonRequest::getString('itemfield_title', ''));
        $itemfieldObj->setVar('itemfield_description', $_REQUEST['itemfield_description']);
        //
        // if itemfield type is changed...
        if ($itemfieldObj->getVar('itemfield_type') != $itemfield_type) {
            // ... reset default, options, typeconfigs
            $itemfieldObj->setVar('itemfield_typeconfigs', array());
            $itemfieldObj->setVar('itemfield_options', array());
            $redirectToEditForm = true;
        } else {
            if ($itemfieldObj->getVar('itemfield_config') == true) {
                $itemfield_options = $itemfieldObj->getVar('itemfield_options');
                $removeOptions = Module_skeletonRequest::getArray('removeOptions', array());
                if (!empty($removeOptions)) {
                    foreach ($removeOptions as $key) {
                        unset($itemfield_options[$key]);
                    }
                    $redirectToEditForm = true;
                }
                $addOptions = Module_skeletonRequest::getArray('addOptions', array());
                if (!empty($addOptions)) {
                    foreach ($addOptions as $option) {
                        if (empty($option['value'])) continue;
                        $itemfield_options[$option['key']] = $option['value'];
                        $redirectToEditForm = true;
                    }
                }
                $itemfieldObj->setVar('itemfield_options', $itemfield_options);
                //
                $itemfield_typeconfigs = Module_skeletonRequest::getArray('itemfield_typeconfigs', array());
                if (!empty($itemfield_typeconfigs)) {
                    $itemfieldObj->setVar('itemfield_typeconfigs', $itemfield_typeconfigs);
                    $redirectToEditForm = false;
                }
    // IN PROGRESS
    // IN PROGRESS
    // IN PROGRESS
            }
        }
        //
        if ($itemfieldObj->getVar('itemfield_edit') == true) {
            $itemfieldObj->setVar('itemfield_required', Module_skeletonRequest::getBool('itemfield_required', false));
        }
        if ($itemfieldObj->getVar('itemfield_edit') == true) {
            if (isset($_REQUEST['itemfield_default'])) {
                $itemfield_default = $itemfieldObj->getValueForSave($_REQUEST['itemfield_default']);
                //Check for multiple selections
                if (is_array($itemfield_default)) {
                    $itemfieldObj->setVar('itemfield_default', serialize($itemfield_default));
                } else {
                    $itemfieldObj->setVar('itemfield_default', $itemfield_default);
                }
            }
        }
        //
        $itemfieldObj->setVar('itemfield_category_id', $itemfield_category_id);
        $itemfieldObj->setVar('itemfield_weight', $itemfield_weight);
        $itemfieldObj->setVar('itemfield_type', $itemfield_type);
        if (isset($_REQUEST['itemfield_datatype'])) {
            $itemfieldObj->setVar('itemfield_datatype', $_REQUEST['itemfield_datatype']);
        }
        //
        if (!$module_skeleton->getHandler('itemfield')->insert($itemfieldObj)) {
            // ERROR
            //  admin navigation
            xoops_cp_header();
            $indexAdmin = new ModuleAdmin();
            echo $indexAdmin->addNavigation($currentFile);
            // buttons
            $adminMenu = new ModuleAdmin();
            $adminMenu->addItemButton(_CO_MODULE_SKELETON_BUTTON_ITEMFIELDS_LIST, "{$currentFile}?op=itemfields.list", 'list');
            echo $adminMenu->renderButton();
            //
            echo $itemfieldObj->getHtmlErrors();
            //include_once '../include/forms.php';
            $form = $itemfieldObj->getForm();//$form = module_skeleton_getFieldForm($itemfieldObj, $currentFile);
            $form->display();
            //
            include 'admin_footer.php';
            exit();
        }
        $itemfield_id = (int) $itemfieldObj->getVar('itemfield_id');
        // save permissions
        $read_groups = Module_skeletonRequest::getArray('itemfield_read', array(), 'POST');
        module_skeleton_savePermissions($read_groups, $itemfield_id, 'itemfield_read');
        if ($itemfieldObj->getVar('itemfield_edit') || $itemfieldObj->isNew()) {
            $write_groups = Module_skeletonRequest::getArray('itemfield_write', array(), 'POST');
            module_skeleton_savePermissions($write_groups, $itemfield_id, 'itemfield_write');
        }
        if (in_array($itemfieldObj->getVar('itemfield_type'), $module_skeleton->getHandler('itemfield')->getSearchableTypes())) {
            $search_groups = Module_skeletonRequest::getArray('itemfield_search', array(), 'POST');
            module_skeleton_savePermissions($search_groups, $itemfield_id, 'itemfield_search');
        }
        //
        if ($redirectToEditForm == true) {
            redirect_header($currentFile . "?op=itemfield.edit&amp;itemfield_id={$itemfield_id}", 3, _CO_MODULE_SKELETON_ITEMFIELD_STORED_EDIT);
        } else {
            redirect_header($currentFile, 3, _CO_MODULE_SKELETON_ITEMFIELD_STORED);
        }
        break;

    case 'itemfield.delete':
        $itemfield_id = Module_skeletonRequest::getInt('itemfield_id', 0);
        $itemfieldObj = $module_skeleton->getHandler('itemfield')->get($itemfield_id);
        if (!$itemfieldObj) {
            redirect_header($currentFile, 3, _CO_MODULE_SKELETON_ERROR_NOITEMFIELD);
            exit();
        }
        if (!$itemfieldObj->getVar('itemfield_config')) {
            redirect_header('index.php', 3, _AM_MODULE_SKELETON_FIELDNOTCONFIGURABLE);
        }
        if (Module_skeletonRequest::getBool('ok', false, 'POST') == true) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header($currentFile, 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($module_skeleton->getHandler('itemfield')->delete($itemfieldObj)) {
                redirect_header($currentFile, 3, _CO_MODULE_SKELETON_ITEMFIELD_DELETED);
            } else {
                // ERROR
                xoops_cp_header();
                echo $itemfieldObj->getHtmlErrors();
                xoops_cp_footer();
                exit();
            }
        } else {
            xoops_cp_header();
            xoops_confirm(
                array('ok' => true, 'itemfield_id' => $itemfield_id, 'op' => 'itemfield.delete'),
                $_SERVER['REQUEST_URI'],
                _CO_MODULE_SKELETON_ITEMFIELD_DELETE_AREUSURE,
                _DELETE
            );
            xoops_cp_footer();
        }
        break;

    case 'itemfields.reorder':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header($currentFile, 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if (isset($_POST['itemfield_ids']) && count($_POST['itemfield_ids']) > 0) {
            $oldweight = $_POST['oldweight'];
            $weight = $_POST['weight'];
            $ids = array();
            foreach ($_POST['itemfield_ids'] as $itemfield_id) {
                if ($oldweight[$itemfield_id] != $weight[$itemfield_id]) {
                    // if itemfield has changed
                    $ids[] = (int) $itemfield_id;
                }
            }
            if (count($ids) > 0) {
                $errors = array();
                // if there are changed itemfields, fetch the itemfielditemcategory objects
                $itemfields = $module_skeleton->getHandler('itemfield')->getObjects(new Criteria('itemfield_id', '(' . implode(',', $ids) . ')', 'IN'), true);
                foreach ($ids as $id) {
                    $itemfields[$id]->setVar('itemfield_weight', (int) $weight[$id]);
                    if (!$module_skeleton->getHandler('itemfield')->insert($itemfields[$id])) {
                        $errors = array_merge($errors, $itemfields[$id]->getErrors());
                    }
                }
                if (count($errors) == 0) {
                    // no errors
                    redirect_header($currentFile, 3, _CO_MODULE_SKELETON_ITEMFIELDS_REORDERED);
                } else {
                    redirect_header($currentFile, 3, implode('<br />', $errors));
                }
            }
        }
        break;

    case 'itemfield.toggle':
        if (isset($_REQUEST['itemfield_id'])) {
            $itemfield_id = (int) $_REQUEST['itemfield_id'];
            if (isset($_REQUEST['itemfield_required'])) {
                $itemfield_required = (int) $_REQUEST['itemfield_required'];
                module_skeleton_visible_toggle($itemfield_id, $itemfield_required);
            }
        }
        break;
}

/**
 * @param int               $itemfield_id
 * @param bool              $itemfield_required
 */
function module_skeleton_visible_toggle($itemfield_id, $itemfield_required)
{
    $currentFile = basename(__FILE__);
    $module_skeleton = Module_skeletonModule_skeleton::getInstance();
    //
    $itemfield_required = !$itemfield_required;
    $itemfieldObj = $module_skeleton->getHandler('itemfield')->get($itemfield_id);
    $itemfieldObj->setVar('itemfield_required', $itemfield_required);
    if ($module_skeleton->getHandler('itemfield')->insert($itemfieldObj, true)) {
        redirect_header($currentFile, 3, _AM_MODULE_SKELETON_REQUIRED_TOGGLE_SUCCESS);
    } else {
        redirect_header($currentFile, 3, _AM_MODULE_SKELETON_REQUIRED_TOGGLE_FAILED);
    }
}
