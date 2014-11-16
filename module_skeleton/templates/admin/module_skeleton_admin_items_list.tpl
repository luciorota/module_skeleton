<fieldset>
    <legend style='font-weight: bold; color: #900;'><{$smarty.const._CO_MODULE_SKELETON_ITEMS_LIST}></legend>
<{if ($items_count == 0)}>
    <{$smarty.const._CO_MODULE_SKELETON_WARNING_NOITEMS}>
<{else}>
    <table class="outer">
        <tr>
            <th><{$smarty.const._CO_MODULE_SKELETON_ITEM_ID}></th>
            <th><{$smarty.const._CO_MODULE_SKELETON_ITEM_TITLE}></th>
            <th><{$smarty.const._CO_MODULE_SKELETON_ITEMCATEGORY_TITLE}></th>
            <th><{$smarty.const._CO_MODULE_SKELETON_ITEM_WEIGHT}></th>
            <th><{$smarty.const._CO_MODULE_SKELETON_ITEM_OWNER_UNAME}></th>
            <th><{$smarty.const._CO_MODULE_SKELETON_ITEM_DATE}></th>
            <th><{$smarty.const._CO_MODULE_SKELETON_ACTIONS}></th>
        </tr>
    <form id='filter_form' name='filter_form' action='' method='post' enctype='multipart/form-data'>
        <tr>
            <td>&nbsp;</td>
            <td>
                <select id='filter_item_title_condition' title='<{$smarty.const._CO_MODULE_SKELETON_FILTER_CONDITION}>' name='filter_item_title_condition' size='1'>
                    <option value='='<{if $filter_item_title_condition == '='}>selected='selected'<{/if}>><{$smarty.const._CO_MODULE_SKELETON_FILTER_SEARCH_EQUAL}></option>
                    <option value='LIKE'<{if $filter_item_title_condition == 'LIKE'}>selected='selected'<{/if}>><{$smarty.const._CO_MODULE_SKELETON_FILTER_SEARCH_CONTAINS}></option>
                </select>
                <input id='filter_item_title' type='text' value='<{$filter_item_title}>' maxlength='100' size='15' title='' name='filter_item_title'>
            </td>
            <td>
                <select id='filter_itemcategory_title_condition' title='<{$smarty.const._CO_MODULE_SKELETON_FILTER_CONDITION}>' name='filter_itemcategory_title_condition' size='1'>
                    <option value='='<{if $filter_itemcategory_title_condition =='='}>selected='selected'<{/if}>><{$smarty.const._CO_MODULE_SKELETON_FILTER_SEARCH_EQUAL}></option>
                    <option value='LIKE' <{if $filter_itemcategory_title_condition =='LIKE'}>selected='selected'<{/if}>><{$smarty.const._CO_MODULE_SKELETON_FILTER_SEARCH_CONTAINS}></option>
                </select>
                <input id='filter_itemcategory_title' type='text' value='<{$filter_itemcategory_title}>' maxlength='100' size='15' title='' name='filter_itemcategory_title'>
            </td>
            <td>&nbsp;</td>
            <td><{$filter_item_owner_uid_select}></td>
            <td>&nbsp;</td>
            <td align='center'>
                <input id='submit' class='formButton' type='submit' title='<{$smarty.const._CO_MODULE_SKELETON_FILTER_SEARCH}>' value='<{$smarty.const._CO_MODULE_SKELETON_FILTER_SEARCH}>' name='submit'>
            </td>
        </tr>
        <input id='op' type='hidden' value='items.filter' name='op'>
    </form>
        <{foreach item=item from=$items}>
            <tr class="<{cycle values='even, odd'}>">
                <td align='center'><{$item.item_id}></td>
                <td><a href='item.php?item_id=<{$item.item_id}>'><{$item.item_title}></a></td>
                <td><a href='itemcategory.php?itemcategory_id=<{$item.item_category_id}>'><{$item.item_itemcategory_title}></a></td>
                <td><{$item.item_weight}></td>
                <td><{$item.item_owner_uname}></td>
                <td><{$item.item_date_formatted}></td>
                <td align='center'>
                    <a href='?op=item.add&amp;item_id=<{$item.item_id}>' title="<{$smarty.const._EDIT}>"><img src="<{xoModuleIcons16 edit.png}>"
                                                                                                              title="<{$smarty.const._EDIT}>"
                                                                                                              alt="<{$smarty.const._EDIT}>"/></a>
                    <a href='?op=item.delete&amp;item_id=<{$item.item_id}>' title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 delete.png}>"
                                                                                                                   title="<{$smarty.const._DELETE}>"
                                                                                                                   alt="<{$smarty.const._DELETE}>"/></a>
                </td>
            </tr>
        <{/foreach}>
    </table>
    <{$items_pagenav}>
<{/if}>
</fieldset>
