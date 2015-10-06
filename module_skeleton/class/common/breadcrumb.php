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
 * Module_skeletonBreadcrumb Class
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @package         module_skeleton
 * @since           1.00
 * @author          Xoops Development Team
 * @version         svn:$id$
 *
 * Example:
 * $breadcrumb = new Module_skeletonBreadcrumb();
 * $breadcrumb->addLink( 'bread 1', 'index1.php' );
 * $breadcrumb->addLink( 'bread 2', '' );
 * $breadcrumb->addLink( 'bread 3', 'index3.php' );
 * echo $breadcrumb->render();
 */
defined('XOOPS_ROOT_PATH') || die('XOOPS root path not defined');
include_once dirname(dirname(__DIR__)) . '/include/common.php';

/**
 * Class Module_skeletonBreadcrumb
 */
class Module_skeletonBreadcrumb
{
    /**
     * @var Module_skeletonModule_skeleton
     * @access public
     */
    public $module_skeletonHelper = null;

    private $dirname;
    private $_bread = array();

    /**
     *
     */
    public function __construct()
    {
        $this->module_skeletonHelper = \Xmf\Module\Helper::getHelper('module_skeleton');
        $this->dirname = basename(dirname(dirname(__DIR__)));
    }

    /**
     * Add link to breadcrumb
     *
     * @param string $title
     * @param string $link
     */
    public function addLink( $title='', $link='' )
    {
        $this->_bread[] = array(
            'link'  => $link,
            'title' => $title
            );
    }

    /**
     * Render Module_skeleton BreadCrumb
     *
     */
    public function render()
    {
        $ret = '';

        if (!isset($GLOBALS['xoTheme']) || !is_object($GLOBALS['xoTheme'])) {
            include_once $GLOBALS['xoops']->path('/class/theme.php');
            $GLOBALS['xoTheme'] = new xos_opal_Theme();
        }
        require_once $GLOBALS['xoops']->path('/class/template.php');
        $breadcrumbTpl = new XoopsTpl();
        $breadcrumbTpl->assign('breadcrumb', $this->_bread);
// IN PROGRESS
// IN PROGRESS
// IN PROGRESS
        $ret .= $breadcrumbTpl->fetch("db:{$this->module_skeletonHelper->getModule()->dirname()}_co_breadcrumb.tpl");
        unset($breadcrumbTpl);

        return $ret;
    }
}
