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

defined('XOOPS_ROOT_PATH') || die('XOOPS root path not defined');

// get path to icons
$pathIcon32 = '';
if (class_exists('Xmf\Module\Admin', true)) {
    $pathIcon32 = \Xmf\Module\Admin::menuIconPath('');
}

$adminmenu = array();
// Index
$adminmenu[] = array(
    'title' => _MI_MODULE_SKELETON_MENU_HOME ,
    'link' => 'admin/index.php' ,
    'icon' => $pathIcon32 . 'home.png'
);
// Itemcategories
$adminmenu[] = array(
    'title' => _MI_MODULE_SKELETON_MENU_ITEMCATEGORIES ,
    'link' => 'admin/itemcategory.php' ,
    'icon' => $pathIcon32 . 'category.png'
);
// Items
$adminmenu[] = array(
    'title' => _MI_MODULE_SKELETON_MENU_ITEMS ,
    'link' => 'admin/item.php' ,
    'icon' => $pathIcon32 . 'block.png'
);
// Itemfieldcategories
$adminmenu[] = array(
    'title' => _MI_MODULE_SKELETON_MENU_ITEMFIELDCATEGORIES ,
    'link' => 'admin/itemfieldcategory.php' ,
    'icon' => $pathIcon32 . 'category.png'
);
// Itemfields
$adminmenu[] = array(
    'title' => _MI_MODULE_SKELETON_MENU_ITEMFIELDS ,
    'link' => 'admin/itemfield.php' ,
    'icon' => $pathIcon32 . 'index.png'
);
// Permissions
$adminmenu[] = array(
    'title' => _MI_MODULE_SKELETON_MENU_PERMISSIONS ,
    'link' => 'admin/permissions.php' ,
    'icon' => $pathIcon32 . 'permissions.png'
);
// Clone
$adminmenu[] = array(
    'title' => _MI_MODULE_SKELETON_MENU_CLONE ,
    'link' => 'admin/clone.php' ,
    'icon' => '/assets/images/icons/32/editcopy.png'
);
// About
$adminmenu[] = array(
    'title' => _MI_MODULE_SKELETON_MENU_ABOUT ,
    'link' => 'admin/about.php' ,
    'icon' => $pathIcon32 . 'about.png'
);
