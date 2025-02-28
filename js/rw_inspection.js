/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/* global base_url */

var rw_inspection_url = '';

function rw_inspection_search() {
    $('#rw_inspection').datagrid('reload', $('#po_search_form').serializeObject());
}

function rw_inspection_detail_search() {
    var row = $('#rw_inspection').datagrid('getSelected');
    var postData = $('#rw_inspection_detail_search_form').serializeObject();
    $.extend(postData, {rw_inspectionid: row.id});
    $('#rw_inspection_detail').datagrid('reload', postData);
}

function rw_inspection_add() {
    rw_inspection_input_form('add', 'New Inspection');
    rw_inspection_url = base_url + 'rw_inspection/save/0';
}
function rw_inspection_edit() {
    var row = $('#rw_inspection').datagrid('getSelected');
    rw_inspection_input_form('edit', 'New Inspection', row);
    rw_inspection_url = base_url + 'rw_inspection/save/' + row.id;

}

function rw_inspection_input_form(type, title, row) {
    if ($('#rw_inspection_dialog')) {
        $('#bodydata').append("<div id='rw_inspection_dialog'></div>");
    }
    $('#rw_inspection_dialog').dialog({
        title: title,
        width: 350,
        height: 'auto',
        href: base_url + 'rw_inspection/input',
        modal: true,
        resizable: false,
        shadow: false,
        maximizable: true,
        collapsible: true,
        buttons: [{
                text: '',
                iconCls: 'icon-save',
                handler: function () {
                    rw_inspection_save();
                }
            }, {
                text: '',
                iconCls: 'icon-cancel',
                handler: function () {
                    $('#rw_inspection_dialog').dialog('close');
                }
            }],
        onLoad: function () {
            $(this).dialog('center');
            if (type === 'edit') {
                $('#rw_inspection_input_form').form('load', row);
            } else {
                $('#rw_inspection_input_form').form('clear');
            }

        }
    });
}
function rw_inspection_save() {
    if ($('#rw_inspection_input_form').form('validate')) {
        $.post(rw_inspection_url, $('#rw_inspection_input_form').serializeObject(), function (content) {
            var result = eval('(' + content + ')');
            if (result.success) {
                $('#rw_inspection').datagrid('reload');
                $('#rw_inspection_dialog').dialog('close');
            } else {
                $.messager.alert('Error', result.msg, 'error');
            }
        });
    }
}

function rw_inspection_release() {
    var row = $('#rw_inspection').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Release P.O', 'With the release PO then the barcode will be automatically created, and you can not change the PO anymore<br/><br/><center>Are you sure?</center>', function (r) {
            if (r) {
                $.post(base_url + 'rw_inspection/release', {id: row.id}, function (result) {
                    if (result.success) {
                        $('#rw_inspection_release').linkbutton('disable');
                        $('#rw_inspection').datagrid('reload');
                    } else {
                        $.messager.alert('Error', result.msg, 'error');
                    }
                }, 'json');
            }
        });
    } else {
        $.messager.alert('No Purchase Order Selected', 'Please Select Purchase Order', 'warning');
    }
}

function print_rw_inspection(type) {
    var row = $('#rw_inspection').datagrid('getSelected');
    if (row !== null) {
        if (type === 'single')
            open_target('POST', base_url + 'rw_inspection/prints', {id: row.id}, '_blank');
        else
            open_target('POST', base_url + 'rw_inspection/print_summary', {id: row.id}, '_blank');
    } else {
        $.messager.alert('No Inspection List Selected', 'Please Select Inspection List', 'warning');
    }
}

function rw_inspection_download() {
    var row = $('#rw_inspection').datagrid('getSelected');
    if (row !== null) {
        open_target('post', base_url + 'rw_inspection/download', {
            id: row.id
        }, '_blank');
    } else {
        $.messager.alert('No Purchase Order Selected', 'Please Select Purchase Order', 'warning');
    }
}

function rw_inspection_download_all_by_order_id() {
    var row = $('#rw_inspection').datagrid('getSelected');
    if (row !== null) {
        open_target('post', base_url + 'rw_inspection/download_all_by_order_id', {
            pi_id: row.pi_id
        }, '_blank');
    } else {
        $.messager.alert('No Purchase Order Selected', 'Please Select Purchase Order', 'warning');
    }
}
//-------------------------
function rw_inspection_delete() {
    var row = $('#rw_inspection').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'Are you sure?', function (r) {
            if (r) {
                $.post(base_url + 'rw_inspection/delete', {
                    id: row.id
                }, function (result) {
                    if (result.success) {
                        $('#rw_inspection').datagrid('reload');
                        $('#rw_inspection_detail').datagrid('reload');
                        $('#po_editorial_create_real_po').linkbutton('disable');
                    } else {
                        $.messager.alert('Error', result.msg, 'error');
                    }
                }, 'json');
            }
        });
    } else {
        $.messager.alert('No Purchase Order Selected', 'Please Select Purchase Order', 'warning');
    }
}

function rw_inspection_product_add(idrow) {
    var row = $('#rw_inspection_detail').datagrid('getSelected');
    //alert (row.rw_inspection_id);
    if (row !== null) {
        rw_inspection_input_product_form('add', 'ADD IMAGE', null, row.id, row.rw_inspection_id,row.rw_image_category_id)
        rw_inspection_url = base_url + 'rw_inspection/product_save/' + row.rw_inspection_id + '/' + row.id+'/'+row.rw_image_category_id;
    } else {
        $.messager.alert('No Product Selected', 'Please Select Product', 'warning');
    }
}
function rw_inspection_product_delete() {
    var row = $('#rw_inspection_detail').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'Are you sure?', function (r) {
            if (r) {
                $.post(base_url + 'rw_inspection/product_delete', {
                    id: row.id
                }, function (result) {
                    if (result.success) {
                        $('#rw_inspection_detail').datagrid('reload');
                    } else {
                        $.messager.alert('Error', result.msg, 'error');
                    }
                }, 'json');
            }
        });
    } else {
        $.messager.alert('No Purchase Order Product Selected', 'Please Select Purchase Order', 'warning');
    }
}
function rw_inspection_product_save(rw_inspection_id, id,rw_image_category_id) {
    $('#rw_inspection_product_input_form').form('submit', {
        url: rw_inspection_url,
        onSubmit: function () {
            return $(this).form('validate');
        },
        success: function (content) {
            var result = eval('(' + content + ')');
            if (result.success) {
                $('#rw_inspection_detail').datagrid('reload');
                $('#rw_inspection_dialog').dialog('close');
            } else {
                $.messager.alert('Error', result.msg, 'error');
            }
        }
    });
}

function rw_inspection_input_product_form(type, title, row, id, rw_inspection_id,rw_image_category_id) {
    if ($('#rw_inspection_dialog')) {
        $('#bodydata').append("<div id='rw_inspection_dialog'></div>");
    }
    $('#rw_inspection_dialog').dialog({
        title: title,
        width: 300,
        height: 'auto',
        href: base_url + 'rw_inspection/product_input/' + rw_inspection_id + '/' + id+ '/' + rw_image_category_id,
        modal: true,
        resizable: true,
        overflow: 'auto',
        top: 5,
        buttons: [{
                text: 'Save',
                iconCls: 'icon-save',
                handler: function () {
                    rw_inspection_product_save(rw_inspection_id, id,rw_image_category_id);
                }
            }, {
                text: 'Close',
                iconCls: 'icon-remove',
                handler: function () {
                    $('#rw_inspection_dialog').dialog('close');
                }
            }],
        onLoad: function () {
            $(this).dialog('center');
            $('#rw_inspection_product_input_form').form('load', row);
        }
    });
}

function rw_inspection_product_view_detail(id) {
    var row = $('#rw_inspection_detail').datagrid('getSelected');
    if ($('#rw_inspection_image_detail_dialog')) {
        $('#bodydata').append("<div id='rw_inspection_image_detail_dialog'></div>");
    }
    $('#rw_inspection_image_detail_dialog').dialog({
        title: 'Detail Description',
        width: 300,
        height: 'auto',
        href: base_url + 'rw_inspection/product_image_detail/' + row.rw_inspection_id + '/' + id+ '/' + row.rw_image_category_id,
        modal: true,
        resizable: true,
        overflow: 'auto',
        top: 5,
        buttons: [{
                text: 'Close',
                iconCls: 'icon-remove',
                handler: function () {
                    $('#rw_inspection_image_detail_dialog').dialog('close');
                }
            }],
        onLoad: function () {
            $(this).dialog('center');
            $('#rw_inspection_product_input_detail_form').form('load', row);
        }
    });
}

function rw_inspection_submit() {
    var row = $('#rw_inspection').datagrid('getSelected');
    var row_rw_inspection_detail = $('#rw_inspection_detail').datagrid('getRows');
    //alert(arr.length); 
    if ((row !== null) && (row_rw_inspection_detail.length>0)){
        $.messager.confirm('Submit Inspection', 'After submited you can not change the Inspection anymore<br/><br/><center>Are you sure?</center>', function (r) {
            if (r) {
                $.post(base_url + 'rw_inspection/submit', {id: row.id,purchaseorder_item_id:row.purchaseorder_item_id}, function (result) {
                    if (result.success) {
                    $('#rw_inspection_submit_id').linkbutton('disable');
                    $('#rw_inspection_edit_id').linkbutton('disable');
                    $('#rw_inspection_delete_id').linkbutton('disable');
                        $('#rw_inspection').datagrid('reload');
                        $('#rw_inspection_detail').datagrid('reload');
                    } else {
                        $.messager.alert('Error', result.msg, 'error');
                    }
                }, 'json');
            }
        });
    } else {
        $.messager.alert('Inspection Warning', 'No Inspection or no item to be submitted', 'warning');
    }
}
