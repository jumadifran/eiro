<form id="requestforsample_input_form" onsubmit="return false;" class="table_form" method="POST">
    <table width="100%">
        <tr>
            <td width="30%"><strong>For Company</strong></td>
            <td width="70%">
                <input class="easyui-combobox" 
                       id="company_id"
                       name="company_id"
                       url="<?php echo site_url('company/get') ?>"
                       method="post"
                       mode="remote"
                       valueField="id"
                       textField="name"
                       data-options="formatter: RfsCompanyFormat"
                       style="width: 100%" 
                       required="true"/>
                <script type="text/javascript">
                    function RfsCompanyFormat(row) {
                        return '<span style="font-weight:bold;">' + row.name + '</span><br/>' +
                                '<span style="color:#888">Address: ' + row.address + '</span>';
                    }
                </script>
            </td>
        </tr>
        <tr valign="top">
            <td><strong>Date</strong></td>
            <td>
                <input type="text" name="date" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser" required="true" style="width: 120px"/>
            </td>
        </tr>
        <tr>
            <td><strong>Vendor</strong></td>
            <td>
                <input class="easyui-combobox" name="vendor_id" data-options="
                       url: '<?php echo site_url('vendor/get') ?>',
                       method: 'post',
                       valueField: 'id',
                       textField: 'name',
                       panelHeight: '200',
                       formatter: RfsEditorialVendorFormat"
                       style="width: 100%" 
                       required="true"
                       mode="remote">
                <script type="text/javascript">
                    function RfsEditorialVendorFormat(row) {
                        return '<span style="font-weight:bold;">' + row.name + ' (' + row.code + ')</span><br/>' +
                                '<span style="color:#888">Desc: ' + row.address + '</span>';
                    }
                </script>
            </td>
        </tr>
        <tr>
            <td><strong>Notes</strong></td>
            <td><textarea name="notes" class="easyui-validatebox" style="width: 99%;height: 40px"></textarea></td>
        </tr>
    </table>
</form>