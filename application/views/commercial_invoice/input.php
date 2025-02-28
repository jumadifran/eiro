<form id="commercial_invoice_form" method="post" novalidate class="table_form">
    <table width="100%" border="0">
        <tr>
            <td><strong>Invoice Date</strong></td>
            <td><input name="order_invoice_date" class="easyui-datebox" style="width: 50%;" required="true" data-options="formatter:myformatter,parser:myparser"></td>
        </tr>
        <tr>
            <td width="25%"><strong>Order ID</strong></td>
            <td width="75%">
                <input name='pi_id' id="po_editorial_pi_1" required="true" style="width: 100%"/>
                <script type="text/javascript">
                    $('#po_editorial_pi_1').combogrid({
                        panelWidth: 600,
                        idField: 'id',
                        fitColumns: true,
                        textField: 'order_id',
                        url: '<?php echo site_url('proformainvoice/get/open') ?>',
                        columns: [[
                                {field: 'order_id', title: 'Order ID', halign: 'center', width: 100},
                                {field: 'order_confirm_date', title: 'Confirm Date', align: 'center', width: 100, formatter: myFormatDate},
                                {field: 'client_name', title: 'Client Name', halign: 'center', width: 160, formatter: function (v, r) {
                                        return '<b>' + v + '</b> - ' + r.client_name;
                                    }},
                                {field: 'client_company_name', title: 'Client Company Name', halign: 'center', width: 200},
                                {field: 'client_contact_name', title: 'Client Contact Name', halign: 'center', width: 200}
                            ]],
                        onSelect: function (index, row) {
                            if (row.dp_count === '0' && row.down_payment !== '0') {
                                $('#ci_payment_type').combobox('setValue', 'Down Payment');
                                $('#ci_payment_type').combobox('readonly');
                                $('#ci_total').numberbox('setValue', row.total);
                                $('#ci_amount').numberbox('setValue', row.down_payment_nominal);
                                $('#ci_percent_amount').numberbox('setValue', row.down_payment);
                                $('#ci_vat_percent').numberbox('setValue', row.vat);
                                var vat_nominal = (parseFloat(row.down_payment_nominal) * parseFloat(row.vat)) / 100;
                                $('#ci_vat_nominal').numberbox('setValue', vat_nominal);
                                var total_amount = vat_nominal + parseFloat(row.down_payment_nominal);
                                $('#ci_total_amount').numberbox('setValue', total_amount);
                            } else {
                                $('#ci_payment_type').combobox('readonly', false);
                                $('#ci_payment_type').combobox('reload', base_url + 'commercial_invoice/reload_type/1');
                                $('#ci_payment_type').combobox('clear');
                                $('#ci_amount').numberbox('clear');
                                $('#ci_percent_amount').numberbox('clear');
                                $('#ci_vat_percent').numberbox('setValue', row.vat);
                            }
                        }
                    });
                </script>
            </td>
        </tr>
        <tr>
            <td><strong>Type</strong></td>
            <td>
                <input class="easyui-combobox" id="ci_payment_type" name="payment_type" panelHeight="auto"
                       data-options="valueField:'id',textField:'text',url:base_url+'commercial_invoice/reload_type',method:'get'" style="width: 50%">
            </td>
        </tr>
        <tr>
            <td><strong>Reference</strong></td>
            <td>
                <textarea name="reference" style="width: 99%;height: 40px;"></textarea>
            </td>
        </tr>
        <tr>
            <td><strong>Total Price</strong></td>
            <td><input type="text" name="total" readonly="readonly" id="ci_total" class="easyui-numberbox" groupSeparator=',' decimalSeparator='.' style="width: 100%;"/></td>
        </tr>
        <tr>
            <td><strong>Amount</strong></td>
            <td><input name="percent" id="ci_percent_amount" class="easyui-numberbox" style="width:20%"/><strong>% = </strong><input type="text" name="amount" id="ci_amount" class="easyui-numberbox" groupSeparator=',' decimalSeparator='.' style="width: 70%;"/></td>
        </tr>
        <tr>
            <td><strong>Vat / PPn</strong></td>
            <td><input name="vat_percent" id="ci_vat_percent" class="easyui-numberbox" style="width:20%"/><strong>% =</strong> <input type="text" name="vat_nominal" id="ci_vat_nominal" class="easyui-numberbox" groupSeparator=',' decimalSeparator='.' style="width: 70%;"/></td>
        </tr>
        <tr>
            <td><strong>Total Invoice</strong></td>
            <td><input type="text" name="total_amount" id="ci_total_amount" class="easyui-numberbox" groupSeparator=',' decimalSeparator='.' style="width: 100%;"/></td>
        </tr>
    </table>        
</form>