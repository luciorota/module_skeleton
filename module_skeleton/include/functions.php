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
include_once __DIR__ . '/common.php';

/**
 *
 * Standard functions
 *
 */

/**
 * Transforms a numerical size (like 2048) to a letteral size (like 2MB)
 *
 * @param int               $bytes numerical size
 * @param int               $precision
 * @return string           letteral size
 **/
function module_skeleton_bytesToSize1000($bytes, $precision = 2)
{
    // human readable format -- powers of 1000
    $units = array('b', 'kb', 'mb', 'gb', 'tb', 'pb', 'eb');
    return @round(
            $bytes / pow(1000, ($i = floor(log($bytes, 1000)))),
            $precision
        ) . ' ' . $units[(int) $i];
}

/**
 * @param int               $bytes
 * @param int               $precision
 * @return string
 */
function module_skeleton_bytesToSize1024($bytes, $precision = 2)
{
    // Human readable format -- powers of 1024
    $units = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB');
    return @round(
            $bytes / pow(1024, ($i = floor(log($bytes, 1024)))),
            $precision
        ) . ' ' . $units[(int) $i];
}

/**
 * Transforms the php.ini notation for numbers (like '2M') to an integer (2*1024*1024 in this case)
 *
 * @param string            $size letteral size
 * @return int              numerical size
 **/
function module_skeleton_sizeToBytes1024($size)
{
    $l   = substr($size, -1);
    $ret = substr($size, 0, -1);
    switch (strtoupper($l)) {
        case 'P':
        case 'p':
            $ret *= 1024;
            break;
        case 'T':
        case 't':
            $ret *= 1024;
            break;
        case 'G':
        case 'g':
            $ret *= 1024;
            break;
        case 'M':
        case 'm':
            $ret *= 1024;
            break;
        case 'K':
        case 'k':
            $ret *= 1024;
            break;
    }

    return $ret;
}

/**
 *
 * Filesystem functions
 *
 */

/**
 * This function will read the full structure of a directory.
 * It's recursive because it doesn't stop with the one directory,
 * it just keeps going through all of the directories in the folder you specify.
 *
 * @param string            $path path to the directory to make
 * @param int               $level
 * @return array
 */
function module_skeleton_getDir($path = '.', $level = 0)
{
    $ret = array();
    $ignore = array('cgi-bin', '.', '..');
    // Directories to ignore when listing output. Many hosts will deny PHP access to the cgi-bin.
    $dirHandler = @opendir($path);
    // Open the directory to the handle $dirHandler
    while (false !== ($file = readdir($dirHandler))) {
        // Loop through the directory
        if (!in_array($file, $ignore)) {
            // Check that this file is not to be ignored
            $spaces = str_repeat('&nbsp;', ($level * 4));
            // Just to add spacing to the list, to better show the directory tree.
            if (is_dir("$path/$file")) {
                // Its a directory, so we need to keep reading down...
                $ret[] = "<strong>{$spaces} {$file}</strong>";
                $ret = array_merge($ret, module_skeleton_getDir($path . DIRECTORY_SEPARATOR . $file, ($level + 1)));
                // Re-call this same function but on a new directory.
                // this is what makes function recursive.
            } else {
                $ret[] = "{$spaces} {$file}";
                // Just print out the filename
            }
        }
    }
    closedir($dirHandler);
    // Close the directory handle
    return $ret;
}

/**
 * Create a new directory that contains the file index.html
 *
 * @param string            $dir path to the directory to make
 * @param int               $perm mode
 * @param bool              $create_index if true create index.html
 * @return bool             TRUE on success or FALSE on failure
 */
function module_skeleton_makeDir($dir, $perm = 0777, $create_index = true)
{
    if (!is_dir($dir)) {
        if (!@mkdir($dir, $perm)) {
            return false;
        } else {
            if ($create_index) {
                if ($fileHandler = @fopen($dir . '/index.html', 'w')) {
                    fwrite($fileHandler, '<script>history.go(-1);</script>');
                }
                @fclose($fileHandler);
            }
            return true;
        }
    }
    return null;
}

/**
 * @param string            $path
 * @return array
 */
function module_skeleton_getFiles($path = '.')
{
$files = array();
    $dir = opendir($path);
	while ($file = readdir($dir)) {
		if(is_file($path . $file)) {
            if($file != '.' && $file != '..' && $file != 'blank.gif' && $file != 'index.html') {
				$files[] = $file;
            }
		}
	}
    return $files;
}

/**
 * Copy a file
 *
 * @param string            $source is the original directory
 * @param string            $destination is the destination directory
 * @return bool             TRUE on success or FALSE on failure
 */
function module_skeleton_copyFile($source, $destination)
{
    // Simple copy for a file
    if (is_file($source)) {
        return copy($source, $destination);
    } else {
        return false;
    }
}

/**
 * Copy a directory and its contents
 *
 * @param string            $source is the original directory
 * @param string            $destination is the destination directory
 * @return  bool            TRUE on success or FALSE on failure
 */
function module_skeleton_copyDir($source, $destination)
{
    if (!$dirHandler = opendir($source)) {
        return false;
    }
    @mkdir($destination);
    while (false !== ($file = readdir($dirHandler))) {
        if (($file != '.') && ($file != '..')) {
            if (is_dir("{$source}/{$file}")) {
                if (!module_skeleton_copyDir("{$source}/{$file}", "{$destination}/{$file}")) {
                    return false;
                }
            } else {
                if (!copy("{$source}/{$file}", "{$destination}/{$file}")) {
                    return false;
                }
            }
        }
    }
    closedir($dirHandler);
    return true;
}

/**
 * Delete a file
 *
 * @param string            $path is the file absolute path
 * @return  bool            TRUE on success or FALSE on failure
 */
function module_skeleton_delFile($path)
{
    if (is_file($path)) {
        @chmod($path, 0777);
        return @unlink($path);
    } else {
        return fasle;
    }

}

/**
 * Delete a empty/not empty directory
 *
 * @param   string          $dir path to the directory to delete
 * @param   bool            $if_not_empty if false it delete directory only if false
 * @return  bool            TRUE on success or FALSE on failure
 */
function module_skeleton_delDir($dir, $if_not_empty = true)
{
    if (!file_exists($dir)) {
        return true;
    }
    if ($if_not_empty == true) {
        if (!is_dir($dir)) {
            return unlink($dir);
        }
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }
            if (!module_skeleton_delDir("{$dir}/{$item}")) {
                return false;
            }
        }
    } else {
        // NOP
    }
    return rmdir($dir);
}

/**
 *
 * Module functions
 *
 */

/**
 * Check if a module exist and return module verision
 * @author luciorota
 *
 * @param string            $dirname
 * @return boolean|int      FALSE if module is not installed or not active, module version if module is installed
 */
function module_skeleton_checkModule($dirname)
{
    if (!xoops_isActiveModule($dirname)) {
        return false;
    }
    $module_handler = xoops_gethandler('module');
    $module = $module_handler->getByDirname($dirname);

    return $module->getVar('version');
}

/**
 * Recursively sort itemcategories by level and weight
 * @author luciorota
 *
 * @param object            $criteria {@link CriteriaElement}
 * @param integer           $itemcategory_pid
 * @param integer           $level
 * @return  array           array of arrays: 'itemcategory_pid', 'itemcategory_id', 'level', 'itemcategory' as array
 */
function module_skeleton_sortItemcategories($criteria = null, $itemcategory_pid = 0, $level = 0)
{
    $module_skeletonHelper = \Xmf\Module\Helper::getHelper('module_skeleton');
    //
    $sorted = array();
    $subCategoryCriteria = (is_null($criteria)) ? new CriteriaCompo() : $criteria;
    $subCategoryCriteria->add(new Criteria('itemcategory_pid', $itemcategory_pid));
    $subCategoryCriteria->setSort('itemcategory_weight');
    $subCategoryCriteria->setOrder('ASC');
    $subCategoryObjs = $module_skeletonHelper->getHandler('itemcategory')->getObjects($subCategoryCriteria);
    if (count($subCategoryObjs) > 0) {
        ++$level;
        foreach ($subCategoryObjs as $subCategoryObj) {
            $itemcategory_pid = $subCategoryObj->getVar('itemcategory_pid');
            $itemcategory_id = $subCategoryObj->getVar('itemcategory_id');
            $subCategory = $subCategoryObj->getInfo(); // as array
            $sorted[] = array('itemcategory_pid' => $itemcategory_pid, 'itemcategory_id' => $itemcategory_id, 'level' => $level, 'itemcategory' => $subCategory);
            if ($subSorted = module_skeleton_sortItemcategories($criteria, $itemcategory_id, $level)) {
                $sorted = array_merge($sorted, $subSorted);
            }
        }
    }
    return $sorted;
}

/**
 * Recursively sort itemfieldcategories by level and weight
 * @author luciorota
 *
 * @param object            $criteria {@link CriteriaElement}
 * @param integer           $itemfieldcategory_pid
 * @param integer           $level
 * @return  array           array of arrays: 'itemfieldcategory_pid', 'itemfieldcategory_id', 'level', 'itemfieldcategory' as array
 */
function module_skeleton_sortItemfieldcategories($criteria = null, $itemfieldcategory_pid = 0, $level = 0)
{
    $module_skeletonHelper = \Xmf\Module\Helper::getHelper('module_skeleton');
    //
    $sorted = array();
    $subCategoryCriteria = (is_null($criteria)) ? new CriteriaCompo() : $criteria;
    $subCategoryCriteria->add(new Criteria('itemfieldcategory_pid', $itemfieldcategory_pid));
    $subCategoryCriteria->setSort('itemfieldcategory_weight');
    $subCategoryCriteria->setOrder('ASC');
    $subCategoryObjs = $module_skeletonHelper->getHandler('itemfieldcategory')->getObjects($subCategoryCriteria);
    if (count($subCategoryObjs) > 0) {
        ++$level;
        foreach ($subCategoryObjs as $subCategoryObj) {
            $itemfieldcategory_pid = $subCategoryObj->getVar('itemfieldcategory_pid');
            $itemfieldcategory_id = $subCategoryObj->getVar('itemfieldcategory_id');
            $subCategory = $subCategoryObj->getInfo(); // as array
            $sorted[] = array('itemfieldcategory_pid' => $itemfieldcategory_pid, 'itemfieldcategory_id' => $itemfieldcategory_id, 'level' => $level, 'itemfieldcategory' => $subCategory);
            if ($subSorted = module_skeleton_sortItemfieldcategories($criteria, $itemfieldcategory_id, $level)) {
                $sorted = array_merge($sorted, $subSorted);
            }
        }
    }
    return $sorted;
}

/**
 * @return array
 */
function module_skeleton_getCurrentUrls()
{
    $http        = ((strpos(XOOPS_URL, "https://")) === false) ? ("http://") : ("https://");
    $phpSelf     = $_SERVER['PHP_SELF'];
    $httpHost    = $_SERVER['HTTP_HOST'];
    $queryString = $_SERVER['QUERY_STRING'];

    If ($queryString != '') {
        $queryString = '?' . $queryString;
    }

    $currentURL = $http . $httpHost . $phpSelf . $queryString;

    $urls                = array();
    $urls['http']        = $http;
    $urls['httphost']    = $httpHost;
    $urls['phpself']     = $phpSelf;
    $urls['querystring'] = $queryString;
    $urls['full']        = $currentURL;

    return $urls;
}

function module_skeleton_getCurrentPage()
{
    $urls = module_skeleton_getCurrentUrls();

    return $urls['full'];
}

// TODO : The SEO feature is not fully implemented in the module...
/**
 * @param string            $op
 * @param int               $id
 * @param string            $title
 *
 * @return string
 */
function module_skeleton_seo_genUrl($op, $id, $title = "")
{
    if (defined('SEO_ENABLED')) {
        if (SEO_ENABLED == 'rewrite') {
            // generate SEO url using htaccess
            return XOOPS_URL . "/module_skeleton.${op}.${id}/" . module_skeleton_seo_title($title);
        } elseif (SEO_ENABLED == 'path-info') {
            // generate SEO url using path-info
            return XOOPS_URL . "/modules/module_skeleton/seo.php/${op}.${id}/" . module_skeleton_seo_title($title);
        } else {
            die('Unknown SEO method.');
        }
    } else {
        // generate classic url
        switch ($op) {
            case 'itemcategory':
                return XOOPS_URL . "/modules/module_skeleton/${op}.php?itemcategoryid=${id}";
            case 'item':
            case 'print':
                return XOOPS_URL . "/modules/module_skeleton/${op}.php?itemid=${id}";
            default:
                die('Unknown SEO operation.');
        }
    }
}

/**
 * save_Permissions()
 *
 * @param array             $groups
 * @param int               $id
 * @param string            $permName
  * @internal param $perm_name
  * @return bool
 */
function module_skeleton_savePermissions($groups, $id, $permName)
{
    $module_skeletonHelper = \Xmf\Module\Helper::getHelper('module_skeleton');

    $id            = (int) $id;
    $result        = true;
    $mid           = $module_skeletonHelper->getModule()->mid();
    $groupperm_handler = xoops_gethandler('groupperm');

    // First, if the permissions are already there, delete them
    $groupperm_handler->deleteByModule($mid, $permName, $id);
    // Save the new permissions
    if (is_array($groups)) {
        foreach ($groups as $group_id) {
            $groupperm_handler->addRight($permName, $id, $group_id, $mid);
        }
    }

    return $result;
}

/**
 * module_skeleton_serverStats()
 *
 * @return string
 */
function module_skeleton_serverStats()
{
//mb    $module_skeletonHelper = \Xmf\Module\Helper::getHelper('module_skeleton');
    global $xoopsDB;
    $html = "";
    $html .= "<fieldset><legend style='font-weight: bold; color: #900;'>" . _AM_MODULE_SKELETON_DOWN_IMAGEINFO . "</legend>\n";
    $html .= "<div style='padding: 8px;'>\n";
    $html .= "<div>" . _AM_MODULE_SKELETON_DOWN_SPHPINI . "</div>\n";
    $html .= "<ul>\n";
    //
    $gdlib = (function_exists('gd_info')) ? "<span style=\"color: green;\">" . _AM_MODULE_SKELETON_DOWN_GDON . "</span>"
        : "<span style=\"color: red;\">" . _AM_MODULE_SKELETON_DOWN_GDOFF . "</span>";
    $html .= "<li>" . _AM_MODULE_SKELETON_DOWN_GDLIBSTATUS . $gdlib;
    if (function_exists('gd_info')) {
        if (true == $gdlib = gd_info()) {
            $html .= "<li>" . _AM_MODULE_SKELETON_DOWN_GDLIBVERSION . "<b>" . $gdlib['GD Version'] . "</b>";
        }
    }
    //
    $safemode = (ini_get('safe_mode')) ? _AM_MODULE_SKELETON_DOWN_ON . _AM_MODULE_SKELETON_DOWN_SAFEMODEPROBLEMS : _AM_MODULE_SKELETON_DOWN_OFF;
    $html .= "<li>" . _AM_MODULE_SKELETON_DOWN_SAFEMODESTATUS . $safemode;
    //
    $registerglobals = (!ini_get('register_globals')) ? "<span style=\"color: green;\">" . _AM_MODULE_SKELETON_DOWN_OFF . "</span>"
        : "<span style=\"color: red;\">" . _AM_MODULE_SKELETON_DOWN_ON . "</span>";
    $html .= "<li>" . _AM_MODULE_SKELETON_DOWN_REGISTERGLOBALS . $registerglobals;
    //
    $downloads = (ini_get('file_uploads')) ? "<span style=\"color: green;\">" . _AM_MODULE_SKELETON_DOWN_ON . "</span>"
        : "<span style=\"color: red;\">" . _AM_MODULE_SKELETON_DOWN_OFF . "</span>";
    $html .= "<li>" . _AM_MODULE_SKELETON_DOWN_SERVERUPLOADSTATUS . $downloads;
    //
    $html .= "<li>" . _AM_MODULE_SKELETON_DOWN_MAXUPLOADSIZE . " <b><span style=\"color: blue;\">" . ini_get('upload_max_filesize') . "</span></b>\n";
    $html .= "<li>" . _AM_MODULE_SKELETON_DOWN_MAXPOSTSIZE . " <b><span style=\"color: blue;\">" . ini_get('post_max_size') . "</span></b>\n";
    $html .= "<li>" . _AM_MODULE_SKELETON_DOWN_MEMORYLIMIT . " <b><span style=\"color: blue;\">" . ini_get('memory_limit') . "</span></b>\n";
    $html .= "</ul>\n";

    $html .= "<ul>\n";
    $html .= "<li>" . _AM_MODULE_SKELETON_DOWN_SERVERPATH . " <b>" . XOOPS_ROOT_PATH . "</b>\n";

    $html .= "</ul>\n";
    $html .= "<br />\n";
    $html .= _AM_MODULE_SKELETON_DOWN_UPLOADPATHDSC . "\n";
    $html .= "</div>";
    $html .= "</fieldset><br />";

    return $html;
}

/**
 * truncateHtml can truncate a string up to a number of characters while preserving whole words and HTML tags
 * www.gsdesign.ro/blog/cut-html-string-without-breaking-the-tags
 * www.cakephp.org
 *
 * @param string  $text         String to truncate.
 * @param integer $length       Length of returned string, including ellipsis.
 * @param string  $ending       Ending to be appended to the trimmed string.
 * @param boolean $exact        If false, $text will not be cut mid-word
 * @param boolean $considerHtml If true, HTML tags would be handled correctly
 *
 * @return string Trimmed string.
 */
function module_skeleton_truncateHtml($text, $length = 100, $ending = '...', $exact = false, $considerHtml = true)
{
    if ($considerHtml) {
        // if the plain text is shorter than the maximum length, return the whole text
        if (strlen(preg_replace('/<.*?'.'>/', '', $text)) <= $length) {
            return $text;
        }
        // splits all html-tags to scanable lines
        preg_match_all('/(<.+?'.'>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);
        $total_length = strlen($ending);
        $open_tags    = array();
        $truncate     = '';
        foreach ($lines as $line_matchings) {
            // if there is any html-tag in this line, handle it and add it (uncounted) to the output
            if (!empty($line_matchings[1])) {
                // if it's an "empty element" with or without xhtml-conform closing slash
                if (preg_match(
                    '/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is',
                    $line_matchings[1]
                )
                ) {
                    // do nothing
                    // if tag is a closing tag
                } elseif (preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings)) {
                    // delete tag from $open_tags list
                    $pos = array_search($tag_matchings[1], $open_tags);
                    if ($pos !== false) {
                        unset($open_tags[$pos]);
                    }
                    // if tag is an opening tag
                } elseif (preg_match('/^<\s*([^\s>!]+).*?'.'>$/s', $line_matchings[1], $tag_matchings)) {
                    // add tag to the beginning of $open_tags list
                    array_unshift($open_tags, strtolower($tag_matchings[1]));
                }
                // add html-tag to $truncate'd text
                $truncate .= $line_matchings[1];
            }
            // calculate the length of the plain text part of the line; handle entities as one character
            $content_length = strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', ' ', $line_matchings[2]));
            if ($total_length + $content_length > $length) {
                // the number of characters which are left
                $left            = $length - $total_length;
                $entities_length = 0;
                // search for html entities
                if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE)) {
                    // calculate the real length of all entities in the legal range
                    foreach ($entities[0] as $entity) {
                        if ($entity[1] + 1 - $entities_length <= $left) {
                            $left--;
                            $entities_length += strlen($entity[0]);
                        } else {
                            // no more characters left
                            break;
                        }
                    }
                }
                $truncate .= substr($line_matchings[2], 0, $left + $entities_length);
                // maximum lenght is reached, so get off the loop
                break;
            } else {
                $truncate .= $line_matchings[2];
                $total_length += $content_length;
            }
            // if the maximum length is reached, get off the loop
            if ($total_length >= $length) {
                break;
            }
        }
    } else {
        if (strlen($text) <= $length) {
            return $text;
        } else {
            $truncate = substr($text, 0, $length - strlen($ending));
        }
    }
    // if the words shouldn't be cut in the middle...
    if (!$exact) {
        // ...search the last occurance of a space...
        $spacepos = strrpos($truncate, ' ');
        if (isset($spacepos)) {
            // ...and cut the text in this position
            $truncate = substr($truncate, 0, $spacepos);
        }
    }
    // add the defined ending to the text
    $truncate .= $ending;
    if ($considerHtml) {
        // close all unclosed html-tags
        foreach ($open_tags as $tag) {
            $truncate .= '</' . $tag . '>';
        }
    }

    return $truncate;
}
