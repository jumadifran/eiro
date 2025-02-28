<form id="fabric_form" method="post" novalidate class="table_form">
    <table width="100%" border="0">
        <tr>
            <td width="25%"><strong>Code</strong></td>
            <td width="75%"><input type="text" name='code' class="easyui-validatebox" required="true" style="width: 80%"/></td>
        </tr>
        <tr>
            <td><strong>Description</strong></td>
            <td><input type="text" name='description' class="easyui-validatebox" style="width: 99%"/></td>
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
                       formatter: FabricComponentVendorFormat"
                       style="width: 80%" 
                       required="true"
                       mode="remote">
                <script type="text/javascript">
                    function FabricComponentVendorFormat(row){
                        return '<span style="font-weight:bold;">' + row.name +' ('+row.code+')</span><br/>' +
                            '<span style="color:#888">Desc: ' + row.address + '</span>';
                    }
                </script>     
                <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" iconCls="icon-add" onclick="vendor_add()">&nbsp;</a>
            </td>
        </tr>
        <tr>
            <td><strong>Price</strong></td>
            <td>
                <input type="text" 
                       autocomplete="off" 
                       name="price" 
                       class="easyui-numberbox" 
                       size="10" 
                       required="true" 
                       min="0" 
                       data-options="min:0,precision:2"
                       decimalSeparator="."
                       groupSeparator=","
                       style="width: 150px"/>
                <input class="easyui-combobox"  name="currency_id"  data-options="
                       url: '<?php echo site_url('currency/get') ?>',
                       method: 'post',
                       valueField: 'id',
                       textField: 'code',
                       panelHeight: 'auto'"
                       style="width: 50px" 
                       required="true">
            </td>
        </tr>
        <tr>
            <td>
                <strong>Remark</strong>
            </td>
            <td>
                <textarea class="easyui-validatebox" 
                          style="width: 98%;height: 40px;" 
                          name="remark"></textarea>
            </td>
        </tr>
    </table>        
</form>