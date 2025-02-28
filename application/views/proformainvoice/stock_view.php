<div id="pi_product_stock_list_toolbar" style="padding-bottom: 2px;">
    <form id='pi_product_stock_list_search_form' onsubmit="return false" style="margin: 0;">
        <span style="display: inline-block">
            Product 
            <input type="text" name="product_id_or_name" class="easyui-validatebox" style="width: 100px"/>
            <script>
                $("#pi_product_stock_list_search_form input[name=product_id_or_name]").keypress(function (event) {
                    if (event.which === 13) {
                        productiontracking_search()
                    }
                });
            </script>
        </span>
        <span style="display: inline-block">
            S.N
            <input type="text" name='serial_number' class="easyui-validatebox" style="width: 100px"/>
            <script>
                $("#pi_product_stock_list input[name=serial_number]").keypress(function (event) {
                    if (event.which === 13) {
                        productiontracking_search()
                    }
                });
            </script>
        </span>
        <span style="display: inline-block">
            Status
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
                   style="width: 100px"/>
            <script>
                function productionTrackingProductionProcessFormat_s(row) {
                    return '<span style="font-weight:bold;">' + row.name + '</span><br/>' +
                            '<span >Progress : ' + row.percent + ' %</span>';
                }
            </script>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="productiontracking_search()"></a>
        </span>
    </form>
</div>
<table id="pi_product_stock_list" data-options="
       url:'<?php echo site_url('stock/get') ?>',
       method:'post',
       border:true,
       singleSelect:false,
       fit:true,
       title:'Available Stock',
       pageSize:30,
       autoRowHeight:false,
       pageList: [30, 50, 70, 90, 110],
       rownumbers:true,
       fitColumns:false,
       remoteSort:true,
       multiSort:true,
       pagination:true,
       nowrap:false,
       toolbar:'#pi_product_stock_list_toolbar'">
    <thead>
        <tr>
            <th field="pi_chck_88" checkbox='true'></th>
            <th field="product_image" width="60" align="center" formatter="pi_product_stock_image_load">Image</th>
            <th field="product_code" width="200" halign="center" formatter="pi_product_stock_detail_product">Product Detail</th>
            <th field="po_no" width="160" halign="center" formatter="pi_product_stock_po_detail">P.O History</th>
            <th field="production_process_name" width="120" halign="center">Progress Status</th>
        </tr>
    </thead>
</table>
<script type="text/javascript">
    $(function () {
        $('#pi_product_stock_list').datagrid({
            onBeforeLoad: function (param) {
                param.product_id = <?php echo $product_id ?>;        // add the parameter code and addr
                param.width = <?php echo $width ?>;
                param.depth = <?php echo $depth ?>;
                param.height = <?php echo $height ?>;
                param.filter_allocated = 'true';
            }
        });
    });
    function pi_product_stock_image_load(value, row) {
        return '<img src="files/products_image/' + value + '" style="max-width:50px;max-height:60px;padding:2px;">';
    }

    function pi_product_stock_detail_product(value, row) {

        var temp = 'SN : ' + row.serial_number + '<br/>' +
                'ID : ' + row.product_code + '<br/>' +
                'Name: ' + row.product_name + '<br/>' +
                'Dimension : ' + row.width + ' x ' + row.depth + ' x ' + row.height + ' <b>(' + row.volume + ')</b><br>' +
                'Material : ' + row.material + '<br/>' +
                'Fabric : ' + ((row.fabric_code !== null) ? row.fabric_code : "") + '<br/>' +
                'Color : ' + ((row.color !== null) ? row.color : "");
        return temp;
    }

    function pi_product_stock_po_detail(value, row) {
        var temp = 'P.O No : ' + row.po_no + '<br/>' +
                'P.O Date: ' + row.po_date + '<br/>' +
                'Vendor : ' + row.vendor_name;
        return temp;
    }
</script>

