<table id="poe_outstanding_approve" data-options="
       url:'<?php echo site_url('purchaseordereditorial/get_outstanding_approve') ?>',
       method:'post',
       border:false,
       singleSelect:true,
       fit:true,
       rownumbers:true,
       fitColumns:false,
       pagination:true,
       pageSize:30,
       pageList: [30, 50, 70, 90, 110],">
    <thead>
        <tr>
            <th field="order_id" width="20%" halign="center">Order ID</th>
            <th field="client_code" width="30%" halign="center" formatter="poeOtsApvClientFormat">Client ID</th>
            <th field="order_confirm_date" width="20%" align="center" formatter="myFormatDate">Confirm Date</th>
            <th field="id" width="30%" align="center" formatter="poe_ots_aprv_act">Action</th>
        </tr>
    </thead>
</table>
<script type="text/javascript">
    $('#poe_outstanding_approve').datagrid({
    });
    function poeOtsApvClientFormat(val, row) {
        return '<b>' + val + '</b> - ' + row.client_company;
    }
    function poe_ots_aprv_act(val, row) {
        var temp = '';
        var user_id = '<?php echo $this->session->userdata("id") ?>';
        
//        console.log('user_id ' +user_id+' row.approval1 '+row.approval1+' row.approval2 '+row.approval2+' row.approval3 '+row.approval3);
        
        if (user_id === row.approval1 && (row.approval1_status === '0' || row.approval1_status === '2')) {
            temp += '<button type="button" class="button_style" onclick="poe_approve(' + row.id + ',1,\'approval1\',1,\'' + row.email_approval2 + '\',' + row.approval2 + ')">Approve</button>' +
                    '<button type="button" class="button_style" onclick="poe_approve(' + row.id + ',2,\'approval1\',1)">Pending</button>';
        } else {
            if (user_id === row.approval2 && (row.approval2_status === '0' || row.approval2_status === '2')) {
                temp += '<button type="button" class="button_style" onclick="poe_approve(' + row.id + ',1,\'approval2\',1,\'' + row.email_approval3 + '\',' + row.approval3 + ')">Approve</button>' +
                        '<button type="button" class="button_style" onclick="poe_approve(' + row.id + ',2,\'approval2\',1)">Pending</button>';
            } else {
//                console.log('in 3');
                if (user_id === row.approval3) {
//                    console.log('in app 3');
                    temp += '<button type="button" class="button_style" onclick="poe_approve(' + row.id + ',1,\'approval3\',1,\'-\',0)">Approve</button>' +
                            '<button type="button" class="button_style" onclick="poe_approve(' + row.id + ',2,\'approval3\',1)">Pending</button>';
//                    console.log(temp);
                }
            }
        }
        console.log(temp);
        return temp;

    }
</script>