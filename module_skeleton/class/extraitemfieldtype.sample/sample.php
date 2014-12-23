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
//xoops_load('Extraitemfieldtype','module_skeleton');

/**
 * Class ExtraitemfieldtypeSample
 */
class ExtraitemfieldtypeSample extends Module_skeletonExtraitemfieldtype
{
    /**
     * @return XoopsFormElementTray
     */
    public function getEditElement()
    {
        xoops_load('XoopsFormLoader');
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
        $maxLength = (!empty($typeconfigs['maxLength'])) ? $typeconfigs['maxLength'] : 255;
        $element = new XoopsFormText($caption, $name, 35, $maxLength, $value);
        return $element;
    }

    /**
     * @return mixed
     */
    public function getOutputValue()
    {
        // get itemfiled vars
        $name = $this->itemfieldObj->getVar('itemfield_name', 'e');
        $value = $this->itemObj->getVar($this->itemfieldObj->getVar('itemfield_name'));
        return $value;
    }

    /**
     * @return string
     */
    public function getValueForSave($value)
    {
        // get itemfiled vars
        $name = $this->itemfieldObj->getVar('itemfield_name', 'e');
        return $value;
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

    public function itemfield_typeconfigs($form)
    {
        xoops_load('XoopsFormLoader');
        // get itemfiled vars
        $typeconfigs = $this->itemfieldObj->getVar('itemfield_typeconfigs');
        // default
        if(empty($typeconfigs)) {
            $typeconfigs = array(
                'maxLength' => 255
            );
        }
        $textbox_maxlength_text = new XoopsFormText(_CO_MODULE_SKELETON_ITEMFIELD_TYPE_TEXTBOX_MAXLENGTH, 'itemfield_typeconfigs[maxLength]', 35, 35, $typeconfigs['maxLength']);
        $textbox_maxlength_text->setDescription(_CO_MODULE_SKELETON_ITEMFIELD_TYPE_TEXTBOX_MAXLENGTH_DESC);
        $form->addElement($textbox_maxlength_text);
    }

    public function itemfield_default($form)
    {
        xoops_load('XoopsFormLoader');
        $form->addElement(new XoopsFormTextArea(_CO_MODULE_SKELETON_ITEMFIELD_DEFAULT, 'itemfield_default', $this->itemfieldObj->getVar('itemfield_default', 'e')));
    }

    public function search()
    {
// IN PROGRESS
// IN PROGRESS
// IN PROGRESS
    }
}
