<div id="production_tracking_po_toolbar" style="padding-bottom: 2px;">   
    <input class="easyui-searchbox" data-options="prompt:'Search..'" style="width:150px" />
</div>
<table id="production_tracking_po" data-options="
       url:'<?php echo site_url('productiontracking/purchaseorder_get') ?>',
       method:'post',
       border:true,
       singleSelect:true,
       title:'Purchase Order',
       fit:true,
       pageSize:30,
       autoRowHeight:false,
       pageList: [30, 50, 70, 90, 110],
       rownumbers:true,
       fitColumns:false,
       remoteSort:true,
       multiSort:true,
       pagination:true,
       toolbar:'#production_tracking_po_toolbar'">
    <thead>
        <tr>
            <th field="po_no" width="30%" halign="center" sortable="true">PO Number</th>            
            <th field="date" width="20%" halign="center" sortable="true">Date</th>
            <th field="vendor_name" width="50%" halign="center" sortable="true">Vendor</th>
        </tr>
    </thead>
</table>
<script color="text/javascript">
    $(function () {
        $('#production_tracking_po').datagrid();
    });
</script>

