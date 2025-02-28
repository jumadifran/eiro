<div id="requestforsample_detail_toolbar" style="padding-bottom: 0;">
    Search : 
    <input type="text" 
           size="12" 
           class="easyui-validatebox" 
           onkeypress="if (event.keyCode === 13) {
                       requestforsample_detail_search();
                   }"
           />
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="requestforsample_detail_search()"> Search</a>

    <?php
    if (in_array("Add", $action)) {
        ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="requestforsample_detail_add()">Add</a>
        <?php
    }if (in_array("Edit", $action)) {
        ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="requestforsample_detail_edit()">Edit</a>
        <?php
    }if (in_array("Delete", $action)) {
        ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="requestforsample_detail_delete()">Delete</a>
        <?php
    }
    ?>
</div>
<table id="requestforsample_detail" 
       class="easyui-datagrid"
       data-options="
       url:'<?php echo site_url('requestforsample/detail_get') ?>',
       method:'post',
       border:false,
       singleSelect:true,
       fit:true,
       rownumbers:true,
       fitColumns:true,
       pagination:true,
       striped:true,
       idField:'id',
       toolbar:'#requestforsample_detail_toolbar'">
    <thead>
        <tr>
            <th field="item_code" width="120" halign="center">Item Code</th>
            <th field="item_description" width="230" halign="center">Item Description</th>
            <th field="dimension" width="150" halign="center">Dimension</th>
            <th field="material" width="130" align="center">Material</th>
            <th field="color" width="130" align="center">Color</th>
            <th field="fabric_code" width="130" align="center">Fabric</th>
            <th field="qty" width="50" align="center">Qty</th>
            <th field="due_date" width="90" align="center" formatter="myFormatDate">Due Date</th>
            <th field="remark" width="300" align="center">Remark</th>
        </tr>
    </thead>
</table>

