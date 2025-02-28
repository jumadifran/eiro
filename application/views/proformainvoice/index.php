<div class="easyui-layout" fit="true">
    <div region="north" 
         title="Proforma Invoice"
         style="height:45%;"
         split="true"
         href="<?php echo site_url('proformainvoice/view') ?>">
    </div>
    <div region="center" 
         title="Product Detail" 
         href="<?php echo site_url('proformainvoice/product_view') ?>">
    </div>
</div>
<script src="<?php echo base_url() ?>js/proformainvoice.js"></script>