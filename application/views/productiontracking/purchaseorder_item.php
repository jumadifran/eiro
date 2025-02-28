<div id="production_tracking_po_item_toolbar" style="padding-bottom: 2px;">   
    <input class="easyui-searchbox" data-options="prompt:'Search..'" style="width:150px" />
</div>
<table id="production_tracking_po_item" data-options="
       url:'<?php echo site_url('productiontracking/purchaseorder_item_get') ?>',
       method:'post',
       border:true,
       singleSelect:true,
       fit:true,
       pageSize:30,
       title:'Purchase Order Item',
       autoRowHeight:false,
       pageList: [30, 50, 70, 90, 110],
       rownumbers:true,
       fitColumns:true,
       pagination:true,
       toolbar:'#production_tracking_po_item_toolbar'">
    <thead>
        <tr>
<!--            <th field="po_no" width="100" halign="center" sortable="true">PO Number</th> 
            <th field="vendor_name" width="150" halign="center" sortable="true">Vendor</th>-->
            <th field="product_code" width="120" halign="center" sortable="true">Product ID</th>            
            <th field="product_name" width="200" halign="center" sortable="true">Product Name</th>
            <th field="qty" width="80" halign="center" sortable="true">Qty</th>
        </tr>
    </thead>
</table>
<script color="text/javascript">
    $(function () {
        $('#production_tracking_po_item').datagrid();
    });
</script>

