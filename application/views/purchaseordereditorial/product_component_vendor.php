<div id="po_editorial_product_component_vendor_toolbar" style="padding-bottom: 2px;">   
    <?php
    if (in_array("Add", $action)) {
        ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" id='po_editorial_component_vendor_edit_price' onclick="po_editorial_component_vendor_edit_price()">Edit</a>
        <?php
    }if (in_array("Delete", $action)) {
        ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" id='po_editorial_component_vendor_delete' onclick="po_editorial_component_vendor_delete()">Delete</a>
        <?php
    }
    ?>
</div>
<table id="po_editorial_product_component_vendor" data-options="
       url:'<?php echo site_url('purchaseordereditorial/product_component_vendor_get') ?>',
       method:'post',
       border:false,
       singleSelect:true,
       fit:true,
       rownumbers:true,
       fitColumns:false,
       striped:true,
       toolbar:'#po_editorial_product_component_vendor_toolbar'">
    <thead>
        <tr>
            <th field="id" hidden="true"></th>
            <th field="component_type_name" width="100" halign="center">Type</th>            
            <th field="vendor_item_code" width="150" halign="center">Vendor Item Code</th>
            <th field="qty" width="50" align="center">Qty</th>
            <th field="uom" width="50" align="center">Uom</th>
            <th field="price" width="130" halign="center" align="right" formatter="po_editorial_product_component_fenrdor_format_price">Price</th>
            <th field="vendor_name" width="200" halign="center"  data-options="formatter:function(value,row,index){if(value !== '0'){return row.vendor_name+' <b>('+row.vendor_code+')</b>';}}">Vendor</th>
        </tr>
    </thead>
</table>
<script>
    function po_editorial_product_component_fenrdor_format_price(value, row) {
        if (value !== null && row.currency_code !== null) {
            var x = '' + value;
            var parts = x.toString().split(".");
            return  row.currency_code + ' ' + parts[0].replace(/\B(?=(\d{3})+(?=$))/g, ",") + (parts[1] ? "." + parts[1] : ".00");
        } else {
            return "";
        }
    }
    $(function () {
        $('#po_editorial_product_component_vendor').datagrid();
    });
</script>

