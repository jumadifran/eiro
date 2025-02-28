/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/* global base_url */


/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


var commercial_invoice_url = '';

function commercial_invoice_search() {

}


function commercial_invoice_input_form(type, title, row) {
    if ($('#commercial_invoice_dialog')) {
        $('#bodydata').append("<div id='commercial_invoice_dialog'></div>");
    }
    $('#commercial_invoice_dialog').dialog({
        title: title,
        width: 400,
        height: 'auto',
        href: base_url + 'commercial_invoice/input',
        modal: true,
        resizable: false,
        shadow: false,
        buttons: [{
                text: 'Save',
                iconCls: 'icon-save',
                handler: function () {
                    $('#commercial_invoice_form').form('submit', {
                        url: base_url + 'commercial_invoice/save/0',
                        onSubmit: function () {
                            return $(this).form('validate');
                        },
                        success: function (content) {
                            console.log(content);
                            var result = eval('(' + content + ')');
                            if (result.success) {
                                $('#commercial_invoice_dialog').dialog('close');
                                $('#commercial_invoice').datagrid('reload');
                            } else {
                                $.messager.alert('Error', result.msg, 'error');
                            }
                        }
                    });
                }
            }, {
                text: 'Close',
                iconCls: 'icon-remove',
                handler: function () {
                    $('#commercial_invoice_dialog').dialog('close');
                }
            }],
        onLoad: function () {
            $(this).dialog('center');
            if (type === 'edit') {
                $('#commercial_invoice_form').form('load', row);
            } else {
                $('#commercial_invoice_form').form('clear');
            }

        }
    });
}

function commercial_invoice_save() {
    $('#commercial_invoice_form').form('submit', {
        url: commercial_invoice_url,
        onSubmit: function () {
            return $(this).form('validate');
        },
        success: function (content) {
            console.log(content);
            var result = eval('(' + content + ')');
            if (result.success) {
                $('#commercial_invoice_dialog').dialog('close');
                $('#commercial_invoice').datagrid('reload');
            } else {
                $.messager.alert('Error', result.msg, 'error');
            }
        }
    });
}

function commercial_invoice_add() {
    commercial_invoice_input_form('add', 'Add Commercial Invoice', null);
    commercial_invoice_url = base_url + 'commercial_invoice/save/0';
}

function commercial_invoice_edit() {
    var row = $('#commercial_invoice').datagrid('getSelected');
    if (row !== null) {
        commercial_invoice_input_form('edit', 'Edit Commercial Invoice', row);
        commercial_invoice_url = base_url + 'commercial_invoice/save/' + row.id;
    } else {
        $.messager.alert('Color not Selected', 'Please Select commercial_invoice', 'warning');
    }
}

function commercial_invoice_delete() {
    var row = $('#commercial_invoice').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'Are you sure to remove this data?', function (r) {
            if (r) {
                $.post(base_url + 'commercial_invoice/delete', {
                    id: row.id
                }, function (result) {
                    console.log(result.success);
                    if (result.success) {
                        $('#commercial_invoice').datagrid('reload');
                    } else {
                        $.messager.alert('Error', result.msg, 'error');
                    }
                }, 'json');
            }
        });
    } else {
        $.messager.alert('Color not Selected', 'Select commercial_invoice', 'warning');
    }
}