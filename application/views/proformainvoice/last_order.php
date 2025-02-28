<table id="pi_last_order" data-options="
       url:'<?php echo site_url('proformainvoice/get/last_ten') ?>',
       method:'post',
       border:false,
       singleSelect:true,
       fit:true,
       pageSize:10,
       pageList: [10],
       rownumbers:true,
       fitColumns:false,
       remoteSort:true,
       multiSort:true,
       pagination:true">
    <thead>
        <tr>
            <th field="id" hidden="true" rowspan="2"></th>    
            <th colspan="8" align="center">Order Details</th>
            <th colspan="7" align="center">Client Detail</th>            
            <th colspan="8" align="center">Shipping Details</th>
            <th field="remark" rowspan="2" halign="center" width="200">Remark</th>
        </tr>
        <tr>
            <th field="order_id" width="80" halign="center">Order ID</th>
            <th field="order_confirm_date" width="78" align="center" formatter="myFormatDate">Confirm Date</th>
            <th field="order_invoice_date" width="78" align="center" formatter="myFormatDate">Invoice Date</th>
            <th field="order_target_ship_date" width="78" align="center" formatter="myFormatDate">Target Ship</th>
            <th field="client_code" width="60" halign="center">Client ID</th>
            <th field="client_company_name" width="100" halign="center">Company Name</th>
            <th field="client_address" width="150" halign="center">Address</th>
            <th field="client_country" width="100" halign="center">Country</th>
            <th field="client_phone_fax" width="80" halign="center">Phone / Fax</th>
            <th field="client_email" width="80" halign="center">Email</th>
            <th field="client_contact_name" width="100" halign="center">Contact Name</th>            
            <th field="client_shipto_code" width="100" halign="center">Ship To</th>
            <th field="ship_address" width="150" halign="center">Address</th>
            <th field="ship_phone_fax" width="80" halign="center">Phone / Fax</th>
            <th field="ship_email" width="80" halign="center">Email</th>  
            <th field="ship_contact_name" width="100" halign="center">Contact Name</th>  
            <th field="ship_port_of_loading" width="100" halign="center">Port of Loading</th>  
            <th field="ship_port_of_destination" width="110" halign="center">Port of Destination</th>  
            <th field="ship_country" width="90" halign="center">Country</th>
        </tr>
    </thead>
</table>
<script type = "text/javascript">
    $('#pi_last_order').datagrid({
    });
</script>