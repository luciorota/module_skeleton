#
# Table structure for table `module_skeleton_itemcategories`
#
CREATE TABLE `module_skeleton_itemcategories` (
    `itemcategory_id`           mediumint(8) unsigned   NOT NULL auto_increment,
    `itemcategory_pid`          mediumint(8) unsigned   NOT NULL default '0',
    `itemcategory_title`        varchar(255)            NOT NULL default '',
    `itemcategory_description`  LONGTEXT                NOT NULL,
    `dohtml`                    tinyint(1)              NOT NULL default '0',
    `dosmiley`                  tinyint(1)              NOT NULL default '1',
    `doxcode`                   tinyint(1)              NOT NULL default '1',
    `doimage`                   tinyint(1)              NOT NULL default '1',
    `dobr`                      tinyint(1)              NOT NULL default '1',

    `itemcategory_weight`       int(11)                 NOT NULL default '0',
    `itemcategory_status`       tinyint(2)              NOT NULL default '0',
    `itemcategory_version`      varchar(20)             NOT NULL default '',
    `itemcategory_owner_uid`    int(11)                 NOT NULL default '0',
    `itemcategory_date`         int(10)                 NOT NULL default '0',
    PRIMARY KEY (`itemcategory_id`),
    KEY `itemcategory_pid` (`itemcategory_pid`)
) ENGINE=MyISAM;

#
# Dumping data for table `module_skeleton_itemcategories`
#

# --------------------------------------------------------



#
# Table structure for table `module_skeleton_items`
#
CREATE TABLE `module_skeleton_items` (
    `item_id`               mediumint(8) unsigned   NOT NULL auto_increment,
    `item_category_id`      mediumint(8) unsigned   NOT NULL default '0',
    `item_title`            varchar(255)            NOT NULL default '',

    `item_weight`           int(11)                 NOT NULL default '0',
    `item_status`           tinyint(2)              NOT NULL default '0',
    `item_version`          varchar(20)             NOT NULL default '',
    `item_owner_uid`        int(11)                 NOT NULL default '0',
    `item_date`             int(10)                 NOT NULL default '0',
    PRIMARY KEY (`item_id`),
    KEY `item_category_id` (`item_category_id`),
    KEY `item_status` (`item_status`)
) ENGINE=MyISAM;

#
# Dumping data for table `module_skeleton_items`
#

# --------------------------------------------------------



#
# Table structure for table `module_skeleton_itemfieldcategories`
#
CREATE TABLE `module_skeleton_itemfieldcategories` (
    `itemfieldcategory_id`          mediumint(8) unsigned   NOT NULL auto_increment,
    `itemfieldcategory_pid`         mediumint(8) unsigned   NOT NULL default '0',
    `itemfieldcategory_title`       varchar(255)            NOT NULL default '',
    `itemfieldcategory_description` LONGTEXT                NOT NULL,
    `dohtml`                        tinyint(1)              NOT NULL default '0',
    `dosmiley`                      tinyint(1)              NOT NULL default '1',
    `doxcode`                       tinyint(1)              NOT NULL default '1',
    `doimage`                       tinyint(1)              NOT NULL default '1',
    `dobr`                          tinyint(1)              NOT NULL default '1',

    `itemfieldcategory_weight`      int(11)                 NOT NULL default '0',
    `itemfieldcategory_status`      tinyint(2)              NOT NULL default '0',
    `itemfieldcategory_version`     varchar(20)             NOT NULL default '',
    `itemfieldcategory_owner_uid`   int(11)                 NOT NULL default '0',
    `itemfieldcategory_date`        int(10)                 NOT NULL default '0',
    PRIMARY KEY (`itemfieldcategory_id`),
    KEY `itemfieldcategory_pid` (`itemfieldcategory_pid`)
) ENGINE=MyISAM;

#
# Dumping data for table `module_skeleton_itemfieldcategories`
#

# --------------------------------------------------------



#
# Table structure for table `module_skeleton_itemfields`
#
CREATE TABLE `module_skeleton_itemfields` (
    `itemfield_id`          mediumint(8) unsigned   NOT NULL auto_increment,
    `itemfield_category_id` mediumint(8) unsigned   NOT NULL default '0',
    `itemfield_title`       varchar(255)            NOT NULL default '',
    `itemfield_description` text,

    `itemfield_weight`      smallint(6) unsigned    NOT NULL default '0',
    `itemfield_name`        varchar(255)            NOT NULL default '',
    `itemfield_type`        varchar(30)             NOT NULL default '',
    `itemfield_typeconfigs` text,
    `itemfield_options`     text,
    `itemfield_datatype`    tinyint(2) unsigned     NOT NULL default '0',
    `itemfield_default`     text,
    `itemfield_notnull`     tinyint(1) unsigned     NOT NULL default '0',
    `itemfield_required`    tinyint(1) unsigned     NOT NULL default '0',

    `itemfield_edit`        tinyint(1) unsigned     NOT NULL default '0',
    `itemfield_show`        tinyint(1) unsigned     NOT NULL default '0',
    `itemfield_config`      tinyint(1) unsigned     NOT NULL default '0',
    PRIMARY KEY (`itemfield_id`),
    UNIQUE KEY `itemfield_name` (`itemfield_name`),
    KEY `itemfield_weight` (`itemfield_weight`)
) ENGINE=MyISAM;

#
# Dumping data for table `module_skeleton_itemfields`
#

# --------------------------------------------------------
