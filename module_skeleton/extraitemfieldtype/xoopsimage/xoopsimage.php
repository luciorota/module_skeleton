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

// IN PROGRESS
// IN PROGRESS
// IN PROGRESS
// LOAD ExtraItemfieldType class
//xoops_load('ExtraItemfieldType','module_skeleton');
include_once __DIR__ . "/../extraitemfieldtype.php";

/**
 * Class ExtraItemfieldTypeXoopsImage
 */class ExtraItemfieldTypeXoopsImage extends ExtraItemfieldType
{
    /**
     * @param $itemObj
     * @param $itemfieldObj
     */
    public function __construct($itemObj, $itemfieldObj)
    {
// IN PROGRESS
// IN PROGRESS
// IN PROGRESS
    }

    /**
     * @return XoopsFormElementTray
     */
    public function getEditElement()
    {
        // get itemfiled vars
        if ($itemObj->isNew()) {
            $value = $itemfieldObj->getVar('itemfield_default');
        } else {
            $value = $itemObj->getVar($itemfieldObj->getVar('itemfield_name'), 'e');
        }
        $name = $itemfieldObj->getVar('itemfield_name', 'e');
        $caption = $itemfieldObj->getVar('itemfield_title');
        $caption = defined($caption) ? constant($caption) : $caption;
        $options = $itemfieldObj->getVar('itemfield_options');
        if (is_array($options)) {
            //asort($options);
            foreach (array_keys($options) as $key) {
                $optval = defined($options[$key]) ? constant($options[$key]) : $options[$key];
                $optkey = defined($key) ? constant($key) : $key;
                unset($options[$key]);
                $options[$optkey] = $optval;
            }
        }
        $typeconfigs = $itemfieldObj->getVar('itemfield_typeconfigs');
        if (empty($value)) {
            $images = array();
        } else {
            $images = json_decode($value, true); // associative arrays
        }
        $maxnum = (!empty($typeconfigs['maxnum'])) ? $typeconfigs['maxnum'] : 1;
        include_once __DIR__ . '/formajaximagemanager.php'; // XoopsFormAjaxImageManager class
        $element = new XoopsFormElementTray($caption, '<br>');
        $element->addElement(new XoopsFormHidden($name, '')); // IN PROGRESS
        for ($image_key = 0; $image_key < $maxnum; ++$image_key) {
            $element->addElement(new XoopsFormAjaxImageManager('', $name . "[]", $images["$image_key"]));
        }
        return $element;
    }

    /**
     * @return mixed
     */
    public function getOutputValue()
    {
        $name = $itemfieldObj->getVar('itemfield_name', 'e');
        $value = $itemObj->getVar($this->getVar('itemfield_name'));
        $typeconfigs = $itemfieldObj->getVar('itemfield_typeconfigs');
        $value = json_decode($value, true); // associative arrays
        return $value;
    }

    /**
     * @param $value
     *
     * @return string
     */
    public function getValueForSave($value)
    {
        $name = $itemfieldObj->getVar('itemfield_name', 'e');
        $typeconfigs = $this->getVar('itemfield_typeconfigs');
        return json_encode($value);
// IN PROGRESS
// IN PROGRESS
// IN PROGRESS
    }

    public function insert()
    {
        $itemfieldObj->setVar('itemfield_datatype', XOBJ_DTYPE_OTHER);
// IN PROGRESS
// IN PROGRESS
// IN PROGRESS
    }

    public function delete()
    {
// IN PROGRESS
// IN PROGRESS
// IN PROGRESS
    }
    public function itemfield_typeconfigs()
    {
// IN PROGRESS
// IN PROGRESS
// IN PROGRESS
    }
    public function search()
    {
// IN PROGRESS
// IN PROGRESS
// IN PROGRESS
    }
}
