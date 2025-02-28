<form id="po_editorial_add_form" method="post" class="table_form">
    <table width="100%" border="0">
        <tr>
            <td width="25%"><strong>Order ID</strong></td>
            <td width="75%">
                <input name='proformainvoice_id' id="po_editorial_pi_1" required="true" style="width: 100%"/>
                <script type="text/javascript">
                    $('#po_editorial_pi_1').combogrid({
                        panelWidth: 450,
                        idField: 'id',
                        fitColumns: true,
                        textField: 'order_id',
                        url: '<?php echo site_url('proformainvoice/get_available_to_create_po_editorial') ?>',
                        columns: [[
                                {field: 'order_id', title: 'Order ID',halign:'center', width: 50},
                                {field: 'client_code', title: 'Client ID',halign:'center', width: 60},
                                {field: 'order_confirm_date', title: 'Confirm Date',align:'center', width: 78, formatter: myFormatDate},
                                {field: 'order_invoice_date', title: 'Invoice Date',align:'center', width: 78, formatter: myFormatDate},
                                {field: 'client_shipto_code', title: 'Ship To',halign:'center', width: 100}
                            ]]
                    });
                </script>
            </td>
        </tr>
        <tr>
            <td><strong>Remark</strong></td>
            <td><textarea class="easyui-validatebox" name="remark" style="width: 99%;height: 50px"></textarea></td>
        </tr>
    </table>        
</form>
