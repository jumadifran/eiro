<div class="easyui-layout" fit="true">
    <div region="north" 
         title="Delivery Receipt"
         style="height:40%;"
         split="true"
         href="<?php echo site_url('receiving/view') ?>">
    </div>
    <div region="center" 
         title="Product Detail"
         href="<?php echo site_url('receiving/detail_view') ?>">
    </div>
</div>
<script src="<?php echo base_url() ?>js/receiving.js"></script>