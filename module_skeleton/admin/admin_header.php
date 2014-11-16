<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

include_once dirname(dirname(dirname(dirname(__FILE__)))) . '/mainfile.php';
include_once dirname(dirname(__FILE__)) . '/include/common.php';

// Include xoops admin header
include_once XOOPS_ROOT_PATH . '/include/cp_header.php';

$pathIcon16 = XOOPS_URL . '/' . $module_skeleton->getModule()->getInfo('icons16');
$pathIcon32 = XOOPS_URL . '/' . $module_skeleton->getModule()->getInfo('icons32');
$pathModuleAdmin = XOOPS_ROOT_PATH . '/' . $module_skeleton->getModule()->getInfo('dirmoduleadmin');
require_once $pathModuleAdmin . '/moduleadmin/moduleadmin.php';

// Load language files
xoops_loadLanguage('admin', $module_skeleton->getModule()->dirname());
xoops_loadLanguage('modinfo', $module_skeleton->getModule()->dirname());
xoops_loadLanguage('main', $module_skeleton->getModule()->dirname());

if (!isset($xoopsTpl) || !is_object($xoopsTpl)) {
    include_once(XOOPS_ROOT_PATH . '/class/template.php');
    $xoopsTpl = new XoopsTpl();
}
