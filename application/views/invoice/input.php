<form id="invoice_input_form" method="post" novalidate class="table_form">
    <table style="width: 100%" cellpadding='0' cellspacing='0'>

        <tr>
            <td><strong>Statement Date</strong></td>
            <td>
                <input name="date" class="easyui-datebox" style="width: 50%;" required="true"  data-options="formatter:myformatter,parser:myparser">
            </td>
        </tr>
        <tr>
            <td width="30%"><strong>Order ID</strong></td>
            <td width="70%">
                <input name='proforma_invoice_id' id="invoice_proforma_invoice_id" required="true" style="width: 100%"/>
                <script type="text/javascript">
                    $('#invoice_proforma_invoice_id').combogrid({
                        mode: 'remote',
                        panelWidth: 450,
                        idField: 'id',
                        fitColumns: true,
                        textField: 'order_id',
                        onBeforeLoad: function (param) {
                            param.page = 1;
                            param.rows = 30;
                        },
                        url: '<?php echo site_url('proformainvoice/get/open') ?>',
                        columns: [[
                                {field: 'order_id', title: 'Order ID', halign: 'center', width: 50},
                                {field: 'client_code', title: 'Client ID', halign: 'center', width: 60},
                                {field: 'order_confirm_date', title: 'Confirm Date', align: 'center', width: 78, formatter: myFormatDate},
                                {field: 'order_invoice_date', title: 'Invoice Date', align: 'center', width: 78, formatter: myFormatDate},
                                {field: 'client_shipto_code', title: 'Ship To', halign: 'center', width: 100}
                            ]],
                        onSelect: function (val, row) {
//                            console.log('row: ', row);
                            $('#invoice_contact_name').textbox('setValue', row.client_contact_name);
                            $('#invoice_po_no').textbox('setValue', row.order_id);
                            $('#invoice_bank_account_id').combobox('setValue', row.bank_account_id);
                            $('#invoice_order_amount').numberbox('setValue', row.total);
                            $('#invoice_outstanding').numberbox('setValue', row.outstanding_invoice);
                            $('#invoice_ship_to').textbox('setValue', row.client_address);
                        }
                    });
                </script>
            </td>
        </tr>
        <tr>
            <td><strong>PO Number</strong></td>
            <td><input type="text" name='po_no' id='invoice_po_no' class="easyui-textbox" style="width: 100%"/></td>
        </tr>
        <tr>
            <td><strong>Contact Name</strong></td>
            <td><input type="text" name='contact_name' id='invoice_contact_name' class="easyui-textbox" style="width: 100%"/></td>
        </tr>
        <tr>
            <td><strong>Ship To</strong></td>
            <td><input type="text" multiline='true' name='ship_to' id='invoice_ship_to' class="easyui-textbox" style="width: 100%;height: 60px;"/></td>
        </tr>
        <tr>
            <td><strong>Bill To</strong></td>
            <td>
                <input class="easyui-combobox"
                       id="invoice_bank_account_id"
                       name="bank_account_id"
                       url ="<?php echo site_url('bank_account/get') ?>"
                       method= "post"
                       valueField="id"
                       textField="account_number"
                       panelHeight= "200"
                       id="bank_account_id"
                       panelWidth="300"
                       required="true"
                       data-options="formatter:InvoiceBankAccountFormat"
                       style="width: 70%"
                       mode="remote"/>
                <script type="text/javascript">
                    function InvoiceBankAccountFormat(row) {
                        return '<span style="font-weight:bold;">Bank : ' + row.bank_code + '</span><br/>' +
                                '<span style="font-weight:bold;">Account No : ' + row.account_number + '</span><br/>' +
                                '<span style="color:#888">On behalf of : ' + row.on_behalf_of + '</span>';
                    }
                </script>
            </td>
        </tr>
        <tr>
            <td><strong>Type</strong></td>
            <td>
                <select class="easyui-combobox" required="true" style="width: 120px;" panelHeight="auto" name="type">
                    <option></option>
                    <option value="Down Payment">Down Payment</option>
                    <option value="Settlement Payment">Settlement Payment</option>
                    <option value="Full Payment">Full Payment</option>
                </select>
            </td>
        </tr>
        <tr>
            <td><strong>Order Amount</strong></td>
            <td><input class="easyui-numberbox" precision='2' name="order_amount" id='invoice_order_amount' groupSeparator=',' decimalSeparator='.' style="width: 100%;text-align: right;" required="true"/></td>
        </tr>
        <tr>
            <td><strong>Outstanding Invoice</strong></td>
            <td><input class="easyui-numberbox" precision='2' name="order_amount" id='invoice_outstanding' groupSeparator=',' decimalSeparator='.' style="width: 100%;text-align: right;" required="true"/></td>
        </tr>
        <tr>
            <td><strong>Invoice Amount</strong></td>
            <td align="right">
                <input class="easyui-numberbox" name="amount_percent" id='invoice_amount_percent' style="width: 10%"/> % =
                <input class="easyui-numberbox" precision='2' groupSeparator=',' name="amount" decimalSeparator='.' id='invoice_amount' style="width: 75%" required="true"/>
            </td>
        </tr>
        <tr>
            <td><strong>Vat / PPn</strong></td>
            <td align="right">
                <input type="checkbox" name="ppn_flag" id="invoice_input_form_ppn_flag" style="vertical-align: bottom;" onclick="invoice_calculate()"/>
                <input class="easyui-numberbox" id="invoice_tax" name="tax" precision='2' readonly="true" groupSeparator=',' decimalSeparator='.' style="width: 75%"/>
            </td>
        </tr>
        <tr>
            <td><strong>Invoice Total</strong></td>
            <td align="right">
                <a href="javascript:void(0)" class="easyui-linkbutton" onclick="invoice_calculate()"> Calculate</a>
                <input class="easyui-numberbox" id="invoice_amount_due" name="amount_due" precision='2' groupSeparator=',' decimalSeparator='.' style="width: 75%" />
            </td>
        </tr>
    </table>
</form>
<script>

</script>