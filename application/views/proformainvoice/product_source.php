<div class="easyui-layout" fit="true" border="false">
    <div region="west"
         collapsible="false"
         style="width: 45%;border-left:none;border-top: none;border-right: none"
         href="<?php echo site_url('proformainvoice/stock_view') ?>"
         data-options="
         queryParams:{
         product_id: <?php echo $product_id ?>,
         width: <?php echo $width ?>,
         depth: <?php echo $depth ?>,
         height: <?php echo $height ?>
         }"></div>
    <div region="center">
        <center>
            <br/><br/><br/>
            <?php
            if ($source_type === "2") {
                ?>
                <button style="cursor: pointer;width: 90%;text-align: center" onclick="pi_allocated_stock(<?php echo $pi_product_id ?>)">>></button><br/><br/><br/><br/>
                <?php
            }
            if($source_type === "3"){
                ?>
                <button style="cursor: pointer;width: 90%" onclick="pi_allocated_stock_for_re_production(<?php echo $pi_product_id ?>)">>></button><br/><br/><br/><br/>
                <?php
            }
            ?>
            <button style="cursor: pointer;width: 90%" onclick="pi_disallocated_stock(<?php echo $pi_product_id ?>)">&nbsp;&nbsp;&nbsp;<<&nbsp;&nbsp;&nbsp;</button>
        </center>
    </div>
    <div region="east"
         collapsible="false"  
         style="width: 45%;border-left:none;border-top: none;border-right: none"
         href="<?php echo site_url('proformainvoice/product_stock_allocated') ?>"
         data-options="
         queryParams:{
         pi_product_id: <?php echo $pi_product_id ?>
         }
         "></div>
</div>
