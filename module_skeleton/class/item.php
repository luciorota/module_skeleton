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
 * Class Module_skeletonItem
 */
class Module_skeletonItem extends XoopsObject
{
    /**
     * @var Module_skeletonModule_skeleton
     * @access private
     */
    private $module_skeletonHelper = null;

    /**
     * @var Module_skeletonCategory
     * @access private
     */
    private $itemcategoryObj = null;

    /**
     * constructor
     *
     * @param array         $itemfields array of {@link module_skeletonItemfield} objects
     */
    public function __construct($itemfields)
    {
        $this->module_skeletonHelper = \Xmf\Module\Helper::getHelper('module_skeleton');
        $this->db = XoopsDatabaseFactory::getDatabaseConnection();
        $this->initVar('item_id', XOBJ_DTYPE_INT);
        $this->initVar('item_category_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('item_title', XOBJ_DTYPE_TXTBOX, '');
        //
        $this->initVar('item_weight', XOBJ_DTYPE_INT, 0);
        $this->initVar('item_status', XOBJ_DTYPE_INT, _MODULE_SKELETON_STATUS_WAITING);
        $this->initVar('item_version', XOBJ_DTYPE_TXTBOX, '');
        $this->initVar('item_owner_uid', XOBJ_DTYPE_INT);
        $this->initVar('item_date', XOBJ_DTYPE_INT);
        //
        $this->initExtraVars($itemfields);
    }

    /**
    * Initiate variables
    * @param array          $itemfieldObjs array of {@link Module_skeletonItemfield} objects
    */
    private function initExtraVars($itemfieldObjs)
    {
        if (is_array($itemfieldObjs) && count($itemfieldObjs) > 0) {
            foreach ($itemfieldObjs as $itemfieldObj) {
                $this->initVar(
                    $itemfieldObj->getVar('itemfield_name'),
                    $itemfieldObj->getVar('itemfield_datatype'),
                    $itemfieldObj->getVar('itemfield_default', 'n'),
                    $itemfieldObj->getVar('itemfield_required')
                );
            }
        }
    }

    /**
     * @return null|object  {@link module_skeletonItemcategory}
     */
    public function getItemcategory()
    {
        if (!isset($this->itemcategoryObj)) {
            $this->itemcategoryObj = $this->module_skeletonHelper->getHandler('itemcategory')->get($this->getVar('item_category_id'));
        }
        return $this->itemcategoryObj;
    }

    /**
     * This method return {@link Module_skeletonItem} values as array ready for html output
     *
     * @return array
     */
    public function getInfo()
    {
        global $myts;
        global $xoopsUser;
        $groupperm_handler = xoops_gethandler('groupperm');
        //
        xoops_load('XoopsUserUtility');
        //
        $isAdmin = $this->module_skeletonHelper->isUserAdmin();
        $groups = is_object($xoopsUser) ? $xoopsUser->getGroups() : array(0 => XOOPS_GROUP_ANONYMOUS);
        //
        $item = $this->toArray();
        $item['id'] = $item['item_id'];
        $item['cid'] = $item['item_category_id'];
        if ($item['item_category_id'] != 0) {
            $itemcategoryObj = $this->getItemcategory();
            $item['item_itemcategory_title'] = $itemcategoryObj->getVar('itemcategory_title');
            $item['item_itemcategory_title_html'] = $myts->htmlSpecialChars($item['item_itemcategory_title']);
            $item['item_itemcategory_description'] = $itemcategoryObj->getVar('itemcategory_description');
            $item['item_itemcategory_description_html'] = $myts->htmlSpecialChars($item['item_itemcategory_description']);
        } else {
            $item['item_itemcategory_title'] = _CO_MODULE_SKELETON_ITEMCATEGORY_ROOT; // IN PROGRESS
            $item['item_itemcategory_title_html'] = $myts->htmlSpecialChars($item['item_itemcategory_title']);
            $item['item_itemcategory_description'] = _CO_MODULE_SKELETON_ITEMCATEGORY_ROOT_DESC;
            $item['item_itemcategory_description_html'] = $myts->htmlSpecialChars($item['item_itemcategory_description']);
        }
        $item['item_title_html'] = $myts->htmlSpecialChars($item['item_title']);
        //
        $item['item_owner_uname'] = XoopsUserUtility::getUnameFromId($item['item_owner_uid']);
        $item['item_date_formatted'] = XoopsLocal::formatTimestamp($item['item_date'], 'l');
        //

        // item: extra item fields
        $itemfieldCriteria = new Criteria('itemfield_category_id', 0);
        $itemfieldCriteria->setSort('itemfield_weight');
        $itemfieldCriteria->setOrder('ASC');
        $itemfieldObjs = $this->module_skeletonHelper->getHandler('itemfield')->getObjects($itemfieldCriteria);
        foreach ($itemfieldObjs as $itemfieldObj) {
            $item[$itemfieldObj->getVar('itemfield_name')] = $itemfieldObj->getOutputValue($this);
        }
        // get readable && writable itemfieldcategory ids
        $permReadIds = $groupperm_handler->getItemIds('itemfieldcategoryRead', $groups, $this->module_skeletonHelper->getModule()->mid());
        $permWriteIds = $groupperm_handler->getItemIds('itemfieldcategoryWrite', $groups, $this->module_skeletonHelper->getModule()->mid());
        $permIds = array_intersect($permReadIds, $permWriteIds);
        $itemfieldcategoryCriteria = new CriteriaCompo();
        $itemfieldcategoryCriteria->add(new Criteria('itemfieldcategory_id', '(' . implode(',', $permIds) . ')', 'IN'));
        // get and sort itemfieldcategories
        $itemfieldcategoryCount = $this->module_skeletonHelper->getHandler('itemfieldcategory')->getCount($itemfieldcategoryCriteria);
        if ($itemfieldcategoryCount > 0) {
            $sortedItemfieldcategories = module_skeleton_sortItemfieldcategories($itemfieldcategoryCriteria); // as array
            foreach ($sortedItemfieldcategories as $sortedItemfieldcategory) {
// IN PROGRESS
// IN PROGRESS check permissions
// IN PROGRESS
                $itemfieldcategory = $sortedItemfieldcategory['itemfieldcategory']; // as array
                $itemfieldCriteria = new Criteria('itemfield_category_id', $itemfieldcategory['itemfieldcategory_id']);
                $itemfieldCriteria->setSort('itemfield_weight');
                $itemfieldCriteria->setOrder('ASC');
                $itemfieldObjs = $this->module_skeletonHelper->getHandler('itemfield')->getObjects($itemfieldCriteria);
                if (count($itemfieldObjs) > 0) {
                    $itemfieldcategory_label = new XoopsFormLabel($itemfieldcategory['itemfieldcategory_title'], $itemfieldcategory['itemfieldcategory_description']);
                    //$itemfieldcategory_label->setDescription($itemfieldcategory['itemfieldcategory_description']);
                    $form->addElement($itemfieldcategory_label);
                    foreach ($itemfieldObjs as $itemfieldObj) {
                        $item[$itemfieldObj->getVar('itemfield_name')] = $itemfieldObj->getOutputValue($this);
                    }
                    unset($itemfieldcategory_label);
                }
            }
        }





// IN PROGRESS
// IN PROGRESS
// IN PROGRESS
        return $item;
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
        $isAdmin = $this->module_skeletonHelper->isUserAdmin();
        $groups = is_object($xoopsUser) ? $xoopsUser->getGroups() : array(0 => XOOPS_GROUP_ANONYMOUS);
        //
        $title = $this->isNew() ? _CO_MODULE_SKELETON_BUTTON_ITEM_ADD : _CO_MODULE_SKELETON_BUTTON_ITEM_EDIT;
        //
        $form = new XoopsThemeForm($title, 'itemform', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        // item: item_title
        $item_title_text = new XoopsFormText(_CO_MODULE_SKELETON_ITEM_TITLE, 'item_title', 50, 255, $this->getVar('item_title', 'e'));
        $item_title_text->setDescription(_CO_MODULE_SKELETON_ITEM_TITLE_DESC);
        $form->addElement($item_title_text, true);
        // item: item_category_id
        $itemcategoryObjs = $this->module_skeletonHelper->getHandler('itemcategory')->getObjects();
        $itemcategoryObjsTree = new Module_skeletonObjectTree($itemcategoryObjs, 'itemcategory_id', 'itemcategory_pid');
        $item_category_id_select = new XoopsFormLabel(_CO_MODULE_SKELETON_ITEMCATEGORY_TITLE, $itemcategoryObjsTree->makeSelBox('item_category_id', 'itemcategory_title', '-', $this->getVar('item_category_id', 'e'), array('0' => _CO_MODULE_SKELETON_ITEMCATEGORY_ROOT)));
        $item_category_id_select->setDescription(_CO_MODULE_SKELETON_ITEMCATEGORY_TITLE_DESC);
        $form->addElement($item_category_id_select);
        // item: item_weight
        $item_weight_text = new XoopsFormText(_CO_MODULE_SKELETON_ITEM_WEIGHT, 'item_weight', 10, 80, $this->getVar('item_weight'));
        $item_weight_text->setDescription(_CO_MODULE_SKELETON_ITEM_WEIGHT_DESC);
        $form->addElement($item_weight_text, false);
        // item: item_owner_uid
        if($isAdmin) {
            if ($this->isNew()) {
                $this->setVar('item_owner_uid', $xoopsUser->getVar('uid', 'e'));
            } else {
                // NOP
            }
            $item_owner_uid_select = new XoopsFormSelectUser(_CO_MODULE_SKELETON_ITEM_OWNER_UNAME, 'item_owner_uid', false, $this->getVar('item_owner_uid', 'e'), 1, false);
            $item_owner_uid_select->setDescription(_CO_MODULE_SKELETON_ITEM_OWNER_UNAME_DESC);
            $form->addElement($item_owner_uid_select);
        }
        // item: item_date
        if($isAdmin) {
            if ($this->isNew()) {
                $this->setVar('item_date', time());
            } else {
                // NOP
            }
            $item_date_datetime = new XoopsFormDateTime(_CO_MODULE_SKELETON_ITEM_DATE, 'item_date', 15, $this->getVar('item_date'), true);
            $item_date_datetime->setDescription(_CO_MODULE_SKELETON_ITEM_DATE_DESC);
            $form->addElement($item_date_datetime);
        }
        // item: extra item fields
        $itemfieldCriteria = new Criteria('itemfield_category_id', 0);
        $itemfieldCriteria->setSort('itemfield_weight');
        $itemfieldCriteria->setOrder('ASC');
        $itemfieldObjs = $this->module_skeletonHelper->getHandler('itemfield')->getObjects($itemfieldCriteria);
        foreach ($itemfieldObjs as $itemfieldObj) {
            $form->addElement($itemfieldObj->getEditElement($this), $itemfieldObj->getVar('itemfield_required'));
        }
        // get readable && writable itemfieldcategory ids
        $permReadIds = $groupperm_handler->getItemIds('itemfieldcategoryRead', $groups, $this->module_skeletonHelper->getModule()->mid());
        $permWriteIds = $groupperm_handler->getItemIds('itemfieldcategoryWrite', $groups, $this->module_skeletonHelper->getModule()->mid());
        $permIds = array_intersect($permReadIds, $permWriteIds);
        $itemfieldcategoryCriteria = new CriteriaCompo();
        $itemfieldcategoryCriteria->add(new Criteria('itemfieldcategory_id', '(' . implode(',', $permIds) . ')', 'IN'));
        // get and sort itemfieldcategories
        $itemfieldcategoryCount = $this->module_skeletonHelper->getHandler('itemfieldcategory')->getCount($itemfieldcategoryCriteria);
        if ($itemfieldcategoryCount > 0) {
            $sortedItemfieldcategories = module_skeleton_sortItemfieldcategories($itemfieldcategoryCriteria); // as array
            foreach ($sortedItemfieldcategories as $sortedItemfieldcategory) {
// IN PROGRESS
// IN PROGRESS check permissions
// IN PROGRESS
                $itemfieldcategory = $sortedItemfieldcategory['itemfieldcategory']; // as array
                $itemfieldCriteria = new Criteria('itemfield_category_id', $itemfieldcategory['itemfieldcategory_id']);
                $itemfieldCriteria->setSort('itemfield_weight');
                $itemfieldCriteria->setOrder('ASC');
                $itemfieldObjs = $this->module_skeletonHelper->getHandler('itemfield')->getObjects($itemfieldCriteria);
                if (count($itemfieldObjs) > 0) {
                    $itemfieldcategory_label = new XoopsFormLabel($itemfieldcategory['itemfieldcategory_title'], $itemfieldcategory['itemfieldcategory_description']);
                    //$itemfieldcategory_label->setDescription($itemfieldcategory['itemfieldcategory_description']);
                    $form->addElement($itemfieldcategory_label);
                    foreach ($itemfieldObjs as $itemfieldObj) {
                        $form->addElement($itemfieldObj->getEditElement($this), $itemfieldObj->getVar('itemfield_required'));
                    }
                    unset($itemfieldcategory_label);
                }
            }
        }
        // form: button tray
        $button_tray = new XoopsFormElementTray('', '');
        $button_tray->addElement(new XoopsFormHidden('op', 'item.save'));
        //
        $button_submit = new XoopsFormButton('', '', _SUBMIT, 'submit');
        $button_submit->setExtra('onclick="this.form.elements.op.value=\'item.save\'"');
        $button_tray->addElement($button_submit);
        if ($this->isNew()) {
            // NOP
        } else {
            $form->addElement(new XoopsFormHidden('item_id', (int) $this->getVar('item_id')));
            //
            $button_delete = new XoopsFormButton('', '', _DELETE, 'submit');
            $button_delete->setExtra('onclick="this.form.elements.op.value=\'item.delete\'"');
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
 * Class Module_skeletonItemHandler
 */
class Module_skeletonItemHandler extends XoopsPersistableObjectHandler
{
    /**
     * @var Module_skeletonModule_skeleton
     * @access private
     */
    private $module_skeletonHelper = null;

    /**
     * Array of {@link Module_skeletonItemfield} objects
     * @var array
     * @access private
     */
    private $itemfields = array();

    /**
     * @param null|object   $db
     */
    public function __construct($db)
    {
        parent::__construct($db, 'mod_module_skeleton_items', 'Module_skeletonItem', 'item_id', 'item_title');
        $this->module_skeletonHelper = \Xmf\Module\Helper::getHelper('module_skeleton');
    }

    /**
     * Create a new {@link Module_skeletonItem} object
     *
     * @param bool          $isNew Flag the new objects as "new"?
     *
     * @return object       {@link module_skeletonItem}
     */
    public function create($isNew = true)
    {
        $itemObj = new $this->className($this->loadItemfields());
        $itemObj->handler = $this;
        if ($isNew === true) {
            $itemObj->setNew();
        }
        return $itemObj;
    }

    /**
    * Load item field information
    *
    * @return array
    */
    function loadItemfields()
    {
        if (count($this->itemfields) == 0) {
            $this->itemfields = $this->module_skeletonHelper->getHandler('itemfield')->loadItemfields();
        }
        return $this->itemfields;
    }

    /**
    * Create new {@link module_skeletonItemfield} object
    *
    * @param bool           $isNew
    *
    * @return object        {@link module_skeletonItemfield}
    */
    function createItemfield($isNew = true)
    {
        $return = $this->module_skeletonHelper->getHandler('itemfield')->create($isNew);

        return $return;
    }

    /**
    * Fetch itemfields
    *
    * @param object         $criteria {@link CriteriaElement}
    * @param bool           $id_as_key return array with field IDs as key?
    * @param bool           $as_object return array of objects?
    *
    * @return array
    **/
    function getItemfields($criteria, $id_as_key = true, $as_object = true)
    {
        return $this->module_skeletonHelper->getHandler('itemfield')->getObjects($criteria, $id_as_key, $as_object);
    }

    /**
    * Insert an itemfield in the database
    *
    * @param object         $itemfieldObj {@link module_skeletonItemfield}
    * @param bool           $force
    *
    * @return bool
    */
    function insertItemfield($itemfieldObj, $force = false)
    {
        return $this->module_skeletonHelper->getHandler('itemfield')->insert($itemfieldObj, $force);
    }

    /**
    * Delete an itemfield from the database
    *
    * @param object         $itemfieldObj {@link module_skeletonItemfield}
    * @param bool           $force
    *
    * @return bool
    */
    function deleteItemfield($itemfieldObj, $force = false)
    {
        return $this->module_skeletonHelper->getHandler('itemfield')->delete($itemfieldObj, $force);
    }

    /**
     * Save a new itemfield in the database
     *
     * @param array         $vars array of variables, taken from $module->loadInfo('profile')['field']
     * @param int           $weight
     *
     * @internal param int  $itemcategoryid ID of the itemcategory to add it to
     * @internal param int  $type datatype of the field
     * @internal param int  $moduleid ID of the module, this field belongs to
     *
     * @return string
     */
    function saveItemfield($vars, $weight = 0)
    {
        $itemfieldObj = $this->createItemfield();
        $itemfieldObj->setVar('field_name', $vars['name']);
        $itemfieldObj->setVar('field_datatype', $vars['datatype']);
        $itemfieldObj->setVar('field_type', $vars['type']);
        $itemfieldObj->setVar('field_weight', $weight);
        if (isset($vars['title'])) {
            $itemfieldObj->setVar('itemfield_title', $vars['title']);
        }
        if (isset($vars['description'])) {
            $itemfieldObj->setVar('itemfield_description', $vars['description']);
        }
        if (isset($vars['required'])) {
            $itemfieldObj->setVar('itemfield_required', $vars['required']); //0 = no, 1 = yes
        }
        if (isset($vars['default'])) {
            $itemfieldObj->setVar('itemfield_default', $vars['default']);
        }
        if (isset($vars['notnull'])) {
            $itemfieldObj->setVar('itemfield_notnull', $vars['notnull']);
        }
        if (isset($vars['show'])) {
            $itemfieldObj->setVar('itemfield_show', $vars['show']);
        }
        if (isset($vars['edit'])) {
            $itemfieldObj->setVar('itemfield_edit', $vars['edit']);
        }
        if (isset($vars['config'])) {
            $itemfieldObj->setVar('field_config', $vars['config']);
        }
        if (isset($vars['options'])) {
            $itemfieldObj->setVar('itemfield_options', $vars['options']);
        } else {
            $itemfieldObj->setVar('itemfield_options', array() );
        }
        if ($this->insertItemfield($itemfieldObj)) {
            $msg = '&nbsp;&nbsp;Field <strong>' . $vars['name'] . '</strong> added to the database';
        } else {
            $msg = '&nbsp;&nbsp;<span class="red">ERROR: Could not insert field <strong>' . $vars['name'] . '</strong> into the database. '.implode(' ', $itemfieldObj->getErrors()) . $this->db->error() . '</span>';
        }
        unset($itemfieldObj);
        return $msg;
    }

    /**
     * Get array of standard variable names (item table)
     *
     * @return array
     */
    function getItemVars()
    {
        return $this->module_skeletonHelper->getHandler('itemfield')->getItemVars();
    }

    /**
     * insert a new {@link module_skeletonItem} object in the database
     *
     * @param object        $itemObj reference to the {@link module_skeletonItem} object
     * @param bool          $force whether to force the query execution despite security settings
     * @param bool          $checkObject check if the object is dirty and clean the attributes
     *
     * @return bool         FALSE if failed, TRUE if already present and unchanged or successful
     */
    function insert($itemObj, $force = false, $checkObject = true)
    {
        return parent::insert($itemObj, $force, $checkObject);
// IN PROGRESS
// IN PROGRESS
// IN PROGRESS
        // trigger event
    }

    /**
     * delete an item from the database
     *
     * @param object|int    $itemObj {@link module_skeletonItem}
     * @param bool          $force
     * @return bool
     */
    public function delete($itemObj, $force = false)
    {
        // check params
        if (is_int($itemObj)) {
            $item_id = (int) $itemObj;
            unset($itemObj);
            $itemObj = $this->get((int) $item_id);
            if (!$itemObj) {
                return false;
            }
        } elseif (get_class($itemObj) == 'Module_skeletonItem') {
            $item_id = (int) $itemObj->getVar('item_id');
        } else {
            return false;
        }
        // delete item
        if (!parent::delete($itemObj, $force)) {
            // ERROR
            return false;
        }
        // delete files from filesystem
        $uploadDir = $this->module_skeletonHelper->getConfig('uploadPath') . '/';
        $sql = "SELECT itemfield_name FROM `{$this->module_skeletonHelper->getHandler('itemfield')->table}`";
        $sql .= " WHERE itemfield_type = 'file'";
        $result = $this->db->query($sql);
        //$itemfield_names = array();
        while ($myrow = $this->db->fetchArray($result)) {
            //$itemfield_names[] = $myrow['itemfield_name'];
            $value = $itemObj->getVar($myrow['itemfield_name']);
            $files = json_decode($value, true); // associative arrays
            foreach($files as $file) {
                unlink($uploadDir . $file['savedfilename']);
            }
        }

        // delete comments
        xoops_comment_delete((int) $this->module_skeletonHelper->getModule()->mid(), (int) $item_id);
        return true;
    }

    /**
     * Search items
     *
     * @param object        $criteria {@link CriteriaElement}
     * @param array         $searchVars Fields to be fetched
     * @param array         $groups for Usergroups is selected (only admin!)
     *
     * @return array
     */
/*
    function search($criteria, $searchVars = array(), $groups = null)
    {
        $itemVars = $this->getItemVars();

        $searchVars_user = array_intersect($searchVars, $itemVars);
        $searchVars_profile = array_diff($searchVars, $itemVars);
        $sv = array('u.uid, u.uname, u.email, u.user_viewemail');
        if (!empty($searchVars_user)) {
            $sv[0] .= ",u." . implode(", u.", $searchVars_user);
        }
        if (!empty($searchVars_profile)) {
            $sv[] = "p." . implode(", p.", $searchVars_profile);
        }

        $sql_select = "SELECT " . (empty($searchVars) ? "u.*, p.*" : implode(", ", $sv));
        $sql_from = " FROM " . $this->db->prefix("users") . " AS u LEFT JOIN " . $this->table . " AS p ON u.uid=p.profile_id" .
                    (empty($groups) ? "" : " LEFT JOIN " . $this->db->prefix("groups_users_link") . " AS g ON u.uid=g.uid");
        $sql_clause = " WHERE 1=1";
        $sql_order = "";

        $limit = $start = 0;
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql_clause .= " AND " . $criteria->render();
            if ($criteria->getSort() != '') {
                $sql_order = ' ORDER BY ' . $criteria->getSort() . ' ' . $criteria->getOrder();
            }
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
        }

        if (!empty($groups)) {
            $sql_clause .= " AND g.groupid IN (" . implode(", ", $groups) . ")";
        }

        $sql_users = $sql_select . $sql_from . $sql_clause . $sql_order;
        $result = $this->db->query($sql_users, $limit, $start);

        if (!$result) {
            return array(array(), array(), 0);
        }
        $user_handler = xoops_gethandler('user');
        $itemVars = $this->getUserVars();
        $users = array();
        $profiles = array();
        while ($myrow = $this->db->fetchArray($result)) {
            $profile = $this->create(false);
            $user = $user_handler->create(false);

            foreach ($myrow as $name => $value) {
                if (in_array($name, $itemVars)) {
                   $user->assignVar($name, $value);
                } else {
                    $profile->assignVar($name, $value);
                }
            }
            $profiles[$myrow['uid']] = $profile;
            $users[$myrow['uid']] = $user;
        }

        $count = count($users);
        if ((!empty($limit) && $count >= $limit) || !empty($start)) {
            $sql_count = "SELECT COUNT(*)" . $sql_from . $sql_clause;
            $result = $this->db->query($sql_count);
            list($count) = $this->db->fetchRow($result);
        }

        return array($users, $profiles, intval($count));
    }
*/
}
