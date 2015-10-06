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
include_once __DIR__ . '/header.php';

$groups = is_object($xoopsUser) ? $xoopsUser->getGroups() : array(0 => XOOPS_GROUP_ANONYMOUS);

// get item_id
$item_id = XoopsRequest::getInt('item_id', 0);

// get itemObj
$itemObj = $module_skeletonHelper->getHandler('item')->get($item_id);
if (empty($itemObj)) {
    redirect_header('index.php', 3, _CO_MODULE_SKELETON_ERROR_NOITEM);
}

$item = $itemObj->getInfo();

// get itemcategory_id
$itemcategory_id = $item['item_category_id'];

// get itemcategory
if ($itemcategory_id != 0) {
    $itemcategoryObj = $module_skeletonHelper->getHandler('itemcategory')->get($itemcategory_id);
    if (empty($itemcategoryObj) || $itemcategoryObj->isNew()) {
        redirect_header('index.php', 3, _CO_MODULE_SKELETON_ERROR_NOITEMCATEGORY);
    }
    $itemcategory = $itemcategoryObj->getInfo();
// IN PROGRESS
// IN PROGRESS
// IN PROGRESS
} else {
    $itemcategory = array();
    $itemcategory['id'] = 0;
    $itemcategory['itemcategory_id'] = 0;
    $itemcategory['itemcategory_title'] = _CO_MODULE_SKELETON_ITEMCATEGORY_ROOT; // IN PROGRESS
    $itemcategory['itemcategory_title_html'] = $myts->htmlSpecialChars($itemcategory['itemcategory_title']);
    $itemcategory['itemcategory_description'] = _CO_MODULE_SKELETON_ITEMCATEGORY_ROOT_DESC;
    $itemcategory['itemcategory_description_html'] = $myts->htmlSpecialChars($itemcategory['itemcategory_description']);
// IN PROGRESS
// IN PROGRESS
// IN PROGRESS
}

// check permissions
if (!$groupperm_handler->checkRight('itemcategoryRead', $itemcategory_id, $groups, $module_skeletonHelper->getModule()->mid())) {
    if (in_array(XOOPS_GROUP_ANONYMOUS, $groups)) {
        redirect_header(XOOPS_URL . '/user.php', 3, _MD_MODULE_SKELETON_NEEDLOGINVIEW);
    } else {
        redirect_header('index.php', 3, _NOPERM);
    }
}

// get write/read permissions
$itemcategory_write_ids = $groupperm_handler->getItemIds('itemcategoryWrite', $groups, $module_skeletonHelper->getModule()->mid()); // array
$itemcategory_read_ids = $groupperm_handler->getItemIds('itemcategoryRead', $groups, $module_skeletonHelper->getModule()->mid()); // array

// get itemcategories tree
$itemcategoryCriteria = new CriteriaCompo();
$itemcategoryCriteria->add(new Criteria('itemcategory_id', '(' . implode(',', $itemcategory_read_ids) . ')', 'IN'));
$itemcategoryObjs = $module_skeletonHelper->getHandler('itemcategory')->getObjects($itemcategoryCriteria, true);
$itemcategoryObjsTree = new XoopsObjectTree($itemcategoryObjs, 'itemcategory_id', 'itemcategory_pid');

// get first childs and all parents
$childItemcategoryObjs = $itemcategoryObjsTree->getFirstChild($itemcategory_id);
$parentItemcategoryObjs = $itemcategoryObjsTree->getAllParent($itemcategory_id);



// load template
$xoopsOption['template_main'] = "{$module_skeletonHelper->getModule()->dirname()}_item.tpl";
include XOOPS_ROOT_PATH . '/header.php';

$xoTheme->addScript(XOOPS_URL . '/browse.php?Frameworks/jquery/jquery.js');
$xoTheme->addStylesheet(MODULE_SKELETON_URL . '/assets/css/module.css');

$xoopsTpl->assign('module_skeleton_url', MODULE_SKELETON_URL . '/');

// template: module_skeleton_breadcrumb
$breadcrumb = new Module_skeletonBreadcrumb();
$breadcrumb->addLink($module_skeletonHelper->getModule()->getVar('name'), MODULE_SKELETON_URL);
if ($itemcategory_id != 0) {
    $breadcrumb->addLink(_CO_MODULE_SKELETON_ITEMCATEGORY_ROOT, MODULE_SKELETON_URL . '/itemcategory.php');
    foreach (array_reverse($parentItemcategoryObjs) as $parentItemcategoryObj) {
        $breadcrumb->addLink($parentItemcategoryObj->getVar('itemcategory_title'), '?itemcategory_id=' . $parentItemcategoryObj->getVar('itemcategory_id'));
    }
}
$breadcrumb->addLink($itemcategory['itemcategory_title'], MODULE_SKELETON_URL . '/itemcategory.php?itemcategory_id=' . $itemcategory['itemcategory_id']);
$breadcrumb->addLink($item['item_title'], '');
$xoopsTpl->assign('module_skeleton_breadcrumb', $breadcrumb->render());

// IN PROGRESS
// IN PROGRESS
// IN PROGRESS

$op = XoopsRequest::getString('op', 'item.add');
switch ($op) {
    default:
    case 'items.list':
        $apply_filter = XoopsRequest::getBool('apply_filter', false);
        $itemcategoryCount = $module_skeletonHelper->getHandler('itemcategory')->getCount();
        $categories = $module_skeletonHelper->getHandler('itemcategory')->getObjects(null, true, false); // as array
        $itemCount = $module_skeletonHelper->getHandler('item')->getCount();
        $GLOBALS['xoopsTpl']->assign('itemCount', $itemCount);
        if ($itemCount > 0) {
            // get filter parameters
            $item_first_letter = XoopsRequest::getString('item_first_letter', '');
// IN PROGRESS
// IN PROGRESS
// IN PROGRESS
            $itemCriteria = new CriteriaCompo();
            $itemCriteria->add(new Criteria('item_category_id', '(' . implode(',', $itemcategory_read_ids) . ')', 'IN'));
            if ($apply_filter == true) {
                // evaluate item_first_letter criteria
                if ($item_first_letter != '') {
                    $itemCriteria->add(new Criteria('LEFT(item_title,1)', $item_first_letter));
                }
            }
            $GLOBALS['xoopsTpl']->assign('apply_filter', $apply_filter);
            $itemFilterCount = $module_skeletonHelper->getHandler('item')->getCount($itemCriteria);
            $GLOBALS['xoopsTpl']->assign('itemFilterCount', $itemFilterCount);
            //
            $itemCriteria->setSort('item_date');
            $itemCriteria->setOrder('DESC');
            //
            $start = XoopsRequest::getInt('start', 0);
            $limit = $module_skeletonHelper->getConfig('userPerpage');
            $itemCriteria->setStart($start);
            $itemCriteria->setLimit($limit);
            //
            if ($itemFilterCount > $limit) {
                xoops_load('xoopspagenav');
                $linklist = "op={$op}";
                $linklist .= "&item_first_letter={$item_first_letter}";
                $pagenav = new XoopsPageNav($itemFilterCount, $limit, $start, 'start', $linklist);
                $pagenav = $pagenav->renderNav(4);
            } else {
                $pagenav = '';
            }
            $GLOBALS['xoopsTpl']->assign('items_pagenav', $pagenav);
            //
            $GLOBALS['xoopsTpl']->assign('token', $GLOBALS['xoopsSecurity']->getTokenHTML());
            $itemObjs = $module_skeletonHelper->getHandler('item')->getObjects($itemCriteria, true, true);
            $items = $module_skeletonHelper->getHandler('item')->getObjects($itemCriteria, true, false); // as array
            // fill items array
            foreach ($itemObjs as $item_id => $itemObj) {
                $itemArray = $itemObj->getInfo();
                $GLOBALS['xoopsTpl']->append('items', $itemArray);
            }




// IN PROGRESS
// IN PROGRESS
// IN PROGRESS

        } else {
            // NOP
        }








        //
        include __DIR__ . '/footer.php';

    case 'item.view':
        $item = $itemObj->getInfo();

// IN PROGRESS
// IN PROGRESS
// IN PROGRESS

        echo print_r($item,true);
        //
        include __DIR__ . '/footer.php';
        break;

    case 'item.add':
    case 'item.edit':
//exit("debug");
        // get item
        $item_id = XoopsRequest::getInt('item_id', 0);
        if (!$itemObj = $module_skeletonHelper->getHandler('item')->get($item_id)) {
            // ERROR
            redirect_header($currentFile, 3, _CO_MODULE_SKELETON_ERROR_NOITEM);
            exit();
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
        $item_id = XoopsRequest::getInt('item_id', 0, 'POST');
        $isNewItem = ($item_id == 0) ? true : false;
        $item_category_id = XoopsRequest::getInt('item_category_id', 0, 'POST');
        $item_title = XoopsRequest::getString('item_title', '', 'POST');

        $item_weight = XoopsRequest::getInt('item_weight', 0, 'POST');
        $item_status = 0; // IN PROGRESS
        $item_version = 0; // IN PROGRESS
        $item_owner_uid = XoopsRequest::getInt('item_owner_uid', 0, 'POST');
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
        $itemObj = $module_skeletonHelper->getHandler('item')->get($item_id);
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
        $itemfieldObjs = $module_skeletonHelper->getHandler('itemfield')->getObjects();
        //
        foreach ($itemfieldObjs as $itemfieldObj) {
            $value = $itemfieldObj->getValueForSave($itemObj, $_REQUEST[$itemfieldObj->getVar('itemfield_name')]);
            $itemObj->setVar($itemfieldObj->getVar('itemfield_name'), $value);
        }
        //
        if(!$module_skeletonHelper->getHandler('item')->insert($itemObj)) {
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
        $item_id = XoopsRequest::getInt('item_id', 0);
        $itemObj = $module_skeletonHelper->getHandler('item')->get($item_id);
        if (!$itemObj) {
            redirect_header($currentFile, 3, _CO_MODULE_SKELETON_ERROR_NOITEM);
            exit();
        }
        if (XoopsRequest::getBool('ok', false, 'POST') == true) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header($currentFile, 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($module_skeletonHelper->getHandler('item')->delete($itemObj)) {
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
                array('ok' => true, 'op' => $op, 'item_id' => $item_id),
                $_SERVER['REQUEST_URI'],
                _CO_MODULE_SKELETON_ITEM_DELETE_AREUSURE,
                _DELETE
            );
            xoops_cp_footer();
        }
        break;
    case 'item.delete.file':
        $item_id = XoopsRequest::getInt('item_id', 0);
        $itemObj = $module_skeletonHelper->getHandler('item')->get($item_id);
        // get item field name and file key
        $file_name_key = XoopsRequest::getArray('delete_file_name_key', 0); // form value: delete_file_name_key[$itemfield_name][$file_key]
        $itemfield_names = array_keys($file_name_key);
        $itemfield_name = $itemfield_names[0];
        $file_keys = array_keys($file_name_key[$itemfield_name]);
        $file_key = $file_keys[0];
        // get file
        $files = json_decode($itemObj->getVar($itemfield_name), true);
        $file = $files[$file_key];
        // delete file from filesystem and from field
        $uploadDir = $module_skeletonHelper->getConfig('uploadPath') . '/';
        @unlink($uploadDir . $file['savedfilename']);
        // delete file from field
        unset($files[$file_key]);
        $files = array_values($files);
        $itemObj->setVar($itemfield_name, json_encode($files));
        $module_skeletonHelper->getHandler('item')->insert($itemObj);
        //
        $form = $itemObj->getForm();
        $form->display();
        //
        include __DIR__ . '/footer.php';
        break;
}
