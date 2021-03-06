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
//
// get itemcategory id & itemcategoryObj & itemcategory
$itemcategory_id = XoopsRequest::getInt('itemcategory_id', 0);
if ($itemcategory_id != 0) {
    $itemcategoryObj = $module_skeletonHelper->getHandler('itemcategory')->get($itemcategory_id);
    if (empty($itemcategoryObj) || $itemcategoryObj->isNew()) {
        redirect_header('index.php', 3, _CO_MODULE_SKELETON_ERROR_NOITEMCATEGORY);
    }
    $itemcategory = $itemcategoryObj->getInfo();
} else {
    // ROOT/MAIN category
    $itemcategory = array();
    $itemcategory['id'] = 0;
    $itemcategory['itemcategory_id'] = 0;
    $itemcategory['itemcategory_title'] = _CO_MODULE_SKELETON_ITEMCATEGORY_ROOT; // IN PROGRESS
    $itemcategory['itemcategory_title_html'] = $myts->htmlSpecialChars($itemcategory['itemcategory_title']);
    $itemcategory['itemcategory_description'] = _CO_MODULE_SKELETON_ITEMCATEGORY_ROOT_DESC;
    $itemcategory['itemcategory_description_html'] = $myts->htmlSpecialChars($itemcategory['itemcategory_description']);
}
//
// check permissions
if ($itemcategory_id != 0) {
    if (!$groupperm_handler->checkRight('itemcategoryRead', $itemcategory_id, $groups, $module_skeletonHelper->getModule()->mid())) {
        if (in_array(XOOPS_GROUP_ANONYMOUS, $groups)) {
            redirect_header(XOOPS_URL . '/user.php', 3, _MD_MODULE_SKELETON_NEEDLOGINVIEW);
        } else {
            redirect_header('index.php', 3, _NOPERM);
        }
    }
}
//
// get write/read permissions
$itemcategory_write_ids = $groupperm_handler->getItemIds('itemcategoryWrite', $groups, $module_skeletonHelper->getModule()->mid()); // array
$itemcategory_read_ids = $groupperm_handler->getItemIds('itemcategoryRead', $groups, $module_skeletonHelper->getModule()->mid()); // array
//
// get itemcategories tree
$itemcategoryCriteria = new CriteriaCompo();
$itemcategoryCriteria->add(new Criteria('itemcategory_id', '(' . implode(',', $itemcategory_read_ids) . ')', 'IN'));
$itemcategoryObjs = $module_skeletonHelper->getHandler('itemcategory')->getObjects($itemcategoryCriteria, true);
$itemcategoryObjsTree = new Module_skeletonObjectTree($itemcategoryObjs, 'itemcategory_id', 'itemcategory_pid');
//
// get itemcategory first childs and all parents
$itemcategoryFirstChildObjs = $itemcategoryObjsTree->getFirstChild($itemcategory_id);
$itemcategoryAllParentObjs = $itemcategoryObjsTree->getAllParent($itemcategory_id);
//
// get itemObjs
$itemCriteria = new CriteriaCompo();
$itemCriteria->add(new Criteria('item_category_id', $itemcategory_id));
$itemObjs = $module_skeletonHelper->getHandler('item')->getObjects($itemCriteria, true, true);



// load template
$xoopsOption['template_main'] = "{$module_skeletonHelper->getModule()->dirname()}_itemcategory.tpl";
include XOOPS_ROOT_PATH . '/header.php';
//
$xoTheme->addScript(XOOPS_URL . '/browse.php?Frameworks/jquery/jquery.js');
$xoTheme->addStylesheet(MODULE_SKELETON_URL . '/assets/css/module.css');
//
// template: itemcategory
$GLOBALS['xoopsTpl']->assign('itemcategory', $itemcategory);
//
// template: itemcategoryAllParentsBreadcrumb
$breadcrumb = new \Xmf\Template\Breadcrumb();
$breadcrumbItems = array();
$breadcrumbItems[] = array(
    'caption' => $module_skeletonHelper->getModule()->getVar('name'),
    'link' => MODULE_SKELETON_URL
);
if ($itemcategory_id != 0) {
    $breadcrumbItems[] = array(
        'caption' => _CO_MODULE_SKELETON_ITEMCATEGORY_ROOT,
        'link' => MODULE_SKELETON_URL . '/itemcategory.php?itemcategory_id=0'
    );
}
$itemcategoryAllParentObjs = array_reverse($itemcategoryAllParentObjs);
foreach ($itemcategoryAllParentObjs as $itemcategoryAllParentObj) {
    $breadcrumbItems[] = array(
        'caption' => $itemcategoryAllParentObj->getVar('itemcategory_title'),
        'link' => MODULE_SKELETON_URL . '/itemcategory.php?itemcategory_id=' . $itemcategoryAllParentObj->getVar('itemcategory_id')
    );
}
$breadcrumbItems[] = array(
    'caption' => $itemcategory['itemcategory_title'],
    'link' => ''
);
$breadcrumb->setItems($breadcrumbItems);
$GLOBALS['xoopsTpl']->assign('itemcategoryAllParentsBreadcrumb', $breadcrumb->fetch());
//
// template: itemcategory_select
$itemcategory_select = $itemcategoryObjsTree->makeSelBox('itemcategory_id', 'itemcategory_title', '-', $itemcategory_id, array('0' => _CO_MODULE_SKELETON_ITEMCATEGORY_ROOT), 0, 'onchange="window.location=\'itemcategory.php?itemcategory_id=\' + this.value;"');
$GLOBALS['xoopsTpl']->assign('itemcategory_select', $itemcategory_select);
//
// template: itemcategoryFirstChilds
$GLOBALS['xoopsTpl']->assign('itemcategoryFirstChildCount', count($itemcategoryFirstChildObjs));
foreach ($itemcategoryFirstChildObjs as $itemcategoryFirstChildObj) {
    $GLOBALS['xoopsTpl']->append('itemcategoryFirstChilds', $itemcategoryFirstChildObj->getInfo());
}
//
// template: items
$GLOBALS['xoopsTpl']->assign('itemCount', count($itemObjs));
foreach ($itemObjs as $item_id => $itemObj) {
    $GLOBALS['xoopsTpl']->append('items', $itemObj->getInfo());
}



include __DIR__ . '/footer.php';
