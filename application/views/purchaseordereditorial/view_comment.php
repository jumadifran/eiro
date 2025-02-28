<div class="easyui-panel" style="height: 400px" border="false">
    <div class="easyui-layout" fit="true">
        <div region="center" border="false">
            <form id="poe_comment_form" onsubmit="return false" method="POST">
                <table width="100%">
                    <tr>
                        <td width="25%"><strong>Comment</strong></td>
                        <td><textarea style="width: 99%;height: 50px" name="comment" class="easyui-validatebox" required="true"></textarea></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td><a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-save" onclick="poe_comment_save(<?php echo $id?>)">Save</a></td>
                    </tr>
                </table>
            </form>
        </div>
        <div region="south" border="false" id="poe_comment_list" collapsible="false" style="height: 300px" title="Comment List"
             href="<?php echo site_url('purchaseordereditorial/load_comment_list/' . $id) ?>">
        </div>
    </div>
</div>
