<fieldset>
    <legend style='font-weight: bold; color: #900;'><{$smarty.const._CO_MODULE_SKELETON_ITEMFIELDCATEGORIES_LIST}></legend>
<{if ($itemfieldcategoryCount == 0)}>
    <{$smarty.const._CO_MODULE_SKELETON_WARNING_NOITEMFIELDCATEGORIES}>
<{else}>
    <table class="outer">
        <tr>
            <td align='left' colspan='6'><{$smarty.const._AM_MODULE_SKELETON_ITEMFIELDCATEGORIES_COUNT|replace:'%s':$itemfieldcategoryCount}></td>
        </tr>
    <form id='itemfieldcategories_form' name='itemfieldcategories_form' action='' method='post'>
        <tr>
            <th><{$smarty.const._CO_MODULE_SKELETON_ITEMFIELDCATEGORY_ID}></th>
            <th>
                <div class="xoops-form-element-caption">
                <span class="caption-text"><{$smarty.const._CO_MODULE_SKELETON_ITEMFIELDCATEGORY_TITLE}></span>
                </div>
                <div class="xoops-form-element-help"><{$smarty.const._CO_MODULE_SKELETON_ITEMFIELDCATEGORY_DESCRIPTION}></div>
            </th>
            <th><{$smarty.const._CO_MODULE_SKELETON_ITEMFIELDCATEGORY_WEIGHT}></th>
            <th><{$smarty.const._CO_MODULE_SKELETON_ITEMFIELDCATEGORY_OWNER_UNAME}></th>
            <th><{$smarty.const._CO_MODULE_SKELETON_ITEMFIELDCATEGORY_DATE}></th>
            <th><{$smarty.const._CO_MODULE_SKELETON_ACTIONS}></th>
        </tr>
    <{foreach item=sorted_itemfieldcategory from=$sorted_itemfieldcategories}>
        <tr class="<{cycle values='even, odd'}>">
            <td align='center'><{$sorted_itemfieldcategory.itemfieldcategory.itemfieldcategory_id}></td>
            <td class="head">
            <div style="margin: 0 0 0 <{$sorted_itemfieldcategory.level*20-20}>px">
                <div class="xoops-form-element-caption">
<{*
                <{section name=indent loop=$sorted_itemfieldcategory.level-1 step=1}>-<{/section}>
*}>
                <span class="caption-text"><a href='../viewcat.php?itemfieldcategory_id=<{$sorted_itemfieldcategory.itemfieldcategory.itemfieldcategory_id}>'><{$sorted_itemfieldcategory.itemfieldcategory.itemfieldcategory_title}></a></span>
                </div>
                <div class="xoops-form-element-help"><{$sorted_itemfieldcategory.itemfieldcategory.itemfieldcategory_description}></div>
            </div>
            </td>
            <td>
                <input type="text" name="new_itemfieldcategory_weights[<{$sorted_itemfieldcategory.itemfieldcategory.itemfieldcategory_id}>]" size="5" maxlength="5"
                       value="<{$sorted_itemfieldcategory.itemfieldcategory.itemfieldcategory_weight}>"/>
            </td>
            <td><{$sorted_itemfieldcategory.itemfieldcategory.itemfieldcategory_owner_uname}></td>
            <td><{$sorted_itemfieldcategory.itemfieldcategory.itemfieldcategory_date_formatted}></td>
            <td align='center'>
                <a href="?op=itemfieldcategory.edit&amp;itemfieldcategory_id=<{$sorted_itemfieldcategory.itemfieldcategory.itemfieldcategory_id}>" title="<{$smarty.const._EDIT}>"><img src="<{xoModuleIcons16 edit.png}>" title="<{$smarty.const._EDIT}>" alt="<{$smarty.const._EDIT}>"/></a>
                <a href="?op=itemfieldcategory.delete&amp;itemfieldcategory_id=<{$sorted_itemfieldcategory.itemfieldcategory.itemfieldcategory_id}>" title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 delete.png}>" title="<{$smarty.const._DELETE}>" alt="<{$smarty.const._DELETE}>"/></a>
            </td>
        </tr>
    <{/foreach}>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>
                <{$token}>
                <input type="hidden" name="op" value="itemfieldcategories.reorder"/>
                <input type="submit" name="submit" value="<{$smarty.const._CO_MODULE_SKELETON_BUTTON_REORDER}>"/>
            </td>
            <td>&nbsp;</td>
        </tr>
    </form>
    </table>
<{/if}>
</fieldset>
