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

use Xmf\Module\Helper;
use Xmf\Module\Permission;
use Xmf\Module\Session;

defined('XOOPS_ROOT_PATH') || die('XOOPS root path not defined');

if (!class_exists('\Xmf\Loader')) {
    if (file_exists($file = dirname(dirname(dirname(__FILE__))) . '/xmf/include/bootstrap.php')) {
        include_once $file;
        trigger_error( 'Please install or reactivate XMF module');
    } else {
        redirect_header(XOOPS_URL, 5, 'Please install XMF module');
    }
}

// common Xoops stuff
xoops_load('XoopsFormLoader');
xoops_load('XoopsPageNav');
xoops_load('XoopsUserUtility');
xoops_load('XoopsLocal');
xoops_load('XoopsRequest');
xoops_load('XoopsLists');

// MyTextSanitizer object
$myts = MyTextSanitizer::getInstance();

// load Xoops handlers
$module_handler = xoops_gethandler('module');
$member_handler = xoops_gethandler('member');
$notification_handler = &xoops_gethandler('notification');
$groupperm_handler = xoops_gethandler('groupperm');

// common module_skeleton stuff
define('MODULE_SKELETON_DIRNAME', basename(dirname(__DIR__)));
define('MODULE_SKELETON_URL', XOOPS_URL . '/modules/' . MODULE_SKELETON_DIRNAME);
define('MODULE_SKELETON_IMAGES_URL', MODULE_SKELETON_URL . '/assets/images');
define('MODULE_SKELETON_JS_URL', MODULE_SKELETON_URL . '/assets/js');
define('MODULE_SKELETON_CSS_URL', MODULE_SKELETON_URL . '/assets/css');
define('MODULE_SKELETON_ADMIN_URL', MODULE_SKELETON_URL . '/admin');
define('MODULE_SKELETON_ROOT_PATH', dirname(__DIR__));

$module_skeletonHelper = \Xmf\Module\Helper::getHelper('module_skeleton');
$module_skeletonSession = new \Xmf\Module\Session($module_skeletonHelper->getModule());

$module_skeletonHelper->loadLanguage('common');

include_once MODULE_SKELETON_ROOT_PATH . '/include/functions.php';
include_once MODULE_SKELETON_ROOT_PATH . '/include/constants.php';

include_once MODULE_SKELETON_ROOT_PATH . '/class/common/breadcrumb.php'; // Module_skeletonBreadcrumb class
include_once MODULE_SKELETON_ROOT_PATH . '/class/common/choicebyletter.php'; // Module_skeletonChoiceByLetter class
include_once MODULE_SKELETON_ROOT_PATH . '/class/common/tree.php'; // Module_skeletonObjectTree class
include_once MODULE_SKELETON_ROOT_PATH . '/class/common/uploader.php'; // Module_skeletonMediaUploader class

// this is needed or it will not work in blocks
global $module_skeleton_isAdmin;
$module_skeleton_isAdmin = $module_skeletonHelper->isUserAdmin();
