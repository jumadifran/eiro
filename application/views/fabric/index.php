<div id="fabric_toolbar" style="padding-bottom: 0px;">
    <form id="fabric_search_form" style="margin: 0px" onsubmit="return false;">   
        Search: 
        <input type="text" 
               size="20" 
               class="easyui-validatebox" 
               name="code_description" 
               onkeypress="if (event.keyCode === 13) {
                           fabric_search();
                       }"
               />  
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="fabric_search()">&nbsp;</a>
        <?php
        if (in_array("Add", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="fabric_add()">Add</a>
            <?php
        }if (in_array("Edit", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="fabric_edit()">Edit</a>
            <?php
        }if (in_array("Delete", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="fabric_delete()">Delete</a>
            <?php
        }
        ?>
    </form>
</div>
<table id="fabric" data-options="
       url:'<?php echo site_url('fabric/get') ?>',
       method:'post',
       border:true,
       title:'Fabric',
       singleSelect:true,
       fit:true,
       pageSize:30,
       pageList: [30, 50, 70, 90, 110],
       rownumbers:true,
       fitColumns:false,
       remoteSort:true,
       multiSort:true,
       pagination:true,
       toolbar:'#fabric_toolbar'">
    <thead>
        <tr>
            <th field="code" width="20%" halign="center">Code</th>            
            <th field="description" width="20%" halign="center">Description</th>
            <th field="vendor_name" width="20%" halign="center" data-options="formatter:function(value,row,index){if(value !== null){return row.vendor_name+' <b>('+row.vendor_code+')</b>';}}">Vendor</th>
            <th field="price" width="15%" halign="center" align="right" formatter="fabricFormatPrice">Price</th>
            <th field="remark" width="25%" halign="center">Remark</th>
        </tr>
    </thead>
</table>
<script type = "text/javascript">
    function fabricFormatPrice(value, row) {
        if (value !== null && row.currency_code !== null) {
            var x = '' + value;
            var parts = x.toString().split(".");
            return  row.currency_code + ' ' + parts[0].replace(/\B(?=(\d{3})+(?=$))/g, ",") + (parts[1] ? "." + parts[1] : ".00");
        } else {
            return "";
        }
    }
    $('#fabric').datagrid({
        onDblClickRow: function (rowIndex, row) {
            fabric_edit();
        }
    });
</script>
<script type="text/javascript" src="<?php echo base_url() ?>js/fabric.js"></script>