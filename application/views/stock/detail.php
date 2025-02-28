<div id="stock_toolbar" style="padding-bottom: 2px;">
    <form id='stock_search_form' onsubmit="return false" style="margin: 0;">
        <span style="display: inline-block;padding: 2px;margin: 0 5px">
            Date :
            <input name="start_date" prompt="Start Date" class="easyui-datebox" style="width: 100px;" data-options="formatter:myformatter,parser:myparser"> -
            <input name="end_date" prompt="End Date" class="easyui-datebox" style="width: 100px;" data-options="formatter:myformatter,parser:myparser">
        </span>
        <span style="display: inline-block;padding: 2px;margin: 0 5px">
            Product Id / Name :
            <input type="text" name="product_id_or_name" class="easyui-validatebox" style="width: 120px"/>
            <script>
                $("#stock_search_form input[name=product_id_or_name]").keypress(function (event) {
                    if (event.which === 13) {
                        stock_search()
                    }
                });
            </script>
        </span>
        <span style="display: inline-block;padding: 2px;margin: 0 5px">
            Dimension (WxDxH) :
            <input type="text" name="width" class="easyui-numberbox" style="width: 40px"/>x
            <script>
                $("#stock_search_form input[name=width]").keypress(function (event) {
                    if (event.which === 13) {
                        stock_search();
                    }
                });
            </script>
            <input type="text" name="depth" class="easyui-numberbox" style="width: 40px"/>x
            <script>
                $("#stock_search_form input[name=depth]").keypress(function (event) {
                    if (event.which === 13) {
                        stock_search();
                    }
                });
            </script>
            <input type="text" name="height" class="easyui-numberbox" style="width: 40px"/>
            <script>
                $("#stock_search_form input[name=height]").keypress(function (event) {
                    if (event.which === 13) {
                        stock_search();
                    }
                });
            </script>
        </span>
        <span style="display: inline-block;padding: 2px">
            Material :
            <input type="text" name='material' class="easyui-validatebox" style="width: 120px"/>
            <script>
                $("#stock_search_form input[name=material]").keypress(function (event) {
                    if (event.which === 13) {
                        stock_search();
                    }
                });
            </script>
        </span>
        <span style="display: inline-block;padding: 2px;margin: 0 5px">
            Fabric :
            <input type="text" name='fabric' class="easyui-validatebox" style="width: 120px"/>
            <script>
                $("#stock_search_form input[name=fabric]").keypress(function (event) {
                    if (event.which === 13) {
                        stock_search();
                    }
                });
            </script>
        </span>
        <span style="display: inline-block;padding: 2px;margin: 0 5px">
            Color :
            <input type="text" name='color' class="easyui-validatebox" style="width: 120px"/>
            <script>
                $("#stock_search_form input[name=color]").keypress(function (event) {
                    if (event.which === 13) {
                        stock_search();
                    }
                });
            </script>
        </span>
        <span style="display: inline-block;padding: 2px;margin: 0 5px">
            Serial Number :
            <input type="text" name='serial_number' class="easyui-validatebox" style="width: 120px"/>
        </span>
        <script>
            $("#stock_search_form input[name=serial_number]").keypress(function (event) {
                if (event.which === 13) {
                    stock_search();
                }
            });
        </script>
        <span style="display: inline-block;padding: 2px;;margin: 0 5px">
            Status :
            <select name="component_type_id" class="easyui-combobox" style="width: 100px;" panelHeight='auto' data-options='onSelect:function(rec){
                    stock_search();
                    }'>
                <option value="0">All</option>
                <?php
                foreach ($component_type as $result) {
                    echo "<option value=" . $result->id . ">" . $result->name . "</option>";
                }
                ?>
            </select>
        </span>
        <span style="display: inline-block;padding: 2px;margin: 0 5px">
            Client :
            <input class="easyui-combobox"
                   id="client_id"
                   name="client_id"
                   url="<?php echo site_url('client/get') ?>"
                   method="post"
                   mode="remote"
                   valueField="id"
                   textField="name"
                   panelWidth="250"
                   data-options="formatter: Stock_Client_Format"
                   style="width: 150px"/>
            <script type="text/javascript">
                function Stock_Client_Format(row) {
                    return '<span style="font-weight:bold;">' + row.name + ' - ' + row.code + '</span><br/>' +
                            '<span style="font-weight:bold;">Company : ' + row.company + '</span><br/>' +
                            '<span style="color:#888">Address: ' + row.address + '</span>';
                }
            </script>
        </span>
        <span style="display: inline-block;padding: 2px;margin: 0 5px">
            P.O :
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
        </span>
        <span style="display: inline-block;padding: 2px;margin: 0 5px">
            Store :
            <input class="easyui-combobox" id="wareouse_storeid" name="wareouse_storeid" data-options="
                   url: '<?php echo site_url('vendor/get_internal_warehouse') ?>',
                   method: 'post',
                   valueField: 'id',
                   textField: 'name',
                   panelHeight: '200',
                   panelWidth: '200',
                   formatter: StockStoreFormat"
                   style="width: 120px"
                   mode="remote">
            <script type="text/javascript">
                function StockStoreFormat(row) {
                    return '<span style="font-weight:bold;">' + row.name + ' (' + row.code + ')</span><br/>' +
                            '<span style="color:#888">Desc: ' + row.address + '</span>';
                }
            </script>
        </span>
        <span style="display: inline-block;padding: 2px;margin: 0 5px">
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="stock_search()">Find</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-excel" plain="true" onclick="stock_export_to_excel()">Export to Excel</a>
        </span>
    </form>
</div>
<table id="stock" data-options="
       url:'<?php echo site_url('stock/get') ?>',
       method:'post',
       border:true,
       singleSelect:false,
       fit:true,
       title:'Stock Detail',
       pageSize:30,
       autoRowHeight:false,
       pageList: [30, 50, 70, 90, 110],
       rownumbers:true,
       fitColumns:false,
       remoteSort:true,
       multiSort:true,
       pagination:true,
       nowrap:false,
       toolbar:'#stock_toolbar'">
    <thead>
        <tr>
            <th field="receive_date" width="70" align="center" rowspan="2" formatter="myFormatDate">Date</th>
            <th field="product_image" width="60" align="center" rowspan="2" formatter="stockImageLoadFormat">Image</th>
            <th field="serial_number" width="100" halign="center" rowspan="2">Serial Number</th>
            <th field="product_code" width="160" halign="center" rowspan="2" formatter='stock_product_format'>Product ID</th>
            <th field="product_name" width="160" halign="center" rowspan="2">Product Name</th>
            <th halign="center" colspan="3">Dimension (mm)</th>
            <th field="volume" width="50" align="center" rowspan="2">Volume<br/>(m3)</th>
            <th field="hpp" width="90" halign="center" align="right" rowspan="2" formatter="formatPrice">HPP</th>
            <th field="aging" width="70" align="center" rowspan="2">Aging (Days)</th>
            <th field="store_location_name" width="120" halign="center" rowspan="2">Store Location</th>
            <th field="material" width="160" halign="center" rowspan="2">Material</th>
            <th field="fabric_code" width="120" halign="center" rowspan="2">Fabric</th>
            <th field="color" width="120" halign="center" rowspan="2">Color</th>
            <th field="client_name" width="120" halign="center" rowspan="2">Order By</th>
            <th field="po_no" width="200" halign="center" formatter="stock_tracking_po_detail"  rowspan="2">P.O History</th>
        </tr>
        <tr>
            <th field="width" width="40" align="center">W</th>
            <th field="depth" width="40" align="center">D</th>
            <th field="height" width="40" align="center">H</th>
        </tr>
    </thead>
</table>
<script type="text/javascript">
    $(function () {
        $('#stock').datagrid({});
    });
    function stock_product_format(value, row) {
        return value + ' - <b>' + row.component_type_name + '</b>';
    }
    function stockImageLoadFormat(value, row) {
        return '<img src="files/products_image/' + value + '" style="max-width:40px;max-height:40px;padding:2px;">';
    }

    function stock_tracking_po_detail(value, row) {
        return '<b>' + row.po_no + '</b>, ' + row.vendor_name + '<br/>' + 'Date: ' + row.po_date + '<br/>';
    }
</script>


