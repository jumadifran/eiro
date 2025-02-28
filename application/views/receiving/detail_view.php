<div id="receiving_detail_toolbar" style="padding-bottom: 2px;">
    <form id='receiving_detail_search_form' onsubmit="return false" style="margin: 0;">
        <!--        P.O 
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
                       receiving_detail_search();
                       }
                       "/>-->
        Serial Number
        <input type="text" name='serial_number' class="easyui-validatebox" style="width: 120px"/>
        <script>
            $("#receiving_detail_search_form input[name=serial_number]").keypress(function (event) {
                if (event.which === 13) {
                    receiving_detail_search();
                }
            });
        </script>
        Product Id / Name 
        <input type="text" name="product_id_or_name" class="easyui-validatebox" style="width: 120px"/>
        <script>
            $("#receiving_detail_search_form input[name=product_id_or_name]").keypress(function (event) {
                if (event.which === 13) {
                    receiving_detail_search();
                }
            });
        </script>
        <!--        Status
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
                       receiving_detail_search();
                       }"
                       style="width: 120px"/>
                <script>
                    function productionTrackingProductionProcessFormat_s(row) {
                        return '<span style="font-weight:bold;">' + row.name + '</span><br/>' +
                                '<span >Progress : ' + row.percent + ' %</span>';
                    }
                </script>-->
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="receiving_detail_search()"></a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="receiving_detail_add_multi()">Add</a>
        <!--<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="receiving_detail_edit()">Edit</a>-->
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="receiving_detail_delete()">Delete</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-import" plain="true" onclick="receiving_detail_import()">Import</a>
    </form>
</div>
<table id="receiving_detail" data-options="
       url:'<?php echo site_url('receiving/detail_get') ?>',
       method:'post',
       border:false,
       singleSelect:false,
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
       toolbar:'#receiving_detail_toolbar'">
    <thead>
        <tr>
            <th field="chck88" checkbox='true'></th>
            <th field="product_image" width="60" align="center" formatter="receiving_detail_image_load">Image</th>
            <th field="serial_number" width="130" align="center">Serial Number</th>
            <th field="product_code" width="250" halign="center" formatter="receiving_detail_detail_product">Product Detail</th>
            <th field='material' width='150' halign='center'>Material</th>
            <th field='fabric_code' width='150' halign='center'>Fabric</th>
            <th field='color' width='150' halign='center'>Color</th>
            <th field="po_no" width="150" halign="center" formatter="receiving_detail_po_detail">P.O Detail</th>
        </tr>
    </thead>
</table>
<script type="text/javascript">
    function receiving_detail_search() {
        var data = $('#receiving_detail_search_form').serializeObject();
        $.extend(data, {receivingid: $('#receiving').datagrid('getSelected').id});
        $('#receiving_detail').datagrid('reload', data);
    }
    $(function () {
        $('#receiving_detail').datagrid();
    });
    function receiving_detail_image_load(value, row) {
        return '<img src="files/products_image/' + value + '" style="max-width:40px;max-height:40px;padding:1px;">';
    }

    function receiving_detail_detail_product(value, row) {

        var temp = 'ID : ' + row.product_code + ' - <b>' + row.comp_type_name + '</b><br/>' +
                'Name: ' + row.product_name + '<br/>' +
                'Dimension : ' + row.width + ' x ' + row.depth + ' x ' + row.height + ' <b>(' + row.volume + ')</b><br>';
        return temp;
    }

    function receiving_detail_po_detail(value, row) {
        var temp = 'No : ' + row.po_no + '<br/>' +
                'Date: ' + row.po_date + '<br/>';
        return temp;
    }
</script>

