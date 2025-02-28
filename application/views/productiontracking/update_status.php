<form id="production_tracking_update_status_form" method="post" novalidate class="table_form">
    <table width="100%" border="0">
        <tr>
            <td width="25%"><strong>Date</strong></td>
            <td width="75%">
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
            <td><strong>Notes</strong></td>
            <td><textarea name='notes' class="easyui-validatebox" style="width: 98%;height: 40px"></textarea></td>
        </tr>
    </table>        
</form>