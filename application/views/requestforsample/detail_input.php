<form id="requestforsample_detail_input_form" onsubmit="return false;" class="table_form" method="POST">
    <table width="100%">
        <tr>
            <td width="25%"><strong>Item Code</strong></td>
            <td width="75%"><input type="text" name="item_code" class="easyui-textbox" style="width: 98%;" required="true"/></td>
        </tr>
        <tr>
            <td><strong>Item Description</strong></td>
            <td><input type="text" name="item_description" class="easyui-textbox" style="width: 98%;" required="true"/></td>
        </tr>
        <tr>
            <td><strong>Dimension</strong></td>
            <td><input type="text" name="dimension" class="easyui-textbox" style="width: 98%;" required="true"/></td>
        </tr>
        <tr>
            <td><strong>Materials</strong></td>
            <td>
                <input class="easyui-combobox" 
                       name="material_id[]"
                       multiple="true" 
                       id="rfsd_material_id"
                       url="<?php echo site_url('materials/get') ?>"
                       method="post"
                       valueField="id"
                       textField="code"
                       data-options="formatter: RfsProductMaterialFormat"
                       style="width: 100%" 
                       required="true"/>
                <script type="text/javascript">
                    function RfsProductMaterialFormat(row) {
                        return '<span style="font-weight:bold;">' + row.code + '</span><br/>' +
                                '<span style="color:#888">Desc: ' + row.description + '</span>';
                    }
                </script>
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
                       id="rfsd_color_id"
                       textField="name"
                       panelHeight= "200"
                       id="color_id"
                       multiple="true" 
                       data-options="formatter:RfsColorFormat"
                       style="width: 90%"
                       mode="remote"/>
                <script type="text/javascript">
                    function RfsColorFormat(row) {
                        return '<span style="font-weight:bold;">' + row.name + '</span><br/>' +
                                '<span style="color:#888">Code: ' + row.code + '</span>';
                    }
                </script>
                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="color_add()"></a>
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
                       data-options="formatter:RfsFabricFormat"
                       style="width: 90%" 
                       mode="remote">
                <script type="text/javascript">
                    function RfsFabricFormat(row) {
                        return '<span style="font-weight:bold;">' + row.code + '</span><br/>' +
                                '<span style="color:#888">Desc: ' + row.description + '</span>';
                    }
                </script>
                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="fabric_add()"></a>
            </td>
        </tr>
        <tr>
            <td><strong>Qty</strong></td>
            <td>
                <input type="text" name="qty" class="easyui-numberbox" style="width: 50px;text-align: center;" required='true'/>
            </td>
        </tr>
        <tr>
            <td><strong>Due Date</strong></td>
            <td>
                <input type="text" name="due_date" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser" required="true" style="width: 120px"/>
            </td>
        </tr>
        <tr>
            <td><strong>Remark</strong></td>
            <td><textarea name="notes" class="easyui-textbox" style="width: 98%;height: 40px"></textarea></td>
        </tr>
    </table>
</form>