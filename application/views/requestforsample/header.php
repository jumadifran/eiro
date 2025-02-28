<div id="requestforsample_toolbar" style="padding-bottom: 0;">
    Search : 
    <input type="text" 
           size="12" 
           class="easyui-validatebox" 
           onkeypress="if (event.keyCode === 13) {
                       requestforsample_search();
                   }"
           />
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="requestforsample_search()"> Search</a>

    <?php
    if (in_array("Add", $action)) {
        ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="requestforsample_add()">Add</a>
        <?php
    }if (in_array("Edit", $action)) {
        ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="requestforsample_edit()">Edit</a>
        <?php
    }if (in_array("Delete", $action)) {
        ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="requestforsample_delete()">Delete</a>
        <?php
    }if (in_array("Print", $action)) {
        ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="requestforsample_print()">Print</a>
        <?php
    }
    ?>

</div>
<table id="requestforsample" data-options="
       url:'<?php echo site_url('requestforsample/get') ?>',
       method:'post',
       border:false,
       singleSelect:true,
       fit:true,
       rownumbers:true,
       fitColumns:true,
       pagination:true,
       striped:true,
       idField:'id',
       toolbar:'#requestforsample_toolbar'">
    <thead>
        <tr>
            <th field="number" width="120" halign="center">R.F.S No</th>
            <th field="date" width="80" align="center" formatter="myFormatDate">Date</th>
            <th field="company_name" width="200" halign="center">Company</th>
            <th field="vendor_name" width="200" halign="center">Vendor</th>
            <th field="name_request_by" width="120" align="center">Request By</th>
            <th field="remark" width="300" align="center">Notes</th>
        </tr>
    </thead>
</table>
<script>
    $(function () {
        $('#requestforsample').datagrid({
            onSelect: function (index, row) {
                $('#requestforsample_detail').datagrid('reload', {
                    requestforsampleid: row.id
                });
            }
        });
    });
</script>
