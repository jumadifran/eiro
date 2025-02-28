<div id="transfer_toolbar" style="padding-bottom: 2px;">
    <form id="transfer_search_form" onsubmit="return false" novalidate="">
        Search <input type="text" name="q" onkeyup="if (event.keyCode === 13) {
                    transfer_search();
                }"/> 
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="transfer_search()">Find</a>
        <?php if (in_array("Add", $action)) { ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="transfer_add()">Add</a>
        <?php }if (in_array("Edit", $action)) { ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="transfer_edit()">Edit</a>
        <?php }if (in_array("Delete", $action)) { ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="transfer_delete()">Delete</a>
        <?php } ?>
    </form>
</div>
<table id="transfer" data-options="
       url:'<?php echo site_url('transfer/get') ?>',
       method:'post',
       border:false,
       singleSelect:true,
       fit:true,
       pageSize:30,
       pageList: [30, 50, 70, 90, 110],
       rownumbers:true,
       fitColumns:false,
       remoteSort:true,
       multiSort:true,
       pagination:true,
       toolbar:'#transfer_toolbar'">
    <thead>
        <tr>
            <th field="transfer_no" width="100" align="center">Transfer No</th>            
            <th field="date" width="70" align="center" formatter="myFormatDate">Date</th>
            <th field="source_name" width="170" halign="center">Transfer From</th>
            <th field="target_name" width="150" halign="center" sortable="true">Transfer To</th>
            <th field="description" width="200" halign="center">Description</th>
        </tr>
    </thead>
</table>
<script type="text/javascript">
    $(function () {
        $('#transfer').datagrid({
            onSelect: function (index, row) {
                $('#transfer_detail').datagrid('reload', {transferid: row.id});
            }
        });
    });
</script>