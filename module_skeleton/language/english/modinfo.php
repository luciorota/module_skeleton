<?php
// $Id:$
// _LANGCODE: en
// _CHARSET : UTF-8
// Translator: XOOPS Translation Team

// Module Info
// The name of this module
define('_MI_MODULE_SKELETON_NAME', "Module_skeleton");
// A brief description of this module
define('_MI_MODULE_SKELETON_DESC', "Module description");

define('_MI_MODULE_SKELETON_AUTHOR', "Module author");
define('_MI_MODULE_SKELETON_CREDITS', "Module credits");

// Help files
define('_MI_MODULE_SKELETON_HELP_OVERVIEW', "Overview");
define('_MI_MODULE_SKELETON_HELP_INSTALL', "Install");
define('_MI_MODULE_SKELETON_HELP_TIPS_TRICKS', "Tips & Tricks");

// Names of admin menu items
define('_MI_MODULE_SKELETON_MENU_HOME', "Home");
define('_MI_MODULE_SKELETON_MENU_ITEMCATEGORIES', "Item categories");
define('_MI_MODULE_SKELETON_MENU_ITEMS', "Items");
define('_MI_MODULE_SKELETON_MENU_ITEMFIELDCATEGORIES', "Item field categories");
define('_MI_MODULE_SKELETON_MENU_ITEMFIELDS', "Item fields");
define('_MI_MODULE_SKELETON_MENU_PERMISSIONS', "Permissions");
define('_MI_MODULE_SKELETON_MENU_CLONE', "Clone module");
define('_MI_MODULE_SKELETON_MENU_ABOUT', "About");

// Names of submenu items
define('_MI_MODULE_SKELETON_SUBMENU_ITEMS', "Items");
define('_MI_MODULE_SKELETON_SUBMENU_ITEMCATEGORIES', "Itemcategories");





    // Blocks
    // Names of blocks for this module (Not all module has blocks)
    define('_MI_MODULE_SKELETON_BNAME1', "Recent Downloads");
    define('_MI_MODULE_SKELETON_BNAME2', "Top Downloads");
    define('_MI_MODULE_SKELETON_BNAME3', "Top Downloads by top categories");


    // Sub menu titles
    define('_MI_MODULE_SKELETON_SMNAME1', "Submit");
    define('_MI_MODULE_SKELETON_SMNAME2', "Popular");
    define('_MI_MODULE_SKELETON_SMNAME3', "Top rated");



// Module config setting
define('_MI_MODULE_SKELETON_EDITOR', "[editor] Text editor");
define('_MI_MODULE_SKELETON_EDITORCHOICE', "Editor for html fields");

define('_MI_MODULE_SKELETON_PERPAGE', "Index items count");
define('_MI_MODULE_SKELETON_PERPAGE_DESC', "Number of items to display per page in user side.");

define('_MI_MODULE_SKELETON_ADMINPERPAGE', "Admin index items count");
define('_MI_MODULE_SKELETON_ADMINPERPAGE_DESC', "Number of items to display per page in admin side.");

define('_MI_MODULE_SKELETON_DATEFORMAT', "Timestamp");
define('_MI_MODULE_SKELETON_DATEFORMAT_DESC', "Default Timestamp for module front end. <br />More info here: <a href='http://www.php.net/manual/en/function.date.php'>http://www.php.net/manual/en/function.date.php</a>");

define('_MI_MODULE_SKELETON_UPLOADPATH', "[upload] Module upload directory");
define('_MI_MODULE_SKELETON_UPLOADPATH_DESC', "Upload directory *MUST* be an absolute path! <br />No trailing slash.");

define('_MI_MODULE_SKELETON_UPLOADMAXFILESIZE', "[upload] Max file size (bytes)");
define('_MI_MODULE_SKELETON_UPLOADMAXFILESIZE_DESC', "Maximum file size allowed for file uploads.<br />WARNING: Upload File Size Limit is also influenced by 'upload_max_filesize', 'post_max_size' and 'memory_limit' php.ini directives");



// Comments



// Notifications
define('_MI_MODULE_SKELETON_GLOBAL_NOTIFY', "Global");
define('_MI_MODULE_SKELETON_GLOBAL_NOTIFYDSC', "Global downloads notification options.");
define('_MI_MODULE_SKELETON_ITEMCATEGORY_NOTIFY', "Category");
define('_MI_MODULE_SKELETON_ITEMCATEGORY_NOTIFYDSC', "Notification options that apply to the current file itemcategory.");
define('_MI_MODULE_SKELETON_FILE_NOTIFY', "File");
define('_MI_MODULE_SKELETON_FILE_NOTIFYDSC', "Notification options that apply to the current file.");
define('_MI_MODULE_SKELETON_GLOBAL_NEWITEMCATEGORY_NOTIFY', "New Category");
define('_MI_MODULE_SKELETON_GLOBAL_NEWITEMCATEGORY_NOTIFYCAP', "Notify me when a new file itemcategory is created.");
define('_MI_MODULE_SKELETON_GLOBAL_NEWITEMCATEGORY_NOTIFYDSC', "Receive notification when a new file itemcategory is created.");
define('_MI_MODULE_SKELETON_GLOBAL_NEWITEMCATEGORY_NOTIFYSBJ', "[{X_SITENAME}] {X_MODULE} auto-notify: New file itemcategory.");
define('_MI_MODULE_SKELETON_GLOBAL_FILEMODIFY_NOTIFY', "Modify File Requested");
define('_MI_MODULE_SKELETON_GLOBAL_FILEMODIFY_NOTIFYCAP', "Notify me of any file modification request.");
define('_MI_MODULE_SKELETON_GLOBAL_FILEMODIFY_NOTIFYDSC', "Receive notification when any file modification request is submitted.");
define('_MI_MODULE_SKELETON_GLOBAL_FILEMODIFY_NOTIFYSBJ', "[{X_SITENAME}] {X_MODULE} auto-notify: File Modification Requested");
define('_MI_MODULE_SKELETON_GLOBAL_FILEBROKEN_NOTIFY', "Broken File Submitted");
define('_MI_MODULE_SKELETON_GLOBAL_FILEBROKEN_NOTIFYCAP', "Notify me of any broken file report.");
define('_MI_MODULE_SKELETON_GLOBAL_FILEBROKEN_NOTIFYDSC', "Receive notification when any broken file report is submitted.");
define('_MI_MODULE_SKELETON_GLOBAL_FILEBROKEN_NOTIFYSBJ', "[{X_SITENAME}] {X_MODULE} auto-notify: Broken File Reported");
define('_MI_MODULE_SKELETON_GLOBAL_FILESUBMIT_NOTIFY', "File Submitted");
define('_MI_MODULE_SKELETON_GLOBAL_FILESUBMIT_NOTIFYCAP', "Notify me when any new file is submitted (awaiting approval).");
define('_MI_MODULE_SKELETON_GLOBAL_FILESUBMIT_NOTIFYDSC', "Receive notification when any new file is submitted (awaiting approval).");
define('_MI_MODULE_SKELETON_GLOBAL_FILESUBMIT_NOTIFYSBJ', "[{X_SITENAME}] {X_MODULE} auto-notify: New file submitted");
define('_MI_MODULE_SKELETON_GLOBAL_NEWFILE_NOTIFY', "New File");
define('_MI_MODULE_SKELETON_GLOBAL_NEWFILE_NOTIFYCAP', "Notify me when any new file is posted.");
define('_MI_MODULE_SKELETON_GLOBAL_NEWFILE_NOTIFYDSC', "Receive notification when any new file is posted.");
define('_MI_MODULE_SKELETON_GLOBAL_NEWFILE_NOTIFYSBJ', "[{X_SITENAME}] {X_MODULE} auto-notify: New file");
define('_MI_MODULE_SKELETON_ITEMCATEGORY_FILESUBMIT_NOTIFY', "File Submitted");
define('_MI_MODULE_SKELETON_ITEMCATEGORY_FILESUBMIT_NOTIFYCAP', "Notify me when a new file is submitted (awaiting approval) to the current itemcategory.");
define('_MI_MODULE_SKELETON_ITEMCATEGORY_FILESUBMIT_NOTIFYDSC', "Receive notification when a new file is submitted (awaiting approval) to the current itemcategory.");
define('_MI_MODULE_SKELETON_ITEMCATEGORY_FILESUBMIT_NOTIFYSBJ', "[{X_SITENAME}] {X_MODULE} auto-notify: New file submitted in itemcategory");
define('_MI_MODULE_SKELETON_ITEMCATEGORY_NEWFILE_NOTIFY', "New File");
define('_MI_MODULE_SKELETON_ITEMCATEGORY_NEWFILE_NOTIFYCAP', "Notify me when a new file is posted to the current itemcategory.");
define('_MI_MODULE_SKELETON_ITEMCATEGORY_NEWFILE_NOTIFYDSC', "Receive notification when a new file is posted to the current itemcategory.");
define('_MI_MODULE_SKELETON_ITEMCATEGORY_NEWFILE_NOTIFYSBJ', "[{X_SITENAME}] {X_MODULE} auto-notify: New file in itemcategory");
define('_MI_MODULE_SKELETON_FILE_APPROVE_NOTIFY', "File Approved");
define('_MI_MODULE_SKELETON_FILE_APPROVE_NOTIFYCAP', "Notify me when this file is approved.");
define('_MI_MODULE_SKELETON_FILE_APPROVE_NOTIFYDSC', "Receive notification when this file is approved.");
define('_MI_MODULE_SKELETON_FILE_APPROVE_NOTIFYSBJ', "[{X_SITENAME}] {X_MODULE} auto-notify: File Approved");
/* Added by Lankford on 2007/3/21 */
define('_MI_MODULE_SKELETON_FILE_FILEMODIFIED_NOTIFY', "File Modified");
define('_MI_MODULE_SKELETON_FILE_FILEMODIFIED_NOTIFYCAP', "Notify me when this file is modified.");
define('_MI_MODULE_SKELETON_FILE_FILEMODIFIED_NOTIFYDSC', "Receive notification when this file is modified.");
define('_MI_MODULE_SKELETON_FILE_FILEMODIFIED_NOTIFYSBJ', "[{X_SITENAME}] {X_MODULE} auto-notify: File Modified");
define('_MI_MODULE_SKELETON_ITEMCATEGORY_FILEMODIFIED_NOTIFY', "File Modified");
define('_MI_MODULE_SKELETON_ITEMCATEGORY_FILEMODIFIED_NOTIFYCAP', "Notify me when a file in this itemcategory is modified.");
define('_MI_MODULE_SKELETON_ITEMCATEGORY_FILEMODIFIED_NOTIFYDSC', "Receive notification when a file in this itemcategory is modified.");
define('_MI_MODULE_SKELETON_ITEMCATEGORY_FILEMODIFIED_NOTIFYSBJ', "[{X_SITENAME}] {X_MODULE} auto-notify: File Modified");
define('_MI_MODULE_SKELETON_GLOBAL_FILEMODIFIED_NOTIFY', "File Modified");
define('_MI_MODULE_SKELETON_GLOBAL_FILEMODIFIED_NOTIFYCAP', "Notify me when any file is modified.");
define('_MI_MODULE_SKELETON_GLOBAL_FILEMODIFIED_NOTIFYDSC', "Receive notification when any file is modified.");
define('_MI_MODULE_SKELETON_GLOBAL_FILEMODIFIED_NOTIFYSBJ', "[{X_SITENAME}] {X_MODULE} auto-notify: File Modified");
/* End add block */
define('_MI_MODULE_SKELETON_AUTHOR_INFO', "Developer Information");
define('_MI_MODULE_SKELETON_AUTHOR_NAME', "Developer");
define('_MI_MODULE_SKELETON_AUTHOR_DEVTEAM', "Development Team");
define('_MI_MODULE_SKELETON_AUTHOR_WEBSITE', "Developer website");
define('_MI_MODULE_SKELETON_AUTHOR_EMAIL', "Developer email");
define('_MI_MODULE_SKELETON_AUTHOR_CREDITS', "Credits");
define('_MI_MODULE_SKELETON_MODULE_INFO', "Module Development Information");
define('_MI_MODULE_SKELETON_MODULE_STATUS', "Development Status");
define('_MI_MODULE_SKELETON_MODULE_DEMO', "Demo Site");
define('_MI_MODULE_SKELETON_MODULE_SUPPORT', "Official support site");
define('_MI_MODULE_SKELETON_MODULE_BUG', "Report a bug for this module");
define('_MI_MODULE_SKELETON_MODULE_FEATURE', "Suggest a new feature for this module");
define('_MI_MODULE_SKELETON_MODULE_DISCLAIMER', "Disclaimer");
define('_MI_MODULE_SKELETON_RELEASE', "Release Date: ");

define('_MI_MODULE_SKELETON_HELP', "Help");





define('_MI_MODULE_SKELETON_VARIOUS_CONFIGS', "Various preferences");
define('_MI_MODULE_SKELETON_VARIOUS_CONFIGSDSC', "");



define('_MI_MODULE_SKELETON_HELP_IMPORT', "Import<br />(IN PROGRESS)");
