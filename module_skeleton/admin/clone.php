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
include_once __DIR__ . '/admin_header.php';

if (@$_POST['op'] == 'submit') {
    if (!$GLOBALS['xoopsSecurity']->check()) {
        redirect_header($currentFile, 3, implode('<br />', $GLOBALS['xoopsSecurity']->getErrors()));
        exit();
    }

    $cloneDirname = $_POST['clonedirname'];

    // Check if name is valid
    if (empty($cloneDirname) || preg_match('/[^a-zA-Z0-9\_\-]/', $cloneDirname)) {
        redirect_header($currentFile, 3, sprintf(_AM_MODULE_SKELETON_CLONE_INVALIDNAME, $cloneDirname));
        exit();
    }
    // Check wether the cloned module exists or not
    if ($cloneDirname && is_dir(XOOPS_ROOT_PATH . '/modules/' . $cloneDirname)) {
        redirect_header($currentFile, 3, sprintf(_AM_MODULE_SKELETON_CLONE_EXISTS, $cloneDirname));
    }

    $patterns = array(
        strtolower(MODULE_SKELETON_DIRNAME)          => strtolower($cloneDirname),
        strtoupper(MODULE_SKELETON_DIRNAME)          => strtoupper($cloneDirname),
        ucfirst(strtolower(MODULE_SKELETON_DIRNAME)) => ucfirst(strtolower($cloneDirname))
    );

    $patKeys   = array_keys($patterns);
    $patValues = array_values($patterns);
    module_skeleton_cloneFileDir(MODULE_SKELETON_ROOT_PATH);
    $logocreated = module_skeleton_createLogo(strtolower($cloneDirname));

    $message = "";
    if (is_dir(XOOPS_ROOT_PATH . '/modules/' . strtolower($cloneDirname))) {
        $message .= sprintf(
                _AM_MODULE_SKELETON_CLONE_CONGRAT,
                "<a href='" . XOOPS_URL . "/modules/system/admin.php?fct=modulesadmin&op=installlist'>" . ucfirst(strtolower($cloneDirname)) . "</a>"
            ) . "<br />\n";
        if (!$logocreated) {
            $message .= _AM_MODULE_SKELETON_CLONE_IMAGEFAIL;
        }
    } else {
        $message .= _AM_MODULE_SKELETON_CLONE_FAIL;
    }

    xoops_cp_header();
    $indexAdmin = \Xmf\Module\Admin::getInstance();
    $indexAdmin->displayNavigation($currentFile);
    echo $message;
    include 'admin_footer.php';
    exit();

} else {
    //  admin navigation
    xoops_cp_header();
    $indexAdmin = \Xmf\Module\Admin::getInstance();
    $indexAdmin->displayNavigation($currentFile);
    //
    xoops_load('XoopsFormLoader');
    $form = new XoopsThemeForm(sprintf(_AM_MODULE_SKELETON_CLONE_TITLE, $module_skeletonHelper->getModule()->getVar('name', 'e') ), 'clone', $currentFile, 'post', true);
    $cloneDirname_text = new XoopsFormText(_AM_MODULE_SKELETON_CLONE_NAME, 'clonedirname', 20, 20, '');
    $cloneDirname_text->setDescription(_AM_MODULE_SKELETON_CLONE_NAME_DSC);
    $form->addElement($cloneDirname_text, true);
    $form->addElement(new XoopsFormHidden('op', 'submit'));
    $form->addElement(new XoopsFormButton('', '', _SUBMIT, 'submit'));
    $form->display();
    include 'admin_footer.php';
    exit();
}

// recursive clonning script
/**
 * @param $path
 */
function module_skeleton_cloneFileDir($path)
{
    global $patKeys;
    global $patValues;

    $newPath = str_replace($patKeys[0], $patValues[0], $path);

    if (is_dir($path)) {
        // create new dir
        mkdir($newPath);
        // check all files in dir, and process it
        if ($handle = opendir($path)) {
            while ($file = readdir($handle)) {
                if ($file != '.' && $file != '..' && $file != '.svn') {
                    module_skeleton_cloneFileDir("{$path}/{$file}");
                }
            }
            closedir($handle);
        }
    } else {
        if (preg_match('/(.jpg|.gif|.png|.zip|.ttf)$/i', $path)) {
            // image
            copy($path, $newPath);
        } else {
            // file, read it
            $content = file_get_contents($path);
            $content = str_replace($patKeys, $patValues, $content);
            file_put_contents($newPath, $content);
        }
    }
}

/**
 * @param $dirname
 *
 * @return bool
 */
function module_skeleton_createLogo($dirname)
{
    $module_skeletonHelper = Module_skeletonModule_skeleton::getInstance();
    // Check extension/functions
    if (!extension_loaded("gd")) {
        return false;
    } else {
        $required_functions = array(
            "imagecreatetruecolor",
            "imagecolorallocate",
            "imagefilledrectangle",
            "imagejpeg",
            "imagedestroy",
            "imageftbbox"
        );
        foreach ($required_functions as $func) {
            if (!function_exists($func)) {
                return false;
            }
        }
    }
    // Check original image/font
    if (!file_exists($imageBase = XOOPS_ROOT_PATH . "/modules/" . $dirname . "/assets/images/module_logo_blank.png")) {
        return false;
    }
    if (!file_exists($font = XOOPS_ROOT_PATH . "/modules/" . $module_skeletonHelper->getModule()->dirname() . "/assets/images/VeraBd.ttf")) {
        return false;
    }
    // Create image
    $imageModule = imagecreatefrompng($imageBase);
    // Erase old text
    $greyColor = imagecolorallocate($imageModule, 237, 237, 237);
    imagefilledrectangle($imageModule, 5, 35, 85, 46, $greyColor);
    // Write text
    $textColor       = imagecolorallocate($imageModule, 0, 0, 0);
    $space_to_border = (80 - strlen($dirname) * 6.5) / 2;
    imagefttext($imageModule, 8.5, 0, $space_to_border, 45, $textColor, $font, ucfirst($dirname), array());
    // Set transparency color
    $whiteColor = imagecolorallocatealpha($imageModule, 255, 255, 255, 127);
    imagefill($imageModule, 0, 0, $whiteColor);
    imagecolortransparent($imageModule, $whiteColor);
    // Save new image
    imagepng($imageModule, XOOPS_ROOT_PATH . "/modules/" . $dirname . "/assets/images/module_logo.png");
    imagedestroy($imageModule);

    return true;
}
