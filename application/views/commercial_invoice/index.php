<script>
    /* global CommercialInvoice */
</script>

<div id="commercial_invoice_toolbar" style="padding-bottom: 2px;">   
    Search: 
    <input type="text" 
           size="20" 
           class="easyui-searchbox" 
           data-options="prompt:'Input Value',searcher:function(value,name)(commercial_invoice_search())"
           style="width:120px"
           name="q"
           />
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="commercial_invoice_search()">Find</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="commercial_invoice_add()">Add</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="commercial_invoice_edit()">Edit</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="commercial_invoice_delete()">Delete</a>
</div>
<table id="commercial_invoice" data-options="
       url:'<?php echo site_url('commercial_invoice/get') ?>',
       method:'post',
       border:true,
       singleSelect:true,
       title:'Commercial Invoice',
       fit:true,
       pageSize:30,
       autoRowHeight:false,
       pageList: [30, 50, 70, 90, 110],
       rownumbers:true,
       fitColumns:false,
       remoteSort:true,
       multiSort:true,
       pagination:true,
       toolbar:'#commercial_invoice_toolbar'">
    <thead>
        <tr>
            <th field="inv_no" width="100" halign="center" sortable="true">Inv No.</th>            
            <th field="date" width="80" align="center" formatter='myFormatDate'>Date</th>
            <th field="order_id" width="80" halign="center" sortable="true">P.I. No</th>
            <th field="client_name" width="150" halign="center" data-options="formatter:function(val,row){
                return '<b>' + val + '</b> - ' + row.client_company_name;
                }">Client</th>
            <!--<th field="client_contact_name" width="120" halign="center">Client Contact</th>-->
            <th field="client_po_no" width="100" halign="center">Client P.O No</th>
            <th field="payment_type" width="100" halign="center">Payment Type</th>
            <th field="reference" width="150" halign="center">Reference</th>
            <th field="amount" width="120" align="right" halign="center" data-options="formatter:function(value,row){
                return '(' + row.percent + '%) = ' + formatPrice(row.amount);
                }">Amount</th>
            <th field="vat_nominal" width="120" align="right" halign="center" data-options="formatter:function(value,row){
                return '(' + row.vat_percent + '%) = ' + formatPrice(row.vat_nominal);
                }">Vat / PPn</th>
            <th field="total_amount" width="120" halign="center" align="right" formatter="formatPrice">Total Invoice</th>
        </tr>
    </thead>
</table>
<script type="text/javascript">
    $(function () {
        $('#commercial_invoice').datagrid({
        });
    });
</script>
<script type="text/javascript" src="<?php echo base_url() ?>js/commercial_invoice.js"></script>