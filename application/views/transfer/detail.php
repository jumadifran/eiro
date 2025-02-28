<div id="transfer_detail_toolbar" style="padding-bottom: 2px;">
    <form id='transfer_detail_search_form' onsubmit="return false" style="margin: 0;">
        Search
        <input type="text" name='q' class="easyui-validatebox" style="width: 120px"/>
        <script>
            $("#transfer_detail_search_form input[name=q]").keypress(function (event) {
                if (event.which === 13) {
                    transfer_detail_search();
                }
            });
        </script>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="transfer_detail_search()"></a>
        <?php if (in_array("Add", $action)) { ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="transfer_detail_add()">Add</a>
        <?php }if (in_array("Edit", $action)) { ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="transfer_detail_delete()">Delete</a>
        <?php }if (in_array("Delete", $action)) { ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-import" plain="true" onclick="transfer_detail_import()">Import</a>
        <?php } ?>
    </form>
</div>
<table id="transfer_detail" data-options="
       url:'<?php echo site_url('transfer/detail_get') ?>',
       method:'post',
       border:false,
       singleSelect:false,
       fit:true,
       title:'Product Detail',
       pageSize:30,
       autoRowHeight:false,
       pageList: [30, 50, 70, 90, 110],
       rownumbers:true,
       fitColumns:false,
       remoteSort:true,
       multiSort:true,
       pagination:true,
       nowrap:false,
       toolbar:'#transfer_detail_toolbar'">
    <thead>
        <tr>
            <th field="transfer_detail_chck88" checkbox='true' rowspan="2"></th>
            <th field="product_image" width="70" align="center" rowspan="2" formatter="transfer_detail_image_load">Image</th>
            <th field="serial_number" width="100" halign="center" rowspan="2">Serial Number</th>
            <th field="product_code" width="120" halign="center" rowspan="2">Product ID</th>
            <th field="product_name" width="120" halign="center" rowspan="2">Product Name</th>
            <th halign="center" colspan="3">Dimension (mm)</th>
            <th field="volume" width="50" align="center" rowspan="2">Volume<br/>(m3)</th>
            <th field="material" width="160" halign="center" rowspan="2">Material</th>
            <th field="fabric_code" width="140" halign="center" rowspan="2">Fabric</th>
            <th field="color" width="120" halign="center" rowspan="2">Color</th>
        </tr>
        <tr>
            <th field="width" width="40" align="center">W</th>
            <th field="depth" width="40" align="center">D</th>
            <th field="height" width="40" align="center">H</th>
        </tr>
    </thead>
</table>
<script type="text/javascript">
    $(function () {
        $('#transfer_detail').datagrid();
    });

    function transfer_detail_image_load(value, row) {
        return '<img src="files/products_image/' + value + '" style="max-width:30px;max-height:30px;padding:2px;">';
    }
</script>

