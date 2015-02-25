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
 * Class ExtraitemfieldtypeGmaplnglat
 */
class ExtraitemfieldtypeGmaplnglat extends Module_skeletonExtraitemfieldtype
{
    /**
     * @return XoopsFormElementTray
     */
    public function getEditElement()
    {
        xoops_load('XoopsFormLoader');
        include_once __DIR__ . '/formgooglemap.php';
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
        if (empty($value)) {
            $value = array(
                'lat' => 0,
                'lng' => 0,
                'elevation' => 0,
                'maptypeid' => 'roadmap',
                'zoom' => 8,
                'search' => ''
                );
        } else {
            $value = json_decode($value, true); // associative arrays
        }
        //
        $typeconfigs = $this->itemfieldObj->getVar('itemfield_typeconfigs');
/*
        $api_key = (!empty($typeconfigs['api_key'])) ? $typeconfigs['api_key'] : '';
        $style = (!empty($typeconfigs['style'])) ? $typeconfigs['style'] : 'width:100%;height:400px;';
        $readonly = (!empty($typeconfigs['readonly'])) ? $typeconfigs['readonly'] : false;
        $config = array(
            'style' => $typeconfigs['style'],
            'readonly' => $typeconfigs['readonly']
        );
*/
        $element = new FormGoogleMap($caption, $name, $value, $typeconfigs['api_key'], array('style' => $typeconfigs['style'], 'readonly' => $typeconfigs['readonly']));
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
                'api_key' => '',
                'style' => 'width:100%;height:400px;',
                'readonly' => false
            );
        }
        $gmaplnglat_api_key_text = new XoopsFormText(_CO_MODULE_SKELETON_ITEMFIELD_TYPE_GMAPLNGLAT_API_KEY, 'itemfield_typeconfigs[api_key]', 50, 50, $typeconfigs['api_key']);
        $gmaplnglat_api_key_text->setDescription(_CO_MODULE_SKELETON_ITEMFIELD_TYPE_GMAPLNGLAT_API_KEY_DESC);
        $form->addElement($gmaplnglat_api_key_text);
        $gmaplnglat_style_textarea = new XoopsFormTextArea(_CO_MODULE_SKELETON_ITEMFIELD_TYPE_GMAPLNGLAT_STYLE, 'itemfield_typeconfigs[style]', $typeconfigs['style'], 5, 50);
        $gmaplnglat_style_textarea->setDescription(_CO_MODULE_SKELETON_ITEMFIELD_TYPE_GMAPLNGLAT_STYLE_DESC);
        $form->addElement($gmaplnglat_style_textarea);
        $gmaplnglat_readonly_radio = new XoopsFormRadioYN(_CO_MODULE_SKELETON_ITEMFIELD_TYPE_GMAPLNGLAT_READONLY, 'itemfield_typeconfigs[readonly]', $typeconfigs['style']);
        $gmaplnglat_readonly_radio->setDescription(_CO_MODULE_SKELETON_ITEMFIELD_TYPE_GMAPLNGLAT_READONLY_DESC);
        $form->addElement($gmaplnglat_readonly_radio);
    }

    public function itemfield_default($form)
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
