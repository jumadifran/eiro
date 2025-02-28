<form id="po_editorial_vendor_edit_form" method="post" novalidate class="table_form">
    <table width="100%" border="0">
        <tr>
            <td width="25%"><strong>Vendor</strong></td>
            <td width="75%">
                <input type="hidden" name="purchaseorderediotrial_id" />
                <input class="easyui-combobox" name="vendor_id" data-options="
                       url: '<?php echo site_url('vendor/get/' . $flag) ?>',
                       method: 'post',
                       valueField: 'id',
                       textField: 'name',
                       panelHeight: '200',
                       formatter: PoEditorialVendorFormat"
                       style="width: 100%" 
                       required="true"
                       mode="remote"
                       readonly="">
                <script type="text/javascript">
                    function PoEditorialVendorFormat(row) {
                        return '<span style="font-weight:bold;">' + row.name + ' (' + row.code + ')</span><br/>' +
                                '<span style="color:#888">Desc: ' + row.address + '</span>';
                    }
                </script>
            </td>
        </tr>
        <tr>
            <td><strong>Currency</strong></td>
            <td>
                <input class="easyui-combobox"  name="currency_id"  data-options="
                       url: '<?php echo site_url('currency/get') ?>',
                       method: 'post',
                       valueField: 'id',
                       textField: 'code',
                       panelHeight: 'auto'"
                       style="width: 60px" 
                       required="true" 
                       readonly=""/>    
            </td>
        </tr>
        <tr>
            <td><strong>Targe Ship Date</strong></td>
            <td><input type="text" name='target_ship_date' class="easyui-datebox" required="" data-options="formatter:myformatter,parser:myparser"style="width: 110px"/></td>
        </tr>
        <tr>
            <td><strong>Down_payment</strong></td>
            <td>
                <input type="text" name='down_payment_date' class="easyui-datebox" data-options="formatter:myformatter,parser:myparser"style="width: 110px"/>
                <input name="down_payment" class="easyui-numberbox" precision="2" decimalSeparator="." groupSeparator="," style="width: 50px" max="100"/> <strong>%</strong>
            </td>
        </tr>
        <tr>
            <td><strong>Vat</strong></td>
            <td>
                <input name="vat" class="easyui-numberbox" precision="2" decimalSeparator="." groupSeparator="," max="100" style="width: 50px"/> <strong>%</strong>
            </td>
        </tr>
        <tr>
            <td><strong>Remark</strong></td>
            <td>
                <textarea name="remark" class="easyui-validatebox" style="width: 98%;height: 35px"></textarea>
            </td>
        </tr>
    </table>        
</form>
