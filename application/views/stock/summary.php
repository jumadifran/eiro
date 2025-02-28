<div id="stock_summary_toolbar" style="padding-bottom: 2px;">
    <form id='stock_summary_search_form' onsubmit="return false" style="margin: 0;">
        <span style="display: inline-block;padding: 2px">
            Product Id / Name : 
            <input type="text" name="product_id_or_name" class="easyui-validatebox" style="width: 120px"/>
            <script>
                $("#stock_summary_search_form input[name=product_id_or_name]").keypress(function (event) {
                    if (event.which === 13) {
                        stock_summary_search()
                    }
                });
            </script>
        </span>
        <span style="display: inline-block;padding: 2px">
            Dimension (WxDxH) : 
            <input type="text" name="width" class="easyui-numberbox" style="width: 40px"/>x
            <script>
                $("#stock_summary_search_form input[name=width]").keypress(function (event) {
                    if (event.which === 13) {
                        stock_summary_search();
                    }
                });
            </script>
            <input type="text" name="depth" class="easyui-numberbox" style="width: 40px"/>x
            <script>
                $("#stock_summary_search_form input[name=depth]").keypress(function (event) {
                    if (event.which === 13) {
                        stock_summary_search();
                    }
                });
            </script>
            <input type="text" name="height" class="easyui-numberbox" style="width: 40px"/>
            <script>
                $("#stock_summary_search_form input[name=height]").keypress(function (event) {
                    if (event.which === 13) {
                        stock_summary_search();
                    }
                });
            </script>
        </span>
        <span>Status :
            <select name="component_type_id" class="easyui-combobox" style="width: 100px;" panelHeight='auto' data-options='onSelect:function(rec){
                    stock_summary_search();
                    }'>
                <option value="0">All</option>
                <?php
                foreach ($component_type as $result) {
                    echo "<option value=" . $result->id . ">" . $result->name . "</option>";
                }
                ?>
            </select>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="stock_summary_search()">Find</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-excel" plain="true" onclick="stock_summary_export_to_excel()">Export to Excel</a>
        </span>
    </form>
</div>
<table id="stock_summary" data-options="
       url:'<?php echo site_url('stock/summary_get') ?>',
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
       toolbar:'#stock_summary_toolbar'">
    <thead>
        <tr>
            <th field="product_image" width="60" align="center" rowspan="2" formatter="stockImageLoadFormat">Image</th>
            <!--<th field="serial_number" width="100" halign="center" rowspan="2">Serial Number</th>-->
            <th field="product_code" width="160" halign="center" rowspan="2" formatter='stock_summary_product_format'>Product ID</th>
            <th field="product_name" width="160" halign="center" rowspan="2">Product Name</th>
            <th halign="center" colspan="3">Dimension (mm)</th>
            <th field="volume" width="100" align="center" rowspan="2">Volume<br/>(m3)</th>
            <th field="qty" width="100" align="center" rowspan="2">Qty</th>
            <th field="total_volume" width="80" align="center" rowspan="2">Total Volume<br/>(m3)</th>
<!--            <th field="aging" width="70" align="center" rowspan="2">Aging (Days)</th>
            <th field="receive_date" width="70" align="center" rowspan="2" formatter="myFormatDate">Receive Date</th>
            <th field="material" width="160" halign="center" rowspan="2">Material</th>
            <th field="fabric_code" width="120" halign="center" rowspan="2">Fabric</th>
            <th field="color" width="120" halign="center" rowspan="2">Color</th>
            <th field="client_name" width="120" halign="center" rowspan="2">Order By</th>-->
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
        $('#stock_summary').datagrid({});
    });
    function stock_summary_product_format(value, row) {
        return value + ' - <b>' + row.component_type_name + '</b>';
    }
    function stockImageLoadFormat(value, row) {
        return '<img src="files/products_image/' + value + '" style="max-width:40px;max-height:40px;padding:2px;">';
    }
</script>


