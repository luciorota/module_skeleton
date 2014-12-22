<fieldset>
    <legend style='font-weight: bold; color: #900;'><{$smarty.const._CO_MODULE_SKELETON_ITEMFIELDS_LIST}></legend>
<{if ($itemfieldCount == 0)}>
    <{$smarty.const._CO_MODULE_SKELETON_WARNING_NOITEMFIELDS}>
<{else}>
    <table class="outer">
        <tr>
            <td align='left' colspan='8'><{$smarty.const._AM_MODULE_SKELETON_ITEMFIELDS_COUNT|replace:'%s':$itemfieldCount}></td>
        </tr>
    <form id='itemfields_form' name='itemfields_form' action='' method='post'>
        <tr>
            <th><{$smarty.const._CO_MODULE_SKELETON_ITEMFIELD_ID}></th>
            <th><{$smarty.const._CO_MODULE_SKELETON_ITEMFIELD_NAME}></th>
            <th>
                <div class="xoops-form-element-caption">
                <span class="caption-text"><{$smarty.const._CO_MODULE_SKELETON_ITEMFIELD_TITLE}></span>
                </div>
                <div class="xoops-form-element-help"><{$smarty.const._CO_MODULE_SKELETON_ITEMFIELD_DESCRIPTION}></div>
            </th>
            <th><{$smarty.const._CO_MODULE_SKELETON_ITEMFIELDCATEGORY_TITLE}></th>
            <th><{$smarty.const._CO_MODULE_SKELETON_ITEMFIELD_WEIGHT}></th>
            <th><{$smarty.const._CO_MODULE_SKELETON_ITEMFIELD_TYPE}></th>
            <th><{$smarty.const._CO_MODULE_SKELETON_ITEMFIELD_REQUIRED}></th>
            <th><{$smarty.const._CO_MODULE_SKELETON_ACTIONS}></th>
        </tr>
    <{foreach item=itemfield from=$itemfields}>
        <tr class="<{cycle values='odd, even'}>">
            <td align='center'><{$itemfield.itemfield_id}></td>
            <td><{$itemfield.itemfield_name}></td>
            <td class="head">
                <div class="xoops-form-element-caption">
                <span class="caption-text"><{$itemfield.itemfield_title}></span>
                </div>
                <div class="xoops-form-element-help"><{$itemfield.itemfield_description}></div>
            </td>
            <td><a href='itemfieldcategory.php?itemfieldcategory_id=<{$itemfield.itemfield_category_id}>'><{$itemfield.itemfield_itemfieldcategory_title}></a></td>
            <td>
            <{if $itemfield.canEdit}>
                <input type="text" name="weight[<{$itemfield.itemfield_id}>]" size="5" maxlength="5" value="<{$itemfield.itemfield_weight}>" />
            <{/if}>
            </td>
            <td><{$itemfield.itemfieldtype}></td>
            <td align="center">
            <{if $itemfield.canEdit}>
                <a href="itemfield.php?op=itemfield.toggle&amp;itemfield_id=<{$itemfield.itemfield_id}>&amp;field=itemfield_required"><img src="<{xoModuleIcons16}><{$itemfield.itemfield_required}>.png" title="<{$smarty.const._AM_MODULE_SKELETON_REQUIRED_TOGGLE}>" alt="<{$smarty.const._AM_MODULE_SKELETON_REQUIRED_TOGGLE}>" /></a>
            <{/if}>
            </td>
            <td align="center">
            <{if $itemfield.canEdit}>
                <input type="hidden" name="oldweight[<{$itemfield.itemfield_id}>]" value="<{$itemfield.itemfield_weight}>" />
                <input type="hidden" name="itemfield_ids[]" value="<{$itemfield.itemfield_id}>" />
                <a href="itemfield.php?op=itemfield.edit&amp;itemfield_id=<{$itemfield.itemfield_id}>" title="<{$smarty.const._EDIT}>"><img src="<{xoModuleIcons16 edit.png}>" alt="<{$smarty.const._EDIT}>" title="<{$smarty.const._EDIT}>" /></a>
            <{/if}>
            <{if $itemfield.canDelete}>
                &nbsp;<a href="itemfield.php?op=itemfield.delete&amp;itemfield_id=<{$itemfield.itemfield_id}>" title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 delete.png}>" alt="<{$smarty.const._DELETE}>" title="<{$smarty.const._DELETE}>"</a>
            <{/if}>
            </td>
        </tr>
    <{/foreach}>
        <tr class="<{cycle values='odd, even'}>">
            <td colspan="4">
            </td>
            <td>
                <{$token}>
                <input type="hidden" name="op" value="itemfields.reorder" />
                <input type="submit" name="submit" value="<{$smarty.const._CO_MODULE_SKELETON_BUTTON_REORDER}>" />
            </td>
            <td colspan="3">
            </td>
        </tr>
    </form>
    </table>
<{/if}>
</fieldset>
