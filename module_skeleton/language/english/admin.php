<?php
// $Id:$
// _LANGCODE: en
// _CHARSET : UTF-8
// Translator: XOOPS Translation Team

// admin/index.php
define('_AM_MODULE_SKELETON_MINDEX_DOWNSUMMARY', "Module admin summary");
define('_AM_MODULE_SKELETON_ITEMCATEGORIES_COUNT', "Item categories: %s");
define('_AM_MODULE_SKELETON_ITEMS_COUNT', "Items: %s");
define('_AM_MODULE_SKELETON_ITEMFIELDCATEGORIES_COUNT', "Item field categories: %s");
define('_AM_MODULE_SKELETON_ITEMFIELDS_COUNT', "Item fields: %s");

define('_AM_MODULE_SKELETON_DOWN_MEMORYLIMIT', "Memory limit (memory_limit directive in php.ini): ");
define('_AM_MODULE_SKELETON_DOWN_MODULE_MAXFILESIZE', "Module max file size: %s (module config value)");
define('_AM_MODULE_SKELETON_UPLOAD_MAXFILESIZE', "Upload file size limit: %s");

define('_AM_MODULE_SKELETON_DOWN_IMAGEINFO', "Server status");
define('_AM_MODULE_SKELETON_DOWN_SERVERPATH', "Server path to XOOPS root: ");
define('_AM_MODULE_SKELETON_DOWN_UPLOADPATH', "Current upload path: ");
define('_AM_MODULE_SKELETON_DOWN_UPLOADPATHDSC', "Note. Upload path *MUST* contain the full server path of your upload folder.");
define('_AM_MODULE_SKELETON_DOWN_SPHPINI', "<span style='font-weight: bold;'>Information taken from PHP ini file:</span>");
define('_AM_MODULE_SKELETON_DOWN_SAFEMODESTATUS', "Safe mode status: ");
define('_AM_MODULE_SKELETON_DOWN_REGISTERGLOBALS', "Register globals: ");
define('_AM_MODULE_SKELETON_DOWN_SERVERUPLOADSTATUS', "Server uploads status: ");
define('_AM_MODULE_SKELETON_DOWN_MAXUPLOADSIZE', "Max upload size permitted (upload_max_filesize directive in php.ini): ");
define('_AM_MODULE_SKELETON_DOWN_MAXPOSTSIZE', "Max post size permitted (post_max_size directive in php.ini): ");
define('_AM_MODULE_SKELETON_DOWN_SAFEMODEPROBLEMS', " (This may cause problems)");
define('_AM_MODULE_SKELETON_DOWN_GDLIBSTATUS', "GD library support: ");
define('_AM_MODULE_SKELETON_DOWN_GDLIBVERSION', "GD Library version: ");
define('_AM_MODULE_SKELETON_DOWN_GDON', "<span style='font-weight: bold;'>Enabled</span> (Thumbsnails available)");
define('_AM_MODULE_SKELETON_DOWN_GDOFF', "<span style='font-weight: bold;'>Disabled</span> (No thumbnails available)");
define('_AM_MODULE_SKELETON_DOWN_OFF', "<span style='font-weight: bold;'>OFF</span>");
define('_AM_MODULE_SKELETON_DOWN_ON', "<span style='font-weight: bold;'>ON</span>");

// admin/clone.php
define('_AM_MODULE_SKELETON_CLONE', "Clone module");
define('_AM_MODULE_SKELETON_CLONE_DSC', "Cloning a module has never been this easy! Just type in the name you want for it and hit submit button!");
define('_AM_MODULE_SKELETON_CLONE_TITLE', "Clone %s");
define('_AM_MODULE_SKELETON_CLONE_NAME', "Choose a name for the new module");
define('_AM_MODULE_SKELETON_CLONE_NAME_DSC', "Do not use special characters! <br />Do not choose an existing module dirname or database table name!");
define('_AM_MODULE_SKELETON_CLONE_INVALIDNAME', "ERROR: Invalid module name, please try another one!");
define('_AM_MODULE_SKELETON_CLONE_EXISTS', "ERROR: Module name already taken, please try another one!");
define('_AM_MODULE_SKELETON_CLONE_CONGRAT', "Congratulations! %s was sucessfully created! <br />You may want to make changes in language files.");
define('_AM_MODULE_SKELETON_CLONE_IMAGEFAIL', "Attention, we failed creating the new module logo. Please consider modifying images/module_logo.png manually!");
define('_AM_MODULE_SKELETON_CLONE_FAIL', "Sorry, we failed in creating the new clone. Maybe you need to temporally set write permissions (CHMOD 777) to 'modules' folder and try again.");

// admin/permissions.php
define('_AM_MODULE_SKELETON_PERM_NOTE', "Select permissions");
define('_AM_MODULE_SKELETON_PERM_NOTE_DESC', "Select itemcategory or item field permissions.");
define('_AM_MODULE_SKELETON_PERM', "Permission form");


/*

define('_AM_MODULE_SKELETON_PERM_MANAGEMENT', "Permissions management");
define('_AM_MODULE_SKELETON_PERM_PERMSNOTE', "Please be aware that even if you've set correct viewing permissions here, a group might not see the articles or blocks if you don't also grant that group permissions to access the module. To do that, go to <span style='font-weight: bold;'>System admin > Groups</span>, choose the appropriate group and click the checkboxes to grant its members the access.");

define('_AM_MODULE_SKELETON_PERM_CSELECTPERMISSIONS', "Select categories that each group is allowed to view");
define('_AM_MODULE_SKELETON_PERM_CNOITEMCATEGORY', "Cannot set permissions: No categories have been created yet!");
define('_AM_MODULE_SKELETON_PERM_FPERMISSIONS', "File permissions");
define('_AM_MODULE_SKELETON_PERM_FNOFILES', "Cannot set permissions: no files have been created yet!");
define('_AM_MODULE_SKELETON_PERM_FSELECTPERMISSIONS', "Select the files that each group is allowed to view");
// Buttons
define('_AM_MODULE_SKELETON_BMODIFY', "Modify");
define('_AM_MODULE_SKELETON_BDELETE', "Delete");
define('_AM_MODULE_SKELETON_BADD', "Add");
define('_AM_MODULE_SKELETON_BAPPROVE', "Approve");
define('_AM_MODULE_SKELETON_BIGNORE', "Ignore");
define('_AM_MODULE_SKELETON_BCANCEL', "Cancel");
define('_AM_MODULE_SKELETON_BSAVE', "Save");
define('_AM_MODULE_SKELETON_BRESET', "Reset");
define('_AM_MODULE_SKELETON_BMOVE', "Move files");
define('_AM_MODULE_SKELETON_BUPLOAD', "Upload");
define('_AM_MODULE_SKELETON_BDELETEIMAGE', "Delete selected image");
define('_AM_MODULE_SKELETON_BRETURN', "Return to where you were!");
define('_AM_MODULE_SKELETON_DBERROR', "Database access error: please report this error to the XOOPS website");
//Banned Users
define('_AM_MODULE_SKELETON_NONBANNED', "Not Banned");
define('_AM_MODULE_SKELETON_BANNED', "Banned");
define('_AM_MODULE_SKELETON_EDITBANNED', "Edit Banned Users");
// Other Options
define('_AM_MODULE_SKELETON_TEXTOPTIONS', "Text options");
define('_AM_MODULE_SKELETON_ALLOWHTML', " Allow HTML tags");
define('_AM_MODULE_SKELETON_ALLOWSMILEY', " Allow Smiley icons");
define('_AM_MODULE_SKELETON_ALLOWXCODE', " Allow XOOPS codes");
define('_AM_MODULE_SKELETON_ALLOWIMAGES', " Allow images");
define('_AM_MODULE_SKELETON_ALLOWBREAK', " Use XOOPS line break conversion");
define('_AM_MODULE_SKELETON_UPLOADFILE', "File uploaded successfully");
define('_AM_MODULE_SKELETON_NOMENUITEMS', "No menu items within the menu");
// Admin Bread crumb
define('_AM_MODULE_SKELETON_PREFS', "Preferences");
define('_AM_MODULE_SKELETON_PERMISSIONS', "Permissions");
define('_AM_MODULE_SKELETON_BINDEX', "Main index");
define('_AM_MODULE_SKELETON_BLOCKADMIN', "Blocks");
define('_AM_MODULE_SKELETON_GOMODULE', "Go to module");
define('_AM_MODULE_SKELETON_BHELP', "Help");
define('_AM_MODULE_SKELETON_ABOUT', "About");
// Admin Summary
define('_AM_MODULE_SKELETON_ITEMCATEGORIES_COUNT', "Itemcategories: %s");
define('_AM_MODULE_SKELETON_ITEMS_COUNT', "Items: %s");




define('_AM_MODULE_SKELETON_SNEWFILESVAL', "New/waiting downloads: %s");
define('_AM_MODULE_SKELETON_SMODREQUEST', "Modifications: %s");
// Admin Main Menu
define('_AM_MODULE_SKELETON_MITEMCATEGORY', "Itemcategories management");
define('_AM_MODULE_SKELETON_INDEXPAGE', "Index page management");
define('_AM_MODULE_SKELETON_MUPLOADS', "Images upload");
define('_AM_MODULE_SKELETON_MMIMETYPES', "MIME types management");
define('_AM_MODULE_SKELETON_MCOMMENTS', "Comments");
define('_AM_MODULE_SKELETON_MVOTEDATA', "Vote data");
// waiting reviews
define('_AM_MODULE_SKELETON_AREVIEWS', "Reviews management");
define('_AM_MODULE_SKELETON_AREVIEWS_WAITING', "Reviews waiting for validation");
define('_AM_MODULE_SKELETON_AREVIEWS_INFO', "Reviews information");
define('_AM_MODULE_SKELETON_AREVIEWS_APPROVE', "Approve new review without validation");
define('_AM_MODULE_SKELETON_AREVIEWS_APPROVED', "Review has been approved.");
define('_AM_MODULE_SKELETON_AREVIEWS_EDIT', "Edit new review and then approve");
define('_AM_MODULE_SKELETON_AREVIEWS_DELETE', "Delete the new review information");
// Catgeory defines
define('_AM_MODULE_SKELETON_CITEMCATEGORY_CREATENEW', "Create new itemcategory");
define('_AM_MODULE_SKELETON_CITEMCATEGORY_MODIFY', "Modify itemcategory");
define('_AM_MODULE_SKELETON_CITEMCATEGORY_MOVE', "Move itemcategory files");
define('_AM_MODULE_SKELETON_CITEMCATEGORY_MODIFY_TITLE', "Category title");
define('_AM_MODULE_SKELETON_CITEMCATEGORY_MODIFY_FAILED', "Failed moving files: cannot move to this itemcategory");
define('_AM_MODULE_SKELETON_CITEMCATEGORY_MODIFY_FAILEDT', "Failed moving files: cannot find this itemcategory");
define('_AM_MODULE_SKELETON_CITEMCATEGORY_MODIFY_MOVED', "Files moved successfully");
define('_AM_MODULE_SKELETON_CITEMCATEGORY_CREATED', "New Category created and database updated successfully");
define('_AM_MODULE_SKELETON_CITEMCATEGORY_MODIFIED', "Selected itemcategory modified and database updated successfully");
define('_AM_MODULE_SKELETON_CITEMCATEGORY_DELETED', "Selected itemcategory deleted and database updated successfully");
define('_AM_MODULE_SKELETON_CITEMCATEGORY_AREUSURE', "WARNING: Are you sure to delete this itemcategory and ALL its files and comments?");
define('_AM_MODULE_SKELETON_CITEMCATEGORY_NOEXISTS', "You must create a itemcategory before you can add a new file");
define('_AM_MODULE_SKELETON_FITEMCATEGORY_GROUPPROMPT', "Category access permissions");
define('_AM_MODULE_SKELETON_FITEMCATEGORY_TITLE', "Category title");
define('_AM_MODULE_SKELETON_FITEMCATEGORY_WEIGHT', "Category weight");
define('_AM_MODULE_SKELETON_FITEMCATEGORY_SUBITEMCATEGORY', "As subitemcategory of");
define('_AM_MODULE_SKELETON_FITEMCATEGORY_CIMAGE', "Category image");
define('_AM_MODULE_SKELETON_FITEMCATEGORY_DESCRIPTION', "Category description");
define('_AM_MODULE_SKELETON_FITEMCATEGORY_SUMMARY', "Category summary");
define('_AM_MODULE_SKELETON_CITEMCATEGORY_CHILDASPARENT', "You cannot set a child's itemcategory as the itemcategory parent");
// Index page Defines
define('_AM_MODULE_SKELETON_IPAGE_UPDATED', "Index page modified and database updated successfully!");
define('_AM_MODULE_SKELETON_IPAGE_INFORMATION', "Index page information");
define('_AM_MODULE_SKELETON_IPAGE_MODIFY', "Modify index page");
define('_AM_MODULE_SKELETON_IPAGE_CIMAGE', "Select index image");
define('_AM_MODULE_SKELETON_IPAGE_CTITLE', "Index title");
define('_AM_MODULE_SKELETON_IPAGE_CHEADING', "Index heading");
define('_AM_MODULE_SKELETON_IPAGE_CHEADINGA', "Index heading alignment");
define('_AM_MODULE_SKELETON_IPAGE_CFOOTER', "Index footer");
define('_AM_MODULE_SKELETON_IPAGE_CFOOTERA', "Index footer alignment");
define('_AM_MODULE_SKELETON_IPAGE_CLEFT', "Align left");
define('_AM_MODULE_SKELETON_IPAGE_CCENTER', "Align center");
define('_AM_MODULE_SKELETON_IPAGE_CRIGHT', "Align right");
//  Permissions defines
define('_AM_MODULE_SKELETON_PERM_MANAGEMENT', "Permissions management");
define('_AM_MODULE_SKELETON_PERM_PERMSNOTE', "Please be aware that even if you've set correct viewing permissions here, a group might not see the articles or blocks if you don't also grant that group permissions to access the module. To do that, go to <span style='font-weight: bold;'>System admin > Groups</span>, choose the appropriate group and click the checkboxes to grant its members the access.");
define('_AM_MODULE_SKELETON_PERM_CPERMISSIONS', "Category permissions");
define('_AM_MODULE_SKELETON_PERM_CSELECTPERMISSIONS', "Select categories that each group is allowed to view");
define('_AM_MODULE_SKELETON_PERM_CNOITEMCATEGORY', "Cannot set permissions: No categories have been created yet!");
define('_AM_MODULE_SKELETON_PERM_FPERMISSIONS', "File permissions");
define('_AM_MODULE_SKELETON_PERM_FNOFILES', "Cannot set permissions: no files have been created yet!");
define('_AM_MODULE_SKELETON_PERM_FSELECTPERMISSIONS', "Select the files that each group is allowed to view");



// Main Index defines

define('_AM_MODULE_SKELETON_MINDEX_PUBLISHEDDOWN', "Published downloads");
define('_AM_MODULE_SKELETON_MINDEX_AUTOPUBLISHEDDOWN', "Auto published downloads");
define('_AM_MODULE_SKELETON_MINDEX_AUTOEXPIRE', "Auto expire downloads");
define('_AM_MODULE_SKELETON_MINDEX_OFFLINEDOWN', "Offline downloads");
define('_AM_MODULE_SKELETON_MINDEX_ID', "ID");
define('_AM_MODULE_SKELETON_MINDEX_TITLE', "Download title");
define('_AM_MODULE_SKELETON_MINDEX_POSTER', "Poster");
define('_AM_MODULE_SKELETON_MINDEX_SUBMITTED', "Submission date");
define('_AM_MODULE_SKELETON_MINDEX_ONLINESTATUS', "Online status");
define('_AM_MODULE_SKELETON_MINDEX_PUBLISHED', "Published");
define('_AM_MODULE_SKELETON_MINDEX_ACTION', "Action");
define('_AM_MODULE_SKELETON_MINDEX_NODOWNLOADSFOUND', "NOTICE: there are no downloads that match these criteria");
define('_AM_MODULE_SKELETON_MINDEX_PAGE', "<span style='font-weight: bold;'>Page:<span style='font-weight: bold;'> ");
define('_AM_MODULE_SKELETON_MINDEX_PAGEINFOTXT', "<ul><li>Downloads main page details.</li><li>You can easily change the image logo, heading, main index header and footer text to suit your own look.</li></ul><br /><br />Note: The Logo image chosen will be used throughout this module.");
// Submitted Files
define('_AM_MODULE_SKELETON_SUB_SUBMITTEDFILES', "Submitted files");
define('_AM_MODULE_SKELETON_SUB_FILESWAITINGINFO', "Waiting files information");
define('_AM_MODULE_SKELETON_SUB_FILESWAITINGVALIDATION', "Files waiting for validation: ");
define('_AM_MODULE_SKELETON_SUB_APPROVEWAITINGFILE', "<span style='font-weight: bold;'>Approve</span> new file information without validation.");
define('_AM_MODULE_SKELETON_SUB_EDITWAITINGFILE', "<span style='font-weight: bold;'>Edit</span> new file information and then approve.");
define('_AM_MODULE_SKELETON_SUB_DELETEWAITINGFILE', "<span style='font-weight: bold;'>Delete</span> the new file information.");
define('_AM_MODULE_SKELETON_SUB_NOFILESWAITING', "There are no files that match these criteria");
define('_AM_MODULE_SKELETON_SUB_NEWFILECREATED', "New file data created and database updated successfully");
// Mime types
define('_AM_MODULE_SKELETON_MIME_ID', "ID");
define('_AM_MODULE_SKELETON_MIME_EXT', "EXT");
define('_AM_MODULE_SKELETON_MIME_NAME', "Application type");
define('_AM_MODULE_SKELETON_MIME_ADMIN', "Admin");
define('_AM_MODULE_SKELETON_MIME_USER', "User");
// Mime type Form
define('_AM_MODULE_SKELETON_MIME_CREATEF', "Create MIME type");
define('_AM_MODULE_SKELETON_MIME_MODIFYF', "Modify MIME type");
define('_AM_MODULE_SKELETON_MIME_EXTF', "File extension");
define('_AM_MODULE_SKELETON_MIME_NAMEF', "Application type/name");
define('_AM_MODULE_SKELETON_MIME_TYPEF', "MIME types");
define('_AM_MODULE_SKELETON_MIME_ADMINF', "Allowed admin MIME types/extension");
define('_AM_MODULE_SKELETON_MIME_ADMINFINFO', "<span style='font-weight: bold;'>MIME types/extensions that are available for admin uploads</span>");
define('_AM_MODULE_SKELETON_MIME_USERF', "Allowed user MIME types/extensions");
define('_AM_MODULE_SKELETON_MIME_USERFINFO', "<span style='font-weight: bold;'>MIME types/extensions that are available for user uploads</span>");
define('_AM_MODULE_SKELETON_MIME_NOMIMEINFO', "No MIME types selected");
define('_AM_MODULE_SKELETON_MIME_FINDMIMETYPE', "Find MIME type information");
define('_AM_MODULE_SKELETON_MIME_EXTFIND', "Search file extension");
define(
    '_AM_MODULE_SKELETON_MIME_INFOTEXT',
    "<ul><li>New MIME types can be created, edited or deleted easily via this form</li>
    <li>Looking for a new MIME type via an external website.</li>
    <li>View displayed MIME types for Admin and user uploads.</li>
    <li>Change MIME type upload status.</li></ul>"
);
// Mime type Buttons
define('_AM_MODULE_SKELETON_MIME_CREATE', "Create");
define('_AM_MODULE_SKELETON_MIME_CLEAR', "Reset");
define('_AM_MODULE_SKELETON_MIME_CANCEL', "Cancel");
define('_AM_MODULE_SKELETON_MIME_MODIFY', "Modify");
define('_AM_MODULE_SKELETON_MIME_DELETE', "Delete");
define('_AM_MODULE_SKELETON_MIME_FINDIT', "Get extension!");
// Mime type Database
define('_AM_MODULE_SKELETON_MIME_DELETETHIS', "Delete selected MIME type?");
define('_AM_MODULE_SKELETON_MIME_MIMEDELETED', "MIME type %s has been deleted");
define('_AM_MODULE_SKELETON_MIME_CREATED', "MIME type information created");
define('_AM_MODULE_SKELETON_MIME_MODIFIED', "MIME type information modified");
// Vote Information
define('_AM_MODULE_SKELETON_VOTE_RATINGINFOMATION', "Voting information");
define('_AM_MODULE_SKELETON_VOTE_TOTALVOTES', "Total votes: ");
define('_AM_MODULE_SKELETON_VOTE_REGUSERVOTES', "Registered user votes: %s");
define('_AM_MODULE_SKELETON_VOTE_ANONUSERVOTES', "Anonymous user votes: %s");
define('_AM_MODULE_SKELETON_VOTE_USER', "User");
define('_AM_MODULE_SKELETON_VOTE_IP', "IP address");
define('_AM_MODULE_SKELETON_VOTE_USERAVG', "Average user rating");
define('_AM_MODULE_SKELETON_VOTE_TOTALRATE', "Total ratings");
define('_AM_MODULE_SKELETON_VOTE_DATE', "Submitted");
define('_AM_MODULE_SKELETON_VOTE_RATING', "Rating");
define('_AM_MODULE_SKELETON_VOTE_NOREGVOTES', "No registered user votes");
define('_AM_MODULE_SKELETON_VOTE_NOUNREGVOTES', "No unregistered user votes");
define('_AM_MODULE_SKELETON_VOTE_VOTEDELETED', "Vote data deleted.");
define('_AM_MODULE_SKELETON_VOTE_ID', "ID");
define('_AM_MODULE_SKELETON_VOTE_FILETITLE', "File title");
define('_AM_MODULE_SKELETON_VOTE_DISPLAYVOTES', "Voting data information");
define('_AM_MODULE_SKELETON_VOTE_NOVOTES', "No User Votes to display");
define('_AM_MODULE_SKELETON_VOTE_DELETE', "No User Votes to display");
define('_AM_MODULE_SKELETON_VOTE_DELETEDSC', "<span style='font-weight: bold;'>Deletes</span> the chosen vote information from the database.");



// File management
define('_AM_MODULE_SKELETON_FILE_SUBMITTERID', "Submitter user ID: <br /><br />Leave this as it is, unless you want to change who submitted the download");
define('_AM_MODULE_SKELETON_FILE_ID', "File ID");
define('_AM_MODULE_SKELETON_FILE_IP', "Uploader's IP address");
define('_AM_MODULE_SKELETON_FILE_ALLOWEDAMIME', "<div style='padding-top: 4px; padding-bottom: 4px;'><span style='font-weight: bold;'>Allowed admin file extensions</span></div>");
define('_AM_MODULE_SKELETON_FILE_MODIFYFILE', "Modify file information");
define('_AM_MODULE_SKELETON_FILE_CREATENEWFILE', "Create new file");
define('_AM_MODULE_SKELETON_FILE_TITLE', "File title");
define('_AM_MODULE_SKELETON_FILE_DLURL', "Remote URL");
define('_AM_MODULE_SKELETON_FILE_FILENAME', "Local file name <br /><br /><span style='font-weight: normal;'>Note: if using local file as download, then you must also enter the correct file type below!</span>");
define('_AM_MODULE_SKELETON_FILE_FILETYPE', "File type");
define('_AM_MODULE_SKELETON_FILE_MIRRORURL', "File mirror");
define('_AM_MODULE_SKELETON_FILE_SUMMARY', "File summary");
define('_AM_MODULE_SKELETON_FILE_DESCRIPTION', "File description");
define('_AM_MODULE_SKELETON_FILE_DUPLOAD', " Upload file");
define('_AM_MODULE_SKELETON_FILE_ITEMCATEGORY', "Select itemcategory");
define('_AM_MODULE_SKELETON_FILE_HOMEPAGETITLE', "Home page title");
define('_AM_MODULE_SKELETON_FILE_HOMEPAGE', "Home page");
define('_AM_MODULE_SKELETON_FILE_SIZE', "File size (in Bytes)");
define('_AM_MODULE_SKELETON_FILE_VERSION', "File version");
define('_AM_MODULE_SKELETON_FILE_VERSIONTYPES', "Release status");
define('_AM_MODULE_SKELETON_FILE_PUBLISHER', "File publisher");
define('_AM_MODULE_SKELETON_FILE_PLATFORM', "Software platform");
define('_AM_MODULE_SKELETON_FILE_LICENCE', "Software licence");
define('_AM_MODULE_SKELETON_FILE_LIMITATIONS', "Software limitations");
define('_AM_MODULE_SKELETON_FILE_PRICE', "Price");
define('_AM_MODULE_SKELETON_FILE_KEYFEATURES', "Key features <br /><br /><span style='font-weight: normal;'>Separate each key feature with a |</span>");
define('_AM_MODULE_SKELETON_FILE_REQUIREMENTS', "System requirements <br /><br /><span style='font-weight: normal;'>Separate each requirement with |</span>");
define('_AM_MODULE_SKELETON_FILE_HISTORY', "Download history edit <br /><br /><span style='font-weight: normal;'>Add new download history and only use this field to if you need to edit the previous history.</span>");
define('_AM_MODULE_SKELETON_FILE_HISTORYD', "Add new download history <br /><br /><span style='font-weight: normal;'>The version number and date will be added automatically</span>");
define('_AM_MODULE_SKELETON_FILE_HISTORYVERS', "<span style='font-weight: bold;'>Version</span>");
define('_AM_MODULE_SKELETON_FILE_HISTORDATE', " <span style='font-weight: bold;'>Updated</span> ");
define('_AM_MODULE_SKELETON_FILE_FILESSTATUS', " Set download offline <br /><br /><span style='font-weight: normal;'>Download will not be viewable to all users.</span>");
define('_AM_MODULE_SKELETON_FILE_SETASUPDATED', " Set download status as updated <br /><br /><span style='font-weight: normal;'>Download will display updated icon.</span>");
define('_AM_MODULE_SKELETON_FILE_SHOTIMAGE', "Select screenshot image <br /><br /><span style='font-weight: normal;'>Note that screenshots will only be displayed if activated in module preferences.</span>");
define('_AM_MODULE_SKELETON_FILE_DISCUSSINFORUM', "Add discuss in this forum?");
define('_AM_MODULE_SKELETON_FILE_PUBLISHDATE', "Download publish date");
define('_AM_MODULE_SKELETON_FILE_EXPIREDATE', "Download expire date");
define('_AM_MODULE_SKELETON_FILE_CLEARPUBLISHDATE', "<br /><br />Remove publish date");
define('_AM_MODULE_SKELETON_FILE_CLEAREXPIREDATE', "<br /><br />Remove expire date");
define('_AM_MODULE_SKELETON_FILE_PUBLISHDATESET', " Publish date set: ");
define('_AM_MODULE_SKELETON_FILE_SETDATETIMEPUBLISH', " Set the date/time of publish");
define('_AM_MODULE_SKELETON_FILE_SETDATETIMEEXPIRE', " Set the date/time of expire");
define('_AM_MODULE_SKELETON_FILE_SETPUBLISHDATE', "<span style='font-weight: bold;'>Set publish date</span>");
define('_AM_MODULE_SKELETON_FILE_SETNEWPUBLISHDATE', "<span style='font-weight: bold;'>Set new publish date:</span> <br />published");
define('_AM_MODULE_SKELETON_FILE_SETPUBDATESETS', "<span style='font-weight: bold;'>Publish date set:</span> <br />publishes on date");
define('_AM_MODULE_SKELETON_FILE_EXPIREDATESET', " Expire date set: ");
define('_AM_MODULE_SKELETON_FILE_SETEXPIREDATE', "<span style='font-weight: bold;'>Set expire date</span>");
define('_AM_MODULE_SKELETON_FILE_MUSTBEVALID', "Screenshot image must be a valid image file under %s directory (ex. shot.gif). Leave it blank if there is no image file.");
define('_AM_MODULE_SKELETON_FILE_EDITAPPROVE', "Approve download:");
define('_AM_MODULE_SKELETON_FILE_NEWFILEUPLOAD', "New file created and database updated successfully");
define('_AM_MODULE_SKELETON_FILE_FILEMODIFIEDUPDATE', "Selected file modified and database updated successfully");
define('_AM_MODULE_SKELETON_FILE_REALLYDELETEDTHIS', "Are you sure to delete the selected file?");
define('_AM_MODULE_SKELETON_FILE_FILEWASDELETED', "File %s successfully deleted from the database!");
define('_AM_MODULE_SKELETON_FILE_USE_UPLOAD_TITLE', " Use upload file name for file title.");
define('_AM_MODULE_SKELETON_FILE_FILEAPPROVED', "File approved and database updated successfully");
define('_AM_MODULE_SKELETON_FILE_CREATENEWSSTORY', "<span style='font-weight: bold;'>Create news story from download</span>");
define('_AM_MODULE_SKELETON_FILE_SUBMITNEWS', "Submit new file as news item?");
define('_AM_MODULE_SKELETON_FILE_NEWSITEMCATEGORY', "Select news itemcategory to submit news:");
define('_AM_MODULE_SKELETON_FILE_NEWSTITLE', "News title:<div style='padding-top: 4px; padding-bottom: 4px;'><span style='font-weight: normal;'>Leave blank to use file title</span></div>");


// About defines
define('_AM_MODULE_SKELETON_BY', "by");
// block defines
define('_AM_MODULE_SKELETON_BADMIN', "Block administration");
define('_AM_MODULE_SKELETON_BLKDESC', "Description");
define('_AM_MODULE_SKELETON_TITLE', "Title");
define('_AM_MODULE_SKELETON_SIDE', "Alignment");
define('_AM_MODULE_SKELETON_WEIGHT', "Weight");
define('_AM_MODULE_SKELETON_VISIBLE', "Visible");
define('_AM_MODULE_SKELETON_ACTION', "Action");
define('_AM_MODULE_SKELETON_SBLEFT', "Left");
define('_AM_MODULE_SKELETON_SBRIGHT', "Right");
define('_AM_MODULE_SKELETON_CBLEFT', "Center left");
define('_AM_MODULE_SKELETON_CBRIGHT', "Center right");
define('_AM_MODULE_SKELETON_CBCENTER', "Center middle");
define('_AM_MODULE_SKELETON_ACTIVERIGHTS', "Active rights");
define('_AM_MODULE_SKELETON_ACCESSRIGHTS', "Access rights");
// image admin icon
define('_AM_MODULE_SKELETON_ICO_EDIT', "Edit this item");
define('_AM_MODULE_SKELETON_ICO_DELETE', "Delete this item");
define('_AM_MODULE_SKELETON_ICO_ONLINE', "Online");
define('_AM_MODULE_SKELETON_ICO_OFFLINE', "Offline");
define('_AM_MODULE_SKELETON_ICO_APPROVED', "Approved");
define('_AM_MODULE_SKELETON_ICO_NOTAPPROVED', "Not approved");
define('_AM_MODULE_SKELETON_ICO_LINK', "Related link");
define('_AM_MODULE_SKELETON_ICO_URL', "Add related URL");
define('_AM_MODULE_SKELETON_ICO_ADD', "Add");
define('_AM_MODULE_SKELETON_ICO_APPROVE', "Approve");
define('_AM_MODULE_SKELETON_ICO_STATS', "Stats");
define('_AM_MODULE_SKELETON_ICO_IGNORE', "Ignore");
define('_AM_MODULE_SKELETON_ICO_ACK', "Broken report acknowledged");
define('_AM_MODULE_SKELETON_ICO_REPORT', "Acknowledge broken report?");
define('_AM_MODULE_SKELETON_ICO_CONFIRM', "Broken report confirmed");
define('_AM_MODULE_SKELETON_ICO_CONBROKEN', "Confirm broken report?");
define('_AM_MODULE_SKELETON_DB_IMPORT', "Import");
define('_AM_MODULE_SKELETON_DB_CURRENTVER', "Current version: <span class='currentVer'>%s</span>");
define('_AM_MODULE_SKELETON_DB_DBVER', "Database Version %s");
define('_AM_MODULE_SKELETON_DB_MSG_ADD_DATA', "Data added in table %s");
define('_AM_MODULE_SKELETON_DB_MSG_ADD_DATA_ERR', "Error adding data in table %s");
define('_AM_MODULE_SKELETON_DB_MSG_CHGFIELD', "Changing field %s in table %s");
define('_AM_MODULE_SKELETON_DB_MSG_CHGFIELD_ERR', "Error changing field %s in table %s");
define('_AM_MODULE_SKELETON_DB_MSG_CREATE_TABLE', "Table %s created");
define('_AM_MODULE_SKELETON_DB_MSG_CREATE_TABLE_ERR', "Error creating table %s");
define('_AM_MODULE_SKELETON_DB_MSG_NEWFIELD', "Successfully added field %s");
define('_AM_MODULE_SKELETON_DB_MSG_NEWFIELD_ERR', "Error adding field %s");
define('_AM_MODULE_SKELETON_DB_NEEDUPDATE', "Your database is out-of-date. Please upgrade your database tables!<br><span style='font-weight: bold;'>Note: The XOOPS Team strongly recommends you to backup all the module tables before running this upgrade script.</span><br>");
define('_AM_MODULE_SKELETON_DB_NOUPDATE', "Your database is up-to-date. No updates are necessary.");
define('_AM_MODULE_SKELETON_DB_UPDATE_DB', "Updating database");
define('_AM_MODULE_SKELETON_DB_UPDATE_ERR', "Errors updating to version %s");
define('_AM_MODULE_SKELETON_DB_UPDATE_NOW', "Update now!");
define('_AM_MODULE_SKELETON_DB_UPDATE_OK', "Successfully updated to version %s");
define('_AM_MODULE_SKELETON_DB_UPDATE_TO', "Updating to version %s");
define('_AM_MODULE_SKELETON_GOMOD', "Go to module");
define('_AM_MODULE_SKELETON_UPDATE_MODULE', "Update module");
define('_AM_MODULE_SKELETON_MDOWNLOADS', "File Management");
define('_AM_MODULE_SKELETON_DB_MSG_UPDATE_TABLE', "Updating field values in %s");
define('_AM_MODULE_SKELETON_DB_MSG_UPDATE_TABLE_ERR', "Errors updating field values in %s");
// Mirrors


// continents (used in mirrors page)
define('_AM_MODULE_SKELETON_CONT1', "Africa");
define('_AM_MODULE_SKELETON_CONT2', "Antarctica");
define('_AM_MODULE_SKELETON_CONT3', "Asia");
define('_AM_MODULE_SKELETON_CONT4', "Europe");
define('_AM_MODULE_SKELETON_CONT5', "North America");
define('_AM_MODULE_SKELETON_CONT6', "South America");
define('_AM_MODULE_SKELETON_CONT7', "Oceania");
define('_AM_MODULE_SKELETON_HELP', "Help");
// Added Formulize module support (2006/05/04) jpc - start
define('_AM_MODULE_SKELETON_FFS_SUBMITBROKEN', "Submit");
define('_AM_MODULE_SKELETON_FFS_STANDARD_FORM', "No, use the standard form");
define('_AM_MODULE_SKELETON_FFS_CUSTOM_FORM', "Use a custom form for this itemcategory?");
define('_AM_MODULE_SKELETON_FFS_DOWNLOADTITLE', "2nd step: create new download");
define('_AM_MODULE_SKELETON_FFS_EDITDOWNLOADTITLE', "2nd step: edit download");
define('_AM_MODULE_SKELETON_FFS_BACK', "Back");
define('_AM_MODULE_SKELETON_FFS_RELOAD', "Reload");
define('_AM_MODULE_SKELETON_ITEMCATEGORYC', "Category: "); // _MD to reuse the itemcategory form
define('_AM_MODULE_SKELETON_FFS_SUBMITITEMCATEGORYHEAD', "Which itemcategory of file do you want to submit?");
define('_AM_MODULE_SKELETON_FFS_DOWNLOADDETAILS', "Download details:");
define('_AM_MODULE_SKELETON_FFS_DOWNLOADCUSTOMDETAILS', "Custom details:");
define('_AM_MODULE_SKELETON_FILETITLE', "Download title: ");
define('_AM_MODULE_SKELETON_DLURL', "Download URL: ");
define('_AM_MODULE_SKELETON_UPLOAD_FILEC', "Upload file: ");
define('_AM_MODULE_SKELETON_DESCRIPTION', "Description");
// Added Formulize module support (2006/05/04) jpc - end
define('_AM_MODULE_SKELETON_MINDEX_LOG', "Logs");
define('_AM_MODULE_SKELETON_IP_LOGS', "View logs");
define('_AM_MODULE_SKELETON_EMPTY_LOG', "No logs recorded.");
define('_AM_MODULE_SKELETON_LOG_FOR_LID', "Here is the list of the downloader's IP address for %s");
define('_AM_MODULE_SKELETON_IP_ADDRESS', "IP address");
define('_AM_MODULE_SKELETON_DATE', "Download date");
define('_AM_MODULE_SKELETON_BACK', "<< Back");
define('_AM_MODULE_SKELETON_USER', "User");
define('_AM_MODULE_SKELETON_ANONYMOUS', "Anonymous user");
// 3.23
define('_AM_MODULE_SKELETON_MINDEX_EXPIREDDOWN', "Expired downloads");
define('_AM_MODULE_SKELETON_BUTTON_ITEMCATEGORIES_REORDER', "Reorder");
define('_AM_MODULE_SKELETON_ITEMCATEGORIES_REORDERED', "Itemcategories reordered");
define('_AM_MODULE_SKELETON_FILE_SUBMITTER', "Submitter User");
define('_AM_MODULE_SKELETON_FILE_SUBMITTER_DESC', "Leave this as it is, unless you want to change who submitted the download");
define('_AM_MODULE_SKELETON_FITEMCATEGORY_ITEMCATEGORIES_LIST', "Itemcategories list");
define('_AM_MODULE_SKELETON_DOWN_ERROR_FILENOTFOUND', "Error: file not found on server.");
define('_AM_MODULE_SKELETON_DOWN_ERROR_ITEMCATEGORYNOTFOUND', "Error: itemcategory not found on server.");
define('_AM_MODULE_SKELETON_MIME_MIMETYPES_LIST', "MIME types list");
define('_AM_MODULE_SKELETON_MIME_NOMIMETYPES', "No MIME types");
define('_AM_MODULE_SKELETON_MINDEX_NEWDOWN', "New/waiting downloads");
define('_AM_MODULE_SKELETON_BROKEN_REPORTS', "Broken downloads reports");
define('_AM_MODULE_SKELETON_MODIFICATIONS', "Modifications");
define('_AM_MODULE_SKELETON_FORMULIZE_AVAILABLE', "Formulize Module active. Custom forms are supported.");
define('_AM_MODULE_SKELETON_FORMULIZE_NOT_AVILABLE', "Formulize Module not present or not installed or not active. Custom Forms are not supported.");



// admin/mimetypes.php
define('_AM_MODULE_SKELETON_MIME_EXTFIND_DESC', "Enter file extension you wish to search.");
define('_AM_MODULE_SKELETON_MIME_EXTF_DESC', "");
define('_AM_MODULE_SKELETON_MIME_NAMEF_DESC', "Enter application associated with this extension.");
define('_AM_MODULE_SKELETON_MIME_TYPEF_DESC', "Enter each MIME type associated with the file extension. Each MIME type must be separated with a space.");
// directories
define('_AM_MODULE_SKELETON_AVAILABLE', "<span style='color:green;'>Available. </span>");
define('_AM_MODULE_SKELETON_NOTAVAILABLE', "<span style='color:red;'>is not available. </span>");
define('_AM_MODULE_SKELETON_NOTWRITABLE', '<span style="color:red;"> should have permission ( %1$d ), but it has ( %2$d )</span>');
define('_AM_MODULE_SKELETON_CREATETHEDIR', "Create it");
define('_AM_MODULE_SKELETON_SETMPERM', "Set the permission");
define('_AM_MODULE_SKELETON_DIRCREATED', "The directory has been created");
define('_AM_MODULE_SKELETON_DIRNOTCREATED', "The directory cannot be created");
define('_AM_MODULE_SKELETON_PERMSET', "The permission has been set");
define('_AM_MODULE_SKELETON_PERMNOTSET', "The permission cannot be set");
define('_AM_MODULE_SKELETON_ERROR_UPLOADDIRNOTEXISTS', "Warning: the upload directory does not exist");
define('_AM_MODULE_SKELETON_ERROR_MAINIMAGEDIRNOTEXISTS', "Warning: the main images directory does not exist");
define('_AM_MODULE_SKELETON_ERROR_SCREENSHOTSDIRNOTEXISTS', "Warning: the categories images upload directory does not exist");
define('_AM_MODULE_SKELETON_ERROR_CATIMAGEDIRNOTEXISTS', "Warning: the upload directory does not exist");
// admin/item.php
define('_AM_MODULE_SKELETON_SEARCH', "Search");
define('_AM_MODULE_SKELETON_FILTER', "Filter");
define('_AM_MODULE_SKELETON_SEARCH_EQUAL', "=");
define('_AM_MODULE_SKELETON_SEARCH_GREATERTHAN', "&gt;");
define('_AM_MODULE_SKELETON_SEARCH_LESSTHAN', "&lt;");
define('_AM_MODULE_SKELETON_SEARCH_CONTAINS', "contains");
define('_AM_MODULE_SKELETON_MIRROR_DISABLED', "Warning: Mirrors system is disabled in module preferences.");
define('_AM_MODULE_SKELETON_REVIEW_DISABLED', "Warning: Reviews system is disabled in module preferences.");
define('_AM_MODULE_SKELETON_RATING_DISABLED', "Warning: Ratings system is disabled in module preferences.");
define('_AM_MODULE_SKELETON_BROKENREPORT_DISABLED', "Warning: Broken reports system is disabled in module preferences.");
// admin/itemcategory.php
define('_AM_MODULE_SKELETON_FITEMCATEGORY_ID', "ID");
// admin/reportsmodifications.php
define('_AM_MODULE_SKELETON_MOD_IGNORE', "Ignore and delete modification request");
define('_AM_MODULE_SKELETON_MOD_VIEWDESC', "<span style='font-weight: bold;'>View & Compare</span> download and modification.");
define('_AM_MODULE_SKELETON_MOD_IGNOREDESC', "<span style='font-weight: bold;'>Ignore & Delete</span> modification.");
define('_AM_MODULE_SKELETON_MOD_REALLYIGNOREDTHIS', "Are you sure to ignore and delete this modification?");
// Editor:
define('_AM_MODULE_SKELETON_MOD_DOHTML', "Allow HTML tags");
define('_AM_MODULE_SKELETON_MOD_DOSMILEY', "Allow XOOPS Smilies");
define('_AM_MODULE_SKELETON_MOD_DOXCODE', "Allow XOOPS BBcode");
define('_AM_MODULE_SKELETON_MOD_DOIMAGE', "Allow XOOPS Images");
define('_AM_MODULE_SKELETON_MOD_DOBR', "Convert line breaks");
define('_AM_MODULE_SKELETON_MOD_FORMULIZE_IDREQ', "Formulize Form ID");
// 3.23
define('_AM_MODULE_SKELETON_MOD_APPROVE', "Approve and delete modification request");
define('_AM_MODULE_SKELETON_MOD_SAVE', "Save");

define('_AM_MODULE_SKELETON_TEXTOPTIONS_DESC', "Description and Summary text options");
define('_AM_MODULE_SKELETON_FITEMCATEGORY_DESCRIPTION_DESC', "");
define('_AM_MODULE_SKELETON_FITEMCATEGORY_SUMMARY_DESC', "");

define('_AM_MODULE_SKELETON_MINDEX_BATCHFILES', "Batch files");
define('_AM_MODULE_SKELETON_MINDEX_NOBATCHFILESFOUND', "NOTICE: there are no files in batch path");
define('_AM_MODULE_SKELETON_MINDEX_BATCHPATH', "Batch path");
define('_AM_MODULE_SKELETON_BATCHFILE_FILENAME', "Filename");
define('_AM_MODULE_SKELETON_BATCHFILE_FILESIZE', "Size");
define('_AM_MODULE_SKELETON_BATCHFILE_EXTENSION', "File extension");
define('_AM_MODULE_SKELETON_BATCHFILE_MIMETYPE', "MIME type");
define('_AM_MODULE_SKELETON_ERROR_BATCHFILENOTFOUND', "ERROR: Batch file non found");
define('_AM_MODULE_SKELETON_ERROR_BATCHFILENOTCOPIED', "ERROR: Batch file not copied");
define('_AM_MODULE_SKELETON_ERROR_BATCHFILENOTADDED', "ERROR: Batch file not added");
define('_AM_MODULE_SKELETON_BATCHFILE_MOVEDEDITNOW', "Batch file moved, now edit!");

define('_AM_MODULE_SKELETON_FILE_CREATE', "Create new download");
define('_AM_MODULE_SKELETON_FILE_EDIT', "Edit download");
define('_AM_MODULE_SKELETON_FFS_1STEP', "1st step: choose itemcategory");
*/

define('_AM_MODULE_SKELETON_REQUIRED_TOGGLE_FAILED', "Toggle failed");
define('_AM_MODULE_SKELETON_REQUIRED_TOGGLE_SUCCESS', "Toggle was successful");
