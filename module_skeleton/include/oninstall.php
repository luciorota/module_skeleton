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

/**
 * @param object            $xoopsModule
 * @return bool             FALSE if failed
 */
function xoops_module_pre_install_module_skeleton(&$xoopsModule)
{
    if (!class_exists('\Xmf\Loader')) {
        $xoopsModule->setErrors('<b>Please install or reactivate XMF module</b>');
        return false;
    }
    return true;
}

/**
 * @param object            $xoopsModule
 * @return bool             FALSE if failed
 */
function xoops_module_install_module_skeleton(&$xoopsModule)
{
    define('INDEX_FILE_PATH', XOOPS_ROOT_PATH . '/uploads/index.html');
    define('BLANK_FILE_PATH', XOOPS_ROOT_PATH . '/uploads/blank.gif');
    xoops_loadLanguage('common', $xoopsModule->getVar('dirname'));
    // get module config values
    $config_handler = xoops_gethandler('config');
    $configArray = $config_handler->getConfigsByCat(0, $xoopsModule->getVar('mid'));

    // create and populate directories with empty blank.gif and index.html
    if (isset($configArray['uploadPath'])) {
        $path = $configArray['uploadPath'];
        if(!is_dir($path))
            mkdir($path, 0777, true);
        chmod($path, 0777);
        copy(INDEX_FILE_PATH, $path . '/index.html');
    }
    return true;
}
