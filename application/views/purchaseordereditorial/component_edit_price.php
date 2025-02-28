<form id="component_edit_price_form" method="post" novalidate class="table_form">
    <table width="100%" border="0">
        <tr>
            <td width="25%"><strong>Vendor Item Code</strong></td>
            <td width="75%">
                <input type="hidden" name="id" />
                <input type="text" name='vendor_item_code' id="cep_item_code89" class="easyui-textbox" style="width: 100%"/>
            </td>
        </tr>
        <tr>
            <td><strong>Vendor</strong></td>
            <td>
                <input class="easyui-combobox" name="vendor_id" id="cep_vendor_id89" data-options="
                       url: '<?php echo site_url('vendor/get/' . $flag) ?>',
                       method: 'post',
                       valueField: 'id',
                       textField: 'name',
                       panelHeight: '200',
                       formatter: poEditorialComponentVendorFormat"
                       style="width: 100%" 
                       required="true"
                       mode="remote">
                <script type="text/javascript">
                    function poEditorialComponentVendorFormat(row) {
                        return '<span style="font-weight:bold;">' + row.name + ' (' + row.code + ')</span><br/>' +
                                '<span style="color:#888">Desc: ' + row.address + '</span>';
                    }
                </script>   
            </td>
        </tr>
        <tr>
            <td><strong>Qty</strong></td>
            <td>
                <input type="text" 
                       autocomplete="off" 
                       name="qty" 
                       class="easyui-numberbox" 
                       size="10" 
                       id="poe_comp_qty"
                       min="0" 
                       precision="2"
                       decimalSeparator="."
                       groupSeparator=","
                       style="width: 150px"/>
                <!-- <input class="easyui-combobox" name="uom" id="po_uom_id" data-options="
                       url: '<?php echo site_url('unit/get/' . $flag) ?>',
                       method: 'post',
                       valueField: 'id',
                       textField: 'code',
                       panelHeight: '50'"
                       style="width: 100%" 
                       required="true"
                       mode="remote"> -->
                    <strong>UoM : </strong><input type="text" class="easyui-validatebox" name="uom" style="width: 50px"/>
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
                       id="poe_comp_price"
                       min="0" 
                       precision="2"
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
            <td><strong>Discount</strong></td>
            <td>
                <input type="text" 
                       autocomplete="off" 
                       name="discount" 
                       class="easyui-numberbox" 
                       id="poe_comp_price"
                       min="0" 
                       precision="2"
                       decimalSeparator="."
                       groupSeparator=","
                       style="width: 70px"/> <strong>%</strong>
            </td>
        </tr>
    </table>        
</form>