<form id="proformainvoice_product_input_form" method="post" novalidate style="padding: 2px;">
    <table width="100%" border="0" class="table_form" cellspacing="0" cellpadding="0">
        <tr>
            <td><strong>Order Category</strong></td>
            <td>
                <select name="category" 
                        id="pi_category" 
                        class="easyui-combobox" 
                        panelHeight="auto" 
                        style="width: 50%;"
                        data-options="onSelect:function(row){
                            if(row.value === '0'){
                                var products_id = $('#products_id').combobox('getValue');
                                var row_products = $('#products_id').combobox('getData');                                
                                $.each(row_products, function (index, row) {
                                    if(products_id === row.id){
                                        set_info(row);
                                    }
                                });
                                $('#pi_product_width').numberbox({readonly:true});
                                $('#pi_product_depth').numberbox({readonly:true});
                                $('#pi_product_height').numberbox({readonly:true});
                                $('#pi_product_allocation_type').combobox({readonly:false});
                                $('#pi_material_id').combobox({readonly:true});
                            }else{
                                $('#pi_product_width').numberbox({readonly:false});
                                $('#pi_product_depth').numberbox({readonly:false});
                                $('#pi_product_height').numberbox({readonly:false});
                                $('#pi_product_allocation_type').combobox('setValue',1);
                                $('#pi_material_id').combobox({readonly:false});
                            }
                        }">
                    <option value='0'>Standard</option>
                    <option value='1'>Customize</option>
                </select>
            </td>
        </tr>      
        <tr>
            <td width="30%"><strong>Product Code </strong></td>
            <td width="70%">
                <input class="easyui-combobox" 
                       id="products_id"
                       name="products_id"
                       url="<?php echo site_url('products/get/released') ?>"
                       method="post"
                       mode="remote"
                       valueField="id"
                       textField="code_name"
                       data-options="formatter: PI_Product_Format,
                       onSelect:function(row){
                        set_info(row);
                       }"
                       style="width: 100%" 
                       required="true"/>
                <script type="text/javascript">
                    function PI_Product_Format(row) {
                        return '<span style="font-weight:bold;">Code ' + row.code + '</span><br/>' +
                                '<span style="font-weight:bold;">Name : ' + row.name + '</span><br/>' +
                                '<span style="color:#888">Dimension (WxDxH): ' + row.width + ' x ' + row.depth + ' x ' + row.height + '</span>';
                    }
                </script>
            </td>
        </tr>
        <tr>
            <td><strong>Dimension (W x D x H)</strong></td>
            <td>
                <input type="text" autocomplete="off" name="width" id="pi_product_width" readonly="" class="easyui-numberbox" size="9" style="text-align: center;width: 20%"/> x
                <input type="text" autocomplete="off" name="depth" id="pi_product_depth" readonly="" class="easyui-numberbox" size="9" style="text-align: center;width: 20%" /> x
                <input type="text" autocomplete="off" name="height" id="pi_product_height" readonly="" class="easyui-numberbox" size="9" style="text-align: center;width: 20%" />

            </td>
        </tr>
        <tr>
            <td><strong>Materials</strong></td>
            <td>
                <input class="easyui-combobox" 
                       name="material_id[]"
                       id="pi_material_id"
                       multiple="true" 
                       url="<?php echo site_url('materials/get') ?>"
                       method="post"
                       valueField="id"
                       textField="code"
                       data-options="formatter: PiProductMaterialFormat"
                       style="width: 100%" 
                       required="true"
                       />
                <script type="text/javascript">
                    function PiProductMaterialFormat(row) {
                        return '<span style="font-weight:bold;">' + row.code + '</span><br/>' +
                                '<span style="color:#888">Desc: ' + row.description + '</span>';
                    }
                </script>
            </td>
        </tr>
        <tr>
            <td><strong>Fabric</strong></td>
            <td>
                <input class="easyui-combobox" 
                       name="fabric_id"
                       url= '<?php echo site_url('fabric/get') ?>'
                       method= 'post'
                       valueField= 'id'
                       textField= 'description'
                       panelHeight= '200'
                       id="pi_product_fabric_id"
                       data-options="formatter:ProductFabFormat"
                       style="width: 90%" 
                       mode="remote">
                <script type="text/javascript">
                    function ProductFabFormat(row) {
                        return '<span style="font-weight:bold;">' + row.code + '</span><br/>' +
                                '<span style="color:#888">Desc: ' + row.description + '</span>';
                    }
                </script>
                <!--<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="fabric_add()"></a>-->
            </td>
        </tr>
        <tr>
            <td><strong>Color</strong></td>
            <td>
                <input class="easyui-combobox" 
                       name="color_id[]"
                       url ="<?php echo site_url('color/get') ?>"
                       method= "post"
                       valueField="id"
                       textField="name"
                       panelHeight= "200"
                       id="color_id"
                       multiple="true" 
                       data-options="formatter:ProductColorFormat"
                       style="width: 90%"
                       mode="local"/>
                <script type="text/javascript">
                    function ProductColorFormat(row) {
                        return '<span style="font-weight:bold;">' + row.name + '</span><br/>' +
                                '<span style="color:#888">Code: ' + row.code + '</span>';
                    }
                </script>
                <!--<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="color_add()"></a>-->
            </td>
        </tr>

        <tr>
            <td><strong>Qty</strong></td>
            <td>
                <input type="text" name="qty" id="pi_prod_qty" class="easyui-textbox easyui-numberbox" style="width: 50px;text-align: center;" required='true'/>
            </td>
        </tr>
        <tr>
            <td><strong>Price</strong></td>
            <td><input name="price" id="pi_price" class="easyui-numberbox" precision="4" required='true' decimalSeparator="." groupSeparator="," style="text-align: right;width: 50%;"></td>
        </tr>
        <tr>
            <td><strong>Discount</strong></td>
            <td><input name="discount" class="easyui-numberbox" decimalSeparator="." groupSeparator="," style="text-align: right;width: 10%;"> %</td>
        </tr>
        <tr>
            <td><strong>Allocated From</strong></td>
            <td>
                <select name='product_allocation_type' id='pi_product_allocation_type' class="easyui-combobox" required="" panelHeight='auto'>
                    <option value="1">New Production</option>
                    <option value="2">Finish Stock</option>
                    <option value="3">UnFinish Stock</option>
                </select>
            </td>
        </tr>
        <tr>
            <td><strong>Special Instruction</strong></td>
            <td>
                <textarea name="special_instruction" class="easyui-validatebox" style="width: 98%;height: 40px"></textarea>
            </td>
        </tr>
        <tr>
            <td><strong>Notes</strong></td>
            <td>
                <textarea name="notes" class="easyui-validatebox" style="width: 98%;height: 40px"></textarea>
            </td>
        </tr>        
    </table>
</form>
<script>
    function currency_adjust_nominal(from_curr_id, nominal) {
        var h_row = $('#proformainvoice').datagrid('getSelected');
        if (from_curr_id === h_row.currency_id) {
            $('#pi_price').numberbox('setValue', nominal);
        } else {
            $.post(base_url + 'rate/convert_nominal', {
                from_id: from_curr_id,
                to_id: h_row.currency_id,
                nominal: nominal
            }, function (content) {
                var t = parseFloat(content);
                $('#pi_price').numberbox('setValue', t);
            });
        }
    }

    function set_info(row) {
        $('#pi_product_name').val(row.name);
        $('#pi_product_width').numberbox('setValue', row.width);
        $('#pi_product_depth').numberbox('setValue', row.depth);
        $('#pi_product_height').numberbox('setValue', row.height);
        currency_adjust_nominal(row.currency_id, row.price);
        var str_mat = row.material_id.replace('{', '').replace('}', '');
        var arr_mat = str_mat.split(',');
        $('#pi_material_id').combobox('setValues', arr_mat);
        if (row.fabric_id !== '0') {
            $('#pi_product_fabric_id').combobox('setValue', row.fabric_id);
        }
    }
</script>
