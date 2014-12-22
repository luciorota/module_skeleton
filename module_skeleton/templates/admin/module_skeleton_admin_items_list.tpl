<script language='JavaScript'>
    function toggle(source){
        checkboxes = document.getElementsByName('item_ids[]');
        for (var i = 0, n = checkboxes.length; i < n; i++) {
            checkboxes[i].checked = source.checked;
        }
        togglers = document.getElementsByName('togglers[]');
        for (var i = 0, n = togglers.length; i < n; i++) {
            togglers[i].checked = source.checked;
        }
    }
</script>
<script language='JavaScript'>
    function check(source){
        checkboxes = document.getElementsByName('item_ids[]');
        for (var i = 0,  n= checkboxes.length; i < n; i++) {
            if (checkboxes[i].checked) return true;
        }
        return false;
    }
</script>

<fieldset>
    <legend style='font-weight: bold; color: #900;'><{$smarty.const._CO_MODULE_SKELETON_ITEMS_LIST}></legend>
<{if ($itemCount == 0)}>
    <{$smarty.const._CO_MODULE_SKELETON_WARNING_NOITEMS}>
<{else}>
    <table class='outer width100' cellspacing='1'>
        <tr class='odd'>
            <td>
            <form id='filter_form' name='filter_form' action='' method='post' enctype='multipart/form-data'>
                <{$smarty.const._CO_MODULE_SKELETON_ITEM_TITLE}>
                <{$filter_item_title_condition_select}>
                <input id='filter_item_title' type='text' value='<{$filter_item_title}>' maxlength='100' size='15' title='' name='filter_item_title'>
                &nbsp;
                <{$smarty.const._CO_MODULE_SKELETON_ITEMCATEGORY_TITLE}>
                <{$filter_itemcategory_title_condition_select}>
                <input id='filter_itemcategory_title' type='text' value='<{$filter_itemcategory_title}>' maxlength='100' size='15' title='' name='filter_itemcategory_title'>
                &nbsp;
                <{$smarty.const._CO_MODULE_SKELETON_ITEM_OWNER_UNAME}>
                <{$filter_item_owner_uid_select}>
                &nbsp;
                <input type='submit' id='filter_submit' class='formButton' title='<{$smarty.const._CO_MODULE_SKELETON_BUTTON_FILTER}>' value='<{$smarty.const._CO_MODULE_SKELETON_BUTTON_FILTER}>' name='filter_submit'>
                <input type='hidden' id='op' name='op' value='list_items' >
                <input type='hidden' id='filter_op' name='apply_filter' value='1' >
            </form>
            </td>
        </tr>
    </table>
    <table class="outer">
        <tr>
            <td align='left' colspan='8'><{$smarty.const._AM_MODULE_SKELETON_ITEMS_COUNT|replace:'%s':$itemCount}></td>
        </tr>
    <form id='form_action' onsubmit='return check(this);' enctype='multipart/form-data' method='post' action='' name='form_action'>
        <tr>
            <th class='center'><input type='checkbox' name='togglers[]' title='<{$smarty.const._ALL}>' onClick='toggle(this);'></th>
            <th><{$smarty.const._CO_MODULE_SKELETON_ITEM_ID}></th>
            <th><{$smarty.const._CO_MODULE_SKELETON_ITEM_TITLE}></th>
            <th><{$smarty.const._CO_MODULE_SKELETON_ITEMCATEGORY_TITLE}></th>
            <th><{$smarty.const._CO_MODULE_SKELETON_ITEM_WEIGHT}></th>
            <th><{$smarty.const._CO_MODULE_SKELETON_ITEM_OWNER_UNAME}></th>
            <th><{$smarty.const._CO_MODULE_SKELETON_ITEM_DATE}></th>
            <th><{$smarty.const._CO_MODULE_SKELETON_ACTIONS}></th>
        </tr>
    <{foreach item=item from=$items}>
        <tr class="<{cycle values='even, odd'}>">
            <td class='center'><input type='checkbox' name='item_ids[]' value='<{$item.item_id}>'></td>
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
        <tr>
            <td colspan='8'>
                <select id='actions_action' name='actions_action' value='delete' size='1'>
                    <option value='delete'><{$smarty.const._DELETE}></option>
                    <option value='activate'><{$smarty.const._CO_MODULE_SKELETON_ACTIONS_ACTIVATE}></option>
                    <option value='unactivate'><{$smarty.const._CO_MODULE_SKELETON_ACTIONS_UNACTIVATE}></option>
                </select>
                <input type='submit' class='formButton' id='actions_submit' title='<{$smarty.const._CO_MODULE_SKELETON_BUTTON_EXECUTE}>' name='actions_submit' value='<{$smarty.const._CO_MODULE_SKELETON_BUTTON_EXECUTE}>'>
                <input type='hidden' id='actions_op' name='op' value='items.apply_actions'>
            </td>
        </tr>
    </form>
    </table>
    <{$items_pagenav}>
<{/if}>
</fieldset>
