<div id="proformainvoice_toolbar" style="padding-bottom: 0;">
    <form id="proformainvoice_search_form" onsubmit="return false" novalidate="">
        Search : 
        <input class="easyui-searchbox" name="q" data-options="prompt:'Input Value',searcher:function(value,name){proformainvoice_search()}" style="width:120px">
        <a href="javascript:void(0)" id="pi_tooltip_search" class="easyui-linkbutton" iconCls="icon-search" plain="true">Search</a>
        <script>
            $('#pi_tooltip_search').tooltip({
                content: $('<div></div>'),
                showEvent: 'click',
                hideEvent: 'none',
                showDelay: 10,
                modal: true,
                onUpdate: function (content) {
                    content.panel({
                        width: 450,
                        title: 'Proforma Invoice Search',
                        href: base_url + 'proformainvoice/load_tooltip_search_form'
                    });
                },
                onShow: function () {
                    var t = $(this);
                    t.tooltip('tip').unbind().bind('mouseenter', function () {
                        t.tooltip('show');
                    });
                }
            });
        </script>
        <?php
        if (in_array("Add", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="proformainvoice_add()">Add</a>
            <?php
        }if (in_array("Edit", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" id="proformainvoice_edit" onclick="proformainvoice_edit()">Edit</a>
            <?php
        }if (in_array("Delete", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" id="proformainvoice_delete" onclick="proformainvoice_delete()">Delete</a>
            <?php
        }if (in_array("Submit", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-submit" plain="true" id="proformainvoice_submit" onclick="proformainvoice_submit()">Submit >></a>
            <?php
        }if (in_array("Revision", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-revision" plain="true" id="proformainvoice_submit" onclick="proformainvoice_revision()"><< Revision</a>
            <?php
        }if (in_array("Download", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-download" plain="true" onclick="proformainvoice_download()">Download</a>
            <?php
        }if (in_array("Excel", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-excel" plain="true" onclick="proformainvoice_excel()">Excel</a>
            <?php
        }
        ?>
    </form>
</div>
<table id="proformainvoice" data-options="
       url:'<?php echo site_url('proformainvoice/get') ?>',
       method:'post',
       border:false,
       singleSelect:true,
       fit:true,
       rownumbers:true,
       fitColumns:false,
       pagination:true,
       striped:true,
       toolbar:'#proformainvoice_toolbar'">
    <thead>
        <tr>
            <th field="id" hidden="true" rowspan="2"></th>    
            <th colspan="10" align="center">Order Details</th>
            <th colspan="7" align="center">Client Detail</th>            
            <th colspan="8" align="center">Shipping Details</th>
        </tr>
        <tr>
            <th field="order_id" width="80" halign="center">Order ID</th>
            <th field="order_company_code" width="60" halign="center" >Order Company</th>
            <th field="remark" halign="center" width="200">Remark</th>
            <th field="salesman_name" halign="center" width="200">Salesman</th>
            <th field="order_confirm_date" width="78" align="center" formatter="myFormatDate">Confirm Date</th>
            <th field="order_invoice_date" width="78" align="center" formatter="myFormatDate">Invoice Date</th>
            <th field="order_target_ship_date" width="78" align="center" formatter="myFormatDate">Target Ship</th>
            <th field="down_payment" width="100" align="center" formatter="down_payment_format">Down Payment</th>
            <th field="vat" width="40" align="center">Vat(%)</th>
            <th field="payment_term" width="90" halign="center">Payment Term</th>
            <th field="order_contract_term" width="90" halign="center">Contract Term</th>
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
<script>
    $(function () {
        $('#proformainvoice').datagrid({
            rowStyler: function (index, row) {
                if (row.submit === 'f') {
                    return 'background-color:#ffcece;';
                }
            },
            onSelect: function (index, row) {
                $('#proformainvoice_product').datagrid('reload', {
                    proformainvoiceid: row.id
                });
                if (row.submit === 't') {
                    $('#proformainvoice_edit').linkbutton('disable');
                    $('#proformainvoice_submit').linkbutton('disable');
                    $('#proformainvoice_delete').linkbutton('disable');
                    $('#proformainvoice_product_add').linkbutton('disable');
                    $('#proformainvoice_product_edit').linkbutton('disable');
                    $('#proformainvoice_product_delete').linkbutton('disable');
                } else {
                    $('#proformainvoice_edit').linkbutton('enable');
                    $('#proformainvoice_submit').linkbutton('enable');
                    $('#proformainvoice_delete').linkbutton('enable');
                    $('#proformainvoice_product_add').linkbutton('enable');
                    $('#proformainvoice_product_edit').linkbutton('enable');
                    $('#proformainvoice_product_delete').linkbutton('enable');
                }
            }
        });
    });
    function down_payment_format(value, row) {
        var ss = '(' + value + '%) ';
        if (row.down_payment_date !== null) {
            ss += myFormatDate(row.down_payment_date, row);
        }
        return  ss;
    }
</script>
