<div id="production_tracking_product_list_toolbar" style="padding-bottom: 2px;">
    <form id='production_tracking_product_list_search_form' onsubmit="return false" style="margin: 0;">
        Vendor
        <input class="easyui-combobox" 
               name="vendor_id" url="<?php echo site_url('vendor/get') ?>"
               textField="name" valueField="id" panelHeight="200" panelWidth="200" style="width: 120px" mode="remote" method="post"
               data-options="formatter:ProductionTrackingVendorFormat,onSelect:function(rec){productiontracking_search();}"/>
        P.O 
        <input type="text"
               style="width: 120px" 
               class="easyui-combogrid" 
               name="purchaseorderid"
               data-options="
               panelWidth:410,
               idField:'id',
               textField:'po_no',
               mode: 'remote',
               url:'<?php echo site_url('purchaseorder/get') ?>',
               columns:[[
               {field:'po_no',title:'P.O',width:120},
               {field:'date',title:'P.O Date',width:80,formatter:myFormatDate},
               {field:'vendor_name',title:'Vendor',width:220}
               ]],
               queryParams:{
               x: '1'
               },
               onSelect: function(rec){
               productiontracking_search();
               }
               "/>
        Product
        <input type="text" name="product_id_or_name" class="easyui-validatebox" style="width: 100px"/>
        <script>
            function ProductionTrackingVendorFormat(row) {
                return '<span style="font-weight:bold;">' + row.name + ' (' + row.code + ')</span><br/>' +
                        '<span style="color:#888">Desc: ' + row.address + '</span>';
            }
            $("#production_tracking_product_list_search_form input[name=product_id_or_name]").keypress(function (event) {
                if (event.which === 13) {
                    productiontracking_search()
                }
            });
        </script>
<!--        S.N
        <input type="text" name='serial_number' class="easyui-validatebox" style="width: 100px"/>
        <script>
            $("#production_tracking_product_list_search_form input[name=serial_number]").keypress(function (event) {
                if (event.which === 13) {
                    productiontracking_search()
                }
            });
        </script>-->
<!--        Progress
        <input class="easyui-combobox" 
               id="production_process_id"
               name="production_process_id"
               panelWidth='200'
               url="<?php echo site_url('productionprocess/get') ?>"
               method="post"
               mode="remote"
               valueField="id"
               textField="name"
               data-options="formatter: productionTrackingProductionProcessFormat_s,
               onSelect: function(rec){
               productiontracking_search();
               }"
               style="width: 120px"/>
        <script>
            function productionTrackingProductionProcessFormat_s(row) {
                return '<span style="font-weight:bold;">' + row.name + '</span><br/>' +
                        '<span >Progress : ' + row.percent + ' %</span>';
            }
        </script>-->
<!--        Status
        <select class="easyui-combobox" name="status" panelHeight="auto" 
                data-options="
                onSelect: function(rec){
                productiontracking_search();
                }">
            <option></option>
            <option value="finish">Ready</option>
            <option value="onprogress">On Progress</option>
        </select>-->
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="productiontracking_search()">Find</a>
        <?php
        if (in_array("Import", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-import" plain="true" onclick="productiontracking_import()">Import</a>
            <?php
        }if (in_array("Update Status", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-update-progress" plain="true" onclick="productiontracking_update_status()">Update Status</a>
            <?php
        }
        ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-excel" plain="true" onclick="productiontracking_export_to_excel()">Export to Excel</a>
        <span  style="display: inline-block;vertical-align: bottom;float: right">
            <input type="checkbox" style="vertical-align: middle"/>View All
        </span>
    </form>
</div>
<table id="production_tracking_product_list" data-options="
       url:'<?php echo site_url('productiontracking/product_list_get') ?>',
       method:'post',
       border:true,
       singleSelect:false,
       title:'Product List',
       fit:true,
       pageSize:30,
       autoRowHeight:false,
       pageList: [30, 50, 70, 90, 110],
       rownumbers:true,
       fitColumns:false,
       remoteSort:true,
       multiSort:true,
       pagination:true,
       nowrap:false,
       toolbar:'#production_tracking_product_list_toolbar'">
    <thead>
        <tr>
            <th field="chck88" checkbox='true'></th>
            <th field="product_image" width="60" align="center" formatter="product_tracking_image_load">Image</th>
            <th field="serial_number" width="100" nowrap:false align="center" data-options="formatter:function(value,row){return '<b>'+value+'</b>'}">Serial Number</th>
            <th field="product_code" width="250" nowrap:false halign="center" formatter="product_tracking_detail_product">Product Detail</th>
            <th field="po_no" width="200" halign="center" formatter="product_tracking_po_detail">P.O</th>
            <th field="target_ship_date"  halign="center"  nowrap:false align="center" formatter="myFormatDate">Delivery Target</th>
            <th field="percent_before" width="50" align="center">(% before)</th>
            <th field="date_before" width="100" align="center" formatter="myFormatDate">(Date Update Before)</th>
            <th field="production_process_percent" width="50" align="center">(%)</th>
            <th field="date" width="80" align="center" formatter="myFormatDate">Last Update</th>
            <th field="production_process_name" width="120" halign="center"  align="center">Production Status</th>
            <th field="notes" width="180" align="center">Notes</th>
        </tr>
    </thead>
</table>
<script type="text/javascript">
    $(function () {
        $('#production_tracking_product_list').datagrid();
    });
    function product_tracking_image_load(value, row) {
        return '<img src="files/products_image/' + value + '" style="max-width:40px;max-height:40px;padding:1px;">';
    }

    function product_tracking_detail_product(value, row) {
        var temp = '<b>' + row.product_code + '</b> - ' + row.product_name + '<br/>' +
                '<i>Size: </i>' + row.width + ' x ' + row.depth + ' x ' + row.height + ' <b>(' + row.volume + ')</b><br>' +
                '<i>Material</i>: ' + (row.material === null ? '-' : row.material) + '<b>, </b>' + '<i>Fabric: </i>' + (row.fabric_code === null ? '-' : row.fabric_code) + '<b>, </b>' + '<i>Color: </i>' + (row.color === null ? '-' : row.color);
        return temp;
    }

    function product_tracking_po_detail(value, row) {
        return '<b>' + row.po_no + '</b>, ' + row.vendor_name + '<br/>' + 'Date: ' + row.po_date + '<br/>';
    }
</script>

