<form id="asset_input_form" method="post" novalidate class="table_form">
    <table style="width: 100%" cellpadding='0' cellspacing='0'>
        <tr>
            <td width="30%"><strong>Item Code</strong></td>
            <td width="70%">
                <input type="text" name='item_code' class="easyui-textbox" style="width: 100%"/>
            </td>
        </tr>
        <tr>
            <td><strong>Item Description</strong></td>
            <td><input type="text" multiline='true' name='item_description' class="easyui-textbox" style="width: 100%;height: 60px;"/></td>
        </tr>
        <tr>
            <td><strong>Class</strong></td>
            <td><input type="text" name='class' class="easyui-textbox" style="width: 10%"/></td>
        </tr>
        <tr>
            <td><strong>% of Depreciation</strong></td>
            <td><input type="text" name='depreciation_percentage' precision="2" class="easyui-numberbox" groupSeparator=',' decimalSeparator='.' style="width: 10%"/> / Year</td>
        </tr>
        <tr>
            <td><strong>Year of Acquisition</strong></td>
            <td><input name="date_of_acquisition" class="easyui-datebox" style="width: 50%;" required="true"  data-options="formatter:myformatter,parser:myparser"></td>
        </tr>
        <tr>
            <td><strong>Acquisition Cost</strong></td>
            <td><input class="easyui-numberbox" precision='2' name="acquisition_cost" groupSeparator=',' decimalSeparator='.' style="width: 100%" required="true"/></td>
        </tr>
        <tr>
            <td><strong>Depreciation Expense</strong></td>
            <td><input class="easyui-numberbox" precision='2' name="depreciation_expense" groupSeparator=',' decimalSeparator='.' style="width: 100%" required="true"/></td>
        </tr>
    </table>
</form>