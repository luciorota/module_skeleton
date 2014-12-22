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

// LOAD Extraitemfieldtype class
xoops_load('Extraitemfieldtype','module_skeleton');

/**
 * Class ExtraitemfieldtypeXoopsImage
 */
class ExtraitemfieldtypeXoopsImage extends Module_skeletonExtraitemfieldtype
{
    /**
     * @return XoopsFormElementTray
     */
    public function getEditElement()
    {
        xoops_load('XoopsFormLoader');
// IN PROGRESS
// IN PROGRESS
// IN PROGRESS
        include_once __DIR__ . '/formajaximagemanager.php'; // XoopsFormAjaxImageManager class
        // get itemfiled vars
        if ($this->itemObj->isNew()) {
            $value = $this->itemfieldObj->getVar('itemfield_default');
        } else {
            $value = $this->itemObj->getVar($this->itemfieldObj->getVar('itemfield_name'), 'e');
        }
        $caption = $this->itemfieldObj->getVar('itemfield_title');
        $caption = defined($caption) ? constant($caption) : $caption;
        $name = $this->itemfieldObj->getVar('itemfield_name', 'e');
        $options = $this->itemfieldObj->getVar('itemfield_options');
        if (is_array($options)) {
            //asort($options);
            foreach (array_keys($options) as $key) {
                $optval = defined($options[$key]) ? constant($options[$key]) : $options[$key];
                $optkey = defined($key) ? constant($key) : $key;
                unset($options[$key]);
                $options[$optkey] = $optval;
            }
        }
        //
        $typeconfigs = $this->itemfieldObj->getVar('itemfield_typeconfigs');
        $value = $this->itemObj->getVar($name);
        if (empty($value)) {
            $images = array();
        } else {
            $images = json_decode($value, true); // associative arrays
        }
        $maxnum = (!empty($typeconfigs['maxnum'])) ? $typeconfigs['maxnum'] : 1;
        $element = new XoopsFormElementTray($caption, '<br>');
        $element->addElement(new XoopsFormHidden($name, '')); // IN PROGRESS
        for ($image_key = 0; $image_key < $maxnum; ++$image_key) {
            $element->addElement(new XoopsFormAjaxImageManager('', $name . '[' . $image_key . ']', $images[$image_key]));
        }
        return $element;
    }

    /**
     * @return mixed
     */
    public function getOutputValue()
    {
        // get itemfiled vars
        $value = $this->itemObj->getVar($this->itemfieldObj->getVar('itemfield_name'));
        $value = json_decode($value, true); // associative arrays
        return $value;
    }

    /**
     *
     * @return string
     */
    public function getValueForSave($value)
    {
        // get itemfiled vars
        $name = $this->itemfieldObj->getVar('itemfield_name', 'e');
        return json_encode($value);
    }

    public function insert()
    {
        $this->itemfieldObj->setVar('itemfield_datatype', XOBJ_DTYPE_OTHER);
    }

    public function delete()
    {
        // remove column from item table
        $sql = "ALTER TABLE {$this->module_skeleton->getHandler('item')->table}";
        $sql .= " DROP `{$this->itemfieldObj->getVar('itemfield_name', 'n')}`";
        if (!$this->db->query($sql)) {
            // ERROR
            return false;
        }
    }

    public function itemfield_datatype($form)
    {
        // NOP
    }

    public function itemfield_notnull($form)
    {
        // NOP
    }

    public function itemfield_options($form)
    {
        // NOP
    }

    public function itemfield_typeconfigs($form)
    {
        xoops_load('XoopsFormLoader');
        // get itemfiled vars
        $typeconfigs = $this->itemfieldObj->getVar('itemfield_typeconfigs');
        // default
        if(empty($typeconfigs)) {
            $typeconfigs = array(
                'maxnum' => 1
            );
        }
        $xoopsimage_maxnum_text = new XoopsFormText(_CO_MODULE_SKELETON_EXTRA_ITEMFIELD_TYPE_XOOPSIMAGE_MAXNUM, 'itemfield_typeconfigs[maxnum]', 50, 255, $typeconfigs['maxnum']);
        $xoopsimage_maxnum_text->setDescription(_CO_MODULE_SKELETON_EXTRA_ITEMFIELD_TYPE_XOOPSIMAGE_MAXNUM_DESC);
        $form->addElement($xoopsimage_maxnum_text);
    }

    public function itemfield_default($form)
    {
        xoops_load('XoopsFormLoader');
// IN PROGRESS
// IN PROGRESS
// IN PROGRESS

    }

// IN PROGRESS
// IN PROGRESS
// IN PROGRESS
    public function search()
    {

    }
}
