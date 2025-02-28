<form id="invoice_input_form" method="post" novalidate class="table_form">
    <table width="100%" border="0" class="table-no-border">
        <tr>
            <td style="width: 50%">
                <table style="width: 100%" cellpadding='0' cellspacing='0'>
                    <tr>
                        <td><strong>Statement Date</strong></td>
                        <td>
                            <input name="date" class="easyui-datebox" style="width: 50%;" required="true"  data-options="formatter:myformatter,parser:myparser">
                        </td>
                    </tr>
                    <tr>
                        <td width="25%"><strong>Order ID</strong></td>
                        <td width="75%">
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
                                        $('#invoice_contact_name').textbox('setValue', row.client_contact_name);
                                        $('#invoice_po_no').textbox('setValue', row.order_id);
                                        $('#invoice_bank_account_id').combobox('setValue', row.bank_account_id);
                                        $('#invoice_down_payment').numberbox('setValue', 100);
                                        $('#invoice_order_amount').numberbox('setValue', row.total);
                                        $('#invoice_amount').numberbox('setValue', row.total);
                                        $('#invoice_amount_due').numberbox('setValue', row.total);
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
                </table>
            </td>
            <td style="width: 50%">
                &nbsp;
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div style="margin: 15px 0;"><strong>Invoice Reference : </strong></div>
                <table style="width: 100%" class="table-border">
                    <tr>
                        <td width='50%' align='center'>Invoice Description</td>
                        <td width='20%' align='center'>Order Amount</td>
                        <td width='5%' align='center'>%</td>
                        <td width='25%' align='center'>Invoice Amount</td>
                    </tr>
                    <tr>
                        <td><input class="easyui-textbox" required="true" name="description" style="width: 100%"></td>
                        <td><input class="easyui-numberbox" precision='2' name="order_amount" id='invoice_order_amount' groupSeparator=',' decimalSeparator='.' style="width: 100%" required="true"/></td>
                        <td><input class="easyui-numberbox" max="100" maxlength="3" name="down_payment" style="width: 100%" id='invoice_down_payment'/></td>
                        <td><input class="easyui-numberbox" precision='2' groupSeparator=',' name="amount" decimalSeparator='.' id='invoice_amount' style="width: 100%" required="true"/></td>
                    </tr>
                </table>

                <table style="width: 100%" class="table-no-border">
                    <tr>
                        <td width='50%' align='center'>&nbsp;</td>
                        <td width='20%' align='right'><strong>PPn / Tax (10%)</strong></td>
                        <td width='5%' align='center'>
                            <input type="checkbox" name="ppn_flag" id="invoice_input_form_ppn_flag" onclick="invoice_calculate()"/>
                        </td>
                        <td width='25%' align='center'><input class="easyui-numberbox" id="invoice_tax" name="tax" precision='2' readonly="true" groupSeparator=',' decimalSeparator='.' style="width: 100%"/></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td colspan="2" align='right' style="padding-right: 10px;"><strong>Amount Due </strong></td>
                        <td><input class="easyui-numberbox" id="invoice_amount_due" name="amount_due" precision='2' groupSeparator=',' decimalSeparator='.' style="width: 100%" /></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
</form>
<script>
    $(document).ready(function () {
//        $('#invoice_amount_due').numberbox('textbox').css('text-align', 'right');
//        $('#invoice_amount').numberbox('textbox').css('text-align', 'right');
//        $('#invoice_down_payment').numberbox('textbox').css('text-align', 'right');
//        $('#invoice_order_amount').numberbox('textbox').css('text-align', 'right');
    });

    function invoice_calculate() {
        var invoice_amount_due = parseFloat($('#invoice_amount').numberbox('getValue'));
        $('#invoice_tax').numberbox('setValue', 0);
        if ($('#invoice_input_form_ppn_flag').is(':checked')) {
            $('#invoice_tax').numberbox('setValue', (invoice_amount_due * 0.1));
            invoice_amount_due = invoice_amount_due + (invoice_amount_due * 0.1);
        }
        $('#invoice_amount_due').numberbox('setValue', invoice_amount_due);
    }
</script>