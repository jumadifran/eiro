<div id="po_editorial_proformainvoice_toolbar" style="padding-bottom: 0;">
    Search
    <input class="easyui-validatebox"
           style="width: 140px"
           name="q"
           onkeyup="if (event.keyCode === 13) {
                       po_editorial_search();
                   }"
           />
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" id='' onclick="po_editorial_search()">Find</a>
    <?php
    if (in_array("Add", $action)) {
        ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" id='' onclick="po_editorial_add()">Add</a>
        <?php
    }if (in_array("Delete", $action)) {
        ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" id='po_editorial_delete' onclick="po_editorial_delete()">Delete</a>
        <?php
    }if (in_array("Submit", $action)) {
        ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-submit" plain="true" id='po_editorial_submit' onclick="po_editorial_submit()">Submit>></a>
        <?php
    }if (in_array("Create P.O", $action)) {
        ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-generate" plain="true" id='po_editorial_create_real_po' onclick="po_editorial_create_real_po()">Create P.O.</a>
        <?php
    }if (in_array("Revision", $action)) {
        ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" id='po_editorial_revision' onclick="po_editorial_revision()"><i class="glyphicon glyphicon-step-backward"></i> Revision</a>
        <?php
    }
    ?>

</div>
<table id="po_editorial_proformainvoice" data-options="
       url:'<?php echo site_url('purchaseordereditorial/get') ?>',
       method:'post',
       border:false,
       singleSelect:true,
       fit:true,
       rownumbers:true,
       fitColumns:false,
       pagination:true,
       striped:true,
       nowrap:false,
       idField:'id',
       toolbar:'#po_editorial_proformainvoice_toolbar'">
    <thead>

        <tr>
            <th field="order_id" width="80" halign="center">Order ID</th>
            <th field="order_company_code" width="60" halign="center" >Order Company</th>
            <th field="client_code" width="160" halign="center" formatter="poeClientFormat">Client ID</th>
            <th field="order_confirm_date" width="78" align="center" formatter="myFormatDate">Confirm Date</th>
            <th field="order_invoice_date" width="78" align="center" formatter="myFormatDate">Invoice Date</th>
            <th field="status" width="120" halign="center" formatter="poeStatusFormat">Status</th>
            <th field="approval1" width="160" halign="center" formatter="poeApproval1Format">Approval 1</th>
            <th field="approval2" width="160" halign="center" formatter="poeApproval2Format">Approval 2</th>
            <th field="approval3" width="160" halign="center" formatter="poeApproval3Format">Approval 3</th>
            <th field="archive" width="120" halign="center" formatter="poeArchiveFormat">Archive</th>
            <th field="rev_version" width="50" align="center">Rev</th>
            <th field="remark" width="180" halign="center">Remark</th>
        </tr>
    </thead>
</table>
<script>
    $(function() {
        $('#po_editorial_proformainvoice').datagrid({
            rowStyler: function(index, row) {
                if (row.status === '0') {
                    return 'background-color:#ffcece;';
                }
                if (row.status === '1' && (row.approval1_status === '0' || row.approval2_status === '0' || row.approval3_status === '0')) {
                    return 'background-color:#f6ee96;';
                }
                if (row.status === '1' && (row.approval1_status === '1' || row.approval2_status === '1' || row.approval3_status === '1')) {
                    return 'background-color:#c4f8b8;';
                }
            },
            onSelect: function(index, row) {
                $('#po_editorial_proformainvoice_product').datagrid('reload', {
                    proformainvoiceid: row.proformainvoice_id
                });
                $('#po_editorial_vendor').datagrid('reload', {
                    po_editorial_id: row.id
                });

                if (row.status === '0') {
                    $('#po_editorial_delete').linkbutton('enable');
                    $('#po_editorial_component_vendor_edit_price').linkbutton('enable');
                    $('#purchaseordereditorial_vendor_edit').linkbutton('enable');
                    $('#po_editorial_create_real_po').linkbutton('disable');
                    $('#po_editorial_submit').linkbutton('enable');
                } else if (row.status === '1') {
                    $('#po_editorial_submit').linkbutton('disable');
                    $('#po_editorial_delete').linkbutton('disable');
                    if (row.approval1_status === '2' || row.approval2_status === '2') {
                        $('#po_editorial_component_vendor_edit_price').linkbutton('enable');
                        $('#purchaseordereditorial_vendor_edit').linkbutton('enable');
                    } else {
                        $('#po_editorial_component_vendor_edit_price').linkbutton('disable');
                        $('#purchaseordereditorial_vendor_edit').linkbutton('disable');
                    }
                    if (row.approval1_status === '1' && row.approval2_status === '1') {
                        $('#po_editorial_create_real_po').linkbutton('enable');
                    } else {
                        $('#po_editorial_create_real_po').linkbutton('disable');
                    }
                } else {
                    $('#po_editorial_submit').linkbutton('disable');
                    $('#po_editorial_create_real_po').linkbutton('disable');
                    $('#po_editorial_delete').linkbutton('disable');
                }
            }
        });
    });

    function poeClientFormat(val, row) {
        return '<b>' + val + '</b> - ' + row.client_company;
    }
    function poeApproval1Format(value, row) {
        var temp = '';
        var user_id = '<?php echo $this->session->userdata("id") ?>';
        if (row.approval1 !== null) {
            temp = row.name_approval1;
            if (row.approval1_status === '1') {
                temp += '<br/>Approve At : ' + row.approval1_time.substring(0, 16);
            } else if (row.approval1_status === '2') {
                temp += '<br/>Pending At : ' + row.approval1_time.substring(0, 16);
            }
            if (row.status === '1') {
                if (user_id === row.approval1 && (row.approval1_status === '0' || row.approval1_status === '2')) {
                    temp += '<br/><button type="button" class="button_style" onclick="poe_approve(' + row.id + ',1,\'approval1\',0,\'' + row.email_approval2 + '\',' + row.approval2 + ')">Approve</button>' +
                            '<button type="button" class="button_style" onclick="poe_approve(' + row.id + ',2,\'approval1\',0)">Pending</button>';
                } else {
                    if (row.approval1_status === '0') {
                        temp += '<br/><font color="blue">Outstanding</font>';
                    }
                }
            }
        }
        return temp;
    }

    function poeApproval2Format(value, row) {
        var temp = '';
        if (row.status === '1' || row.status === '2') {
            if (row.approval1 !== null) {
                var user_id = '<?php echo $this->session->userdata("id") ?>';
//            console.log(user_id);
                temp = row.name_approval2;
                if (row.approval1_status === '1') {
                    if (row.approval2_status === '1') {
                        temp += '<br/>Approve At : ' + row.approval2_time.substring(0, 16);
                    } else if (row.approval2_status === '2') {
                        temp += '<br/>Pending At : ' + row.approval2_time.substring(0, 16);
                    }

                    if (row.status === '1') {
                        if (user_id === row.approval2 && (row.approval2_status === '0' || row.approval2_status === '2')) {
                            temp += '<br/><button type="button" class="button_style" onclick="poe_approve(' + row.id + ',1,\'approval2\',0,\'' + row.email_approval3 + '\',' + row.approval3 + ')">Approve</button>' +
                                    '<button type="button" class="button_style" onclick="poe_approve(' + row.id + ',2,\'approval2\',0)">Pending</button>';
                        } else {
                            if (row.approval2_status === '0') {
                                temp += '<br/><font color="blue">Outstanding</font>';
                            }
                        }
                    }
                } else {
                    temp += '<br/><font color="#966e02">Waiting..</font>';
                }
            }
        }
        return temp;
    }

    function poeApproval3Format(value, row) {
        var temp = '';
        if (row.status === '1' || row.status === '2') {
            if (row.approval2 !== null) {
                var user_id = '<?php echo $this->session->userdata("id") ?>';
//            console.log(user_id);
                temp = row.name_approval3;
                if (row.approval2_status === '1') {
                    if (row.approval3_status === '1') {
                        temp += '<br/>Approve At : ' + row.approval3_time.substring(0, 16);
                    } else if (row.approval2_status === '2') {
                        temp += '<br/>Pending At : ' + row.approval3_time.substring(0, 16);
                    }

                    if (row.status === '1') {
                        if (user_id === row.approval3 && (row.approval3_status === '0' || row.approval3_status === '2')) {
                            temp += '<br/><button type="button" class="button_style" onclick="poe_approve(' + row.id + ',1,\'approval3\',0,\'-\',0)">Approve</button>' +
                                    '<button type="button" class="button_style" onclick="poe_approve(' + row.id + ',2,\'approval3\',0)">Pending</button>';
                        } else {
                            if (row.approval3_status === '0') {
                                temp += '<br/><font color="blue">Outstanding</font>';
                            }
                        }
                    }
                } else {
                    temp += '<br/><font color="#966e02">Waiting..</font>';
                }
            }
        }
        return temp;
    }

    function poeStatusFormat(value, row) {
        var temp = 'Draft';
        if (value === '1') {
            temp = 'Approval Process';
            if (row.approval1_status === '0') {
                temp = 'Outstanding For : <br/>' + row.name_approval1;
            } else if (row.approval1_status === '2') {
                temp = 'Pending By : ' + row.name_approval1;
            } else {
                if (row.approval2_status === '0') {
                    temp = 'Outstanding For : <br/>' + row.name_approval2;
                } else if (row.approval2_status === '2') {
                    temp = 'Pending By : ' + row.name_approval2;
                } else {
                    if (row.approval3_status === '0') {
                        temp = 'Outstanding For : <br/>' + row.name_approval3;
                    } else if (row.approval3_status === '2') {
                        temp = 'Pending By : ' + row.name_approval3;
                    } else {
                        temp = 'Ready to Create P.O';
                    }
                }
            }
        } else if (value === '2') {
            temp = 'Generated P.O';
        }
        return temp;
    }

    function poeArchiveFormat(val, row) {
        return '<a href="javascript:void(0)" style="text-decoration:none" onclick="poe_view_comment(' + row.id + ')">Comment (' + row.count_comment + ')<a/><br/>' +
                '<a href="javascript:void(0)" style="text-decoration:none">Attachment (0)<a/>';
    }
</script>

