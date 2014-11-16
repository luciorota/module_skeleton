    <fieldset>
        <legend style='font-weight: bold; color: #900;'><{$smarty.const._CO_MODULE_SKELETON_ITEMCATEGORIES_LIST}></legend>
    <{if ($categories_count == 0)}>
        <{$smarty.const._CO_MODULE_SKELETON_WARNING_NOITEMCATEGORIES}>
    <{else}>
        <form id='categories_form' name='categories_form' action='' method='post'>
            <table class="outer">
                <tr>
                    <th><{$smarty.const._CO_MODULE_SKELETON_ITEMCATEGORY_ID}></th>
                    <th>
                        <div class="xoops-form-element-caption">
                        <span class="caption-text"><{$smarty.const._CO_MODULE_SKELETON_ITEMCATEGORY_TITLE}></span>
                        </div>
                        <div class="xoops-form-element-help"><{$smarty.const._CO_MODULE_SKELETON_ITEMCATEGORY_DESCRIPTION}></div>
                    </th>
                    <th><{$smarty.const._CO_MODULE_SKELETON_ITEMCATEGORY_WEIGHT}></th>
                    <th><{$smarty.const._CO_MODULE_SKELETON_ITEMCATEGORY_OWNER_UNAME}></th>
                    <th><{$smarty.const._CO_MODULE_SKELETON_ITEMCATEGORY_DATE}></th>
                    <th><{$smarty.const._CO_MODULE_SKELETON_ACTIONS}></th>
                </tr>
                <{foreach item=sorted_itemcategory from=$sorted_categories}>
                    <tr class="<{cycle values='even, odd'}>">
                        <td align='center'><{$sorted_itemcategory.itemcategory.itemcategory_id}></td>
                        <td class="head">
                        <div style="margin: 0 0 0 <{$sorted_itemcategory.level*20-20}>px">
                            <div class="xoops-form-element-caption">
<{*
                            <{section name=indent loop=$sorted_itemcategory.level-1 step=1}>-<{/section}>
*}>
                            <span class="caption-text"><a href='../viewcat.php?itemcategory_id=<{$sorted_itemcategory.itemcategory.itemcategory_id}>'><{$sorted_itemcategory.itemcategory.itemcategory_title}></a></span>
                            </div>
                            <div class="xoops-form-element-help"><{$sorted_itemcategory.itemcategory.itemcategory_description}></div>
                        </div>
                        </td>
                        <td>
                            <input type="text" name="new_itemcategory_weights[<{$sorted_itemcategory.itemcategory.itemcategory_id}>]" size="5" maxlength="5"
                                   value="<{$sorted_itemcategory.itemcategory.itemcategory_weight}>"/>
                        </td>
                        <td><{$sorted_itemcategory.itemcategory.itemcategory_owner_uname}></td>
                        <td><{$sorted_itemcategory.itemcategory.itemcategory_date_formatted}></td>
                        <td align='center'>
                            <a href="?op=itemcategory.edit&amp;itemcategory_id=<{$sorted_itemcategory.itemcategory.itemcategory_id}>" title="<{$smarty.const._EDIT}>"><img src="<{xoModuleIcons16 edit.png}>" title="<{$smarty.const._EDIT}>" alt="<{$smarty.const._EDIT}>"/></a>
                            <a href="?op=itemcategory.delete&amp;itemcategory_id=<{$sorted_itemcategory.itemcategory.itemcategory_id}>" title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 delete.png}>" title="<{$smarty.const._DELETE}>" alt="<{$smarty.const._DELETE}>"/></a>
                            <a href="?op=itemcategory.move&amp;itemcategory_id=<{$sorted_itemcategory.itemcategory.itemcategory_id}>" title="<{$smarty.const._CO_MODULE_SKELETON_BUTTON_ITEMS_MOVE}>"><img src="<{xoModuleIcons16 forward.png}>" title="<{$smarty.const._CO_MODULE_SKELETON_BUTTON_ITEMS_MOVE}>" alt="<{$smarty.const._CO_MODULE_SKELETON_BUTTON_ITEMS_MOVE}>"/></a>
                        </td>
                    </tr>
                <{/foreach}>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>
                        <{$token}>
                        <input type="hidden" name="op" value="categories.reorder"/>
                        <input type="submit" name="submit" value="<{$smarty.const._CO_MODULE_SKELETON_BUTTON_REORDER}>"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </form>
    <{/if}>
    </fieldset>
