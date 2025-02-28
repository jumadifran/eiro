<div style="width: 100%">
    <form id="proformainvoice_input_form" method="post" novalidate >
        <table width="99%">
            <tr valign="top">
                <td width="100%">  
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table_form">
                        <caption><span style="font-weight: bold;">Order Details</span></caption>
                        <tr>
                            <td width="30%"><strong>Order For Company</strong></td>
                            <td width="70%">
                                <input class="easyui-combobox" 
                                       id="company_id"
                                       name="company_id"
                                       url="<?php echo site_url('company/get') ?>"
                                       method="post"
                                       mode="remote"
                                       valueField="id"
                                       textField="name"
                                       style="width: 100%" 
                                       required="true"
                                       data-options="
                                       formatter: PI_Company_Format,
                                       onSelect:function(row){
                                       console.log(row.type)
                                       if(row.type==='Ppn'){
                                       $('#pi_vat').numberbox('setValue',10);
                                       }else{
                                       $('#pi_vat').numberbox('setValue',0);
                                       }
                                       }
                                       "/>
                                <script type="text/javascript">
                                    function PI_Company_Format(row) {
                                        return '<span style="font-weight:bold;">' + row.name + '</span><br/>' +
                                                '<span style="color:#888">Address: ' + row.address + '</span>';
                                    }
                                </script>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Salesman</strong></td>
                            <td>
                                <input type="text" 
                                       name="salesman_id" 
                                       class="easyui-combobox" 
                                       data-options="
                                       url: '<?php echo site_url('users/get') ?>',
                                       method: 'post',
                                       valueField: 'id',
                                       textField: 'name',
                                       panelHeight: '200'"
                                       style="width: 75%"
                                       required="true"
                                       mode="remote"/>
                            </td>
                        </tr>
                        <tr>
                            <td width="30%"><strong>Order Date</strong></td>
                            <td width="70%"><input name="order_confirm_date" class="easyui-datebox" style="width: 50%;"  data-options="formatter:myformatter,parser:myparser"></td>
                        </tr>
                        <tr>
                            <td><strong>Client PO No</strong></td>
                            <td><input name="client_po_no"  class="easyui-validatebox" style="width: 98%;"/></td>
                        </tr>
                        <tr>
                            <td><strong>Invoice Date</strong></td>
                            <td><input name="order_invoice_date" class="easyui-datebox" style="width: 50%;" required="true" data-options="formatter:myformatter,parser:myparser"></td>
                        </tr>                            
                        <tr>
                            <td><strong>Target Ship</strong></td>
                            <td><input name="order_target_ship_date" class="easyui-datebox" style="width: 50%;" data-options="formatter:myformatter,parser:myparser" style="width: 69%;"></td>
                        </tr>
                        <tr>
                            <td><strong>Down Payment</strong></td>
                            <td>
                                <input name="down_payment_date" id="" class="easyui-datebox" style="width: 100px;" data-options="formatter:myformatter,parser:myparser">
                                <input name="down_payment" class="easyui-numberbox" precision="2" decimalSeparator="." groupSeparator="," style="width: 50px" max="100"/> <strong>%</strong>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Vat</strong></td>
                            <td>
                                <input name="vat" id='pi_vat' class="easyui-numberbox" precision="2" decimalSeparator="." groupSeparator="," max="100" style="width: 50px"/> <strong>%</strong>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Payment Term</strong></td>
                            <td>
                                <select class="easyui-combobox" name='order_payment_term' required="true" panelHeight='70' style="width: 100px">
                                    <?php
                                    foreach ($payment_term as $result) {
                                        echo "<option value='" . $result->id . "'>" . $result->name . "</option>";
                                    }
                                    ?>
                                </select>
                            </td>

                        </tr>
                        <tr>
                            <td><strong>Contract Term</strong></td>
                            <td><input name="order_contract_term" class="easyui-textbox" style="width: 100%;"></td>
                        </tr>
                        <tr>
                            <td><strong>Bill To</strong></td>
                            <td>
                                <input class="easyui-combobox" 
                                       name="bank_account_id"
                                       url ="<?php echo site_url('bank_account/get') ?>"
                                       method= "post"
                                       valueField="id"
                                       textField="account_number"
                                       panelHeight= "200"
                                       id="bank_account_id"
                                       panelWidth="300"
                                       required="true"
                                       data-options="formatter:BankAccountFormat"
                                       style="width: 70%"
                                       mode="remote"/>
                                <script type="text/javascript">
                                    function BankAccountFormat(row) {
                                        return '<span style="font-weight:bold;">Bank : ' + row.bank_code + '</span><br/>' +
                                                '<span style="font-weight:bold;">Account No : ' + row.account_number + '</span><br/>' +
                                                '<span style="color:#888">On behalf of : ' + row.on_behalf_of + '</span>';
                                    }
                                </script>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr valign="top">
                <td width="100%">
                    <table width="100%" border="0" class="table_form" cellspacing="0" cellpadding="0">
                        <caption><span style="font-weight: bold;">Client Details</span></caption>
                        <tr>
                            <td width="30%"><strong>Client</strong></td>
                            <td width="70%">
                                <input class="easyui-combobox" 
                                       id="client_id"
                                       name="client_id"
                                       url="<?php echo site_url('client/get') ?>"
                                       method="post"
                                       mode="remote"
                                       valueField="id"
                                       textField="name"
                                       data-options="formatter: PI_Client_Format"
                                       style="width: 100%" 
                                       required="true"/>
                                <script type="text/javascript">
                                    function PI_Client_Format(row) {
                                        return '<span style="font-weight:bold;">' + row.name + ' - ' + row.code + '</span><br/>' +
                                                '<span style="font-weight:bold;">Company : ' + row.company + '</span><br/>' +
                                                '<span style="color:#888">Address: ' + row.address + '</span>';
                                    }
                                    $('#client_id').combobox({
                                        onSelect: function (row) {                                                //                                                alert('test');
                                            $('#client_company_name').val(row.company);
                                            $('#client_address').val(row.address);
                                            $('#client_country').val(row.country);
                                            $('#client_phone_fax').val(row.phone + '/' + row.fax);
                                            $('#client_email').val(row.email);
                                            $('#ship_to').combobox('setValue', row.id);
                                            $('#ship_phone_fax').val(row.phone + '/' + row.fax);
                                            $('#ship_address').val(row.address);
                                            $('#ship_phone_fax').val(row.phone + '/' + row.fax);
                                            $('#ship_email').val(row.email);
                                            $('#pi_currency_i').combobox('setValue', row.currency_id);
                                            $('#pi_ship_port_of_destination').val(row.country);
                                        }
                                    });
                                </script>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Currency</strong></td>
                            <td>
                                <input class="easyui-combobox" id='pi_currency_i'  name="currency_id"  data-options="
                                       url: '<?php echo site_url('currency/get') ?>',
                                       method: 'post',
                                       valueField: 'id',
                                       textField: 'code',
                                       panelHeight: 'auto'"
                                       style="width: 60px" 
                                       required="true">    
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Company Name</strong></td>
                            <td><input type="text" class="easyui-validatebox" name="client_company_name" id="client_company_name" style="width: 98%;"></td>
                        </tr>
                        <tr>
                            <td><strong>Address</strong></td>
                            <td><textarea name="client_address" id="client_address" class="easyui-validatebox" style="width: 98%;height: 35px"></textarea></td>
                        </tr>
                        <tr>
                            <td><strong>Country</strong></td>
                            <td><input class="easyui-validatebox" id="client_country" name="client_country" style="width: 98%;"></td>
                        </tr>
                        <tr>
                            <td><strong>Phone / Fax</strong></td>
                            <td>
                                <input name="client_phone_fax" id="client_phone_fax" class="easyui-textbox" style="width: 100px;">
                                <strong style="padding-right: 10px">Email</strong>
                                <input name="client_email" id="client_email" class="easyui-validatebox textbox" style="width: 100px;" data-options="validType:'email'">
                                <input type="hidden" name="client_contact_name" id="client_contact_name" style="width: 100%;">
                            </td>
                        </tr>                            
<!--                            <tr>
                            <td><strong>Contact Name</strong></td>
                            <td><input name="client_contact_name" id="client_contact_name" class="easyui-textbox" style="width: 100%;"></td>
                        </tr>-->
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table width="100%" border="0" class="table_form" cellspacing="0" cellpadding="0">
                        <caption><span style="font-weight: bold;">Shipping Details</span></caption>
                        <tr>
                            <td width="30%"><strong>Ship To </strong></td>
                            <td width="70%">                                    
                                <input class="easyui-combobox" 
                                       id="ship_to"
                                       name="ship_to"
                                       url="<?php echo site_url('client/get') ?>"
                                       method="post"
                                       mode="remote"
                                       valueField="id"
                                       textField="company"
                                       data-options="formatter: PI_Client_Format"
                                       style="width: 80%" 
                                       required="true"/>
                                <script type="text/javascript">
                                    $('#ship_to').combobox({
                                        onSelect: function (row) {
                                            $('#ship_phone_fax').val(row.phone + '/' + row.fax);
                                            $('#ship_address').val(row.address);
                                            $('#ship_email').val(row.email);
                                            $('#pi_ship_port_of_destination').val(row.country);
                                        }
                                    });
                                </script>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Address</strong></td>
                            <td><textarea name="ship_address" id="ship_address" class="easyui-validatebox" style="width: 98%;height: 35px"></textarea></td>
                        </tr>
                        <tr>
                            <td><strong>Phone / Fax</strong></td>
                            <td>
                                <input name="ship_phone_fax" id="ship_phone_fax" class="easyui-validatebox" style="width: 100px;">
                                <strong style="padding-right: 10px">Email</strong>
                                <input name="ship_email" id="ship_email" class="easyui-validatebox" style="width: 100px;" data-options="validType:'email'">
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Contact Name</strong></td>
                            <td><input name="ship_contact_name" class="easyui-textbox" style="width: 100%;"></td>
                        </tr>
                        <tr>
                            <td><strong>Port of Loading</strong></td>
                            <td>
                                <select class="easyui-combobox" name='ship_port_of_loading' style="width: 50%" panelHeight='auto'>
                                    <option value="Jakarta">Jakarta</option>
                                    <option value="Semarang">Semarang</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Port of Destination</strong></td>
                            <td>
                                <input name="ship_port_of_destination" id='pi_ship_port_of_destination' class="easyui-validatebox" style="width: 98%;">
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table width="100%" border="0" class="table_form" cellspacing="0" cellpadding="0">
                        <caption><span style="font-weight: bold;">Remark</span></caption>
                        <tr>
                            <td>
                                <textarea style="width: 99%;height: 40px" name="remark" class="easyui-validatebox"></textarea>

                            </td>
                        </tr>
                    </table>
                    <br/><br/>
                </td>
            </tr>
        </table>
    </form>
</div>