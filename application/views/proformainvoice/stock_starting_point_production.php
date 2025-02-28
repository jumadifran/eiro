<form id="pi_stock_starting_point_form" method="post" novalidate class="table_form">
    <table width="100%" border="0">
        <tr>
            <td width="30%"><strong>Starting Point</strong></td>
            <td width="70%">
                <input class="easyui-combobox" 
                       id="production_process_id"
                       name="production_process_id"
                       url="<?php echo site_url('productionprocess/get') ?>"
                       method="post"
                       mode="remote"
                       valueField="id"
                       textField="name"
                       data-options="formatter: allocatedStockProductionProcessFormat"
                       style="width: 100%" 
                       required="true"/>
                <script>
                    function allocatedStockProductionProcessFormat(row) {
                        return '<span style="font-weight:bold;">' + row.name + '</span><br/>' +
                                '<span >Progress : ' + row.percent + ' %</span>';
                    }
                </script>
            </td>
        </tr>
    </table>        
</form>