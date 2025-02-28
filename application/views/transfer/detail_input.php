<div id="transfer_detail_product_available_toolbar" style="padding-bottom: 2px;">
    <form id='transfer_detail_product_available_search_form' onsubmit="return false" style="margin: 0;">
        <span style="display: inline-block">
            Product 
            <input type="text" name="product_id_or_name" class="easyui-validatebox" style="width: 100px"/>
            <script>
                $("#transfer_detail_product_available_search_form input[name=product_id_or_name]").keypress(function (event) {
                    if (event.which === 13) {
                        $('#transfer_detail_product_available').datagrid('reload', $('#transfer_detail_product_available_search_form').serializeObject());
                    }
                });
            </script>
        </span>
        <span style="display: inline-block">
            S.N
            <input type="text" name='serial_number' class="easyui-validatebox" style="width: 100px"/>
            <script>
                $("#transfer_detail_product_available input[name=serial_number]").keypress(function (event) {
                    if (event.which === 13) {
                        $('#transfer_detail_product_available').datagrid('reload', $('#transfer_detail_product_available_search_form').serializeObject());
                    }
                });
            </script>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="$('#transfer_detail_product_available').datagrid('reload', $('#transfer_detail_product_available_search_form').serializeObject());"></a>
        </span>
    </form>
</div>
<table id="transfer_detail_product_available" data-options="
       url:'<?php echo site_url('stock/get') ?>',
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
       toolbar:'#transfer_detail_product_available_toolbar'">
    <thead>
        <tr>
            <th field="pi_chck_88" checkbox='true'></th>
            <th field="product_image" width="60" align="center" formatter="transfer_detail_product_available_image_load">Image</th>
            <th field="product_code" width="200" halign="center" formatter="transfer_detail_product_available_detail_product">Product Detail</th>
            <th field="material" width="100" halign="center">Material</th>
            <th field="fabric_code" width="100" halign="center">Fabric</th>
            <th field="color" width="100" halign="center">Color</th>
            <th field="po_no" width="200" halign="center" formatter="transfer_detail_product_available_po_detail">History P.O</th>
        </tr>
    </thead>
</table>
<script type="text/javascript">
    $(function () {
        $('#transfer_detail_product_available').datagrid({
            onBeforeLoad: function (param) {
                param.wareouse_storeid = <?php echo $source_id ?>;
            }
        });
    });
    function transfer_detail_product_available_image_load(value, row) {
        return '<img src="files/products_image/' + value + '" style="max-width:50px;max-height:60px;padding:1px;">';
    }

    function transfer_detail_product_available_detail_product(value, row) {
        return 'SN : ' + row.serial_number + '<br/>' +
                'ID : ' + row.product_code + ' <b>' + row.component_type_name + '</b><br/>' +
                'Name: ' + row.product_name + '<br/>' +
                'Dimension : ' + row.width + ' x ' + row.depth + ' x ' + row.height + ' <b>(' + row.volume + ')</b><br>';
    }

    function transfer_detail_product_available_po_detail(value, row) {
        return '<b>' + row.po_no + '</b>, ' + row.vendor_name + '<br/>' + 'Date: ' + myFormatDate(row.po_date, null) + '<br/>';
    }
</script>

