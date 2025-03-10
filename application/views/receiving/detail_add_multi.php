<div id="receive_detail_product_available_toolbar" style="padding-bottom: 2px;">
    <form id='receive_detail_product_available_search_form' onsubmit="return false" style="margin: 0;">
        <span style="display: inline-block">
            Product 
            <input type="text" name="product_id_or_name" class="easyui-validatebox" style="width: 100px"/>
            <script>
                $("#receive_detail_product_available_search_form input[name=product_id_or_name]").keypress(function (event) {
                    if (event.which === 13) {
                        $('#receive_detail_product_available').datagrid('reload', $('#receive_detail_product_available_search_form').serializeObject());
                    }
                });
            </script>
        </span>
        <span style="display: inline-block">
            S.N
            <input type="text" name='serial_number' class="easyui-validatebox" style="width: 100px"/>
            <script>
                $("#receive_detail_product_available input[name=serial_number]").keypress(function (event) {
                    if (event.which === 13) {
                        $('#receive_detail_product_available').datagrid('reload', $('#receive_detail_product_available_search_form').serializeObject());
                    }
                });
            </script>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="$('#receive_detail_product_available').datagrid('reload', $('#receive_detail_product_available_search_form').serializeObject());"></a>
        </span>
    </form>
</div>
<table id="receive_detail_product_available" data-options="
       url:'<?php echo site_url('purchaseorder/product_get_available_to_receive/' . $vendor_id) ?>',
       method:'post',
       border:false,
       singleSelect:false,
       fit:true,
       autoRowHeight:false,
       rownumbers:true,
       fitColumns:false,
       remoteSort:true,
       multiSort:true,
       pagination:true,
       nowrap:false,
       toolbar:'#receive_detail_product_available_toolbar'">
    <thead>
        <tr>
            <th field="pi_chck_88" checkbox='true'></th>
            <th field="product_image" width="60" align="center" formatter="receive_detail_product_available_image_load">Image</th>
            <th field="product_code" width="200" halign="center" formatter="receive_detail_product_available_detail_product">Product Detail</th>
            <th field="po_no" width="160" halign="center" formatter="receive_detail_product_available_po_detail">History P.O</th>
            <th field="production_process_name" width="120" halign="center">Progress Status</th>
        </tr>
    </thead>
</table>
<script type="text/javascript">
    $(function () {
        $('#receive_detail_product_available').datagrid({
        });
    });
    function receive_detail_product_available_image_load(value, row) {
        return '<img src="files/products_image/' + value + '" style="max-width:50px;max-height:60px;padding:2px;">';
    }

    function receive_detail_product_available_detail_product(value, row) {

        var temp = 'SN : ' + row.serial_number + '<br/>' +
                'ID : ' + row.product_code + ' <b>' + row.component_type_name + '</b><br/>' +
                'Name: ' + row.product_name + '<br/>' +
                'Dimension : ' + row.width + ' x ' + row.depth + ' x ' + row.height + ' <b>(' + row.volume + ')</b><br>' +
                'Material : ' + row.material + '<br/>' +
                'Fabric : ' + ((row.fabric_code !== null) ? row.fabric_code : "") + '<br/>' +
                'Color : ' + ((row.color !== null) ? row.color : "");
        return temp;
    }

    function receive_detail_product_available_po_detail(value, row) {
        return '<b>' + row.po_no + '</b>, ' + row.vendor_name + '<br/>' + 'Date: ' + row.po_date + '<br/>';
    }
</script>

