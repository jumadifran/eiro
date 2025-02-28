<div class="easyui-layout" fit="true">
    <div region="north" 
         style="height:35%" 
         split="true" 
         title="Order" 
         href="<?php echo site_url('purchaseordereditorial/proformainvoice_view') ?>">
    </div>
    <div region="center" border="false">
        <div id="po_editorial_tab" class="easyui-tabs" data-options="fit:true,tabHeight:20,tabPosition:'top'">
            <div fit="true" title="Product Detail & Component Vendor" >
                <div class="easyui-layout" fit="true">
                    <div region="center"
                         border="false"
                         href="<?php echo site_url('purchaseordereditorial/proformainvoice_product_view') ?>">
                    </div>
                    <div region="south"
                         style="height: 40%"
                         title="Component & Vendor " 
                         split="true" 
                         collapsible="false"
                         href="<?php echo site_url('purchaseordereditorial/product_component_vendor') ?>"
                         >
                    </div>
                </div>
            </div>
            <div fit="true" title="PO Plan for Vendor">
                <div class="easyui-layout" fit="true">
                    <div region="north"
                         title="Vendor"
                         style="height: 40%"
                         border="false"
                         split="true"
                         collapsible="true"
                         href="<?php echo site_url('purchaseordereditorial/vendor_view') ?>">
                    </div>
                    <div region="center"                         
                         title="Detail Item"
                         href="<?php echo site_url('purchaseordereditorial/vendor_item_view') ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url() ?>js/purchaseordereditorial.js"></script>