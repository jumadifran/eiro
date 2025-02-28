<div id="asset_toolbar" style="padding-bottom: 2px;">
    <form id="asset_search_form" onsubmit="return false" style="margin: 0">
        Search :
        <input type="text" size="20" class="easyui-validatebox" name="q" onkeypress="if (event.keyCode === 13) {
                    asset_search();

                }"/>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" iconCls="icon-search" plain="true" onclick="asset_search()">Find</a>
        <?php
        if (in_array("Add", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="asset_add()"> Add</a>
            <?php
        }if (in_array("Edit", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="asset_edit()"> Edit</a>
            <?php
        }if (in_array("Delete", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="asset_delete()"> Delete</a>
            <?php
        }
        ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="asset_print()"> Print</a>
    </form>
</div>
<table id="asset" data-options="
       url:'<?php echo site_url('asset/get') ?>',
       method:'post',
       border:true,
       singleSelect:true,
       fit:true,
       title:'Asets',
       pageSize:30,
       pageList: [30, 50, 70, 90, 110],
       rownumbers:true,
       fitColumns:false,
       remoteSort:true,
       multiSort:true,
       pagination:true,
       toolbar:'#asset_toolbar'">
    <thead>
        <tr>
            <th field="item_code" width="100" halign="center">Item Code</th>
            <th field="item_description" width="250" halign="center">Invoice Description</th>
            <th field="class" width="90" align="center">Class</th>
            <th field="depreciation_percentage" width="100" align="center">% of Depreciation</th>
            <th field="date_of_acquisition" width="120" align="center" formatter="myFormatDate">Year of Acquisition</th>
            <th field="acquisition_cost" width="150" halign="center" align="right" formatter="formatPrice">Acquisition Cost</th>
            <th field="depreciation_expense" width="150" halign="center" align="right" formatter="formatPrice">Depreciation Expense</th>
        </tr>
    </thead>
</table>
<script asset="text/javascript">
    $(function () {
        $('#asset').datagrid();
    });
</script>
<script type="text/javascript" src="<?php echo base_url() ?>js/asset.js"></script>

