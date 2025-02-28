<form id="transfer_input_form" method="post" novalidate class="table_form">
    <table width="100%" border="0">
        <tr>
            <td width="30%"><strong>Date</strong></td>
            <td width="70%">
                <input type="text" 
                       name='date' 
                       class="easyui-datebox" 
                       required="true" 
                       data-options="formatter:myformatter,parser:myparser"
                       style="width:120px"/>
            </td>
        </tr>
        <tr>
            <td><strong>Transfer From</strong></td>
            <td>
                <input class="easyui-combobox" name="source_id" data-options="
                       url: '<?php echo site_url('vendor/get/iw') ?>',
                       method: 'post',
                       valueField: 'id',
                       textField: 'name',
                       panelHeight: '200',
                       formatter: TransferFromVendorFormat"
                       style="width: 100%" 
                       required="true"
                       mode="remote">
                <script type="text/javascript">
                    function TransferFromVendorFormat(row) {
                        return '<span style="font-weight:bold;">' + row.name + ' (' + row.code + ')</span><br/>' +
                                '<span style="color:#888">Desc: ' + row.address + '</span>';
                    }
                </script>
            </td>
        </tr>
        <tr>
            <td><strong>Transfer To</strong></td>
            <td>
                <input class="easyui-combobox" name="target_id" data-options="
                       url: '<?php echo site_url('vendor/get/iw') ?>',
                       method: 'post',
                       valueField: 'id',
                       textField: 'name',
                       panelHeight: '200',
                       formatter: TransferToVendorFormat"
                       style="width: 100%" 
                       required="true"
                       mode="remote">
                <script type="text/javascript">
                    function TransferToVendorFormat(row) {
                        return '<span style="font-weight:bold;">' + row.name + ' (' + row.code + ')</span><br/>' +
                                '<span style="color:#888">Desc: ' + row.address + '</span>';
                    }
                </script>
            </td>
        </tr>
        <tr>
            <td><strong>Description</strong></td>
            <td><textarea name="description" style="width: 99%;height: 50px" class="easyui-validatebox"></textarea></td>
        </tr>
    </table>        
</form>