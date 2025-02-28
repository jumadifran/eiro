<div id="po_editorial_vendor_item_toolbar" style="padding-bottom: 2px;">   
    Search: 
    <input type="text" 
           size="20" 
           class="easyui-validatebox" 
           name="code_name"
           onkeypress="if (event.keyCode === 13) {
                       po_editorial_vendor_item_search();
                   }" />
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="po_editorial_vendor_item_search()">Find</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" id='po_editorial_component_vendor_edit_price' onclick="po_editorial_component_vendor_edit_price2()">Edit</a>
</div>
<table id="po_editorial_vendor_item" data-options="
       url:'<?php echo site_url('purchaseordereditorial/vendor_item_get') ?>',
       fit:true,
       method:'post',
       border:false,
       singleSelect:true,
       rownumbers:true,
       fitColumns:false,
       striped:true,
       idField:'id',
       toolbar:'#po_editorial_vendor_item_toolbar'">
    <thead>
        <tr>
            <th field="component_type_name" width="60" halign="center">Type</th>
            <th field="item_code" width="100" halign="center">Product ID</th>
            <th field="item_description" width="150" halign="center">Product Name</th>
            <th field="vendor_item_code" width="150" halign="center">Vendor Code</th>
            <th field="width" width="30" align="center">W</th>
            <th field="depth" width="30" align="center">D</th>
            <th field="height" width="30" align="center">H</th>
            <th field="volume" width="50" align="center">Vol (m3)</th>
            <th field="material" width="90" halign="center">Material</th>
            <th field="fabric" width="90" halign="center">Fabric</th>
            <th field="color" width="90" halign="center">Color</th>
            <th field="qty" width="30" align="center">Qty</th>
            <th field="price" width="130" halign="center" align="right" formatter="formatPrice">Price</th>
            <th field="discount" width="50" align="center">Disc (%)</th>
            <th field="notes" width="150" >Notes</th>
        </tr>
    </thead>
</table>
<script po_editorial_vendor_item="text/javascript">
    $(function () {
        $('#po_editorial_vendor_item').datagrid();
    });
</script>
