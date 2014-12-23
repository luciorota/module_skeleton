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

/**
 * Class Extraitemfieldtype
 */
abstract class Module_skeletonExtraitemfieldtype
{
    protected $module_skeleton = null;
    protected $db = null;
    protected $itemObj = null;
    protected $itemfieldObj = null;

    /**
     * @param object    $itemObj
     * @param object    $itemfieldObj
     */
    public function __construct($itemObj, $itemfieldObj)
    {
        $this->module_skeleton = Module_skeletonModule_skeleton::getInstance();
        $this->db = XoopsDatabaseFactory::getDatabaseConnection();
        $this->itemObj = $itemObj;
        $this->itemfieldObj = $itemfieldObj;
    }

	public function getEditElement()
    {
    }

	public function getOutputValue()
    {
    }

    public function getValueForSave($value)
    {
    }

    public function insert()
    {
    }

    public function delete()
    {
    }

    public function itemfield_datatype($form)
    {
    }

    public function itemfield_notnull($form)
    {
    }

    public function itemfield_options($form)
    {
    }

    public function itemfield_typeconfigs($form)
    {
    }

    public function itemfield_default($form)
    {
    }

    public function search()
    {
// IN PROGRESS
// IN PROGRESS
// IN PROGRESS
    }
}

/**
 * class Extraitemfieldtype handler
 *
 */
class Module_skeletonExtraitemfieldtypeHandler
{
    // static $instance;
    protected $root_path = '';

    public function __construct()
    {
        $this->root_path = __DIR__;
    }

    /**
     * Access the only instance of this class
     *
     * @return object
     * @static
     * @staticvar object
     */
    static function &getInstance()
    {
        static $instance;
        if (!isset($instance)) {
            $class = __CLASS__;
            $instance = new $class();
        }

        return $instance;
    }

    /**
     *
     * @param string    $name Extraitemfieldtype name which is actually the folder name
     * @param object    $itemObj
     * @param object    $itemfieldObj
     * @param array     $options Extraitemfieldtype options: $key => $val
     *
     * @return null
     */
    public function get($name = '', $itemObj = null, $itemfieldObj = null, $options = null)
    {
        if (array_key_exists($name, $this->getList()) && $extraItemfieldTypeObj = $this->_loadExtraitemfieldtype($name, $itemObj, $itemfieldObj, $options)) {
            return $extraItemfieldTypeObj;
        }
        return false;
    }

    /**
     * Module_skeletonExtraitemfieldtypeHandler::getList()
     *
     * Do NOT use this method statically, please use
     * $extraItemfieldType_handler = Module_skeletonExtraitemfieldtypeHandler::getInstance();
     * $result = array_flip($extraItemfieldType_handler->getList());
     *
     * @return array
     */
    public function getList($useCache = true)
    {
        if (!isset($this->root_path)) {
            $this->root_path = __DIR__;
            $GLOBALS['xoopsLogger']->addDeprecated(__CLASS__ . '::' . __FUNCTION__ . '() should not be called statically.');
        }
        if ($useCache == true) {
        xoops_load('XoopsCache');
            $list = XoopsCache::read('module_skeleton_extraitemfieldtypeslist');
        }
        if (empty($list)) {
            $list = array();
            $order = array();
            xoops_load('XoopsLists');
            $types = XoopsLists::getDirListAsArray($this->root_path . '/');
            foreach ($types as $type) {
                if (file_exists($laguageFile = $this->root_path . '/' . $type . '/language/' . $GLOBALS['xoopsConfig']['language'] . '.php')) {
                    include_once $laguageFile;
                } else if (file_exists($laguageFile = $this->root_path . '/' . $type . '/language/english.php')) {
                    include_once $laguageFile;
                }
                if (file_exists($registryFile = $this->root_path . '/' . $type . '/extraitemfieldtype_registry.php')) {
                    include $registryFile;
                    if (empty($config['order']))
                        continue;
                    $order[] = $config['order'];
                    $list[$type] = $config['title'];
                }
            }
            array_multisort($order, $list);
            if ($useCache == true) {
                XoopsCache::write('module_skeleton_extraitemfieldtypeslist', $list);
            }
        }
        return $list;
    }

    /**
     * Module_skeletonExtraitemfieldtypeHandler::setConfig()
     *
     * @param  mixed    $extraItemfieldTypeObj
     * @param  array    $options
     * @return void
     */
    public function setConfig($extraItemfieldTypeObj, $options)
    {
        if (method_exists($extraItemfieldTypeObj, 'setConfig')) {
            $extraItemfieldTypeObj->setConfig($options);
        } else {
            foreach ($options as $key => $val) {
                $extraItemfieldTypeObj->$key = $val;
            }
        }
    }

    /**
     * Module_skeletonExtraitemfieldtypeHandler::_loadEditor()
     *
     * @param mixed     $name
     * @param object    $itemObj
     * @param object    $itemfieldObj
     * @param mixed     $options
     * @return
     */
    private function _loadExtraitemfieldtype($name, $itemObj = null, $itemfieldObj = null, $options = null)
    {
        $extraItemfieldTypeObj = false;
        if (empty($name) || !array_key_exists($name, $this->getList())) {
            return false;
        }
        $extraItemfieldTypes_path = $this->root_path . '/' . $name;
        if (file_exists($laguageFile = $extraItemfieldTypes_path . '/language/' . $GLOBALS['xoopsConfig']['language'] . '.php')) {
            include_once $laguageFile;
        } else if (file_exists($laguageFile = $extraItemfieldTypes_path . '/language/english.php')) {
            include_once $laguageFile;
        }
        if (file_exists($registryFile = $extraItemfieldTypes_path . '/extraitemfieldtype_registry.php')) {
            include $registryFile;
        } else {
            return false;
        }
        include_once $config['file'];
        $extraItemfieldTypeObj = new $config['class']($itemObj, $itemfieldObj);
        if (!is_null($options)) {
            $this->setConfig($extraItemfieldTypeObj, $options);
        }
        return $extraItemfieldTypeObj;
    }
}
