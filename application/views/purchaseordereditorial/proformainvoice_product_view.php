<div id="po_editorial_proformainvoice_product_toolbar" style="padding-bottom: 0;">
    <form id="po_editorial_proformainvoice_product_search_form" onsubmit="return false" novalidate="">
        Search : 
        <input type="text" 
               size="12" 
               name="q"
               class="easyui-validatebox" 
               onkeyup="if (event.keyCode === 13) {
                           po_editorial_proformainvoice_product_search();
                       }"
               />
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="po_editorial_proformainvoice_product_search()"> Search</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-refresh" plain="true" onclick="$('#po_editorial_proformainvoice_product').datagrid('reload')">Refresh</a>
    </form>
</form>
</div>
<table id="po_editorial_proformainvoice_product" data-options="
       url:'<?php echo site_url('proformainvoice/product_get') ?>',
       method:'post',
       singleSelect:true,
       title:'Product Detail',
       fit:true,
       rownumbers:true,
       fitColumns:false,
       striped:true,
       toolbar:'#po_editorial_proformainvoice_product_toolbar'">
    <thead>
        <tr>
            <th field="product_code" width="100" halign="center" rowspan="2">Product ID</th>
            <th field="product_name" width="120" halign="center" rowspan="2">Product Name</th>
            <th halign="center" colspan="3">Dimension (mm)</th>
            <th field="volume" width="60" align="center" rowspan="2">Volume<br/>(m3)</th>
            <th field="material" width="120" halign="center" rowspan="2">Material</th>
            <th field="fabric_code" width="120" halign="center" rowspan="2">Fabric</th>
            <th field="color" width="120" halign="center" rowspan="2">Color</th>
            <th field="qty" width="50" align="center" rowspan="2">Qty</th>
            <th field="category" halign="center"  width="100" rowspan="2" formatter="po_e1">Category</th>
            <th field="notes" width="200" rowspan="2">Notes</th>
        <tr>
            <th field="width" width="40" align="center">W</th>
            <th field="depth" width="40" align="center">D</th>
            <th field="height" width="40" align="center">H</th>
        </tr>
    </thead>
</table>
<script>
    $(function () {
        $('#po_editorial_proformainvoice_product').datagrid({
            onSelect: function (index, row) {
                $('#po_editorial_product_component_vendor').datagrid('reload', {
                    proformainvoice_product_id: row.id
                });
            }
        });
    });

    function po_e1(value, row) {
        if (value === '1') {
            return 'Request For Sample';
        }
    }
</script>
