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
 * @package         wfdownload
 * @since           3.23
 * @author          Xoops Development Team
 * @version         svn:$id$
 */

/**
 * Function: b_mydownloads_top_by_itemcategory_show
 * Input   : $options[0] = date for the most recent downloads
 *                     hits for the most popular downloads
 *            $block['content'] = The optional above content
 *            $options[1]   = How many downloads are displayes
 * Output  : Returns the most recent or most popular downloads
 */
defined('XOOPS_ROOT_PATH') || die('XOOPS root path not defined');
include_once dirname(dirname(__FILE__)) . '/include/common.php';
/**
 * @param $options
 *
 * @return array
 */
function module_skeleton_top_by_itemcategory_show($options)
{
    global $xoopsUser;
    $module_skeleton = Module_skeletonModule_skeleton::getInstance();

    $groupperm_handler            = xoops_gethandler('groupperm');
    $groups                   = is_object($xoopsUser) ? $xoopsUser->getGroups() : array(0 => XOOPS_GROUP_ANONYMOUS);
    $allowedDownItemcategoriesIds = $groupperm_handler->getItemIds('WFDownCatPerm', $groups, $module_skeleton->getModule()->mid());

    $block = array();

    // get downloads
    $criteria = new CriteriaCompo();
    $criteria->add(new Criteria('cid', '(' . implode(',', $allowedDownItemcategoriesIds) . ')', 'IN'));
    $criteria->add(new Criteria('offline', false));
    $criteria->setSort('date');
    $criteria->setOrder('DESC');
    $criteria->setLimit($options[1]);
    $downloadObjs = $module_skeleton->getHandler('download')->getObjects($criteria);

    foreach ($downloadObjs as $downloadObj) {
        $download = $downloadObj->toArray();
        if (!in_array((int) $download['cid'], $allowedDownItemcategoriesIds)) {
            continue;
        }
        $download['title'] = xoops_substr($download['title'], 0, ($options[2] - 1));
        $download['id']    = (int) $download['lid'];
        if ($options[0] == 'published') {
            $download['date'] = formatTimestamp($download['published'], $module_skeleton->getConfig('dateFormat'));
        } else {
            $download['date'] = formatTimestamp($download['date'], $module_skeleton->getConfig('dateFormat'));
        }
        $download['dirname']  = $module_skeleton->getModule()->dirname();
        $block['downloads'][] = $download;
    }

    $allsubcats_linked_totop = $module_skeleton->getHandler('itemcategory')->getAllSubcatsTopParentCid();

    foreach ($module_skeleton->getHandler('itemcategory')->topItemcategories as $cid) {
        $block['topcats'][$cid]['title']  = $module_skeleton->getHandler('itemcategory')->allItemcategories[$cid]->getVar('title');
        $block['topcats'][$cid]['cid']    = $cid;
        $block['topcats'][$cid]['imgurl'] = $module_skeleton->getHandler('itemcategory')->allItemcategories[$cid]->getVar('imgurl');
    }

//mb    foreach ($block['downloads'] as $key => $value) {
    foreach ($block['downloads'] as $value) {
        $block['topcats'][$allsubcats_linked_totop[$value['cid']]]['downloads'][] = $value;
    }

    return $block;
}

/**
 * @param $options
 *
 * @return string
 */
function module_skeleton_top_by_itemcategory_edit($options)
{
    $form = "" . _MB_MODULE_SKELETON_DISP . "&nbsp;";
    $form .= "<input type='hidden' name='options[]' value='" . ($options[0] == 'published') ? 'published' : 'hits' . "' />";
    $form .= "<input type='text' name='options[]' value='" . $options[1] . "' />&nbsp;" . _MB_MODULE_SKELETON_FILES . "";
    $form .= "<br />";
    $form
        .=
        "" . _MB_MODULE_SKELETON_CHARS . "&nbsp;<input type='text' name='options[]' value='" . $options[2] . "' />&nbsp;" . _MB_MODULE_SKELETON_LENGTH . "";

    return $form;
}
