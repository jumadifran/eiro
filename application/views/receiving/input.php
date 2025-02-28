<form id="receive_input_form" method="post" novalidate class="table_form">
    <table width="100%" border="0">
        <tr>
            <td width="25%"><strong>Date</strong></td>
            <td width="75%">
                <input type="text" 
                       name='date' 
                       class="easyui-datebox" 
                       required="true" 
                       data-options="formatter:myformatter,parser:myparser"
                       style="width:120px"/>
            </td>
        </tr>
        <tr>
            <td><strong>Vendor</strong></td>
            <td>
                <input class="easyui-combobox" id="receiving_vendor_id" name="vendor_id" data-options="
                       url: '<?php echo site_url('receiving/get_vendor_unfinish_delivery') ?>',
                       method: 'post',
                       valueField: 'id',
                       textField: 'name',
                       panelHeight: '200',
                       formatter: receivingVendorFormat"
                       style="width: 100%" 
                       required="true"
                       mode="remote">
                <script type="text/javascript">
                    function receivingVendorFormat(row) {
                        return '<span style="font-weight:bold;">' + row.name + ' (' + row.code + ')</span><br/>' +
                                '<span style="color:#888">Desc: ' + row.address + '</span>';
                    }
                </script>
            </td>
        </tr>
        <tr>
            <td><strong>DO Number</strong></td>
            <td><input type="text" class="easyui-validatebox" style="width: 98%" name="do_number"></td>
        </tr>
        <tr>
            <td><strong>DO Date</strong></td>
            <td>
                <input type="text" 
                       name='do_date' 
                       class="easyui-datebox" 
                       required="true" 
                       data-options="formatter:myformatter,parser:myparser"
                       style="width:120px"/>
            </td>
        </tr>
        <tr>
            <td><strong>Store To</strong></td>
            <td>
                <input class="easyui-combobox" id="wareouse_storeid" name="wareouse_storeid" data-options="
                       url: '<?php echo site_url('vendor/get_internal_warehouse') ?>',
                       method: 'post',
                       valueField: 'id',
                       textField: 'name',
                       panelHeight: '200',
                       formatter: receivingStoreFormat"
                       style="width: 100%" 
                       required="true"
                       mode="remote">
                <script type="text/javascript">
                    function receivingStoreFormat(row) {
                        return '<span style="font-weight:bold;">' + row.name + ' (' + row.code + ')</span><br/>' +
                                '<span style="color:#888">Desc: ' + row.address + '</span>';
                    }
                </script>
            </td>
        </tr>
        <tr>
            <td><strong>Remark</strong></td>
            <td><textarea name="remark" style="width: 99%;height: 50px" class="easyui-validatebox"></textarea></td>
        </tr>
    </table>        
</form>