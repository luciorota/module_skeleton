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
include dirname(__FILE__) . '/header.php';

if (function_exists('mb_http_output')) {
    mb_http_output('pass');
}

$feed_type = 'rss';
$contents  = ob_get_clean();
header('Content-Type:text/xml; charset=utf-8');
$xoopsOption['template_main'] = 'system_' . $feed_type . '.tpl';
error_reporting(0);

include_once(XOOPS_ROOT_PATH . "/class/template.php");
$xoopsTpl = new XoopsTpl();

// Find case
$case     = "all";
$itemcategoryObj = $module_skeleton->getHandler('itemcategory')->get((int) $_REQUEST['itemcategory_id']);

$groups = is_object($xoopsUser) ? $xoopsUser->getGroups() : array(0 => XOOPS_GROUP_ANONYMOUS);

// Get download permissions
$allowedReadItemcategoriesIds = $groupperm_handler->getItemIds('read', $groups, $module_skeleton->getModule()->mid());

if (!$itemcategoryObj->isNew()) {
    if (!in_array($itemcategoryObj->getVar('itemcategory_id'), $allowedReadItemcategoriesIds)) {
        exit();
    }
    $case = "itemcategory";
}

switch ($case) {
    // Set cache_prefix
    default:
    case "all" :
        $cache_prefix = 'wfd|feed|' . $feed_type;
        break;

    case "itemcategory" :
        $cache_prefix = 'wfd|catfeed|' . $feed_type . '|' . (int) $itemcategoryObj->getVar('cid');
        break;
}

$xoopsTpl->caching = true;
$xoopsTpl->cache_lifetime = $xoopsConfig['module_cache'][(int) $module_skeleton->getModule()->mid()];
if (!$xoopsTpl->is_cached('db:' . $xoopsOption['template_main'], $cache_prefix)) {
    // Get content
    $limit = 30;

    $itemCriteria = new CriteriaCompo();
    $itemCriteria->setSort('item_date');
    $itemCriteria->setOrder('DESC');
    $itemCriteria->setLimit($limit);

    switch ($case) {
        default:
        case "all" :
            $shorthand   = 'all';
            $title       = $xoopsConfig['sitename'] . ' - ' . htmlspecialchars($module_skeleton->getModule()->getVar('name'), ENT_QUOTES);
            $desc        = $xoopsConfig['slogan'];
            $channel_url = XOOPS_URL . '/modules/' . $module_skeleton->getModule()->getVat('dirname') . '/rss.php';

            $itemCriteria->add(new Criteria('item_category_id', '(' . implode(',', $allowedReadItemcategoriesIds) . ')', 'IN'));
            $itemObjs = $module_skeleton->getHandler('item')->getObjects($itemCriteria);
            $id        = 0;
            break;

        case "itemcategory" :
            $shorthand   = 'cat';
            $title       = $xoopsConfig['sitename'] . ' - ' . htmlspecialchars($itemcategoryObj->getVar('title'), ENT_QUOTES);
            $desc        = $xoopsConfig['slogan'] . ' - ' . htmlspecialchars($itemcategoryObj->getVar('title'), ENT_QUOTES);
            $channel_url = XOOPS_URL . '/modules/' . $module_skeleton->getModule()->getVat('dirname') . '/rss.php?cid=' . (int) $itemcategoryObj->getVar('cid');

            $itemCriteria->add(new Criteria('item_category_id', (int) $itemcategoryObj->getVar('itemcategory_id')));
            $itemObjs = $module_skeleton->getHandler('item')->getObjects($itemCriteria);
            $id        = $itemcategoryObj->getVar('itemcategory_id');
            break;
    }

    // Assign feed-specific vars
    $xoopsTpl->assign('channel_title', xoops_utf8_encode($title, 'n'));
    $xoopsTpl->assign('channel_desc', xoops_utf8_encode($desc, 'n'));
    $xoopsTpl->assign('channel_link', $channel_url);
    $xoopsTpl->assign('channel_lastbuild', formatTimestamp(time(), $feed_type));
    $xoopsTpl->assign('channel_webmaster', $xoopsConfig['adminmail']);
    $xoopsTpl->assign('channel_editor', $xoopsConfig['adminmail']);
    $xoopsTpl->assign('channel_editor_name', $xoopsConfig['sitename']);
    $xoopsTpl->assign('channel_itemcategory', $module_skeleton->getModule()->getVar('name', 'e'));
    $xoopsTpl->assign('channel_generator', 'PHP');
    $xoopsTpl->assign('channel_language', _LANGCODE);

    // Assign items to template style array
    $url = XOOPS_URL . '/modules/' . $module_skeleton->getModule()->getVat('dirname') . '/';
    if (count($itemObjs) > 0) {
        // Get users for downloads
        $uids = array();
        foreach ($itemObjs as $itemObj) {
            $uids[] = $itemObj->getVar('item_owner_uid');
        }
        if (count($uids) > 0) {
            $users = $member_handler->getUserList(new Criteria('uid', '(' . implode(',', array_unique($uids)) . ')', 'IN'));
        }

        // Assign items to template
        foreach ($itemObjs as $itemObj) {
            $item   = $itemObj;
            $link   = $url . 'item.php?op=view.item&item_id=' . (int) $item->getVar('item_id');
            $title  = htmlspecialchars($item->getVar('item_title', 'n'));
            $teaser = '';
            $author = isset($users[$item->getVar('item_owner_uid')]) ? isset($users[$item->getVar('item_owner_uid')]) : $xoopsConfig['anonymous'];

            $xoopsTpl->append(
                'items',
                array(
                     'title'        => xoops_utf8_encode($title),
                     'author'       => xoops_utf8_encode($author),
                     'link'         => $link,
                     'guid'         => $link,
                     'is_permalink' => false,
                     'pubdate'      => formatTimestamp($item->getVar('published'), $feed_type),
                     'dc_date'      => formatTimestamp($item->getVar('published'), 'd/m H:i'),
                     'description'  => xoops_utf8_encode($teaser)
                )
            );
        }
    } else {
        $excuse_title = 'No items!';
        $excuse       = 'There are no items for this feed!';
        $art_title    = htmlspecialchars($excuse_title, ENT_QUOTES);
        $art_teaser   = htmlspecialchars($excuse, ENT_QUOTES);
        $xoopsTpl->append(
            'items',
            array(
                 'title'       => xoops_utf8_encode($art_title),
                 'link'        => $url,
                 'guid'        => $url,
                 'pubdate'     => formatTimestamp(time(), $feed_type),
                 'dc_date'     => formatTimestamp(time(), 'd/m H:i'),
                 'description' => xoops_utf8_encode($art_teaser)
            )
        );
    }
}

$xoopsTpl->display('db:' . $xoopsOption['template_main'], $cache_prefix);
