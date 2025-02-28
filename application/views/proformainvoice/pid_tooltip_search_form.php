<div style="width: 100%;padding: 5px;">
    <form class="table_form" id="pi_tooltip_form_search" onsubmit="return false;">
        <table width="100%">
            <tr>
                <td width="25%"  style="padding-right: 5px;"><strong>Order ID</strong></td>
                <td width="75%">
                    <input type="text" class="easyui-validatebox" name="order_id" style="width: 50%"/>
                </td>
            </tr>
            <tr>
                <td width="25%" style="padding-right: 5px;"><strong>Date</strong></td>
                <td width="75%">
                    <input name="start_date" prompt="Start Date" class="easyui-datebox" style="width: 100px;" data-options="formatter:myformatter,parser:myparser"> - 
                    <input name="end_date" prompt="End Date" class="easyui-datebox" style="width: 100px;" data-options="formatter:myformatter,parser:myparser">
                </td>
            </tr>
            <tr>
                <td width="25%"><strong>Client</strong></td>
                <td width="75%">
                    <input class="easyui-combobox"
                           name="client_id"
                           url="<?php echo site_url('client/get') ?>"
                           method="post"
                           mode="remote"
                           valueField="id"
                           textField="name"
                           data-options="formatter: PI_Client_Format_Tooltip"
                           style="width:300px"/>
                    <script type="text/javascript">
                        function PI_Client_Format_Tooltip(row) {
                            return '<span style="font-weight:bold;">' + row.name + ' - ' + row.code + '</span><br/>' +
                                    '<span style="font-weight:bold;">Company : ' + row.company + '</span><br/>' +
                                    '<span style="color:#888">Address: ' + row.address + '</span>';
                        }
                    </script>
                </td>
            </tr>
            <tr>
                <td style="border: none;">&nbsp;</td>
                <td style="border: none;">
                    <a href="javascript:void(0)" style="margin: 5px 0 0;width: 80px;" iconCls="icon-search" onclick="pi_tooltip_search()" class="easyui-linkbutton">Search</a>
                    <a href="javascript:void(0)" onclick="$('#pi_tooltip_form_search').form('clear');
                            pi_tooltip_search()" style="margin: 5px 5px 0 0;width: 80px" iconCls="icon-clear" class="easyui-linkbutton" >Reset</a>
                    <a href="javascript:void(0)" style="margin: 5px 5px 0 0;width: 80px" id="pi_tooltip_btn_close" 
                       onclick="$('#pi_tooltip_search').tooltip('hide')" class="easyui-linkbutton" iconCls="icon-cancel">Close</a>
                </td>
            </tr>
        </table>
    </form>
</div>
