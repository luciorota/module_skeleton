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
include_once(XOOPS_ROOT_PATH . "/modules/module_skeleton/include/common.php");
@include_once(XOOPS_ROOT_PATH . "/modules/module_skeleton/language/" . $xoopsConfig['language'] . "/admin.php");

define('INDEX_FILE_PATH', XOOPS_ROOT_PATH . '/uploads/index.html');
define('BLANK_FILE_PATH', XOOPS_ROOT_PATH . '/uploads/blank.gif');

/**
 * @param object            $xoopsModule
 * @return bool             FALSE if failed
 */
function xoops_module_pre_install_module_skeleton(&$xoopsModule)
{
    // NOP
    return true;
}

/**
 * @param object            $xoopsModule
 * @return bool             FALSE if failed
 */
function xoops_module_install_module_skeleton(&$xoopsModule)
{
    // get module config values
    $config_handler = xoops_gethandler('config');
    $configArray = $config_handler->getConfigsByCat(0, $xoopsModule->getVar('mid'));

    // create and populate directories with empty blank.gif and index.html
    $path = $configArray['uploadPath'];
    if(!is_dir($path))
        mkdir($path, 0777, true);
    chmod($path, 0777);
    copy(INDEX_FILE_PATH, $path . '/index.html');
    return true;
}
