/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


/* global base_url */

var rw_image_category_url = '';

function rw_image_category_search() {
    $('#rw_image_category').datagrid('reload', $('#rw_image_category_search_form').serializeObject());
}

function rw_image_category_input_form(type, title, row) {
    if ($('#rw_image_category_dialog')) {
        $('#bodydata').append("<div id='rw_image_category_dialog'></div>");
    }

    $('#rw_image_category_dialog').dialog({
        title: title,
        width: 400,
        height: 'auto',
        href: base_url + 'rw_image_category/input',
        modal: true,
        resizable: true,
        top: 60,
        buttons: [{
                text: 'Save',
                iconCls: 'icon-save',
                handler: function () {
                    rw_image_category_save();
                }
            }, {
                text: 'Close',
                iconCls: 'icon-remove',
                handler: function () {
                    $('#rw_image_category_dialog').dialog('close');
                }
            }],
        onLoad: function () {
            $(this).dialog('center');
            if (type === 'edit') {
                $('#rw_image_category_input_form').form('load', row);
            } else {
                $('#rw_image_category_input_form').form('clear');
            }
        }
    });
}

function rw_image_category_add() {
    rw_image_category_input_form('add', 'ADD Image Category', null);
    rw_image_category_url = base_url + 'rw_image_category/save';
}

function rw_image_category_edit() {
    var row = $('#rw_image_category').datagrid('getSelected');
    if (row !== null) {
        rw_image_category_input_form('edit', 'EDIT Image Category', row);
        rw_image_category_url = base_url + 'rw_image_category/update/' + row.id;
    } else {
        $.messager.alert('No Currency Selected', 'Please Select Currency', 'warning');
    }
}

function rw_image_category_save() {
    $('#rw_image_category_input_form').form('submit', {
        url: rw_image_category_url,
        onSubmit: function () {
            return $(this).form('validate');
        },
        success: function (content) {
            var result = eval('(' + content + ')');
            if (result.success) {
                $('#rw_image_category').datagrid('reload');
                $('#rw_image_category_dialog').dialog('close');
            } else {
                $.messager.alert('Error', result.msg, 'error');
            }
        }
    });
}

function rw_image_category_delete() {
    var row = $('#rw_image_category').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'Are you sure to remove this data?', function (r) {
            if (r) {
                $.post(base_url + 'rw_image_category/delete', {
                    id: row.id
                }, function (result) {
                    if (result.success) {
                        $('#rw_image_category').datagrid('reload');
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