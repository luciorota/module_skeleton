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

// Check directories
if (!is_dir($module_skeleton->getConfig('uploadPath'))) {
    redirect_header(XOOPS_URL, 3, _CO_MODULE_SKELETON_WARNING_NOUPLOADDIR);
    exit();
}

// Get user group
$groups = is_object($xoopsUser) ? $xoopsUser->getGroups() : array(0 => XOOPS_GROUP_ANONYMOUS);

// Get write/read permissions
$itemcategory_write_ids = $groupperm_handler->getItemIds('itemcategory_write', $groups, $module_skeleton->getModule()->mid());
$itemcategory_read_ids = $groupperm_handler->getItemIds('itemcategory_read', $groups, $module_skeleton->getModule()->mid());

$xoopsOption['template_main'] = "{$module_skeleton->getModule()->dirname()}_index.tpl";
include XOOPS_ROOT_PATH . '/header.php';

$xoTheme->addScript(XOOPS_URL . '/browse.php?Frameworks/jquery/jquery.js');
$xoTheme->addStylesheet(MODULE_SKELETON_URL . '/assets/css/module.css');

$xoopsTpl->assign('module_skeleton_url', MODULE_SKELETON_URL . '/');

// template: module_skeleton_breadcrumb
$breadcrumb = new Module_skeletonBreadcrumb();
$breadcrumb->addLink($module_skeleton->getModule()->getVar('name'), MODULE_SKELETON_URL);

$xoopsTpl->assign('module_skeleton_breadcrumb', $breadcrumb->render());

// template: module_skeleton_choicebyletter
$itemCriteria = new CriteriaCompo();
if(!module_skeleton_userIsAdmin()) {
    $itemCriteria->add(new Criteria('item_category_id', '(' . implode(',', $itemcategory_read_ids) . ')', 'IN'));
}
$letterChoice = new Module_skeletonChoiceByLetter($module_skeleton->getHandler('item'), $itemCriteria, 'item_title', array(), 'item_first_letter', 'item.php', 'op=items.list&apply_filter=' . true, false);
$xoopsTpl->assign('module_skeleton_choicebyletter', $letterChoice->render());
unset($itemCriteria);

// IN PROGRESS
// IN PROGRESS
// IN PROGRESS

include dirname(__FILE__) . '/footer.php';
