<div id="receiving_toolbar" style="padding-bottom: 2px;">
    <form id="receiving_search_form" onsubmit="return false" novalidate="">
        Search <input type="text" name="q" onkeyup="if(event.keyCode===13){receiving_search()}"/>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="receiving_search()">Find</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="receiving_add()">Add</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="receiving_edit()">Edit</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="receiving_delete()">Delete</a>
    </form>
</div>
<table id="receiving" data-options="
       url:'<?php echo site_url('receiving/get') ?>',
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
       toolbar:'#receiving_toolbar'">
    <thead>
        <tr>
            <th field="id" hidden="true"></th>
            <th field="number" width="100" halign="center" sortable="true">Receipt No</th>            
            <th field="date" width="80" align="center" sortable="true" formatter="myFormatDate">Date</th>
            <th field="vendor_code" width="200" halign="center" sortable="true" data-options="formatter:function(value,row){return '<b>'+value+'</b> - '+row.vendor_name}">Vendor</th>
            <th field="do_number" width="140" halign="center">D.O No.</th>
            <th field="do_date" width="100" align="center" formatter="myFormatDate">D.O Date</th>
            <th field="received_name" width="150" halign="center">Received BY</th>
            <th field="store_warehouse_code" width="150" halign="center" data-options="formatter:function(value,row){return '<b>'+value+'</b> - '+row.store_warehouse_name}">Store To</th>
            <th field="remark" width="190" halign="center">Remark</th>
        </tr>
    </thead>
</table>
<script receiving="text/javascript">
    $(function () {
        $('#receiving').datagrid({
            onSelect: function (index, row) {
                $('#receiving_detail').datagrid('reload', {receivingid: row.id})
            },
            onDblClickRow: function (index, row) {
                receiving_edit();
            }
        });
    });
</script>
