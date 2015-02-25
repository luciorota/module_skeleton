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

define('_CO_MODULE_SKELETON_EXTRA_ITEMFIELD_TYPE_GMAPLNGLAT',"Longitude & latitude");
define('_CO_MODULE_SKELETON_EXTRA_ITEMFIELD_TYPE_GMAPLNGLAT_DESC',"Insert longitude and latitude using Google map");

define('_CO_MODULE_SKELETON_ITEMFIELD_TYPE_GMAPLNGLAT_API_KEY',"Google API key");
define('_CO_MODULE_SKELETON_ITEMFIELD_TYPE_GMAPLNGLAT_API_KEY_DESC',"<a href='https://developers.google.com/maps/documentation/javascript/tutorial'>More info here</a>");
define('_CO_MODULE_SKELETON_ITEMFIELD_TYPE_GMAPLNGLAT_STYLE',"Style");
define('_CO_MODULE_SKELETON_ITEMFIELD_TYPE_GMAPLNGLAT_STYLE_DESC',"");
define('_CO_MODULE_SKELETON_ITEMFIELD_TYPE_GMAPLNGLAT_READONLY',"Readonly");
define('_CO_MODULE_SKELETON_ITEMFIELD_TYPE_GMAPLNGLAT_READONLY_DESC',"");

define("_FORMGOOGLEMAP_ERROR_GEOCODER", "Geocode was not successful for the following reason: ");
define("_FORMGOOGLEMAP_ERROR_ELEVATOR", "Elevation service failed due to: ");
define("_FORMGOOGLEMAP_ERROR_ELEVATOR_NOTFOUND", "No results found");


define("_FORMGOOGLEMAP_GO_INIT", "Reset");
define("_FORMGOOGLEMAP_GO_INIT_DESC", "Click to set the map to Initial position");
define("_FORMGOOGLEMAP_TYPE_OPENSTREETMAP", "OpenStreetMap");

define("_FORMGOOGLEMAP_MARKER_CLICKTOUPDATEPOSITION", "Click to set the coordinates or drag");
define("_FORMGOOGLEMAP_GOOGLEMAPHERE", "<b>GOOGLE MAP HERE</b>");
define("_FORMGOOGLEMAP_GOOGLEMAPHERE_DESC", "In this area will appear Google Maps map if an internet connection is available");
define("_FORMGOOGLEMAP_LAT", "Latitude (Dec. Deg.)");
define("_FORMGOOGLEMAP_LNG", "Longitude (Dec. Deg.)");
define("_FORMGOOGLEMAP_ELEVATION", "Elevation (meters)");
define("_FORMGOOGLEMAP_ZOOM", "Zoom level");
define("_FORMGOOGLEMAP_LATLNGZOOM", "Position");
define("_FORMGOOGLEMAP_LATLNGZOOM_DESC1",
    "<b>Drag the Marker and click on it to set the coordinates or input the coordinates to automatically move the marker</b>");
define("_FORMGOOGLEMAP_LATLNGZOOM_DESC2",
    "<small>Use: deg-min-sec suffixed with N/S/E/W (e.g. 40&deg;44&#39;55&quot;N, 73 59 11W), <br />or signed decimal degrees without compass direction, where negative indicates west/south (e.g. +40.689060  -74.044636)</small>");
define("_FORMGOOGLEMAP_SEARCH", "Search location");
define("_FORMGOOGLEMAP_SEARCH_DESC", "Use &quot;Search Location&quot; to use Google searching engine");
define("_FORMGOOGLEMAP_SEARCHBUTTON", "Search");
define("_FORMGOOGLEMAP_SEARCHERROR", "Geocode was not successful for the following reason: ");
