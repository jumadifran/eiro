<div id="materials_toolbar" style="padding-bottom: 2px;">   
    <form id="materials_search_form" onsubmit="return false">
        Search : 
        <input type="text" 
               size="20" 
               name="code"
               class="easyui-validatebox"
               onkeypress="if (event.keyCode === 13) {
                           materials_search();
                       }"
               /> 
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="materials_search()">Find</a>
        <?php
        if (in_array("Add", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="materials_add()"> Add</a>
            <?php
        }if (in_array("Edit", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="materials_edit()"> Edit</a>
            <?php
        }if (in_array("Delete", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="materials_delete()"> Delete</a>
            <?php
        }
        ?>

    </form>
</div>
<table id="materials" data-options="
       url:'<?php echo site_url('materials/get') ?>',
       method:'post',
       border:true,
       singleSelect:true,
       title:'Material',
       fit:true,
       pageSize:30,
       pageList: [30, 50, 70, 90, 110],
       rownumbers:true,
       fitColumns:true,
       remoteSort:true,
       multiSort:true,
       pagination:true,
       toolbar:'#materials_toolbar'">
    <thead>
        <tr>
            <th field="code" width="20%" halign="center" sortable="true">Code</th>            
            <th field="description" width="80%" halign="center" sortable="true">Description</th>
        </tr>
    </thead>
</table>
<script materials="text/javascript">
    $(function () {
        $('#materials').datagrid({
            onDblClickRow: function (rowIndex, row) {
                materials_ubah();
            }
        });
    });
</script>
<script type="text/javascript" src="<?php echo base_url() ?>js/materials.js"></script>
<?php
//$this->load->view('materials/add');

