/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


/* global base_url */


function po_editorial_search() {
    $('#po_editorial_proformainvoice').datagrid('reload', {
        q: $('#po_editorial_proformainvoice_toolbar input[name=q]').val()
    });
}

function purchaseordereditorial_vendor_search() {
    var data = $('#po_editorial_vendor_search_form').serializeObject();
    $.extend(data, {po_editorial_id: $('#po_editorial_proformainvoice').datagrid('getSelected').id});
    $('#po_editorial_vendor').datagrid('reload', data);
}

function po_editorial_proformainvoice_product_search() {
    var data = $('#po_editorial_proformainvoice_product_search_form').serializeObject();
    $.extend(data, {proformainvoiceid: $('#po_editorial_proformainvoice').datagrid('getSelected').proformainvoice_id});
    $('#po_editorial_proformainvoice_product').datagrid('reload', data);
}

function purchaseordereditorial_vendor_edit() {
    var row = $('#po_editorial_vendor').datagrid('getSelected');

    if (row !== null) {
        var flag = (row.vendor_flag === '1' ? 'iw' : '');
        if ($('#po_editorial_dialog')) {
            $('#bodydata').append("<div id='po_editorial_dialog'></div>");
        }
        $('#po_editorial_dialog').dialog({
            title: 'Edit Vendor Information',
            width: 500,
            height: 'auto',
            href: base_url + 'purchaseordereditorial/vendor_edit/' + flag,
            modal: true,
            resizable: false,
            shadow: false,
            maximizable: true,
            collapsible: true,
            buttons: [{
                    text: 'Save',
                    iconCls: 'icon-save',
                    handler: function() {
                        if ($('#po_editorial_vendor_edit_form').form('validate')) {
                            $.post(base_url + 'purchaseordereditorial/vendor_update', $('#po_editorial_vendor_edit_form').serializeObject(), function(content) {
                                var result = eval('(' + content + ')');
                                if (result.success) {
                                    $('#po_editorial_vendor').datagrid('reload');
                                    $('#po_editorial_dialog').dialog('close');
                                } else {
                                    $.messager.alert('Error', result.msg, 'error');
                                }
                            });
                        }
                    }
                }, {
                    text: 'Close',
                    iconCls: 'icon-remove',
                    handler: function() {
                        $('#po_editorial_dialog').dialog('close');
                    }
                }],
            onLoad: function() {
                $(this).dialog('center');
                $('#po_editorial_vendor_edit_form').form('load', row);
            }
        });
    } else {
        $.messager.alert('No Vendor Selected', 'Please Select Vendor', 'warning');
    }
}

function po_editorial_vendor_item_delete() {
    var row = $('#po_editorial_vendor_item').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'Are you sure you want to remove this item?', function(r) {
            if (r) {
                $.post(base_url + 'purchaseordereditorial/vendor_item_delete', {
                    id: row.proformainvoice_product_component_id
                }, function(result) {
                    console.log(result)
                    if (result.success) {
                        $('#po_editorial_vendor_item').datagrid('reload');
                    } else {
                        $.messager.alert('Error', result.msg, 'error');
                    }
                }, 'json');
            }
        });
    } else {
        $.messager.alert('No Item Selected', 'Please Select Item', 'warning');
    }
}


function po_editorial_add() {
    if ($('#po_editorial_dialog')) {
        $('#bodydata').append("<div id='po_editorial_dialog'></div>");
    }
    $('#po_editorial_dialog').dialog({
        title: 'Create PO Editorial',
        width: 400,
        height: 'auto',
        href: base_url + 'purchaseordereditorial/add',
        modal: true,
        resizable: false,
        shadow: false,
        buttons: [{
                text: 'Save',
                iconCls: 'icon-save',
                handler: function() {
                    if ($('#po_editorial_add_form').form('validate')) {
                        $.post(base_url + 'purchaseordereditorial/save', $('#po_editorial_add_form').serializeObject(), function(content) {
                            console.log(content);
                            var result = eval('(' + content + ')');
                            if (result.success) {
                                $('#po_editorial_dialog').dialog('close');
                                $('#po_editorial_proformainvoice').datagrid('reload');
                            } else {
                                $.messager.alert('Error', result.msg, 'error');
                            }
                        });
                    }
                }
            }, {
                text: 'Close',
                iconCls: 'icon-remove',
                handler: function() {
                    $('#po_editorial_dialog').dialog('close');
                }
            }],
        onLoad: function() {
            $(this).dialog('center');
        }
    });
}

function po_editorial_delete() {
    var row = $('#po_editorial_proformainvoice').datagrid('getSelected');
    if (row !== null) {
        if (row.status === '0') {
            $.messager.confirm('Confirm', 'Are you sure?', function(r) {
                if (r) {
                    $.post(base_url + 'purchaseordereditorial/delete', {
                        id: row.id
                    }, function(result) {
                        console.log(result.success);
                        if (result.success) {
                            $('#po_editorial_proformainvoice').datagrid('reload');
                            $('#po_editorial_proformainvoice_product').datagrid('reload');
                            $('#po_editorial_vendor_item').datagrid('reload');
                            $('#po_editorial_vendor').datagrid('reload');
                            $('#po_editorial_product_component_vendor').datagrid('reload');
                        } else {
                            $.messager.alert('Error', result.msg, 'error');
                        }
                    }, 'json');
                }
            });
        } else {
            $.messager.alert('Action Interup', 'Unable to delete', 'error');
        }
    } else {
        $.messager.alert('No Order Selected', 'Please Select Order!', 'warning');
    }
}

function po_editorial_create_real_po() {
    var row = $('#po_editorial_proformainvoice').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'Are you sure?', function(r) {
            if (r) {
                $.post(base_url + 'purchaseorder/create_from_po_editorial', {
                    id: row.id
                }, function(result) {
                    console.log(result.success);
                    if (result.success) {
                        addTab('Purchase Order', 'purchaseorder');
                        $('#purchaseorder').datagrid('reload');
                        $('#po_editorial_create_real_po').linkbutton('disable');
                    } else {
                        $.messager.alert('Error', result.msg, 'error');
                    }
                }, 'json');
            }
        });
    } else {
        $.messager.alert('No Order Selected', 'Please Select Order!', 'warning');
    }
}

function po_editorial_revision() {
    var row = $('#po_editorial_proformainvoice').datagrid('getSelected');
    console.log(row);
    if (row !== null) {
        if (row.status === "2") {
            $.messager.alert('Already Generate P.O', 'Please remove all P.O according to selected row!', 'warning');
        } else {
            $.messager.confirm('Confirm', 'This order will set to  Draft status.<br/>Are you sure?', function(r) {
                if (r) {
                    $.post(base_url + 'purchaseordereditorial/set_to_draft', {
                        id: row.id
                    }, function(result) {
                        console.log(result.success);
                        if (result.success) {
                            $('#po_editorial_proformainvoice').datagrid('reload');
                        } else {
                            $.messager.alert('Error', result.msg, 'error');
                        }
                    }, 'json');
                }
            });
        }
    } else {
        $.messager.alert('No Order Selected', 'Please Select Order!', 'warning');
    }
}

function po_editorial_submit() {
    var row = $('#po_editorial_proformainvoice').datagrid('getSelected');
    if (row !== null) {
        if ($('#po_editorial_dialog')) {
            $('#bodydata').append("<div id='po_editorial_dialog'></div>");
        }
        $('#po_editorial_dialog').dialog({
            title: 'Submit PO Editorial',
            width: 400,
            height: 'auto',
            href: base_url + 'purchaseordereditorial/submit/' + row.id,
            modal: true,
            resizable: false,
            shadow: false,
            buttons: [{
                    text: 'Save',
                    iconCls: 'icon-save',
                    handler: function() {
                        $.messager.progress({
                            title: 'Please waiting',
                            msg: 'Loading....'
                        });
                        $('#pio_submit_form').form('submit', {
                            url: base_url + 'purchaseordereditorial/do_submit/' + row.id,
                            onSubmit: function() {
                                var isValid = $(this).form('validate');
                                if (!isValid) {
                                    $.messager.progress('close');	// hide progress bar while the form is invalid
                                }
                                return isValid;	// return false will stop the form submission
                            },
                            success: function(content) {
                                $.messager.progress('close');
                                var result = eval('(' + content + ')');
                                if (result.success) {
                                    $('#po_editorial_proformainvoice').datagrid('reload');
                                    $('#po_editorial_dialog').dialog('close');
                                    $('#po_editorial_submit').linkbutton('disable');
                                } else {
                                    $.messager.alert('Error', result.msg, 'error');
                                }
                            }
                        });
                    }
                }, {
                    text: 'Close',
                    iconCls: 'icon-remove',
                    handler: function() {
                        $('#po_editorial_dialog').dialog('close');
                    }
                }],
            onLoad: function() {
                $(this).dialog('center');
            }
        });
    } else {
        $.messager.alert('No P.O Selected', 'Please Select P.O!', 'warning');
    }
}

function poe_approve(id, status, who, flag, next_mail, next_approval_user_id) {
    if (status === 1) {
        $.messager.confirm('Confirm', 'Are you sure?', function(r) {
            if (r) {
                $.messager.progress({
                    title: 'Please waiting',
                    msg: 'Loading...'
                });
                $.post(base_url + 'purchaseordereditorial/approve', {
                    id: id,
                    who: who,
                    status: status,
                    next_mail: next_mail,
                    next_approval_user_id: next_approval_user_id
                }, function(result) {
                    $.messager.progress('close');
                    if (result.success) {
                        if (flag === 0) {
                            $('#po_editorial_proformainvoice').datagrid('reload');
                        } else {
                            $('#poe_outstanding_approve').datagrid('reload');
                        }
                    } else {
                        $.messager.alert('Error', result.msg, 'error');
                    }

                }, 'json');
            }
        });
    } else {
        if ($('#po_editorial_dialog')) {
            $('#bodydata').append("<div id='po_editorial_dialog'></div>");
        }
        $('#po_editorial_dialog').dialog({
            title: 'Pending PO Editorial',
            width: 400,
            height: 'auto',
            href: base_url + 'purchaseordereditorial/pending',
            modal: true,
            resizable: false,
            shadow: false,
            buttons: [{
                    text: 'Save',
                    iconCls: 'icon-save',
                    handler: function() {
                        $('#poe_pending_form').form('submit', {
                            url: base_url + 'purchaseordereditorial/do_pending',
                            onSubmit: function() {
                                return $(this).form('validate');
                            },
                            success: function(content) {
                                console.log(content);
                                var result = eval('(' + content + ')');
                                if (result.success) {
                                    $('#po_editorial_dialog').dialog('close');
                                    $('#po_editorial_proformainvoice').datagrid('reload');
                                } else {
                                    $.messager.alert('Error', result.msg, 'error');
                                }
                            }
                        });
                    }
                }, {
                    text: 'Close',
                    iconCls: 'icon-remove',
                    handler: function() {
                        $('#po_editorial_dialog').dialog('close');
                    }
                }],
            onLoad: function() {
                $(this).dialog('center');
                $('#poe_id').val(id);
                $('#poe_who').val(who);
                $('#poe_status').val(status);
            }
        });
    }
}

function poe_view_comment(id) {
    if ($('#po_editorial_dialog')) {
        $('#bodydata').append("<div id='po_editorial_dialog'></div>");
    }
    $('#po_editorial_dialog').dialog({
        title: 'Pending PO Comments',
        width: 400,
        height: 'auto',
        href: base_url + 'purchaseordereditorial/view_comment/' + id,
        modal: true,
        resizable: false,
        shadow: false,
        buttons: [{
                text: 'Close',
                iconCls: 'icon-remove',
                handler: function() {
                    $('#po_editorial_dialog').dialog('close');
                }
            }],
        onLoad: function() {
            $(this).dialog('center');
        },
        onClose: function() {
            $('#po_editorial_proformainvoice').datagrid('reload');
        }
    });
}

function poe_comment_save(id) {
    $('#poe_comment_form').form('submit', {
        url: base_url + 'purchaseordereditorial/save_comment',
        onSubmit: function(param) {
            param.po_editorial_id = id;
            return $(this).form('validate');
        },
        success: function(content) {
            console.log(content);
            var result = eval('(' + content + ')');
            if (result.success) {
                $('#poe_comment_form').form('clear');
                $('#poe_comment_list').panel('open').panel('refresh');
            } else {
                $.messager.alert('Error', result.msg, 'error');
            }
        }
    });
}

function po_editorial_component_vendor_edit_price() {
    var row = $('#po_editorial_product_component_vendor').datagrid('getSelected');
    if (row !== null) {
        if ($('#po_editorial_dialog')) {
            $('#bodydata').append("<div id='po_editorial_dialog'></div>");
        }
        $('#po_editorial_dialog').empty();
        $('#po_editorial_dialog').dialog({
            title: 'Edit Price Component',
            width: 450,
            height: 'auto',
            href: base_url + 'purchaseordereditorial/component_edit_price/' + row.product_allocation_type,
            modal: true,
            resizable: false,
            shadow: false,
            buttons: [
                {
                    text: 'Save',
                    iconCls: 'icon-save',
                    handler: function() {
                        $('#component_edit_price_form').form('submit', {
                            url: base_url + 'purchaseordereditorial/component_update_price/0',
                            onSubmit: function() {
                                return $(this).form('validate');
                            },
                            success: function(content) {
                                console.log(content);
                                var result = eval('(' + content + ')');
                                if (result.success) {
                                    $('#po_editorial_dialog').dialog('close');
                                    $('#po_editorial_product_component_vendor').datagrid('reload');
                                } else {
                                    $.messager.alert('Error', result.msg, 'error');
                                }
                            }
                        });
                    }
                }, {
                    text: 'Close',
                    iconCls: 'icon-remove',
                    handler: function() {
                        $('#po_editorial_dialog').dialog('close');
                    }
                }],
            onLoad: function() {
                $(this).dialog('center');
                if (row.product_allocation_type === '2') {
                    $('#poe_comp_price').numberbox({required: false});
                }
                $('#component_edit_price_form').form('load', row);
            }
        });
    } else {
        $.messager.alert('No Component Selected', 'Please Select Component', 'warning');
    }
}

function po_editorial_component_vendor_edit_price2() {
    var row = $('#po_editorial_vendor_item').datagrid('getSelected');
    if (row !== null) {
        if ($('#po_editorial_dialog')) {
            $('#bodydata').append("<div id='po_editorial_dialog'></div>");
        }
        $('#po_editorial_dialog').empty();
        $('#po_editorial_dialog').dialog({
            title: 'Edit Price Component',
            width: 450,
            height: 'auto',
            href: base_url + 'purchaseordereditorial/component_edit_price/' + row.product_allocation_type,
            modal: true,
            resizable: false,
            shadow: false,
            buttons: [
                {
                    text: 'Save',
                    iconCls: 'icon-save',
                    handler: function() {
                        $('#component_edit_price_form').form('submit', {
                            url: base_url + 'purchaseordereditorial/component_update_price/1',
                            onSubmit: function() {
                                return $(this).form('validate');
                            },
                            success: function(content) {
                                console.log(content);
                                var result = eval('(' + content + ')');
                                if (result.success) {
                                    $('#po_editorial_dialog').dialog('close');
                                    $('#po_editorial_product_component_vendor').datagrid('reload');
                                    $('#po_editorial_vendor_item').datagrid('reload');
                                } else {
                                    $.messager.alert('Error', result.msg, 'error');
                                }
                            }
                        });
                    }
                }, {
                    text: 'Close',
                    iconCls: 'icon-remove',
                    handler: function() {
                        $('#po_editorial_dialog').dialog('close');
                    }
                }],
            onLoad: function() {
                $(this).dialog('center');
                if (row.product_allocation_type === '2') {
                    $('#poe_comp_price').numberbox({required: false});
                }
                $('#component_edit_price_form').form('load', row);
                $('#cep_item_code89').textbox('readonly', true);
                $('#cep_vendor_id89').parent().parent().remove();
            }
        });
    } else {
        $.messager.alert('No Component Selected', 'Please Select Component', 'warning');
    }
}

function po_editorial_component_vendor_delete() {
    var row = $('#po_editorial_product_component_vendor').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'These data will be permanently deleted and cannot be recovered.<br/>Are you sure?', function(r) {
            if (r) {
                $.post(base_url + 'purchaseordereditorial/component_vendor_delete', {
                    id: row.id
                }, function(result) {
                    console.log(result.success);
                    if (result.success) {
                        $('#po_editorial_product_component_vendor').datagrid('reload');
                    } else {
                        $.messager.alert('Error', result.msg, 'error');
                    }
                }, 'json');
            }
        });
    } else {
        $.messager.alert('No Component Selected', 'Please Select Component', 'warning');
    }
}