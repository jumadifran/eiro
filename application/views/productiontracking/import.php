<form id="production_tracking_import_form" enctype="multipart/form-data" method="post" novalidate class="table_form">
    <table width="100%" border="0">
        <tr>
            <td width="30%"><strong>Date</strong></td>
            <td width="70%">
                <input name="date" 
                       class="easyui-datebox" 
                       style="width: 50%;" 
                       required="true"
                       data-options="formatter:myformatter,parser:myparser">
            </td>
        </tr>
        <tr>
            <td><strong>Status</strong></td>
            <td>
                <input class="easyui-combobox" 
                       id="production_process_id"
                       name="production_process_id"
                       url="<?php echo site_url('productionprocess/get') ?>"
                       method="post"
                       mode="remote"
                       valueField="id"
                       textField="name"
                       data-options="formatter: productionTrackingProductionProcessFormat"
                       style="width: 100%" 
                       required="true"/>
                <script>
                    function productionTrackingProductionProcessFormat(row) {
                        return '<span style="font-weight:bold;">' + row.name + '</span><br/>' +
                                '<span >Progress : ' + row.percent + ' %</span>';
                    }
                </script>
            </td>
        </tr>
        <tr>
            <td><strong>File (Ext: csv,txt)</strong></td>
            <td>
                <div>
                    <input class="easyui-filebox" 
                           name="inputfile" 
                           data-options="prompt:'Choose a file...'" 
                           style="width:100%"
                           required="true"
                           >
                </div>
            </td>
        </tr>
        <tr>
            <td><strong>Notes</strong></td>
            <td><textarea name='notes' class="easyui-validatebox" style="width: 98%;height: 40px"></textarea></td>
        </tr>
    </table>        
</form>