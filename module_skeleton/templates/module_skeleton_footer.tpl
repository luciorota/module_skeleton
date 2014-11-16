<div class="footer">
// FOOTER
<{if !$com_rule == 0}>
    <a name="comments"></a>
    <div class="module_skeleton_foot_commentnav">
        <{$commentsnav}>
        <{$lang_notice}>
    </div>

    <div class="module_skeleton_foot_comments">
        <!-- start comments loop -->
    <{if $comment_mode == "flat"}>
        <{include file="db:system_comments_flat.html"}>
    <{elseif $comment_mode == "thread"}>
        <{include file="db:system_comments_thread.html"}>
    <{elseif $comment_mode == "nest"}>
        <{include file="db:system_comments_nest.html"}>
    <{/if}>
        <!-- end comments loop -->
    </div>
<{/if}>

    <{include file='db:system_notification_select.html'}>

    <!-- footer menu -->
    <div class="module_skeleton_adminlinks">
    <{foreach item='footerMenuItem' from=$moduleInfoSub}>
        <a href='<{$smarty.const.MODULE_SKELETON_URL}>/<{$footerMenuItem.url}>'><{$footerMenuItem.name}></a>
    <{/foreach}>
    <{if $isAdmin == true}>
        <br />
        <a href="<{$smarty.const.MODULE_SKELETON_URL}>/admin/index.php"><{$smarty.const._MD_MODULE_SKELETON_ADMIN_PAGE}></a>
    <{/if}>
    </div>
// FOOTER
</div>
