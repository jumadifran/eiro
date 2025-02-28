<div id="invoice_toolbar" style="padding-bottom: 2px;">
    <form id="invoice_search_form" onsubmit="return false" style="margin: 0">
        Search :
        <input type="text" size="20" class="easyui-validatebox" name="q" onkeypress="if (event.keyCode === 13) {
                    invoice_search();

                }"/>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" iconCls="icon-search" plain="true" onclick="invoice_search()">Find</a>
        <?php
        if (in_array("Add", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="invoice_add('dp')"> Add</a>
            <!--            <a href="#" class="easyui-menubutton" iconCls='icon-add' menu="#invoice_menu_list"> Add</a>
                        <div id="invoice_menu_list" style="width:150px;">
                            <div iconCls='icon-add' onclick="invoice_add('dp')">Down Payment</div>
                            <div iconCls='icon-add' onclick="invoice_add('sp')">Settlement Payment </div>
                            <div iconCls='icon-add' onclick="invoice_add('fp')">Full Payment</div>
                        </div>-->
            <?php
        }if (in_array("Edit", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="invoice_edit()"> Edit</a>
            <?php
        }if (in_array("Delete", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="invoice_delete()"> Delete</a>
            <?php
        }
        ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="invoice_print()"> Print</a>
    </form>
</div>
<table id="invoice" data-options="
       url:'<?php echo site_url('invoice/get') ?>',
       method:'post',
       border:true,
       singleSelect:true,
       fit:true,
       title:'Invoice',
       pageSize:30,
       pageList: [30, 50, 70, 90, 110],
       rownumbers:true,
       fitColumns:false,
       remoteSort:true,
       multiSort:true,
       pagination:true,
       toolbar:'#invoice_toolbar'">
    <thead>
        <tr>
            <th field="transaction_number" width="120" halign="center">Invoice No.</th>
            <th field="type" width="100" align="center">Type</th>
            <th field="date" width="100" align="center" formatter="myFormatDate">Date</th>
            <th field="po_no" width="90" halign="center">PO No#</th>
            <th field="client_name" width="200" halign="center">Client</th>
            <th field="contact_name" width="150" halign="center">Contact Name</th>
            <th field="currency_code" width="80" align="center">Currency</th>
            <th field="amount" width="140" halign="center" align="right" formatter="formatPrice">Invoice Amount</th>
            <th field="tax" width="140" halign="center" align="right" formatter="formatPrice">Vat/PPn</th>
            <th field="amount_due" width="140" halign="center" align="right" formatter="formatPrice">Total Invoice</th>
            <th field="remark" width="300" halign="center">Remark</th>
        </tr>
    </thead>
</table>
<script invoice="text/javascript">
    $(function () {
        $('#invoice').datagrid();
    });
</script>
<script type="text/javascript" src="<?php echo base_url() ?>js/invoice.js"></script>

