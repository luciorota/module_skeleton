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
 * @author          Kazumi Ono (http://www.myweb.ne.jp/, http://jp.xoops.org/)
 * @author          Taiwen Jiang <phppp@users.sourceforge.net>
 * @author          Gottfried Gabor <gottfried.gabor@gmx.net>
 * @author          Lucio Rota <lucio.rota@gmail.com>
 * @version         svn:$id$
 */

defined('XOOPS_ROOT_PATH') || die('Restricted access');
xoops_load('XoopsMediaUploader');

/**
 * Upload Media files
 *
 * Example of usage:
 * <code>
 * include_once 'uploader.php';
 * $allowedMimeTypes = array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/x-png');
 * $maxFileSize = 50000; // bytes
 * $maxFileWidth = 120; // pixels
 * $maxFileHeight = 120;  // pixels
 * $uploader = new Module_skeletonMediaUploader('/home/xoops/uploads', $allowedMimeTypes, $maxFileSize, $maxFileWidth, $maxFileHeight);
 * if ($uploader->fetchMedia($_POST['uploader_file_name'])) {
 *        if (!$uploader->upload()) {
 *           echo $uploader->getErrors();
 *        } else {
 *           echo '<h4>File uploaded successfully!</h4>'
 *           echo 'Saved as: ' . $uploader->getSavedFileName() . '<br />';
 *           echo 'Full path: ' . $uploader->getSavedDestination();
 *        }
 * } else {
 *        echo $uploader->getErrors();
 * }
 * </code>
 *
 */

define('_ER_UP_PHPERR_INI_SIZE',        'The uploaded file exceeds the upload_max_filesize directive in php.ini');
define('_ER_UP_PHPERR_PARTIAL',         'The uploaded file was only partially uploaded');
define('_ER_UP_PHPERR_NO_FILE',         'No file was uploaded');
define('_ER_UP_PHPERR_NO_TMP_DIR',      'Missing a temporary folder');
define('_ER_UP_PHPERR_CANT_WRITE',      'Failed to write file to disk');
define('_ER_UP_PHPERR_EXTENSION',       'A PHP extension stopped the file upload');

/**
 * Class Module_skeletonMediaUploader
 */
class Module_skeletonMediaUploader extends XoopsMediaUploader
{

    var $warnings = array();

    /**
     * Check if uploaded file exists
     *
     * @param string        $media_name Name of the input file form element $_FILES[$media_name]
     * @param int           $index Index of the file (if more than one uploaded under that name)
     * @return bool
     */
    function mediaExists($media_name, $index = null)
    {
        // 4: UPLOAD_ERR_NO_FILE
        if (empty($_FILES[$media_name]['name']) && $_FILES[$media_name]['size'] == 0 && $_FILES[$media_name]['error'] == UPLOAD_ERR_NO_FILE) {
            return false;
        } else if (is_array($_FILES[$media_name]['name']) && isset($index) && empty($_FILES[$media_name]['name'][$index]) && $_FILES[$media_name]['size'][$index] == 0 && $_FILES[$media_name]['error'][$index] == UPLOAD_ERR_NO_FILE) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * array_merge_recursive does indeed merge arrays, but it converts values with duplicate keys
     * to arrays rather than overwriting the value in the first array with the duplicate value in
     * the second array, as array_merge does. I.e., with array_merge_recursive,
     * this happens (documented behavior):
     *
     * array_merge_recursive(array('key' => 'org value'), array('key' => 'new value'));
     *     => array('key' => array('org value', 'new value'));
     *
     * array_merge_recursive_distinct does not change the datatypes of the values in the arrays.
     * Matching keys' values in the second array overwrite those in the first array, as is the case
     * with array_merge, i.e.:
     *
     * array_merge_recursive_distinct(array('key' => 'org value'), array('key' => 'new value'));
     *     => array('key' => array('new value'));
     *
     * Parameters are passed by reference, though only for performance reasons. They're not altered
     * by this function.
     *
     * @param array $array1
     * @param array $array2
     * @return array
     * @author Daniel <daniel (at) danielsmedegaardbuus (dot) dk>
     * @author Gabriel Sobrinho <gabriel (dot) sobrinho (at) gmail (dot) com>
     */
    private function arrayMergeRecursiveDistinct(array &$array1, array &$array2)
    {
        $merged = $array1;
        foreach ($array2 as $key => &$value) {
            if (is_array($value) && isset($merged[$key]) && is_array($merged[$key])) {
                $merged[$key] = $this->{__FUNCTION__}($merged[$key], $value);
            } else {
                $merged[$key] = $value;
            }
        }
        return $merged;
    }

    /**
     * @param $array
     * @param $key1
     *
     * @return array
     */
    private function moveFirstKeyRecursive($array, $key1) {
        $retArray = array();
        if(is_array($array)) {
            foreach ($array as $key => $value) {
                if (is_array($value)) {
                    $retArray[$key] = $this->{__FUNCTION__}($value, $key1);
                } else {
                    $retArray[$key] = array($key1 => $value);
                }
            }
        }
        return $retArray;
    }

    /**
     * Normalize $_FILES array
     *
     * @return array
     */
    public function normalizedFILES()
    {
        // run once
        static $normalizedFiles;
        if (!isset($normalizedFiles)) {
            $normalizedFiles = array();
            foreach ($_FILES as $field_name => $field) {
                $tempArrays = array();
                //error_log(print_r($field,true));

                foreach($field as $key1 => $array) {
                    $tempArrays[] = $this->moveFirstKeyRecursive($array, $key1);
                }
                //error_log(print_r($tempArrays,true));
                $mergedArray = array();
                foreach ($tempArrays as $key => $tempArray) {
                    //error_log('$tempArray = ' . print_r($tempArray,true));
                    $mergedArray = $this->arrayMergeRecursiveDistinct($mergedArray, $tempArray);
                }
                $normalizedFiles[$field_name] = $mergedArray;
            }
        }
        return $normalizedFiles;
    }

    /**
     * Fetch the uploaded file
     *
     * @param string        $media_name Name of the file field
     * @param int           $index Index of the file (if more than one uploaded under that name)
     * @return bool
     */
    public function fetchMedia($media_name, $index = null)
    {
        $this->errors = array();
        if (empty($this->extensionToMime)) {
            $this->setErrors(_ER_UP_MIMETYPELOAD);
            return false;
        }
        if (!isset($_FILES[$media_name])) {
            $this->setErrors(_ER_UP_FILENOTFOUND);
            return false;
        } else if (is_array($_FILES[$media_name]['name']) && isset($index)) {
            $index = (int) $index;
            $this->mediaName = (get_magic_quotes_gpc()) ? stripslashes($_FILES[$media_name]['name'][$index]) : $_FILES[$media_name]['name'][$index];
            $this->mediaType = $_FILES[$media_name]['type'][$index];
            $this->mediaSize = $_FILES[$media_name]['size'][$index];
            $this->mediaTmpName = $_FILES[$media_name]['tmp_name'][$index];
            $this->mediaError = !empty($_FILES[$media_name]['error'][$index]) ? $_FILES[$media_name]['error'][$index] : 0;
        } else {
            $media_name =& $_FILES[$media_name];
            $this->mediaName = (get_magic_quotes_gpc()) ? stripslashes($media_name['name']) : $media_name['name'];
            $this->mediaType = $media_name['type'];
            $this->mediaSize = $media_name['size'];
            $this->mediaTmpName = $media_name['tmp_name'];
            $this->mediaError = !empty($media_name['error']) ? $media_name['error'] : 0;
        }
        if (($ext = strrpos($this->mediaName, '.')) !== false) {
            $ext = strtolower(substr($this->mediaName, $ext + 1));
            if (isset($this->extensionToMime[$ext])) {
                $this->mediaRealType = $this->extensionToMime[$ext];
            }
        }
        // check first for file-upload errors
        if ($this->mediaError > 0) {
            $this->setErrors(sprintf(_ER_UP_ERROROCCURRED, $this->mediaError));
            switch ($this->mediaError) {
                case UPLOAD_ERR_INI_SIZE: // 1: the uploaded file exceeds the upload_max_filesize directive in php.ini
                    $this->setErrors(_ER_UP_PHPERR_INI_SIZE);
                    break;
                case UPLOAD_ERR_FORM_SIZE: // 2: the uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form
                    // should be done by checkMaxFileSize
                    // NOP
                    break;
                case UPLOAD_ERR_PARTIAL: // 3: the uploaded file was only partially uploaded
                    $this->setErrors(_ER_UP_PHPERR_PARTIAL);
                    break;
                case UPLOAD_ERR_NO_FILE: // 4: no file was uploaded
                    $this->setErrors(_ER_UP_PHPERR_NO_FILE);
                    break;
                case UPLOAD_ERR_NO_TMP_DIR: // 6: missing a temporary folder
                    $this->setErrors(_ER_UP_PHPERR_NO_TMP_DIR);
                    break;
                case UPLOAD_ERR_CANT_WRITE: // 7: failed to write file to disk
                    $this->setErrors(_ER_UP_PHPERR_CANT_WRITE);
                    break;
                case UPLOAD_ERR_EXTENSION: // 8: a PHP extension stopped the file upload
                    $this->setErrors(_ER_UP_PHPERR_EXTENSION);
                    break;
                case UPLOAD_ERR_OK: // 0: there is no error, the file uploaded with success
                default:
                    break;
            }
            return false;
        }
        // than checks by xoopsuploader
        if (intval($this->mediaSize) < 0) {
            $this->setErrors(_ER_UP_INVALIDFILESIZE);
            return false;
        }
        if ($this->mediaName == '') {
            $this->setErrors(_ER_UP_FILENAMEEMPTY);
            return false;
        }
        if ($this->mediaTmpName == 'none' || ! is_uploaded_file($this->mediaTmpName)) {
            $this->setErrors(_ER_UP_NOFILEUPLOADED);
            return false;
        }
        return true;
    }

    /**
     * Copy the file to its destination
     *
     * @param $chmod
     * @return bool
     */
    function _copyFile($chmod)
    {
        $matched = array();
        if (!preg_match("/\.([a-zA-Z0-9]+)$/", $this->mediaName, $matched)) {
            $this->setErrors(_ER_UP_INVALIDFILENAME);

            return false;
        }
        if (isset($this->targetFileName)) {
            $this->savedFileName = $this->targetFileName;
        } else if (isset($this->prefix)) {
            $this->savedFileName = uniqid($this->prefix) . '.' . strtolower($matched[1]);
        } else if ($this->randomFilename) {
            $this->savedFileName = uniqid(time()) . '.' . strtolower($matched[1]);
        } else {
            $this->savedFileName = strtolower($this->mediaName);
        }

        $this->savedFileName = iconv("UTF-8", "ASCII//TRANSLIT", $this->savedFileName);
        $this->savedFileName = preg_replace('!\s+!', '_', $this->savedFileName);
        $this->savedFileName = preg_replace("/[^a-zA-Z0-9\._-]/", "", $this->savedFileName);

        $this->savedDestination = $this->uploadDir . '/' . $this->savedFileName;
        if (!move_uploaded_file($this->mediaTmpName, $this->savedDestination)) {
            $this->setErrors(sprintf(_ER_UP_FAILEDSAVEFILE, $this->savedDestination));

            return false;
        }
        // Check IE XSS before returning success
        $ext = strtolower(substr(strrchr($this->savedDestination, '.'), 1));
        if (in_array($ext, $this->imageExtensions)) {
            $info = @getimagesize($this->savedDestination);
            if ($info === false || $this->imageExtensions[(int) $info[2]] != $ext) {
                $this->setErrors(_ER_UP_SUSPICIOUSREFUSED);
                @unlink($this->savedDestination);

                return false;
            }
        }
        @chmod($this->savedDestination, $chmod);

        return true;
    }
}
