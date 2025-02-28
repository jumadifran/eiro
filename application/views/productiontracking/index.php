<div class="easyui-layout" fit="true">
<!--    <div region='north'
         style="height: 30%"
         border='false'
         split='true'
         title='Purchase Order Item'
         href="<?php echo site_url('productiontracking/purchaseorder_item') ?>">
    </div>-->
<!--        <div region="west" 
             style="width:32%;"
             split="true"
             border="false">
            <div class="easyui-layout" fit="true">
                <div region="north"
                     style="height: 40%"
                     split="true"
                     border="false"
                     href="<?php echo site_url('productiontracking/purchaseorder') ?>">
                </div>
                <div region="center" 
                     border='false'
                     href="<?php echo site_url('productiontracking/purchaseorder_item') ?>">
                </div>
            </div>
        </div>-->
    <div region="center" 
         border='false'
         href="<?php echo site_url('productiontracking/product_list') ?>">
    </div>
</div>
<script src="<?php echo base_url() ?>js/productiontracking.js"></script>