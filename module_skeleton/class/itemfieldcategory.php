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
 * Class Module_skeletonItemfieldcategory
 */
class Module_skeletonItemfieldcategory extends XoopsObject
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
        $this->initVar('itemfieldcategory_id', XOBJ_DTYPE_INT);
        $this->initVar('itemfieldcategory_pid', XOBJ_DTYPE_INT, 0);
        $this->initVar('itemfieldcategory_title', XOBJ_DTYPE_TXTBOX, '');
        $this->initVar('itemfieldcategory_description', XOBJ_DTYPE_TXTAREA, '');
        $this->initVar('dohtml', XOBJ_DTYPE_INT, false); // boolean
        $this->initVar('dosmiley', XOBJ_DTYPE_INT, true); // boolean
        $this->initVar('doxcode', XOBJ_DTYPE_INT, true); // boolean
        $this->initVar('doimage', XOBJ_DTYPE_INT, true); // boolean
        $this->initVar('dobr', XOBJ_DTYPE_INT, true); // boolean
        //
        $this->initVar('itemfieldcategory_weight', XOBJ_DTYPE_INT, 0);
        $this->initVar('itemfieldcategory_status', XOBJ_DTYPE_INT, _MODULE_SKELETON_STATUS_WAITING);
        $this->initVar('itemfieldcategory_version', XOBJ_DTYPE_TXTBOX, '');
        $this->initVar('itemfieldcategory_owner_uid', XOBJ_DTYPE_INT);
        $this->initVar('itemfieldcategory_date', XOBJ_DTYPE_INT);
    }

    /**
     * This method return {@link Module_skeletonItem} values as array ready for html output
     *
     * @return  array
     */
    public function getInfo()
    {
        global $myts;
        xoops_load('XoopsUserUtility');
        //
        $itemfieldcategory = $this->toArray();
        $itemfieldcategory['id'] = $itemfieldcategory['itemfieldcategory_id'];
        $itemfieldcategory['itemfieldcategory_title_html'] = $myts->htmlSpecialChars($itemfieldcategory['itemfieldcategory_title']);
        //
        $itemfieldcategory['itemfieldcategory_owner_uname'] = XoopsUserUtility::getUnameFromId($itemfieldcategory['itemfieldcategory_owner_uid']);
        $itemfieldcategory['itemfieldcategory_date_formatted'] = XoopsLocal::formatTimestamp($itemfieldcategory['itemfieldcategory_date'], 'l');
        //
        return $itemfieldcategory;
    }

    /**
     * Get {@link XoopsThemeForm} for adding/editing categories
     *
     * @param bool          $action
     * @return object       {@link XoopsThemeForm}
     */
    function getForm($action = false)
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
        $title = $this->isNew() ? _CO_MODULE_SKELETON_BUTTON_ITEMFIELDCATEGORY_ADD : _CO_MODULE_SKELETON_BUTTON_ITEMFIELDCATEGORY_EDIT;
        //
        $form = new XoopsThemeForm($title, 'itemfieldcategoryform', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        // itemfieldcategory: itemfieldcategory_title
        $form->addElement(new XoopsFormText(_CO_MODULE_SKELETON_ITEMFIELDCATEGORY_TITLE, 'itemfieldcategory_title', 50, 255, $this->getVar('itemfieldcategory_title', 'e')), true);
        // itemfieldcategory: itemfieldcategory_description
        $editor_configs           = array();
        $editor_configs['name']   = 'itemfieldcategory_description';
        $editor_configs['value']  = $this->getVar('itemfieldcategory_description', 'e');
        $editor_configs['rows']   = 40;
        $editor_configs['cols']   = 80;
        $editor_configs['width']  = '100%';
        $editor_configs['height'] = '800px';
        $editor_configs['editor'] = $this->module_skeleton->getConfig('editor_options');
        $itemfieldcategory_description_editor = new XoopsFormEditor(_CO_MODULE_SKELETON_ITEMFIELDCATEGORY_DESCRIPTION, 'itemfieldcategory_description', $editor_configs);
        $itemfieldcategory_description_editor->setDescription(_CO_MODULE_SKELETON_ITEMFIELDCATEGORY_DESCRIPTION_DESC);
        $form->addElement($itemfieldcategory_description_editor);
        // itemfieldcategory: dohtml, dosmiley, doxcode, doimage, dobr
        $options_tray = new XoopsFormElementTray(_CO_MODULE_SKELETON_TEXTOPTIONS, ' ');
        $options_tray->setDescription(_CO_MODULE_SKELETON_TEXTOPTIONS_DESC);
        $html_checkbox = new XoopsFormCheckBox('', 'dohtml', $this->getVar('dohtml'));
        $html_checkbox->addOption(1, _CO_MODULE_SKELETON_ALLOWHTML);
        $options_tray->addElement($html_checkbox);
        $smiley_checkbox = new XoopsFormCheckBox('', 'dosmiley', $this->getVar('dosmiley'));
        $smiley_checkbox->addOption(1, _CO_MODULE_SKELETON_ALLOWSMILEY);
        $options_tray->addElement($smiley_checkbox);
        $xcodes_checkbox = new XoopsFormCheckBox('', 'doxcode', $this->getVar('doxcode'));
        $xcodes_checkbox->addOption(1, _CO_MODULE_SKELETON_ALLOWXCODE);
        $options_tray->addElement($xcodes_checkbox);
        $noimages_checkbox = new XoopsFormCheckBox('', 'doimage', $this->getVar('doimage'));
        $noimages_checkbox->addOption(1, _CO_MODULE_SKELETON_ALLOWIMAGES);
        $options_tray->addElement($noimages_checkbox);
        $breaks_checkbox = new XoopsFormCheckBox('', 'dobr', $this->getVar('dobr'));
        $breaks_checkbox->addOption(1, _CO_MODULE_SKELETON_ALLOWBREAK);
        $options_tray->addElement($breaks_checkbox);
        $form->addElement($options_tray);
        // itemfieldcategory: itemfieldcategory_pid
        if ($this->module_skeleton->getHandler('itemfieldcategory')->getCount() > 0) {
            $itemfieldcategoryObjs = $this->module_skeleton->getHandler('itemfieldcategory')->getObjects();
            $itemfieldcategoryObjsTree = new Module_skeletonObjectTree($itemfieldcategoryObjs, 'itemfieldcategory_id', 'itemfieldcategory_pid');
            $itemfieldcategory_pid_select = new XoopsFormLabel(_CO_MODULE_SKELETON_ITEMFIELDCATEGORY_PID_TITLE, $itemfieldcategoryObjsTree->makeSelBox('itemfieldcategory_pid', 'itemfieldcategory_title', '-', $this->getVar('itemfieldcategory_pid', 'e'), array('0' => _CO_MODULE_SKELETON_ITEMFIELDCATEGORY_ROOT)));
            $itemfieldcategory_pid_select->setDescription(_CO_MODULE_SKELETON_ITEMFIELDCATEGORY_PID_TITLE_DESC);
            $form->addElement($itemfieldcategory_pid_select);
        }
        // itemfieldcategory: itemfieldcategory_weight
        $form->addElement(new XoopsFormText(_CO_MODULE_SKELETON_ITEMFIELDCATEGORY_WEIGHT, 'itemfieldcategory_weight', 10, 80, $this->getVar('itemfieldcategory_weight')), false);
        // item: itemfieldcategory_owner_uid
        if($isAdmin) {
            if (!$this->isNew()) {
                $this->setVar('itemfieldcategory_owner_uid', $xoopsUser->getVar('uid', 'e'));
            } else {
                // NOP
            }
            $itemfieldcategory_owner_uid_select = new XoopsFormSelectUser(_CO_MODULE_SKELETON_ITEMFIELDCATEGORY_OWNER_UNAME, 'itemfieldcategory_owner_uid', false, $this->getVar('itemfieldcategory_owner_uid', 'e'), 1, false);
            $itemfieldcategory_owner_uid_select->setDescription(_CO_MODULE_SKELETON_ITEMFIELDCATEGORY_OWNER_UNAME_DESC);
            $form->addElement($itemfieldcategory_owner_uid_select);
        }
        // itemfieldcategory: itemfieldcategory_date
        if($isAdmin) {
            if ($this->isNew()) {
                $this->setVar('itemfieldcategory_date', time());
            } else {
                // NOP
            }
            $itemfieldcategory_date_datetime = new XoopsFormDateTime(_CO_MODULE_SKELETON_ITEMFIELDCATEGORY_DATE, 'itemfieldcategory_date', 15, $this->getVar('itemfieldcategory_date'), true);
            $itemfieldcategory_date_datetime->setDescription(_CO_MODULE_SKELETON_ITEMFIELDCATEGORY_DATE_DESC);
            $form->addElement($itemfieldcategory_date_datetime);
        }
        // permission: read
        $read_groups = $groupperm_handler->getGroupIds('itemfieldcategory_read', $this->getVar('itemfieldcategory_id'), $this->module_skeleton->getModule()->mid());
        $read_groups_select = new XoopsFormSelectGroup(_CO_MODULE_SKELETON_PERM_ITEMFIELDCATEGORY_READ, 'itemfieldcategory_read', true, $read_groups, 5, true);
        $read_groups_select->setDescription(_CO_MODULE_SKELETON_PERM_ITEMFIELDCATEGORY_READ_DESC);
        $form->addElement($read_groups_select);
        // permission: write
        $write_groups = $groupperm_handler->getGroupIds('itemfieldcategory_write', $this->getVar('itemfieldcategory_id'), $this->module_skeleton->getModule()->mid());
        $write_groups_select = new XoopsFormSelectGroup(_CO_MODULE_SKELETON_PERM_ITEMFIELDCATEGORY_WRITE, 'itemfieldcategory_write', true, $write_groups, 5, true);
        $write_groups_select->setDescription(_CO_MODULE_SKELETON_PERM_ITEMFIELDCATEGORY_WRITE_DESC);
        $form->addElement($write_groups_select);
        // form: button tray
        $button_tray = new XoopsFormElementTray('', '');
        $button_tray->addElement(new XoopsFormHidden('op', 'itemfieldcategory.save'));
        //
        $button_submit = new XoopsFormButton('', '', _SUBMIT, 'submit');
        $button_submit->setExtra('onclick="this.form.elements.op.value=\'itemfieldcategory.save\'"');
        $button_tray->addElement($button_submit);
        if ($this->isNew()) {
            // NOP
        } else {
            $form->addElement(new XoopsFormHidden('itemfieldcategory_id', $this->getVar('itemfieldcategory_id')));
            //
            $button_delete = new XoopsFormButton('', '', _DELETE, 'submit');
            $button_delete->setExtra('onclick="this.form.elements.op.value=\'itemfieldcategory.delete\'"');
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
        //
        return $form;
    }
}

/**
 * Class Module_skeletonItemfieldcategoryHandler
 */
class Module_skeletonItemfieldcategoryHandler extends XoopsPersistableObjectHandler
{
    /**
     * @var Module_skeletonModule_skeleton
     * @access public
     */
    private $module_skeleton = null;

    var $allItemfieldcategories = false;
    var $topItemfieldcategories = false;

    /**
     * @param null|object   $db
     */
    public function __construct($db)
    {
        parent::__construct($db, 'module_skeleton_itemfieldcategories', 'Module_skeletonItemfieldcategory', 'itemfieldcategory_id', 'itemfieldcategory_title');
        $this->module_skeleton = Module_skeletonModule_skeleton::getInstance();
    }

    /**
     * delete a itemfieldcategory, child categories and items from the database
     *
     * @param object|int    $itemfieldcategoryObj
     * @param bool          $force
     * @return bool         TRUE on success or FALSE on failure
     */
    public function delete($itemfieldcategoryObj, $force = false)
    {
        // check params
        if (is_int($itemfieldcategoryObj)) {
            $itemfieldcategory_id = (int) $itemfieldcategoryObj;
            unset($itemfieldcategoryObj);
            $itemfieldcategoryObj = $this->get((int) $itemfieldcategory_id);
            if (!$itemfieldcategoryObj) {
                return false;
            }
        } elseif (get_class($itemfieldcategoryObj) == 'Module_skeletonCategory') {
            $itemfieldcategory_id = (int) $itemfieldcategoryObj->getVar('itemfieldcategory_id');
        } else {
            return false;
        }
        // delete items
        $itemObjs = $this->module_skeleton->getHandler('item')->getObjects(new Criteria('item_category_id', $itemfieldcategory_id));
        foreach($itemObjs as $itemObj) {
            if (!$this->module_skeleton->getHandler('item')->delete($itemObj)) { // delete as object
                // ERROR
                return false;
            }
        }
        // delete child categories
        //include_once XOOPS_ROOT_PATH . '/class/tree.php';
        $itemfieldcategoryObjs = $this->getObjects();
        $itemfieldcategoryObjsTree = new Module_skeletonObjectTree($itemfieldcategoryObjs, 'itemfieldcategory_id', 'itemfieldcategory_pid');
        $childCategoryObjs = $itemfieldcategoryObjsTree->getAllChild($itemfieldcategory_id);
        foreach ($childCategoryObjs as $childCategoryObj) {
            if (!$this->delete($childCategoryObj, $force)) {
                // ERROR
                return false;
            }
        }
        // delete itemfieldcategory
        if (!parent::delete($itemfieldcategoryObj, $force)) {
            // ERROR
            return false;
        }
        // delete permissions
        $mid = $this->module_skeleton->getModule()->mid();
        $groupperm_handler = xoops_gethandler('groupperm');
        $groupperm_handler->deleteByModule($mid, 'itemfieldcategory.%', $itemfieldcategory_id);
        //$groupperm_handler->deleteByModule($mid, 'itemfieldcategory_read', $itemfieldcategory_id);
        //$groupperm_handler->deleteByModule($mid, 'itemfieldcategory_write', $itemfieldcategory_id);
        return true;
    }
}
