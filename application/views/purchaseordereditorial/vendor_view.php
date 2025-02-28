<div id="po_editorial_vendor_toolbar" style="padding-bottom: 2px;">   
    <form id="po_editorial_vendor_search_form" onsubmit="return false;" novalidate="">
        Search: 
        <input type="text" 
               size="20" 
               class="easyui-validatebox" 
               name="q"
               onkeypress="if (event.keyCode === 13) {
                           purchaseordereditorial_vendor_search();
                       }" />
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="purchaseordereditorial_vendor_search()">Find</a>
        <?php
        if (in_array("Add", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" id='purchaseordereditorial_vendor_edit' onclick="purchaseordereditorial_vendor_edit()">Edit</a>
            <?php
        }
        ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-refresh" plain="true" onclick="$('#po_editorial_vendor').datagrid('reload')">Refresh</a>
    </form>
</div>
<table id="po_editorial_vendor" data-options="
       url:'<?php echo site_url('purchaseordereditorial/vendor_get') ?>',
       method:'post',
       border:true,
       singleSelect:true,
       fit:true,
       rownumbers:true,
       pagination:false,
       fitColoum:true,
       striped:true,
       toolbar:'#po_editorial_vendor_toolbar'">
    <thead>
        <tr>
            <th field="id" hidden="true"></th>
            <th field="vendor_name" width="200" halign="center">Vendor</th>
            <th field="target_ship_date" width="100" align="center" formatter="myFormatDate">Target Ship Date</th>
            <th field="vat" width="60" align="center">Vat(%)</th>
            <th field="down_payment" width="120" halign="center" align="right" formatter="po_plan_payment_format">Down Payment</th>
            <th field="currency_code" width="60" align="center">Currency</th>
            <th field="flag" width="120" halign="center" formatter="poe_cat_format_67">Category</th>
            <th field="remark" width="200" halign="center">Remark</th>
        </tr>
    </thead>
</table>
<script po_editorial_vendor="text/javascript">

    function poe_cat_format_67(value, row) {
        if (value === '1') {
            return 'Request For Sample';
        }
    }
    function po_plan_payment_format(value, row) {
        var ss = '(' + value + '%) ';
        if (row.down_payment_date !== null) {
            ss += myFormatDate(row.down_payment_date, row)
        }
        return  ss;
    }
    $(function () {
        $('#po_editorial_vendor').datagrid({
            onSelect: function (index, row) {
                $('#po_editorial_vendor_item').datagrid('reload', {
                    po_ediotrial_id: row.purchaseorderediotrial_id,
                    vendor_id: row.vendor_id,
                    currency_id: row.currency_id,
                    flag: row.flag
                });
            }
        });
    });
</script>

