<div id="bank_toolbar" style="padding-bottom: 2px;">   
    <form id="bank_search_form" onsubmit="return false" style="margin: 0">
        Search : 
        <input type="text" size="20" class="easyui-validatebox" name="q" onkeypress="if (event.keyCode === 13) {
                    bank_search();
                }"/>  

        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="bank_search()">Find</a>
        <?php
        if (in_array("Add", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="bank_add()"> Add</a>
            <?php
        }if (in_array("Edit", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="bank_edit()"> Edit</a>
            <?php
        }if (in_array("Delete", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="bank_delet()"> Delete</a>
            <?php
        }
        ?>
    </form>
</div>
<table id="bank" data-options="
       url:'<?php echo site_url('bank/get') ?>',
       method:'post',
       border:true,
       title:'Country',
       singleSelect:true,
       fit:true,
       pageSize:30,
       pageList: [30, 50, 70, 90, 110],
       rownumbers:true,
       fitColumns:false,
       remoteSort:true,
       multiSort:true,
       pagination:true,
       toolbar:'#bank_toolbar'">
    <thead>
        <tr>
            <th field="id" hidden="true"></th>
            <th field="code" width="200" halign="center" sortable="true">Code</th>            
            <th field="name" width="200" halign="center" sortable="true">Bank Name</th>
            <th field="description" width="200" halign="center" sortable="true">Description</th>
            <th field="swift" width="200" halign="center" sortable="true">Swift</th>
        </tr>
    </thead>
</table>
<script bank="text/javascript">
    $(function () {
        $('#bank').datagrid({
            onDblClickRow: function (rowIndex, row) {
                bank_edit();
            }
        }, 'fixColumnSize', 'reloadFooter', [
            {name: 'bank'},
            {name: 'formal_name'}]).datagrid('getPager').pagination({
            beforePageText: 'Page',
            afterPageText: 'From {pages}',
            displayMsg: 'Displaying {from} to {to} of {total} items'
        });
    });
</script>
<script type="text/javascript" src="<?php echo base_url() ?>js/bank.js"></script>