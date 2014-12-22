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
include_once dirname(__DIR__) . '/include/common.php';

/**
 * Class Module_skeletonItemfield
 */
class Module_skeletonItemfield extends XoopsObject
{
    /**
     * @var Module_skeletonModule_skeleton
     * @access private
     */
    private $module_skeleton = null;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->module_skeleton = Module_skeletonModule_skeleton::getInstance();
        $this->db = XoopsDatabaseFactory::getDatabaseConnection();
        $this->initVar('itemfield_id', XOBJ_DTYPE_INT);
        $this->initVar('itemfield_category_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('itemfield_title', XOBJ_DTYPE_TXTBOX);
        $this->initVar('itemfield_description', XOBJ_DTYPE_TXTAREA);
        //
        $this->initVar('itemfield_weight', XOBJ_DTYPE_INT, 0);
        $this->initVar('itemfield_name', XOBJ_DTYPE_TXTBOX, null, true);
        $this->initVar('itemfield_type', XOBJ_DTYPE_TXTBOX);
        $this->initVar('itemfield_typeconfigs', XOBJ_DTYPE_ARRAY, array());
        $this->initVar('itemfield_options', XOBJ_DTYPE_ARRAY, array());
        $this->initVar('itemfield_datatype', XOBJ_DTYPE_INT, null, true); // datatype
        $this->initVar('itemfield_default', XOBJ_DTYPE_TXTAREA, '');
        $this->initVar('itemfield_notnull', XOBJ_DTYPE_INT, 1);
        $this->initVar('itemfield_required', XOBJ_DTYPE_INT, false); // boolean
        // flags
        $this->initVar('itemfield_edit', XOBJ_DTYPE_INT, true); // boolean
        $this->initVar('itemfield_show', XOBJ_DTYPE_INT, true); // boolean
        $this->initVar('itemfield_config', XOBJ_DTYPE_INT, false); // boolean
    }

    /**
     * Extra treatment dealing with non latin encoding
     * Tricky solution
     *
     * @param string $key
     * @param mixed  $value
     * @param bool   $not_gpc
     */
    public function setVar($key, $value, $not_gpc = false)
    {
        if ($key == 'itemfield_options' && is_array($value)) {
            foreach (array_keys($value) as $idx ) {
                $value[$idx] = base64_encode($value[$idx]);
            }
        }
        parent::setVar($key, $value, $not_gpc);
    }

    /**
     * @param string        $key
     * @param string        $format
     * @return mixed
     */
    public function getVar($key, $format = 's')
    {
        $value = parent::getVar($key, $format);
        if ($key == 'itemfield_options' && !empty($value)) {
            foreach (array_keys($value) as $idx) {
                $value[$idx] = base64_decode($value[$idx]);
            }
        }

        return $value;
    }

    /**
     * @return null|object  {@link module_skeletonItemfieldcategory}
     */
    public function getItemfieldcategory()
    {
        if (!isset($this->itemfieldcategoryObj)) {
            $this->itemfieldcategoryObj = $this->module_skeleton->getHandler('itemfieldcategory')->get($this->getVar('itemfield_category_id'));
        }
        return $this->itemfieldcategoryObj;
    }

    /**
     * This method return {@link Module_skeletonItemfield} values as array ready for html output
     *
     * @return array
     */
    public function getInfo()
    {
        global $myts;
        xoops_load('XoopsUserUtility');
        //
        $datatypes = $this->module_skeleton->getHandler('itemfield')->getDataTypes(); // array of data types
        $itemfieldtypes = $this->module_skeleton->getHandler('itemfield')->getItemfieldTypesList();  // array of itemfield types
        //
        $itemfield = $this->toArray();
        $itemfield['id'] = $itemfield['itemfield_id'];
        $itemfield['cid'] = $itemfield['itemfield_category_id'];
        if ($itemfield['itemfield_category_id'] != 0) {
            $itemfieldcategoryObj = $this->getItemfieldcategory();
            $itemfield['itemfield_itemfieldcategory_title'] = $itemfieldcategoryObj->getVar('itemfieldcategory_title');
            $itemfield['itemfield_itemfieldcategory_title_html'] = $myts->htmlSpecialChars($itemfield['itemfield_itemfieldcategory_title']);
            $itemfield['itemfield_itemfieldcategory_description'] = $itemfieldcategoryObj->getVar('itemfieldcategory_description');
            $itemfield['itemfield_itemfieldcategory_description_html'] = $myts->htmlSpecialChars($itemfield['itemfield_itemfieldcategory_description']);
        } else {
            $itemfield['itemfield_itemfieldcategory_title'] = _CO_MODULE_SKELETON_ITEMFIELDCATEGORY_ROOT; // IN PROGRESS
            $itemfield['itemfield_itemfieldcategory_title_html'] = $myts->htmlSpecialChars($itemfield['itemfield_itemfieldcategory_title']);
            $itemfield['itemfield_itemfieldcategory_description'] = '';
            $itemfield['itemfield_itemfieldcategory_description_html'] = '';
        }
        $itemfield['itemfield_title_html'] = $myts->htmlSpecialChars($itemfield['itemfield_title']);
        //
        $itemfield['canEdit'] = $itemfield['itemfield_config'] || $itemfield['itemfield_show'] || $itemfield['itemfield_edit'];
        $itemfield['canDelete'] = $itemfield['itemfield_config'];
        $itemfield['itemfieldtype'] = $itemfieldtypes[$itemfield['itemfield_type']];
        $itemfield['datatype'] = $datatypes[$itemfield['itemfield_datatype']];
// IN PROGRESS
// IN PROGRESS
// IN PROGRESS
        return $itemfield;
    }

    /**
     * Get {@link XoopsThemeForm} for adding/editing items
     *
     * @param bool          $action
     * @return object       {@link XoopsThemeForm}
     */
    public function getForm($action = false)
    {
        global $xoopsUser;
        $groupperm_handler = xoops_gethandler('groupperm');
        //
        xoops_load('XoopsFormLoader');
        //
        if ($action === false) {
            $action = $_SERVER['REQUEST_URI'];
        }
        //
        $isAdmin = module_skeleton_userIsAdmin();
        $groups = is_object($xoopsUser) ? $xoopsUser->getGroups() : array(0 => XOOPS_GROUP_ANONYMOUS);
        //
        $title = $this->isNew() ? _CO_MODULE_SKELETON_BUTTON_ITEMFIELD_ADD : _CO_MODULE_SKELETON_BUTTON_ITEMFIELD_EDIT;
        //
        $form = new XoopsThemeForm($title, 'itemfieldform', $action);
        $form->setExtra('enctype="multipart/form-data"');
        // itemfield: itemfield_title
        $itemfield_title_text = new XoopsFormText(_CO_MODULE_SKELETON_ITEMFIELD_TITLE, 'itemfield_title', 50, 255, $this->getVar('itemfield_title', 'e'));
        $itemfield_title_text->setDescription(_CO_MODULE_SKELETON_ITEMFIELD_TITLE_DESC);
        $form->addElement($itemfield_title_text);
        // itemfield: itemfield_description
        $itemfield_description_textarea = new XoopsFormTextArea(_CO_MODULE_SKELETON_ITEMFIELD_DESCRIPTION, 'itemfield_description', $this->getVar('itemfield_description', 'e'));
        $itemfield_description_textarea->setDescription(_CO_MODULE_SKELETON_ITEMFIELD_DESCRIPTION_DESC);
        $form->addElement($itemfield_description_textarea);
        // itemfield: itemfield_category_id
        $itemfieldcategoryObjs = $this->module_skeleton->getHandler('itemfieldcategory')->getObjects();
        $itemfieldcategoryObjsTree = new Module_skeletonObjectTree($itemfieldcategoryObjs, 'itemfieldcategory_id', 'itemfieldcategory_pid');
        $itemfield_category_id_select = new XoopsFormLabel(_CO_MODULE_SKELETON_ITEMFIELDCATEGORY_TITLE, $itemfieldcategoryObjsTree->makeSelBox('itemfield_category_id', 'itemfieldcategory_title', '-', $this->getVar('itemfield_category_id', 'e'), array('0' => _CO_MODULE_SKELETON_ITEMFIELDCATEGORY_ROOT)));
        $itemfield_category_id_select->setDescription(_CO_MODULE_SKELETON_ITEMFIELDCATEGORY_TITLE_DESC);
        $form->addElement($itemfield_category_id_select);
        // itemfield: itemfield_weight
        $itemfield_weight_text = new XoopsFormText(_CO_MODULE_SKELETON_ITEMFIELD_WEIGHT, 'itemfield_weight', 10, 10, $this->getVar('itemfield_weight', 'e'));
        $itemfield_weight_text->setDescription(_CO_MODULE_SKELETON_ITEMFIELD_WEIGHT_DESC);
        $form->addElement($itemfield_weight_text);
        //
        if ($this->getVar('itemfield_config') == true || $this->isNew()) {
            // itemfield: itemfield_name
            if (!$this->isNew()) {
                $form->addElement(new XoopsFormLabel(_CO_MODULE_SKELETON_ITEMFIELD_NAME, $this->getVar('itemfield_name')));
                $form->addElement(new XoopsFormHidden('itemfield_id', $this->getVar('itemfield_id')));
            } else {
                $form->addElement(new XoopsFormText(_CO_MODULE_SKELETON_ITEMFIELD_NAME, 'itemfield_name', 35, 255, $this->getVar('itemfield_name', 'e')));
            }
            // itemfield: itemfield_type
            // autotext and theme left out of this one as itemfields of that type should never be changed (valid assumption, I think)
// IN PROGRESS
// IN PROGRESS
// IN PROGRESS
            $itemfieldtypes = $this->module_skeleton->getHandler('itemfield')->getItemfieldTypesList();
            $element_select = new XoopsFormSelect(_CO_MODULE_SKELETON_ITEMFIELD_TYPE, 'itemfield_type', $this->getVar('itemfield_type', 'e'));
            $element_select->addOptionArray($itemfieldtypes);
            $form->addElement($element_select);
            // itemfield: itemfield_datatype
            switch ($this->getVar('itemfield_type')) {
                case 'textbox':
                    $datatypes = array(
                        XOBJ_DTYPE_ARRAY           => _CO_MODULE_SKELETON_ITEMFIELD_VALUETYPE_ARRAY,
                        XOBJ_DTYPE_EMAIL           => _CO_MODULE_SKELETON_ITEMFIELD_VALUETYPE_EMAIL,
                        XOBJ_DTYPE_INT             => _CO_MODULE_SKELETON_ITEMFIELD_VALUETYPE_INT,
                        XOBJ_DTYPE_FLOAT           => _CO_MODULE_SKELETON_ITEMFIELD_VALUETYPE_FLOAT,
                        XOBJ_DTYPE_DECIMAL         => _CO_MODULE_SKELETON_ITEMFIELD_VALUETYPE_DECIMAL,
                        XOBJ_DTYPE_TXTAREA         => _CO_MODULE_SKELETON_ITEMFIELD_VALUETYPE_TXTAREA,
                        XOBJ_DTYPE_TXTBOX          => _CO_MODULE_SKELETON_ITEMFIELD_VALUETYPE_TXTBOX,
                        XOBJ_DTYPE_URL             => _CO_MODULE_SKELETON_ITEMFIELD_VALUETYPE_URL,
                        XOBJ_DTYPE_OTHER           => _CO_MODULE_SKELETON_ITEMFIELD_VALUETYPE_OTHER,
                        XOBJ_DTYPE_UNICODE_ARRAY   => _CO_MODULE_SKELETON_ITEMFIELD_VALUETYPE_UNICODE_ARRAY,
                        XOBJ_DTYPE_UNICODE_TXTBOX  => _CO_MODULE_SKELETON_ITEMFIELD_VALUETYPE_UNICODE_TXTBOX,
                        XOBJ_DTYPE_UNICODE_TXTAREA => _CO_MODULE_SKELETON_ITEMFIELD_VALUETYPE_UNICODE_TXTAREA,
                        XOBJ_DTYPE_UNICODE_EMAIL   => _CO_MODULE_SKELETON_ITEMFIELD_VALUETYPE_UNICODE_EMAIL,
                        XOBJ_DTYPE_UNICODE_URL     => _CO_MODULE_SKELETON_ITEMFIELD_VALUETYPE_UNICODE_URL
                    );
                    $type_select = new XoopsFormSelect(_CO_MODULE_SKELETON_ITEMFIELD_VALUETYPE, 'itemfield_datatype', $this->getVar('itemfield_datatype', 'e'));
                    $type_select->addOptionArray($datatypes);
                    $form->addElement($type_select);
                    break;
                case 'select':
                case 'radio':
                    $datatypes = array(
                        XOBJ_DTYPE_ARRAY           => _CO_MODULE_SKELETON_ITEMFIELD_VALUETYPE_ARRAY,
                        XOBJ_DTYPE_EMAIL           => _CO_MODULE_SKELETON_ITEMFIELD_VALUETYPE_EMAIL,
                        XOBJ_DTYPE_INT             => _CO_MODULE_SKELETON_ITEMFIELD_VALUETYPE_INT,
                        XOBJ_DTYPE_FLOAT           => _CO_MODULE_SKELETON_ITEMFIELD_VALUETYPE_FLOAT,
                        XOBJ_DTYPE_DECIMAL         => _CO_MODULE_SKELETON_ITEMFIELD_VALUETYPE_DECIMAL,
                        XOBJ_DTYPE_TXTAREA         => _CO_MODULE_SKELETON_ITEMFIELD_VALUETYPE_TXTAREA,
                        XOBJ_DTYPE_TXTBOX          => _CO_MODULE_SKELETON_ITEMFIELD_VALUETYPE_TXTBOX,
                        XOBJ_DTYPE_URL             => _CO_MODULE_SKELETON_ITEMFIELD_VALUETYPE_URL,
                        XOBJ_DTYPE_OTHER           => _CO_MODULE_SKELETON_ITEMFIELD_VALUETYPE_OTHER,
                        XOBJ_DTYPE_UNICODE_ARRAY   => _CO_MODULE_SKELETON_ITEMFIELD_VALUETYPE_UNICODE_ARRAY,
                        XOBJ_DTYPE_UNICODE_TXTBOX  => _CO_MODULE_SKELETON_ITEMFIELD_VALUETYPE_UNICODE_TXTBOX,
                        XOBJ_DTYPE_UNICODE_TXTAREA => _CO_MODULE_SKELETON_ITEMFIELD_VALUETYPE_UNICODE_TXTAREA,
                        XOBJ_DTYPE_UNICODE_EMAIL   => _CO_MODULE_SKELETON_ITEMFIELD_VALUETYPE_UNICODE_EMAIL,
                        XOBJ_DTYPE_UNICODE_URL     => _CO_MODULE_SKELETON_ITEMFIELD_VALUETYPE_UNICODE_URL
                    );
                    $type_select = new XoopsFormSelect(_CO_MODULE_SKELETON_ITEMFIELD_VALUETYPE, 'itemfield_datatype', $this->getVar('itemfield_datatype', 'e'));
                    $type_select->addOptionArray($datatypes);
                    $form->addElement($type_select);
                    break;
                // extra item field types
                default:
                    if ($extraItemfieldTypeObj = $this->module_skeleton->getHandler('extraitemfieldtype')->get($this->getVar('itemfield_type'), null, $this)) {
                        $extraItemfieldTypeObj->itemfield_datatype($form);
                    } else {
                        // NOP
                    }
                    break;
            }
            // itemfield: itemfield_notnull
            switch ($this->getVar('itemfield_notnull')) {
                // extra item field types
                default:
                    if ($extraItemfieldTypeObj = $this->module_skeleton->getHandler('extraitemfieldtype')->get($this->getVar('itemfield_type'), null, $this)) {
                        $extraItemfieldTypeObj->itemfield_notnull($form);
                    } else {
//            $form->addElement(new XoopsFormRadioYN(_AM_MODULE_SKELETON_NOTNULL, 'itemfield_notnull', $this->getVar('itemfield_notnull', 'e') ));                    }
                    break;
                }
            }
            // itemfield: itemfield_options
            switch ($this->getVar('itemfield_type')) {
                case 'select':
                case 'select_multi':
                case 'radio':
                case 'checkbox':
                    $options = $this->getVar('itemfield_options');
                    if (count($options) > 0) {
                        $remove_options = new XoopsFormCheckBox(_CO_MODULE_SKELETON_ITEMFIELD_REMOVEOPTIONS, 'removeOptions');
                        $remove_options->columns = 3;
                        asort($options);
                        foreach (array_keys($options) as $key) {
                            $options[$key] .= "[{$key}]";
                        }
                        $remove_options->addOptionArray($options);
                        $form->addElement($remove_options);
                    }
                    $option_text = "<table cellspacing='1'>";
                    $option_text .= "<tr>";
                    $option_text .= "<td class='width20'>" . _CO_MODULE_SKELETON_ITEMFIELD_KEY . "</td>";
                    $option_text .= "<td>" . _CO_MODULE_SKELETON_ITEMFIELD_VALUE . "</td>";
                    $option_text .= "</tr>";
                    for ($i = 0; $i < 3; ++$i) {
                        $option_text .= "<tr>";
                        $option_text .= "<td><input type='text' name='addOptions[{$i}][key]' id='addOptions[{$i}][key]' size='15' /></td>";
                        $option_text .= "<td><input type='text' name='addOptions[{$i}][value]' id='addOptions[{$i}][value]' size='35' /></td>";
                        $option_text .= "</tr>";
                        $option_text .= "<tr height='3px'>";
                        $option_text .= "<td colspan='2'> </td>";
                        $option_text .= "</tr>";
                    }
                    $option_text .= "</table>";
                    $form->addElement(new XoopsFormLabel(_CO_MODULE_SKELETON_ITEMFIELD_ADDOPTION, $option_text));
                    break;
                // extra item field types
                default:
                    if ($extraItemfieldTypeObj = $this->module_skeleton->getHandler('extraitemfieldtype')->get($this->getVar('itemfield_type'), null, $this)) {
                        $extraItemfieldTypeObj->itemfield_options($form);
                    } else {
                        // NOP
                    }
                    break;
            }
            // itemfield: itemfield_typeconfigs
            switch ($this->getVar('itemfield_type')) {
                 case 'textbox':
                    $typeconfigs = $this->getVar('itemfield_typeconfigs');
                    // default
                    if(empty($typeconfigs)) {
                        $typeconfigs = array(
                            'maxLength' => 255
                        );
                    }
                    $textbox_maxlength_text = new XoopsFormText(_CO_MODULE_SKELETON_ITEMFIELD_TYPE_TEXTBOX_MAXLENGTH, 'itemfield_typeconfigs[maxLength]', 35, 35, $typeconfigs['maxLength']);
                    $textbox_maxlength_text->setDescription(_CO_MODULE_SKELETON_ITEMFIELD_TYPE_TEXTBOX_MAXLENGTH_DESC);
                    $form->addElement($textbox_maxlength_text);
                    break;
                case 'textarea':
                case 'dhtmltextarea':
                    $typeconfigs = $this->getVar('itemfield_typeconfigs');
                    // default
                    if(empty($typeconfigs)) {
                        $typeconfigs = array(
                            'rows' => 5,
                            'cols' => 50
                        );
                    }
                    $textarea_rows_text = new XoopsFormText(_CO_MODULE_SKELETON_ITEMFIELD_TYPE_TEXTAREA_ROWS, 'itemfield_typeconfigs[rows]', 3, 3, $typeconfigs['rows']);
                    $textarea_rows_text->setDescription(_CO_MODULE_SKELETON_ITEMFIELD_TYPE_TEXTAREA_ROWS_DESC);
                    $form->addElement($textarea_rows_text);
                    $textarea_cols_text = new XoopsFormText(_CO_MODULE_SKELETON_ITEMFIELD_TYPE_TEXTAREA_COLS, 'itemfield_typeconfigs[cols]', 3, 3, $typeconfigs['cols']);
                    $textarea_cols_text->setDescription(_CO_MODULE_SKELETON_ITEMFIELD_TYPE_TEXTAREA_COLS_DESC);
                    $form->addElement($textarea_cols_text);
                    break;
                // new item field types
                case 'file':
                    $typeconfigs = $this->getVar('itemfield_typeconfigs');
                    // default
                    if(empty($typeconfigs)) {
                        $typeconfigs = array(
                            'maxFileSize' => $this->module_skeleton->getConfig('uploadMaxFileSize'),
                            'allowedMimeTypes' => '',
                            'maxnum' => 1
                        );
                    }
                    $file_maxFileSize_text = new XoopsFormText(_CO_MODULE_SKELETON_ITEMFIELD_TYPE_FILE_MAXFILESIZE, 'itemfield_typeconfigs[maxFileSize]', 50, 255, $typeconfigs['maxFileSize']);
                    $file_maxFileSize_text->setDescription(_CO_MODULE_SKELETON_ITEMFIELD_TYPE_FILE_MAXFILESIZE_DESC);
                    $form->addElement($file_maxFileSize_text);
                    $file_allowedMimeTypes_text = new XoopsFormText(_CO_MODULE_SKELETON_ITEMFIELD_TYPE_FILE_ALLOWEDMIMETYPES, 'itemfield_typeconfigs[allowedMimeTypes]', 50, 255, $typeconfigs['allowedMimeTypes']);
                    $file_allowedMimeTypes_text->setDescription(_CO_MODULE_SKELETON_ITEMFIELD_TYPE_FILE_ALLOWEDMIMETYPES_DESC);
                    $form->addElement($file_allowedMimeTypes_text);
                    $file_maxnum_text = new XoopsFormText(_CO_MODULE_SKELETON_ITEMFIELD_TYPE_FILE_MAXNUM, 'itemfield_typeconfigs[maxnum]', 50, 255, $typeconfigs['maxnum']);
                    $file_maxnum_text->setDescription(_CO_MODULE_SKELETON_ITEMFIELD_TYPE_FILE_MAXNUM_DESC);
                    $form->addElement($file_maxnum_text);
                    break;
                // extra item field types
                default:
                    if ($extraItemfieldTypeObj = $this->module_skeleton->getHandler('extraitemfieldtype')->get($this->getVar('itemfield_type'), null, $this)) {
                        $extraItemfieldTypeObj->itemfield_typeconfigs($form);
                    } else {
                        // NOP
                    }
                    break;
            }
        }
        // itemfield: itemfield_default
        if ($this->getVar('itemfield_edit') == true) {
            switch ($this->getVar('itemfield_type')) {
                case 'textbox':
                case 'textarea':
                case 'dhtmltextarea':
                    $form->addElement(new XoopsFormTextArea(_CO_MODULE_SKELETON_ITEMFIELD_DEFAULT, 'itemfield_default', $this->getVar('itemfield_default', 'e')));
                    break;
                case 'checkbox':
                case 'select_multi':
                    $def_value = $this->getVar('itemfield_default', 'e') != null ? unserialize($this->getVar('itemfield_default', 'n')) : null;
                    $element = new XoopsFormSelect(_CO_MODULE_SKELETON_ITEMFIELD_DEFAULT, 'itemfield_default', $def_value, 8, true);
                    $options = $this->getVar('itemfield_options');
                    asort($options);
                    // If options do not include an empty element, then add a blank option to prevent any default selection
                    if (!in_array('', array_keys($options))) {
                        $element->addOption('', _NONE);
                    }
                    $element->addOptionArray($options);
                    $form->addElement($element);
                    break;
                case 'select':
                case 'radio':
                    $def_value = $this->getVar('itemfield_default', 'e') != null ? $this->getVar('itemfield_default') : null;
                    $element = new XoopsFormSelect(_CO_MODULE_SKELETON_ITEMFIELD_DEFAULT, 'itemfield_default', $def_value);
                    $options = $this->getVar('itemfield_options');
                    asort($options);
                    // If options do not include an empty element, then add a blank option to prevent any default selection
                    if (!in_array('', array_keys($options))) {
                        $element->addOption('', _NONE);
                    }
                    $element->addOptionArray($options);
                    $form->addElement($element);
                    break;
                case 'date':
                    $form->addElement(new XoopsFormTextDateSelect(_CO_MODULE_SKELETON_ITEMFIELD_DEFAULT, 'itemfield_default', 15, $this->getVar('itemfield_default', 'e')));
                    break;
                case 'longdate':
                    $form->addElement(new XoopsFormTextDateSelect(_CO_MODULE_SKELETON_ITEMFIELD_DEFAULT, 'itemfield_default', 15, strtotime($this->getVar('itemfield_default', 'e'))));
                    break;
                case 'datetime':
                    $form->addElement(new XoopsFormDateTime(_CO_MODULE_SKELETON_ITEMFIELD_DEFAULT, 'itemfield_default', 15, $this->getVar('itemfield_default', 'e')));
                    break;
                case 'yesno':
                    $form->addElement(new XoopsFormRadioYN(_CO_MODULE_SKELETON_ITEMFIELD_DEFAULT, 'itemfield_default', $this->getVar('itemfield_default', 'e')));
                    break;
                case 'timezone':
                    $form->addElement(new XoopsFormSelectTimezone(_CO_MODULE_SKELETON_ITEMFIELD_DEFAULT, 'itemfield_default', $this->getVar('itemfield_default', 'e')));
                    break;
                case 'language':
                    $form->addElement(new XoopsFormSelectLang(_CO_MODULE_SKELETON_ITEMFIELD_DEFAULT, 'itemfield_default', $this->getVar('itemfield_default', 'e')));
                    break;
                case 'group':
                    $form->addElement(new XoopsFormSelectGroup(_CO_MODULE_SKELETON_ITEMFIELD_DEFAULT, 'itemfield_default', true, $this->getVar('itemfield_default', 'e')));
                    break;
                case 'group_multi':
                    $form->addElement(new XoopsFormSelectGroup(_CO_MODULE_SKELETON_ITEMFIELD_DEFAULT, 'itemfield_default', true, unserialize($this->getVar('itemfield_default', 'n')), 5, true));
                    break;
                case 'theme':
                    $form->addElement(new XoopsFormSelectTheme(_CO_MODULE_SKELETON_ITEMFIELD_DEFAULT, 'itemfield_default', $this->getVar('itemfield_default', 'e')));
                    break;
                case 'autotext':
                    $form->addElement(new XoopsFormTextArea(_CO_MODULE_SKELETON_ITEMFIELD_DEFAULT, 'itemfield_default', $this->getVar('itemfield_default', 'e')));
                    break;
                // new item field types
                case 'file':
                    // NOP
                    break;
                // extra item field types
                default:
                    if ($extraItemfieldTypeObj = $this->module_skeleton->getHandler('extraitemfieldtype')->get($this->getVar('itemfield_type'), null, $this)) {
                        $extraItemfieldTypeObj->itemfield_default($form);
                    } else {
                        // NOP
                    }
                    // NOP
                    break;
            }
        }
        // itemfield: itemfield_required
        $form->addElement(new XoopsFormRadioYN(_CO_MODULE_SKELETON_ITEMFIELD_REQUIRED, 'itemfield_required', $this->getVar('itemfield_required', 'e')));
        // permission: read
        $read_groups = $groupperm_handler->getGroupIds('itemfield_read', $this->getVar('itemfield_id'), $this->module_skeleton->getModule()->mid());
        $read_groups_select = new XoopsFormSelectGroup(_CO_MODULE_SKELETON_PERM_ITEMFIELD_READ, 'itemfield_read', true, $read_groups, 5, true);
        $read_groups_select->setDescription(_CO_MODULE_SKELETON_PERM_ITEMFIELD_READ_DESC);
        $form->addElement($read_groups_select);
        // permission: write
        if ($this->getVar('itemfield_edit') || $this->isNew()) {
            if (!$this->isNew()) {
                // Load groups
                $write_groups = $groupperm_handler->getGroupIds('itemfield_write', $this->getVar('itemfield_id'), $this->module_skeleton->getModule()->mid());
            } else {
                $write_groups = array();
            }
            $write_groups_select = new XoopsFormSelectGroup(_CO_MODULE_SKELETON_PERM_ITEMFIELD_WRITE, 'itemfield_write', false, $write_groups, 5, true);
            $write_groups_select->setDescription(_CO_MODULE_SKELETON_PERM_ITEMFIELD_WRITE_DESC);
            $form->addElement($write_groups_select);
        }
        // permission: search
        if (in_array($this->getVar('itemfield_type'), $this->module_skeleton->getHandler('itemfield')->getSearchableTypes())) {
            $search_groups = $groupperm_handler->getGroupIds('itemfield_search', $this->getVar('itemfield_id'), $this->module_skeleton->getModule()->mid());
            $search_groups_select = new XoopsFormSelectGroup(_CO_MODULE_SKELETON_PERM_ITEMFIELD_SEARCH, 'itemfield_search', true, $search_groups, 5, true);
            $search_groups_select->setDescription(_CO_MODULE_SKELETON_PERM_ITEMFIELD_SEARCH_DESC);
            $form->addElement($search_groups_select);
        }
        // form: button tray
        $button_tray = new XoopsFormElementTray('', '');
        $button_tray->addElement(new XoopsFormHidden('op', 'itemfield.save'));
        //
        $button_submit = new XoopsFormButton('', '', _SUBMIT, 'submit');
        $button_submit->setExtra('onclick="this.form.elements.op.value=\'itemfield.save\'"');
        $button_tray->addElement($button_submit);
        if ($this->isNew()) {
            // NOP
        } else {
            $button_delete = new XoopsFormButton('', '', _DELETE, 'submit');
            $button_delete->setExtra('onclick="this.form.elements.op.value=\'itemfield.delete\'"');
            $button_tray->addElement($button_delete);
        }
        $button_reset = new XoopsFormButton('', '', _RESET, 'reset');
        $button_tray->addElement($button_reset);
        //
        $button_cancel = new XoopsFormButton('', '', _CANCEL, 'button');
        $button_cancel->setExtra('onclick="history.go(-1)"');
        $button_tray->addElement($button_cancel);
        //
        $form->addElement($button_tray);
        $form->addElement(new XoopsFormHiddenToken());
        //
        return $form;
    }

    /**
    * Returns a {@link XoopsFormElement} for editing the value of this itemfield
    *
    * @param object         $itemObj {@link Module_skeletonItem} object to edit the value of
    * @return object        {@link XoopsFormElement}
    **/
    public function getEditElement($itemObj)
    {
        xoops_load('XoopsFormLoader');
        // get itemfiled vars
        if ($itemObj->isNew()) {
            $value = $this->getVar('itemfield_default');
        } else {
            $value = $itemObj->getVar($this->getVar('itemfield_name'), 'e');
        }
        $caption = $this->getVar('itemfield_title');
        $caption = defined($caption) ? constant($caption) : $caption;
        $name = $this->getVar('itemfield_name', 'e');
        $options = $this->getVar('itemfield_options');
        if (is_array($options)) {
            //asort($options);
            foreach (array_keys($options) as $key) {
                $optval = defined($options[$key]) ? constant($options[$key]) : $options[$key];
                $optkey = defined($key) ? constant($key) : $key;
                unset($options[$key]);
                $options[$optkey] = $optval;
            }
        }
        // get edit element by type
        switch ($this->getVar('itemfield_type')) {
            case 'autotext':
                //autotext is not for editing
                $element = new XoopsFormLabel($caption, $this->getOutputValue($itemObj));
                break;
            case 'textbox':
                $typeconfigs = $this->getVar('itemfield_typeconfigs');
                $maxLength = (!empty($typeconfigs['maxLength'])) ? $typeconfigs['maxLength'] : 255;
                $element = new XoopsFormText($caption, $name, 35, $maxLength, $value);
                break;
            case 'textarea':
                $typeconfigs = $this->getVar('itemfield_typeconfigs');
                $rows = (!empty($typeconfigs['rows'])) ? $typeconfigs['rows'] : 5;
                $cols = (!empty($typeconfigs['cols'])) ? $typeconfigs['cols'] : 50;
                $element = new XoopsFormTextArea($caption, $name, $value, $rows, $cols);
                break;
            case 'dhtmltextarea':
                $typeconfigs = $this->getVar('itemfield_typeconfigs');
                $rows = (!empty($typeconfigs['rows'])) ? $typeconfigs['rows'] : 5;
                $cols = (!empty($typeconfigs['cols'])) ? $typeconfigs['cols'] : 50;
                $element = new XoopsFormDhtmlTextArea($caption, $name, $value, $rows, $cols);
                break;
            case 'select':
                $element = new XoopsFormSelect($caption, $name, $value);
                // If options do not include an empty element, then add a blank option to prevent any default selection
                if (!in_array('', array_keys($options))) {
                    $element->addOption('', _NONE);
                    $eltmsg = empty($caption) ? sprintf(_FORM_ENTER, $name) : sprintf( _FORM_ENTER, $caption);
                    $eltmsg = str_replace('"', '\"', stripslashes($eltmsg));
                    $element->customValidationCode[] = "\nvar hasSelected = false; var selectBox = myform.{$name};" .
                        "for (i = 0; i < selectBox.options.length; i++) { if (selectBox.options[i].selected == true && selectBox.options[i].value != '') { hasSelected = true; break; } }" .
                        "if (!hasSelected) { window.alert(\"{$eltmsg}\"); selectBox.focus(); return false; }";
                }
                $element->addOptionArray($options);
                break;
            case 'select_multi':
                $element = new XoopsFormSelect($caption, $name, $value, 5, true);
                $element->addOptionArray($options);
                break;
            case 'radio':
                $element = new XoopsFormRadio($caption, $name, $value);
                $element->addOptionArray($options);
                break;
            case 'checkbox':
                $element = new XoopsFormCheckBox($caption, $name, $value);
                $element->addOptionArray($options);
                break;
            case 'yesno':
                $element = new XoopsFormRadioYN($caption, $name, $value);
                break;
            case 'group':
                $element = new XoopsFormSelectGroup($caption, $name, true, $value);
                break;
            case 'group_multi':
                $element = new XoopsFormSelectGroup($caption, $name, true, $value, 5, true);
                break;
            case 'language':
                $element = new XoopsFormSelectLang($caption, $name, $value);
                break;
            case 'date':
                $element = new XoopsFormTextDateSelect($caption, $name, 15, $value);
                break;
            case 'longdate':
                $element = new XoopsFormTextDateSelect($caption, $name, 15, str_replace('-', '/', $value));
                break;
            case 'datetime':
                $element = new XoopsFormDatetime($caption, $name, 15, $value);
                break;
            case 'list':
                $element = new XoopsFormSelectList($caption, $name, $value, 1, $options[0]);
                break;
            case 'timezone':
                $element = new XoopsFormSelectTimezone($caption, $name, $value);
                $element->setExtra("style='width: 280px;'");
                break;
            case 'rank':
                $element = new XoopsFormSelect($caption, $name, $value);
                xoops_load('XoopsLists');
                $ranks = XoopsLists::getUserRankList();
                $element->addOption(0, "--------------");
                $element->addOptionArray($ranks);
                break;
            case 'theme':
                $element = new XoopsFormSelect($caption, $name, $value);
                $element->addOption('0', _PROFILE_MA_SITEDEFAULT);
                $handle = opendir(XOOPS_THEME_PATH . '/');
                $dirlist = array();
                while (false !== ($file = readdir($handle) ) ) {
                    if (is_dir(XOOPS_THEME_PATH . '/' . $file) && !preg_match("/^[.]{1,2}$/", $file) && strtolower($file) != 'cvs' ) {
                        if (file_exists(XOOPS_THEME_PATH . "/" . $file . "/theme.html") && in_array($file, $GLOBALS['xoopsConfig']['theme_set_allowed'])) {
                            $dirlist[$file] = $file;
                        }
                    }
                }
                closedir($handle);
                if (!empty($dirlist)) {
                    asort($dirlist);
                    $element->addOptionArray($dirlist);
                }
                break;
            // new item field types
            case 'file':
                $typeconfigs = $this->getVar('itemfield_typeconfigs');
                $value = $itemObj->getVar($name);
                if (empty($value)) {
                    $files = array();
                } else {
                    $files = json_decode($value, true); // associative arrays
                }
                $element = new XoopsFormElementTray($caption, '<br>');
                $element->addElement(new XoopsFormHidden($name, '')); // IN PROGRESS
                // start from 0 because file informations are stored in array
                $file_key = 0;
                // existing files
                foreach ($files as $file_key => $file) {
                    $delete_formElementTray = new XoopsFormElementTray('', '&nbsp;');
                    $delete_formElementTray->addElement(new XoopsFormLabel('', $file['medianame']));
                    $delete_formButton = new XoopsFormButton('', "delete_file_name_key[$name][$file_key]", _DELETE, 'submit');
                    $delete_formButton->setExtra("onclick='this.form.elements.op.value=\"item.delete.file\";'");
                    $delete_formElementTray->addElement($delete_formButton);
                    $element->addElement($delete_formElementTray);
                    unset($delete_formElementTray);
                    ++$file_key;
                }
                // new files
                $maxnum = (!empty($typeconfigs['maxnum'])) ? $typeconfigs['maxnum'] : $file_key + 1;
                $maxFileSize = (!empty($typeconfigs['maxFileSize'])) ? $typeconfigs['maxFileSize'] : $this->module_skeleton->getConfig('uploadMaxFileSize');
                for ($file_key; $file_key < $maxnum; ++$file_key) {
                    $add_formElementTray = new XoopsFormElementTray('', '&nbsp;&nbsp;');
                    $add_formFile = new XoopsFormFile('', "upload_file_name_key($name)($file_key)", $maxFileSize);
// IN PROGRESS
// IN PROGRESS
// IN PROGRESS
                    $add_formElementTray->addElement($add_formFile);
                    $element->addElement($add_formElementTray);
                    unset($add_formElementTray);
                }
                break;
            // extra item field types
            default:
                if ($extraItemfieldTypeObj = $this->module_skeleton->getHandler('extraitemfieldtype')->get($this->getVar('itemfield_type'), $itemObj, $this)) {
                    $element = $extraItemfieldTypeObj->getEditElement();
                } else {
                    $element = new XoopsFormLabel($caption, $this->getOutputValue($itemObj));
                }
                break;
        }
        if ($this->getVar('itemfield_description') != '') {
            $element->setDescription($this->getVar('itemfield_description') );
        }

        return $element;
    }

    /**
    * Returns a value for output of this itemfield
    *
    * @param object         $itemObj {@link Module_skeletonItem} object to get the value of
    * @return mixed
    **/
    public function getOutputValue($itemObj)
    {
        // get itemfiled vars
        $name = $this->getVar('itemfield_name', 'e');
        $value = $itemObj->getVar($this->getVar('itemfield_name'));
        // get output value by type
        switch ($this->getVar('itemfield_type')) {
            case 'textbox':
                if ($this->getVar('itemfield_name') == 'url' && $value != '') {
                     return '<a href="' . formatURL($value) . '" rel="external">' . $value . '</a>';
                   } else {
                     return $value;
                }
                break;
            case 'textarea':
            case 'dhtmltextarea':
            case 'theme':
            case 'language':
            case 'list':
                return $value;
                break;
            case 'select':
            case 'radio':
                $options = $this->getVar('itemfield_options');
                if (isset($options[$value])) {
                    $value = htmlspecialchars(defined($options[$value]) ? constant($options[$value]) : $options[$value]);
                } else {
                    $value = '';
                }
                return $value;
                break;
            case 'select_multi':
            case 'checkbox':
                $options = $this->getVar('itemfield_options');
                $ret = array();
                if (count($options) > 0) {
                    foreach (array_keys($options) as $key) {
                        if (in_array($key, $value)) {
                            $ret[$key] = htmlspecialchars(defined($options[$key]) ? constant($options[$key]) : $options[$key]);
                        }
                    }
                }
                return $ret;
                break;
            case 'group':
                $member_handler = &xoops_gethandler('member');
                $options = $member_handler->getGroupList();
                $ret = isset($options[$value]) ? $options[$value] : '';
                return $ret;
                break;
            case 'group_multi':
                $member_handler = &xoops_gethandler('member');
                $options = $member_handler->getGroupList();
                $ret = array();
                foreach (array_keys($options) as $key) {
                    if (in_array($key, $value)) {
                        $ret[$key] = htmlspecialchars($options[$key]);
                    }
                }
                return $ret;
                break;
            case 'longdate':
                // return YYYY/MM/DD format - not optimal as it is not using local date format, but how do we do that
                // when we cannot convert it to a UNIX timestamp?
                return str_replace("-", "/", $value);
                break;
            case 'date':
                return formatTimestamp($value, 's');
                break;
            case 'datetime':
                if (!empty($value)) {
                       return formatTimestamp($value, 'm');
                   } else {
                       return $value = "IN_PROGRESS";
// IN PROGRESS
// IN PROGRESS
// IN PROGRESS
                   }
                break;
            case 'autotext':
                $value = $itemObj->getVar($this->getVar('itemfield_name'), 'n'); // autotext can have HTML in it
                $value = str_replace("{X_UID}", $itemObj->getVar('uid'), $value);
                $value = str_replace("{X_URL}", XOOPS_URL, $value );
                $value = str_replace("{X_UNAME}", $itemObj->getVar('uname'), $value);
                return $value;
                break;
            case 'rank':
                $userrank = $itemObj->rank();
                $user_rankimage = "";
                if (isset($userrank['image']) && $userrank['image'] != "") {
                    $user_rankimage = '<img src="' . XOOPS_UPLOAD_URL . '/' . $userrank['image'] . '" alt="' . $userrank['title'] . '" /><br />';
                }
                return $user_rankimage.$userrank['title'];
                break;
            case 'yesno':
                return $value ? _YES : _NO;
                break;
            case 'timezone':
                xoops_load('XoopsLists');
                $timezones = XoopsLists::getTimeZoneList();
                $value = empty($value) ? '0' : strval($value);
                return $timezones[str_replace('.0', '', $value)];
                break;
            // new item field types
            case 'file':
                $typeconfigs = $this->getVar('itemfield_typeconfigs');
                $value = json_decode($value, true); // associative arrays
                return $value;
                break;
            // extra item field types
            default:
                if ($extraItemfieldTypeObj = $this->module_skeleton->getHandler('extraitemfieldtype')->get($this->getVar('itemfield_type'), $itemObj, $this)) {
                    return $extraItemfieldTypeObj->getOutputValue();
                } else {
                    return $value;
                }
                break;
        }
    }

    /**
     * Returns a value ready to be saved in the database
     *
     * @param       $itemObj
     * @param mixed $value value to format
     * @return mixed
     */
    public function getValueForSave($itemObj, $value)
    {
        // get itemfiled vars
        $name = $this->getVar('itemfield_name', 'e');
        // get value for save by type
        switch ($this->getVar('itemfield_type')) {
            default:
            case 'textbox':
            case 'textarea':
            case 'dhtmltextarea':
            case 'yesno':
            case 'timezone':
            case 'theme':
            case 'language':
            case 'list':
            case 'select':
            case 'radio':
            case 'select_multi':
            case 'group':
            case 'group_multi':
                return $value;
                break;
            case 'longdate':
// IN PROGRESS
// IN PROGRESS
// IN PROGRESS
/*
                if ($value != '') {
                    $dateTimeObj = DateTime::createFromFormat(_SHORTDATESTRING, $value);
                    $dateTimeObj->setTime(0, 0, 0);
                    $ret = $dateTimeObj->format('Y-m-d');
                    unset($dateTimeObj);
                    return $ret;
                }
*/
                return $value;
                break;
            case 'checkbox':
                return (array) $value;
                break;
            case 'date':
                if ($value != '') {
                    $dateTimeObj = DateTime::createFromFormat(_SHORTDATESTRING, $value);
                    $dateTimeObj->setTime(0, 0, 0);
                    $ret = $dateTimeObj->getTimestamp() + 0;
                    unset($dateTimeObj);
                    return $ret;
                }
                return $value;
                break;
            case 'datetime':
                if (!empty($value)) {
                    $dateTimeObj = DateTime::createFromFormat(_SHORTDATESTRING, $value['date']);
                    $dateTimeObj->setTime(0, 0, 0);
                    $ret = $dateTimeObj->getTimestamp() + $value['time'];
                    unset($dateTimeObj);
                    return $ret;
                }
                return $value;
                break;
            // new item field types
            case 'file':
                $uploadDir = $this->module_skeleton->getConfig('uploadPath') . '/';
                $typeconfigs = $this->getVar('itemfield_typeconfigs');
// IN PROGRESS
// IN PROGRESS
// IN PROGRESS
                $files = json_decode($itemObj->getVar($name), true); // associative arrays
                if ($files == false) {
                    $files = array();
                }
                // check upload_dir
                if (!is_dir($uploadDir)) {
                    $indexFile = XOOPS_UPLOAD_PATH . "/index.html";
                    mkdir($uploadDir, 0777);
                    chmod($uploadDir, 0777);
                    copy($indexFile, $uploadDir . "index.html");
                }
                // upload files
                $maxFileSize = (!empty($typeconfigs['maxFileSize'])) ? $typeconfigs['maxFileSize'] : $this->module_skeleton->getConfig('uploadMaxFileSize');
                $allowedMimeTypes = (!empty($typeconfigs['allowedMimeTypes'])) ? explode('|', $typeconfigs['allowedMimeTypes']) : null;
                if (isset($_POST['xoops_upload_file'])) {
                    foreach ($_POST['xoops_upload_file'] as $media_name) {
                        preg_match('/' . preg_quote('upload_file_name_key') . '\(([\w]+)\)\(([0-9]+)\)/', $media_name, $matches);
                        $itemfield_name = $matches[1];
                        $file_key = $matches[2];
                        $uploader = new Module_skeletonMediaUploader($uploadDir, $allowedMimeTypes, $maxFileSize, null, null);
// IN PROGRESS
// IN PROGRESS
// IN PROGRESS
error_log(print_r($uploader->normalizedFILES(),true));
                        if (($itemfield_name == $name) && $uploader->mediaExists($media_name)) {
                            $uploader->setPrefix('file_') ; // keep original name
                            if ($uploader->fetchMedia($media_name) && $uploader->upload()) {
                                $files[$file_key] = array(
                                    'savedfilename' => $uploader->getSavedFileName(),
                                    'saveddestination' => $uploader->getSavedDestination(), // full path
                                    'medianame' => $uploader->getMediaName(), // original name
                                    'mediatempname' => $uploader->getMediaTmpName(),
                                    'mediatype' => $uploader->getMediaType(), // mimetype
                                    'mediasize' => $uploader->getMediaSize() // bytes
                                );
                            } else {
                                // ERROR
                                $errors = $uploader->getErrors();
                                redirect_header('javascript:history.go(-1)', 3, $errors);
                                exit();
                            }
                        }
                    }
                }
                // compact array
                $files = array_values($files);
                //return base64_encode(serialize($files));
                return json_encode($files);
                break;
            // extra item field types
            default:
                if ($extraItemfieldTypeObj = $this->module_skeleton->getHandler('extraitemfieldtype')->get($this->getVar('itemfield_type'), $itemObj, $this)) {
                    return $extraItemfieldTypeObj->getValueForSave($value);
                } else {
                    return $value;
                }
                break;
        }
    }

    /**
     * Get names of user variables
     *
     * @return array
     */
    public function getItemVars()
    {
        return $this->module_skeleton->getHandler('item')->getItemVars();
    }
}

/**
 * Class Module_skeletonItemfieldHandler
 */
class Module_skeletonItemfieldHandler extends XoopsPersistableObjectHandler
{
    /**
     * @var Module_skeletonModule_skeleton
     * @access private
     */
    private $module_skeleton = null;

    /**
     * @param null|object   $db
     */
    public function __construct($db)
    {
        parent::__construct($db, 'module_skeleton_itemfields', 'Module_skeletonItemfield', 'itemfield_id', 'itemfield_title');
        $this->module_skeleton = Module_skeletonModule_skeleton::getInstance();
    }

    /**
    * Read itemfield information from cached storage
    *
    * @param bool           $force_update read itemfields from database and not cached storage
    * @return array         array of {@link Module_skeletonItemfield} objects
    */
    public function loadItemfields($force_update = true)
    {
        // run once
        static $retItemfieldObjs = array();
        if (!empty($force_update) || count($retItemfieldObjs) == 0) {
            //$itemfieldObjs = $this->getObjects(null, false, true); // NOT USABLE, is it a Xoops bug?
            $sql = "SELECT * FROM `{$this->table}`";
            $result = $this->db->query($sql);
            $itemfieldObjs = array();
            while ($myrow = $this->db->fetchArray($result)) {
                $itemfieldObj = $this->create(false);
                $itemfieldObj->assignVars($myrow);
                $itemfieldObjs[] = $itemfieldObj;
                unset($itemfieldObj);
            }
            foreach ($itemfieldObjs as $itemfieldObj) {
                $retItemfieldObjs[$itemfieldObj->getVar('itemfield_name')] = $itemfieldObj;
            }
        }
        return $retItemfieldObjs;
    }

    /**
     * save a profile itemfield in the database
     *
     * @param object        $itemfieldObj   reference to the object
     * @param bool          $force whether to force the query execution despite security settings
     * @internal param bool $checkObject check if the object is dirty and clean the attributes
     * @return bool         FALSE if failed, TRUE if already present and unchanged or successful
     */
    public function insert($itemfieldObj, $force = false)
    {
        $itemfieldObj->setVar('itemfield_name', str_replace(' ', '_', $itemfieldObj->getVar('itemfield_name')));
        $itemfieldObj->cleanVars();
        $defaultstring = '';
        //
        switch ($itemfieldObj->getVar('itemfield_type')) {
            // standard itemfield types
            case 'datetime':
            case 'date':
                $itemfieldObj->setVar('itemfield_datatype', XOBJ_DTYPE_INT);
                $itemfieldObj->setVar('itemfield_typeconfigs', array('maxLength' => 10));
                break;
            case 'longdate':
                $itemfieldObj->setVar('itemfield_datatype', XOBJ_DTYPE_MTIME);
                break;
            case 'yesno':
                $itemfieldObj->setVar('itemfield_datatype', XOBJ_DTYPE_INT);
                $itemfieldObj->setVar('itemfield_typeconfigs', array('maxLength' => 1));
                break;
            case 'textbox':
                if ($itemfieldObj->getVar('itemfield_datatype') != XOBJ_DTYPE_INT) {
                    $itemfieldObj->setVar('itemfield_datatype', XOBJ_DTYPE_TXTBOX);
                }
                break;
            case 'autotext':
                if ($itemfieldObj->getVar('itemfield_datatype') != XOBJ_DTYPE_INT) {
                    $itemfieldObj->setVar('itemfield_datatype', XOBJ_DTYPE_TXTAREA);
                }
                break;
            case 'group_multi':
            case 'select_multi':
            case 'checkbox':
                $itemfieldObj->setVar('itemfield_datatype', XOBJ_DTYPE_ARRAY);
                break;
            case 'language':
            case 'timezone':
            case 'theme':
                $itemfieldObj->setVar('itemfield_datatype', XOBJ_DTYPE_TXTBOX);
                break;
            case 'dhtmltextarea':
            case 'textarea':
                $itemfieldObj->setVar('itemfield_datatype', XOBJ_DTYPE_TXTAREA);
                break;
            // new item field types
            case 'file':
                $itemfieldObj->setVar('itemfield_datatype', XOBJ_DTYPE_OTHER);
                break;
            // extra itemfield types
            default:
                if ($extraItemfieldTypeObj = $this->module_skeleton->getHandler('extraitemfieldtype')->get($itemfieldObj->getVar('itemfield_type'), null, $itemfieldObj)) {
                    $extraItemfieldTypeObj->insert();
                } else {
                    $itemfieldObj->setVar('itemfield_datatype', XOBJ_DTYPE_TXTBOX);
                }
                break;
        }
        //
        if ((!in_array($itemfieldObj->getVar('itemfield_name'), $this->getItemVars())) && (isset($_REQUEST['itemfield_required']))) {
            if ($itemfieldObj->isNew()) {
                // add column to table
                $sqlChangeType = 'ADD';
            } else {
                // update column information
                $sqlChangeType = "CHANGE `{$itemfieldObj->getVar('itemfield_name', 'n')}`";
            }
            $typeconfigs = $itemfieldObj->getVar('itemfield_typeconfigs');
            $maxlengthstring = (isset($typeconfigs['maxLength']) && $typeconfigs['maxLength'] > 0) ? "({$typeconfigs['maxLength']})" : '';
            // set type
            switch ($itemfieldObj->getVar('itemfield_datatype')) {
                default:
                case XOBJ_DTYPE_ARRAY:
                case XOBJ_DTYPE_UNICODE_ARRAY:
                    $sqlType = 'mediumtext';
                    break;
                case XOBJ_DTYPE_UNICODE_EMAIL:
                case XOBJ_DTYPE_UNICODE_TXTBOX:
                case XOBJ_DTYPE_UNICODE_URL:
                case XOBJ_DTYPE_EMAIL:
                case XOBJ_DTYPE_TXTBOX:
                case XOBJ_DTYPE_URL:
                    $sqlType = 'varchar';
                    // varchars must have a maxlength
                    if (!$maxlengthstring) {
                        $maxlengthstring = "(255)";
                    }
                    break;
                case XOBJ_DTYPE_INT:
                    $sqlType = 'int';
                    break;
                case XOBJ_DTYPE_DECIMAL:
                    $sqlType = 'decimal(14,6)';
                    break;
                case XOBJ_DTYPE_FLOAT:
                    $sqlType = 'float(15,9)';
                    break;
                case XOBJ_DTYPE_OTHER:
                case XOBJ_DTYPE_UNICODE_TXTAREA:
                case XOBJ_DTYPE_TXTAREA:
                    $sqlType = 'text';
                    $maxlengthstring = '';
                    break;
                case XOBJ_DTYPE_MTIME:
                    $sqlType = 'date';
                    $maxlengthstring = '';
                    break;
            }
            // alter table
            $sql = "ALTER TABLE `{$this->module_skeleton->getHandler('item')->table}`";
            $sql .= " {$sqlChangeType} `{$itemfieldObj->cleanVars['itemfield_name']}` {$sqlType}{$maxlengthstring} NULL";
            if (!$this->db->query($sql)) {
                return false;
            }
        }
        // change this to also update the cached itemfield information storage
        $itemfieldObj->setDirty();
        if (!parent::insert($itemfieldObj, $force)) {
            return false;
        }

        return $itemfieldObj->getVar('itemfield_id');
    }

    /**
     * delete an itemfield from the database
     *
     * @param object|int    $itemfieldObj reference to the object to delete
     * @param bool          $force
     * @return bool         FALSE if failed
     */
    public function delete($itemfieldObj, $force = false)
    {
        // check params
        if (is_int($itemfieldObj)) {
            $itemfield_id = (int) $itemfieldObj;
            unset($itemfieldObj);
            $itemfieldObj = $this->get((int) $itemfield_id);
            if (!$itemfieldObj) {
                return false;
            }
        } elseif (get_class($itemfieldObj) == 'Module_skeletonItemfield') {
            $itemfield_id = (int) $itemfieldObj->getVar('itemfield_id');
        } else {
            return false;
        }
        //
        switch ($itemfieldObj->getVar('itemfield_type')) {
            // standard itemfield types
            case 'datetime':
            case 'date':
            case 'longdate':
            case 'yesno':
            case 'textbox':
            case 'autotext':
            case 'group_multi':
            case 'select_multi':
            case 'checkbox':
            case 'language':
            case 'timezone':
            case 'theme':
            case 'dhtmltextarea':
            case 'textarea':
                // remove column from item table
                $sql = "ALTER TABLE {$this->module_skeleton->getHandler('item')->table}";
                $sql .= " DROP `{$itemfieldObj->getVar('itemfield_name', 'n')}`";
                if (!$this->db->query($sql)) {
                    // ERROR
                    return false;
                }
                break;
            // new item field types
            case 'file':
                // delete files from filesystem
                $uploadDir = $this->module_skeleton->getConfig('uploadPath') . '/';
                $sql = "SELECT {$itemfieldObj->getVar('itemfield_name')} FROM `{$this->module_skeleton->getHandler('item')->table}`";
                $result = $this->db->query($sql);
                //$itemfield_names = array();
                while ($myrow = $this->db->fetchArray($result)) {
                    $value = $myrow[$itemfieldObj->getVar('itemfield_name')];
                    $files = json_decode($value, true); // associative arrays
                    foreach($files as $file) {
                        unlink($uploadDir . $file['savedfilename']);
                    }
                }
                // remove column from item table
                $sql = "ALTER TABLE {$this->module_skeleton->getHandler('item')->table}";
                $sql .= " DROP `{$itemfieldObj->getVar('itemfield_name', 'n')}`";
                if (!$this->db->query($sql)) {
                    // ERROR
                    return false;
                }
                break;
            // extra itemfield types
            default:
                if ($extraItemfieldTypeObj = $this->module_skeleton->getHandler('extraitemfieldtype')->get($itemfieldObj->getVar('itemfield_type'), null, $itemfieldObj)) {
                    $extraItemfieldTypeObj->delete();
                } else {
                    // remove column from item table
                    $sql = "ALTER TABLE {$this->module_skeleton->getHandler('item')->table}";
                    $sql .= " DROP `{$itemfieldObj->getVar('itemfield_name', 'n')}`";
                    if (!$this->db->query($sql)) {
                        // ERROR
                        return false;
                    }
                }
                break;
        }
        // delete itemfield
        if (!parent::delete($itemfieldObj, $force)) {
            // ERROR
            return false;
        }
        // delete permissions
        $mid = $this->module_skeleton->getModule()->mid();
        $groupperm_handler = xoops_gethandler('groupperm');
        $groupperm_handler->deleteByModule($mid, 'itemfield.%', $itemfield_id); // % wildcard
        //$groupperm_handler->deleteByModule($mid, 'itemfield_read', $itemfield_id);
        //$groupperm_handler->deleteByModule($mid, 'itemfield_write', $itemfield_id);
        //$groupperm_handler->deleteByModule($mid, 'itemfield_search', $itemfield_id);
        return true;
    }

    /**
     * Get array of standard variable names (user table)
     *
     * @return array
     */
    public function getItemVars()
    {
        return array(
            'item_id', 'item_category_id', 'item_title',
            'item_weight', 'item_status', 'item_version', 'item_owner_uid', 'item_date'
        );
    }

    /**
     * Get array of available data types
     *
     * @return array
     */
    public function getDataTypes()
    {
        return array(
            XOBJ_DTYPE_ARRAY   => _CO_MODULE_SKELETON_ITEMFIELD_VALUETYPE_ARRAY,
            XOBJ_DTYPE_EMAIL   => _CO_MODULE_SKELETON_ITEMFIELD_VALUETYPE_EMAIL,
            XOBJ_DTYPE_INT     => _CO_MODULE_SKELETON_ITEMFIELD_VALUETYPE_INT,
            XOBJ_DTYPE_TXTAREA => _CO_MODULE_SKELETON_ITEMFIELD_VALUETYPE_TXTAREA,
            XOBJ_DTYPE_TXTBOX  => _CO_MODULE_SKELETON_ITEMFIELD_VALUETYPE_TXTBOX,
            XOBJ_DTYPE_URL     => _CO_MODULE_SKELETON_ITEMFIELD_VALUETYPE_URL,
            XOBJ_DTYPE_OTHER   => _CO_MODULE_SKELETON_ITEMFIELD_VALUETYPE_OTHER,
            XOBJ_DTYPE_MTIME   => _CO_MODULE_SKELETON_ITEMFIELD_VALUETYPE_DATE
        );
    }

    /**
     * Get array of standard itemfield types
     *
     * @return array
     */
    public function getStandardItemfieldTypesList()
    {
        return array(
            'checkbox'      => _CO_MODULE_SKELETON_ITEMFIELD_TYPE_CHECKBOX,
            'group'         => _CO_MODULE_SKELETON_ITEMFIELD_TYPE_GROUP,
            'group_multi'   => _CO_MODULE_SKELETON_ITEMFIELD_TYPE_GROUPMULTI,
            'language'      => _CO_MODULE_SKELETON_ITEMFIELD_TYPE_LANGUAGE,
            'radio'         => _CO_MODULE_SKELETON_ITEMFIELD_TYPE_RADIO,
            'select'        => _CO_MODULE_SKELETON_ITEMFIELD_TYPE_SELECT,
            'select_multi'  => _CO_MODULE_SKELETON_ITEMFIELD_TYPE_SELECTMULTI,
            'textarea'      => _CO_MODULE_SKELETON_ITEMFIELD_TYPE_TEXTAREA,
            'dhtmltextarea' => _CO_MODULE_SKELETON_ITEMFIELD_TYPE_DHTMLTEXTAREA,
            'textbox'       => _CO_MODULE_SKELETON_ITEMFIELD_TYPE_TEXTBOX,
            'timezone'      => _CO_MODULE_SKELETON_ITEMFIELD_TYPE_TIMEZONE,
            'yesno'         => _CO_MODULE_SKELETON_ITEMFIELD_TYPE_YESNO,
            'date'          => _CO_MODULE_SKELETON_ITEMFIELD_TYPE_DATE,
            'datetime'      => _CO_MODULE_SKELETON_ITEMFIELD_TYPE_DATETIME,
// IN PROGRESS
// IN PROGRESS
// IN PROGRESS
//            'longdate'      => _CO_MODULE_SKELETON_ITEMFIELD_TYPE_LONGDATE,
            'theme'         => _CO_MODULE_SKELETON_ITEMFIELD_TYPE_THEME,
            'autotext'      => _CO_MODULE_SKELETON_ITEMFIELD_TYPE_AUTOTEXT,
            'rank'          => _CO_MODULE_SKELETON_ITEMFIELD_TYPE_RANK,
            // new item field types
            'file'          => _CO_MODULE_SKELETON_ITEMFIELD_TYPE_FILE, // new
        );
    }

    /**
     * Get array of extra itemfield types
     *
     * @return array
     */
    public function getExtraitemfieldtypesList()
    {
        return $this->module_skeleton->getHandler('extraitemfieldtype')->getList();
    }

    /**
     * Get array of itemfield types
     *
     * @return array
     */
    public function getItemfieldTypesList()
    {
        $standardItemfieldTypes = $this->getStandardItemfieldTypesList();
        $extraItemfieldTypes = $this->getExtraitemfieldtypesList();
        $itemfieldTypes = array_merge($standardItemfieldTypes, $extraItemfieldTypes);
        return $itemfieldTypes;
    }

    /**
     * Get array of standard variable names (user table)
     *
     * @return array
     */
    public function getSearchableTypes()
    {
        return array('textbox', 'select', 'radio', 'yesno', 'date', 'datetime', 'timezone', 'language');
    }
}
