<div id="proformainvoice_product_toolbar" style="padding-bottom: 0;">
    <form id="proformainvoice_product_search_form" onsubmit="return false" novalidate="">
        Search : 
        <input type="text" 
               size="12" 
               name="q"
               class="easyui-validatebox" 
               onkeypress="if (event.keyCode === 13) {
                           proformainvoice_product_search();
                       }"
               />
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="proformainvoice_product_search()">Find</a>

        <?php
        if (in_array("Add", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" id='proformainvoice_product_add' onclick="proformainvoice_product_add()">Add</a>
            <?php
        }if (in_array("Edit", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" id="proformainvoice_product_edit" onclick="proformainvoice_product_edit()">Edit</a>
            <?php
        }if (in_array("Delete", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" id='proformainvoice_product_delete' onclick="proformainvoice_product_delete()">Delete</a>
            <?php
        }
        ?>
    </form>
</div>
<table id="proformainvoice_product" data-options="
       url:'<?php echo site_url('proformainvoice/product_get') ?>',
       method:'post',
       border:false,
       singleSelect:true,
       fit:true,
       rownumbers:true,
       fitColumns:false,
       pagination:true,
       autoRowHeight:false,
       striped:true,
       showFooter: true,
       nowrap:false,
       idField:'id',
       toolbar:'#proformainvoice_product_toolbar'">
    <thead>
        <tr>
            <th field="source" width="50" align="center" rowspan="2" formatter="piStockSourceFormat" data-options="styler:function(value,row,index){if(row.product_allocation_type==='2'){ return 'background-color:#3d9a2a;'}else if(row.product_allocation_type==='3'){return 'background-color:#e7e24c;'}}">Source<br>Stock</th>
            <th field="product_image" width="50" align="center" rowspan="2" formatter="piProductImageLoad">Image</th>
            <th field="product_code" width="100" halign="center" rowspan="2">Product ID</th>
            <th field="product_name" width="120" halign="center" rowspan="2">Product Name</th>
            <th halign="center" colspan="3">Dimension (mm)</th>
            <th field="volume" width="50" align="center" rowspan="2">Volume<br/>(m3)</th>
            <th field="material" width="90" halign="center" rowspan="2">Material</th>
            <th field="fabric_code" width="90" halign="center" rowspan="2">Fabric</th>
            <th field="color" width="90" halign="center" rowspan="2">Color</th>
            <th field="qty" width="30" align="center" rowspan="2">Qty</th>
            <th field="price" width="90" halign="center" align="right" rowspan="2" formatter="formatPrice">Unit Price</th>
            <th field="discount" width="30" align="center" rowspan="2">Disc<br/>(%)</th>
            <th field="net_factory" width="90" halign="center" align="right" rowspan="2" formatter="formatPrice">Net<br/>Factory</th>
            <th field="line_total" width="90" halign="center" align="right" rowspan="2" formatter="formatPrice">Line<br/>Total</th>
            <th field="category" width="150" rowspan="2" halign="center" formatter="piCategoryFormat">Category</th>
            <th field="notes" width="150" rowspan="2" halign="center">Notes</th>
            <th field="special_instruction" width="300" rowspan="2" halign="center">Special Instruction</th>
        </tr>
        <tr>
            <th field="width" width="40" align="center">W</th>
            <th field="depth" width="40" align="center">D</th>
            <th field="height" width="40" align="center">H</th>
        </tr>
    </thead>
</table>
<script>

    $(function () {
        $('#proformainvoice_product').datagrid({
            rowStyler: function (index, row) {
//                console.log(row.stock_set + '@' + row.qty);
                if (row.product_allocation_type === '2' || row.product_allocation_type === '3') {
                    if (row.stock_set !== row.qty) {
                        return 'background-color:#ffcece;';
                    }
                }
            },
            view: detailview,
            detailFormatter: function (index, row) {
                return '<div style="padding:2px"><table class="pi_ddv" id="sub_grid' + row.id + '"></table></div>';
            },
            onExpandRow: function (index, row_pi) {
                var pi_ddv = $(this).datagrid('getRowDetail', index).find('table.pi_ddv');
                pi_ddv.datagrid({
                    url: base_url + 'proformainvoice/product_component_get/' + row_pi.id,
                    title: 'Product Component',
                    fitColumns: true,
                    singleSelect: true,
                    rownumbers: true,
                    width: 900,
                    height: 'auto',
                    columns: [[
                            {field: 'component_type', title: 'Component Type', halign: 'center', width: 200},
                            {field: 'width', title: 'Width', width: 50, align: 'center', formatter: function (value, row, index) {
                                    if (value !== '0') {
                                        return value;
                                    }
                                }},
                            {field: 'depth', title: 'Depth', width: 50, align: 'center', formatter: function (value, row, index) {
                                    if (value !== '0') {
                                        return value;
                                    }
                                }},
                            {field: 'height', title: 'Height', width: 50, align: 'center', formatter: function (value, row, index) {
                                    if (value !== '0') {
                                        return value;
                                    }
                                }},
                            {field: 'qty', title: 'Qty Required', width: 100, align: 'center', formatter: PI_Product_Component_Format_qty},
                            {field: 'remark', title: 'Remark', width: 100, halign: 'center'},
                            {field: 'action', title: 'Action', width: 50, halign: 'center',
                                formatter: function (val, row, index) {
                                    return '<a href="javascript:proformainvoice_product_component_delete(' + row.id + ',' + row_pi.id + ')" style="cursor:pointer">Delete</a>';
                                }
                            }
                        ]],
                    onResize: function () {
                        $('#proformainvoice_product').datagrid('fixDetailRowHeight', index);
                    },
                    onLoadSuccess: function () {
                        setTimeout(function () {
                            $('#proformainvoice_product').datagrid('fixDetailRowHeight', index);
                        }, 0);
                    }
                });
                $('#proformainvoice_product').datagrid('fixDetailRowHeight', index);
            }
        });
    });

    function PI_Product_Component_Format_qty(value, row) {
        var temp = '';
        if (row.component_type_id !== '1' && row.component_type_id !== '2' && row.component_type_id !== '3') {
            temp = value;
            if (row.uom !== null) {
                temp = temp + ' / ' + row.uom;
            }
        }
        return temp;

    }

    function piStockSourceFormat(value, row) {
        //console.log(row.product_allocation_type);
        if (row.product_allocation_type === "2" || row.product_allocation_type === "3") {
            var temp = '<button style="width:30px;height:15px;cursor:pointer;line-height: 0;" onclick="pi_product_source(' + row.id + ',' + row.products_id + ',' + row.width + ',' + row.depth + ',' + row.height + ',' + row.product_allocation_type + ')">...</button>';
            if (row.product_allocation_type === "2") {
                temp += '<br/>Finish Stock';
            } else {
                temp += '<br/>UnFinish Stock';
            }
            return temp;
        }
    }

    function piProductImageLoad(value, row) {
        if (value !== undefined) {
            return '<img src="files/products_image/' + value + '" style="max-width:30px;max-height:40px;padding:1px;">';
        }
    }

    function piCategoryFormat(value, row) {
        if (value === '0') {
            return 'Standard';
        } else if (value === '1') {
            return 'Customize';
        }
    }
</script>
