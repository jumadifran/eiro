<div id="rw_inspection_detail_toolbar" style="padding-bottom: 2px;">
    <form id="rw_inspection_detail_search_form" onsubmit="rw_inspection_detail_search();
            return false" style="margin: 0;">
        Search 
        <input type="text" name="q" class="easyui-validatebox" />
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="rw_inspection_detail_search()"></a>
<!--        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" id='rw_inspection_product_add' onclick="rw_inspection_product_add()"></a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" id='rw_inspection_product_edit_id' onclick="rw_inspection_product_edit()"></a>-->
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" plain="true" id='rw_inspection_product_delete_id' onclick="rw_inspection_product_delete()"></a>
    </form>

</div>
<table id="rw_inspection_detail" class="easyui-datagrid" data-options="
       url:'<?php echo site_url('rw_inspection/rw_inspection_detail_get') ?>',
       method:'post',
       border:true,
       singleSelect:true,
       fit:true,
       rownumbers:true,
       fitColumns:false,
       pagination:true,
       striped:true,
       autoRowHeight:true,
       toolbar:'#rw_inspection_detail_toolbar'">
    <thead>
        <tr>
            <th data-options="field:'ck',checkbox:true"></th>
            <th field ="detail" formatter="rw_formatDetail2" styler="rw_cellStyler2" valign="center">Actions</th>
            <th  field="filename"  valign="center" align=center formatter="rw_showimage">Image</th>
            <th  field="view_position" valign="center">Image Category</th>
            <th  field="description" valign="center">Description</th>
            <th  field="filename_detail" valign="center">File Name</th>
            <th  field="submited" valign="center">submited</th>
            <!--<th  field="filename" width="100" halign="center">File</th>-->
        </tr>
    </thead>
</table>
<script>
    function rw_showimage(value, row) {
        var idrow = row.id;
        var temp = '';
        if(row.filename==null)
            var temp='no image';
        else
            var temp = "<img src='files/rw_inspection/" + row.rw_inspection_id + "/" + row.filename + "' width=50 onclick='rw_inspection_product_view_detail(" + idrow + ")'>";
            //var temp = "<img src='files/rw_inspection/" + row.rw_inspection_id + "/" + row.filename + "' width=50>" + row.filename;
        return temp;
    }
    function rw_formatDetail2(value, row) {
        var idrow = row.id;
        //var temp = '';
        if(row.submited=='f')
            var temp = "<input type=button value='Upload' id='inspect"+row.id+"' onclick='rw_inspection_product_add(" + idrow + ")'> ";
        else
            var temp='submited';
        return temp;
    }
    function rw_cellStyler2(value, row) {
        if ((row.id % 2) == 1) {
            return 'color:blue;';
        }
    }
</script>