<div class="easyui-panel" title="Project Progress" fit="true" border="false">
    <div class="easyui-layout" data-options="fit:true">
        <div data-options="region:'north'" style="height:50px;padding:10px">
            PO Vendor : 
            <input type="text"
                   style="width: 120px" 
                   class="easyui-combogrid" 
                   name="purchaseorderid"
                   data-options="
                   panelWidth:410,
                   idField:'id',
                   textField:'po_no',
                   mode: 'remote',
                   url:'<?php echo site_url('purchaseorder/get') ?>',
                   columns:[[
                   {field:'po_no',title:'P.O',width:120},
                   {field:'date',title:'P.O Date',width:80,formatter:myFormatDate},
                   {field:'vendor_name',title:'Vendor',width:220}
                   ]],
                   queryParams:{
                   x: '1'
                   },
                   onSelect: function(index,row){
                   productiontracking_reload_chart(row.id);
                   }
                   "/>
        </div>
        <div data-options="region:'center'"
             id="chart_content"
             href="<?php echo site_url('productiontracking/load_chart/') ?>"
             style="padding:10px">

        </div>
    </div>
</div>