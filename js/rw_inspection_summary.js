/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


/* global base_url */

var rw_inspection_summary_url = '';

function rw_inspection_summary_search() {
    $('#rw_inspection_summary').datagrid('reload', $('#rw_inspection_summary_search_form').serializeObject());
}

function rw_inspection_summary_input_form(type, title, row) {
    if ($('#rw_inspection_summary_dialog')) {
        $('#bodydata').append("<div id='rw_inspection_summary_dialog'></div>");
    }

    $('#rw_inspection_summary_dialog').dialog({
        title: title,
        width: 400,
        height: 'auto',
        href: base_url + 'rw_inspection_summary/input',
        modal: true,
        resizable: true,
        top: 60,
        buttons: [{
                text: 'Save',
                iconCls: 'icon-save',
                handler: function () {
                    rw_inspection_summary_save();
                }
            }, {
                text: 'Close',
                iconCls: 'icon-remove',
                handler: function () {
                    $('#rw_inspection_summary_dialog').dialog('close');
                }
            }],
        onLoad: function () {
            $(this).dialog('center');
            if (type === 'edit') {
                $('#rw_inspection_summary_input_form').form('load', row);
            } else {
                $('#rw_inspection_summary_input_form').form('clear');
            }
        }
    });
}

function rw_inspection_summary_add() {
    rw_inspection_summary_input_form('add', 'ADD Image Category', null);
    rw_inspection_summary_url = base_url + 'rw_inspection_summary/save';
}

function rw_inspection_summary_edit() {
    var row = $('#rw_inspection_summary').datagrid('getSelected');
    if (row !== null) {
        rw_inspection_summary_input_form('edit', 'EDIT Image Category', row);
        rw_inspection_summary_url = base_url + 'rw_inspection_summary/update/' + row.id;
    } else {
        $.messager.alert('No Currency Selected', 'Please Select Currency', 'warning');
    }
}

function rw_inspection_summary_save() {
    $('#rw_inspection_summary_input_form').form('submit', {
        url: rw_inspection_summary_url,
        onSubmit: function () {
            return $(this).form('validate');
        },
        success: function (content) {
            var result = eval('(' + content + ')');
            if (result.success) {
                $('#rw_inspection_summary').datagrid('reload');
                $('#rw_inspection_summary_dialog').dialog('close');
            } else {
                $.messager.alert('Error', result.msg, 'error');
            }
        }
    });
}

function rw_inspection_summary_delete() {
    var row = $('#rw_inspection_summary').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'Are you sure to remove this data?', function (r) {
            if (r) {
                $.post(base_url + 'rw_inspection_summary/delete', {
                    id: row.id
                }, function (result) {
                    if (result.success) {
                        $('#rw_inspection_summary').datagrid('reload');
                    } else {
                        $.messager.alert('Error', result.msg, 'error');
                    }
                }, 'json');
            }
        });
    } else {
        $.messager.alert('No Currency Selected', 'Please Select Currency', 'warning');
    }
}
function print_rw_inspection2(type) {
    var row = $('#rw_inspection_summary').datagrid('getSelected');
    if (row !== null) {
        if (type === 'single')
            open_target('POST', base_url + 'rw_inspection/prints', {id: row.id}, '_blank');
        else
            open_target('POST', base_url + 'rw_inspection/print_summary', {id: row.id}, '_blank');
    } else {
        $.messager.alert('No Inspection List Selected', 'Please Select Inspection List', 'warning');
    }
}