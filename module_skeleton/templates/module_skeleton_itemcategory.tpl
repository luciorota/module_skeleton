<{php}>
    /** add JQuery */
    global $xoTheme;
    $xoTheme->addScript("browse.php?Frameworks/jquery/jquery.js");
<{/php}>

<{include file='db:module_skeleton_header.tpl'}>

<{$itemcategory_select}>

<h1><{$smarty.const._CO_MODULE_SKELETON_ITEMCATEGORY}></h1>
<{$itemcategory.itemcategory_title}>

<h1><{$smarty.const._CO_MODULE_SKELETON_ITEMCATEGORIES_LIST}></h1>
<ul>
<{foreach item=itemcategoryFirstChild from=$itemcategoryFirstChilds}>
    <li>
        <a href="itemcategory.php?itemcategory_id=<{$itemcategoryFirstChild.itemcategory_id}>"><{$itemcategoryFirstChild.itemcategory_title}></a>
    </li>
<{/foreach}>
</ul>

<h1><{$smarty.const._CO_MODULE_SKELETON_ITEMS_LIST}></h1>
<ul>
<{foreach item=item from=$items}>
    <li>
        <a href="item.php?item_id=<{$item.item_id}>"><{$item.item_title}></a>
    </li>
<{/foreach}>
</ul>

<{include file='db:module_skeleton_footer.tpl'}>
