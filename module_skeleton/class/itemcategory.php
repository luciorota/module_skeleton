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
 * Class Module_skeletonItemcategory
 */
class Module_skeletonItemcategory extends XoopsObject
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
        $this->initVar('itemcategory_id', XOBJ_DTYPE_INT);
        $this->initVar('itemcategory_pid', XOBJ_DTYPE_INT, 0);
        $this->initVar('itemcategory_title', XOBJ_DTYPE_TXTBOX, '');
        $this->initVar('itemcategory_description', XOBJ_DTYPE_TXTAREA, '');
        $this->initVar('dohtml', XOBJ_DTYPE_INT, false); // boolean
        $this->initVar('dosmiley', XOBJ_DTYPE_INT, true); // boolean
        $this->initVar('doxcode', XOBJ_DTYPE_INT, true); // boolean
        $this->initVar('doimage', XOBJ_DTYPE_INT, true); // boolean
        $this->initVar('dobr', XOBJ_DTYPE_INT, true); // boolean
        //
        $this->initVar('itemcategory_weight', XOBJ_DTYPE_INT, 0);
        $this->initVar('itemcategory_status', XOBJ_DTYPE_INT, _MODULE_SKELETON_STATUS_WAITING);
        $this->initVar('itemcategory_version', XOBJ_DTYPE_TXTBOX, '');
        $this->initVar('itemcategory_owner_uid', XOBJ_DTYPE_INT);
        $this->initVar('itemcategory_date', XOBJ_DTYPE_INT);
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
        $itemcategory = $this->toArray();
        $itemcategory['id'] = $itemcategory['itemcategory_id'];
        $itemcategory['itemcategory_title_html'] = $myts->htmlSpecialChars($itemcategory['itemcategory_title']);
        //
        $itemcategory['itemcategory_owner_uname'] = XoopsUserUtility::getUnameFromId($itemcategory['itemcategory_owner_uid']);
        $itemcategory['itemcategory_date_formatted'] = XoopsLocal::formatTimestamp($itemcategory['itemcategory_date'], 'l');
        //
        return $itemcategory;
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
        $title = $this->isNew() ? _CO_MODULE_SKELETON_BUTTON_ITEMCATEGORY_ADD : _CO_MODULE_SKELETON_BUTTON_ITEMCATEGORY_EDIT;
        //
        $form = new XoopsThemeForm($title, 'itemcategoryform', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        // itemcategory: itemcategory_title
        $form->addElement(new XoopsFormText(_CO_MODULE_SKELETON_ITEMCATEGORY_TITLE, 'itemcategory_title', 50, 255, $this->getVar('itemcategory_title', 'e')), true);
        // itemcategory: itemcategory_description
        $editor_configs           = array();
        $editor_configs['name']   = 'itemcategory_description';
        $editor_configs['value']  = $this->getVar('itemcategory_description', 'e');
        $editor_configs['rows']   = 40;
        $editor_configs['cols']   = 80;
        $editor_configs['width']  = '100%';
        $editor_configs['height'] = '800px';
        $editor_configs['editor'] = $this->module_skeleton->getConfig('editor_options');
        $itemcategory_description_editor = new XoopsFormEditor(_CO_MODULE_SKELETON_ITEMCATEGORY_DESCRIPTION, 'itemcategory_description', $editor_configs);
        $itemcategory_description_editor->setDescription(_CO_MODULE_SKELETON_ITEMCATEGORY_DESCRIPTION_DESC);
        $form->addElement($itemcategory_description_editor);
        // itemcategory: dohtml, dosmiley, doxcode, doimage, dobr
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
        // itemcategory: itemcategory_pid
        if ($this->module_skeleton->getHandler('itemcategory')->getCount() > 0) {
            $itemcategoryObjs = $this->module_skeleton->getHandler('itemcategory')->getObjects();
            $itemcategoryObjsTree = new Module_skeletonObjectTree($itemcategoryObjs, 'itemcategory_id', 'itemcategory_pid');
            $itemcategory_pid_select = new XoopsFormLabel(_CO_MODULE_SKELETON_ITEMCATEGORY_PID_TITLE, $itemcategoryObjsTree->makeSelBox('itemcategory_pid', 'itemcategory_title', '-', $this->getVar('itemcategory_pid', 'e'), array('0' => _CO_MODULE_SKELETON_ITEMCATEGORY_ROOT)));
            $itemcategory_pid_select->setDescription(_CO_MODULE_SKELETON_ITEMCATEGORY_PID_TITLE_DESC);
            $form->addElement($itemcategory_pid_select);
        }
        // itemcategory: itemcategory_weight
        $form->addElement(new XoopsFormText(_CO_MODULE_SKELETON_ITEMCATEGORY_WEIGHT, 'itemcategory_weight', 10, 80, $this->getVar('itemcategory_weight')), false);
        // item: itemcategory_owner_uid
        if($isAdmin) {
            if (!$this->isNew()) {
                $this->setVar('itemcategory_owner_uid', $xoopsUser->getVar('uid', 'e'));
            } else {
                // NOP
            }
            $itemcategory_owner_uid_select = new XoopsFormSelectUser(_CO_MODULE_SKELETON_ITEMCATEGORY_OWNER_UNAME, 'itemcategory_owner_uid', false, $this->getVar('itemcategory_owner_uid', 'e'), 1, false);
            $itemcategory_owner_uid_select->setDescription(_CO_MODULE_SKELETON_ITEMCATEGORY_OWNER_UNAME_DESC);
            $form->addElement($itemcategory_owner_uid_select);
        }
        // itemcategory: itemcategory_date
        if($isAdmin) {
            if ($this->isNew()) {
                $this->setVar('itemcategory_date', time());
            } else {
                // NOP
            }
            $itemcategory_date_datetime = new XoopsFormDateTime(_CO_MODULE_SKELETON_ITEMCATEGORY_DATE, 'itemcategory_date', 15, $this->getVar('itemcategory_date'), true);
            $itemcategory_date_datetime->setDescription(_CO_MODULE_SKELETON_ITEMCATEGORY_DATE_DESC);
            $form->addElement($itemcategory_date_datetime);
        }
        // permission: read
        $read_groups = $groupperm_handler->getGroupIds('itemcategory_read', $this->getVar('itemcategory_id'), $this->module_skeleton->getModule()->mid());
        $read_groups_select = new XoopsFormSelectGroup(_CO_MODULE_SKELETON_PERM_ITEMCATEGORY_READ, 'itemcategory_read', true, $read_groups, 5, true);
        $read_groups_select->setDescription(_CO_MODULE_SKELETON_PERM_ITEMCATEGORY_READ_DESC);
        $form->addElement($read_groups_select);
        // permission: write
        $write_groups = $groupperm_handler->getGroupIds('itemcategory_write', $this->getVar('itemcategory_id'), $this->module_skeleton->getModule()->mid());
        $write_groups_select = new XoopsFormSelectGroup(_CO_MODULE_SKELETON_PERM_ITEMCATEGORY_WRITE, 'itemcategory_write', true, $write_groups, 5, true);
        $write_groups_select->setDescription(_CO_MODULE_SKELETON_PERM_ITEMCATEGORY_WRITE_DESC);
        $form->addElement($write_groups_select);
        // form: button tray
        $button_tray = new XoopsFormElementTray('', '');
        $button_tray->addElement(new XoopsFormHidden('op', 'itemcategory.save'));
        //
        $button_submit = new XoopsFormButton('', '', _SUBMIT, 'submit');
        $button_submit->setExtra('onclick="this.form.elements.op.value=\'itemcategory.save\'"');
        $button_tray->addElement($button_submit);
        if ($this->isNew()) {
            // NOP
        } else {
            $form->addElement(new XoopsFormHidden('itemcategory_id', $this->getVar('itemcategory_id')));
            //
            $button_delete = new XoopsFormButton('', '', _DELETE, 'submit');
            $button_delete->setExtra('onclick="this.form.elements.op.value=\'itemcategory.delete\'"');
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
 * Class Module_skeletonItemcategoryHandler
 */
class Module_skeletonItemcategoryHandler extends XoopsPersistableObjectHandler
{
    /**
     * @var Module_skeletonModule_skeleton
     * @access public
     */
    private $module_skeleton = null;

    var $allItemcategories = false;
    var $topItemcategories = false;

    /**
     * @param null|object   $db
     */
    public function __construct($db)
    {
        parent::__construct($db, 'module_skeleton_itemcategories', 'Module_skeletonItemcategory', 'itemcategory_id', 'itemcategory_title');
        $this->module_skeleton = Module_skeletonModule_skeleton::getInstance();
    }

    /**
     * delete a itemcategory, child categories and items from the database
     *
     * @param object|int    $itemcategoryObj
     * @param bool          $force
     * @return bool         TRUE on success or FALSE on failure
     */
    public function delete($itemcategoryObj, $force = false)
    {
        // check params
        if (is_int($itemcategoryObj)) {
            $itemcategory_id = (int) $itemcategoryObj;
            unset($itemcategoryObj);
            $itemcategoryObj = $this->get((int) $itemcategory_id);
            if (!$itemcategoryObj) {
                return false;
            }
        } elseif (get_class($itemcategoryObj) == 'Module_skeletonCategory') {
            $itemcategory_id = (int) $itemcategoryObj->getVar('itemcategory_id');
        } else {
            return false;
        }
        // delete items
        $itemObjs = $this->module_skeleton->getHandler('item')->getObjects(new Criteria('item_category_id', $itemcategory_id));
        foreach($itemObjs as $itemObj) {
            if (!$this->module_skeleton->getHandler('item')->delete($itemObj)) { // delete as object
                // ERROR
                return false;
            }
        }
        // delete child categories
        //include_once XOOPS_ROOT_PATH . '/class/tree.php';
        $itemcategoryObjs = $this->getObjects();
        $itemcategoryObjsTree = new Module_skeletonObjectTree($itemcategoryObjs, 'itemcategory_id', 'itemcategory_pid');
        $childCategoryObjs = $itemcategoryObjsTree->getAllChild($itemcategory_id);
        foreach ($childCategoryObjs as $childCategoryObj) {
            if (!$this->delete($childCategoryObj, $force)) {
                // ERROR
                return false;
            }
        }
        // delete itemcategory
        if (!parent::delete($itemcategoryObj, $force)) {
            // ERROR
            return false;
        }
        // delete permissions
        $mid = $this->module_skeleton->getModule()->mid();
        $groupperm_handler = xoops_gethandler('groupperm');
        $groupperm_handler->deleteByModule($mid, 'itemcategory.%', $itemcategory_id);
        //$groupperm_handler->deleteByModule($mid, 'itemcategory_read', $itemcategory_id);
        //$groupperm_handler->deleteByModule($mid, 'itemcategory_write', $itemcategory_id);
        return true;
    }
}
