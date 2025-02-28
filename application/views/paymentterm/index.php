<div id="paymentterm_toolbar" style="padding-bottom: 2px;">   
    Description : 
    <input type="text" 
           size="20" 
           class="easyui-validatebox" 
           name="code_name"
           onkeypress="if (event.keyCode === 13) {
                       paymentterm_search();
                   }" />
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="paymentterm_search()">Search</a>
    <?php
    if (in_array("Add", $action)) {
        ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="paymentterm_add()"> Add</a>
        <?php
    }if (in_array("Edit", $action)) {
        ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="paymentterm_edit()"> Edit</a>
        <?php
    }if (in_array("Delete", $action)) {
        ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="paymentterm_delete()"> Delete</a>
        <?php
    }
    ?>
</div>
<table id="paymentterm" data-options="
       url:'<?php echo site_url('paymentterm/get') ?>',
       method:'post',
       border:true,
       singleSelect:true,
       title:'Color',
       fit:true,
       pageSize:30,
       autoRowHeight:false,
       pageList: [30, 50, 70, 90, 110],
       rownumbers:true,
       fitColumns:false,
       remoteSort:true,
       multiSort:true,
       pagination:true,
       toolbar:'#paymentterm_toolbar'">
    <thead>
        <tr>
            <th field="id" hidden="true"></th>           
            <th field="name" width="50%" halign="center" sortable="true">Description</th>
        </tr>
    </thead>
</table>
<script paymentterm="text/javascript">
    $(function () {
        $('#paymentterm').datagrid({
            onDblClickRow: function (rowIndex, row) {
                paymentterm_edit();
            }
        });
    });
</script>
<script src="<?php echo base_url() ?>js/paymentterm.js"></script>