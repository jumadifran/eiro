/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/* global base_url */
var pi_url = '';

function proformainvoice_search() {
    $('#proformainvoice').datagrid('reload', $('#proformainvoice_search_form').serializeObject());
}

function  pi_tooltip_search() {
    $('#proformainvoice_search_form').form('clear');
    $('#proformainvoice').datagrid('reload', $('#pi_tooltip_form_search').serializeObject());
}
function proformainvoice_input_form(type, title, row) {
    if ($('#proformainvoice_dialog')) {
        $('#bodydata').append("<div id='proformainvoice_dialog'></div>");
    }
    $('#proformainvoice_dialog').dialog({
        title: title,
        width: 500,
        height: 600,
        href: base_url + 'proformainvoice/input',
        modal: true,
        resizable: false,
        shadow: false,
        maximizable: true,
        collapsible: true,
        buttons: [{
                text: 'Save',
                iconCls: 'icon-save',
                handler: function () {
                    proformainvoice_save();
                }
            }, {
                text: 'Close',
                iconCls: 'icon-remove',
                handler: function () {
                    $('#proformainvoice_dialog').dialog('close');
                }
            }],
        onLoad: function () {
            $(this).dialog('center');
            if (type === 'edit') {
                $('#proformainvoice_input_form').form('load', row);
            } else {
                $('#proformainvoice_input_form').form('clear');
            }

        }
    });
}


function proformainvoice_add() {
    proformainvoice_input_form('add', 'NEW PROFORMA INVOICE');
    pi_url = base_url + 'proformainvoice/save/0';
}

function proformainvoice_save() {
    if ($('#proformainvoice_input_form').form('validate')) {
        $.post(pi_url, $('#proformainvoice_input_form').serializeObject(), function (content) {
            var result = eval('(' + content + ')');
            if (result.success) {
                $('#proformainvoice').datagrid('reload');
                $('#proformainvoice_dialog').dialog('close');
            } else {
                $.messager.alert('Error', result.msg, 'error');
            }
        });
    }
}

function proformainvoice_edit() {
    var row = $('#proformainvoice').datagrid('getSelected');
    if (row !== null) {
        proformainvoice_input_form('edit', 'EDIT PROFORMA INVOICE', row);
    } else {
        $.messager.alert('No Customer Selected', 'Please Select Customer', 'warning');
    }
    pi_url = base_url + 'proformainvoice/save/' + row.id;
}

function proformainvoice_delete() {
    var row = $('#proformainvoice').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'Are you sure to remove this data', function (r) {
            if (r) {
                $.post(base_url + 'proformainvoice/delete', {
                    id: row.id
                }, function (result) {
                    if (result.success) {
                        $('#proformainvoice').datagrid('reload');
                    } else {
                        $.messager.alert('Error', result.msg, 'error');
                    }
                }, 'json');
            }
        });
    } else {
        $.messager.alert('No Proforma Invoice Selected', 'Please Select Proforma Invoice', 'warning');
    }
}


function proformainvoice_submit() {
    var row = $('#proformainvoice').datagrid('getSelected');
    if (row !== null) {
        var row_detail = $('#proformainvoice_product').datagrid('getRows');
//        console.log(row_detail);
        if (row_detail.length > 0) {
            $.get(base_url + 'proformainvoice/get_pi_ots_allocated_stock/' + row.id, function (content) {
                var temp = parseInt(content);
                if (temp > 0) {
                    $.messager.alert('System interupted', 'Some Product uncomplete allocated stock', 'warning');
                } else {
                    $.messager.confirm('Confirm', 'Are you sure to submit this order?', function (r) {
                        if (r) {
                            $.post(base_url + 'proformainvoice/submit', {
                                id: row.id
                            }, function (result) {
                                if (result.success) {
                                    $('#proformainvoice').datagrid('reload');
                                } else {
                                    $.messager.alert('Error', result.msg, 'error');
                                }
                            }, 'json');
                        }
                    });
                }
            });
        } else {
            $.messager.alert('No Products', 'Please Input Products', 'warning');
        }
    } else {
        $.messager.alert('No Proforma Invoice Selected', 'Please Select Proforma Invoice', 'warning');
    }
}

function proformainvoice_revision() {
    var row = $('#proformainvoice').datagrid('getSelected');
    if (row !== null) {
        if (row.poe_id === null) {
            $.messager.confirm('Confirm', 'Are you sure to revision this order?', function (r) {
                if (r) {
                    $.post(base_url + 'proformainvoice/revision', {
                        id: row.id
                    }, function (result) {
                        if (result.success) {
                            $('#proformainvoice').datagrid('reload');
                        } else {
                            $.messager.alert('Error', result.msg, 'error');
                        }
                    }, 'json');
                }
            });
        } else {
            $.messager.alert('Already have P.O Editorial', 'Unable to revision because already have P.O Editorial', 'error');
        }
    } else {
        $.messager.alert('No Proforma Invoice Selected', 'Please Select Proforma Invoice', 'warning');
    }
}

function proformainvoice_product_search() {
    var data = $('#proformainvoice_product_search_form').serializeObject();
    $.extend(data, {proformainvoiceid: $('#proformainvoice').datagrid('getSelected').id});
    $('#proformainvoice_product').datagrid('reload', data);
}

function proformainvoice_input_product_form(type, title, row, proformainvoice_id) {
    if ($('#proformainvoice_dialog')) {
        $('#bodydata').append("<div id='proformainvoice_dialog'></div>");
    }

    $('#proformainvoice_dialog').dialog({
        title: title,
        width: 500,
        height: 'auto',
        href: base_url + 'proformainvoice/product_input',
        modal: true,
        resizable: true,
        buttons: [{
                text: 'Save',
                iconCls: 'icon-save',
                handler: function () {
                    proformainvoice_product_save(proformainvoice_id);
                }
            }, {
                text: 'Close',
                iconCls: 'icon-remove',
                handler: function () {
                    $('#proformainvoice_dialog').dialog('close');
                }
            }],
        onLoad: function () {
            $(this).dialog('center');
            if (type === 'edit') {
                $('#proformainvoice_product_input_form').form('load', row);

                var material_temp = row.material_id.replace(/[({}]/g, "");
                var material = material_temp.split(',');
                $('#pi_material_id').combobox('setValues', material);

                if (row.color_id !== null) {
                    var color_temp = row.color_id.replace(/[({}]/g, "");
                    var color = color_temp.split(',');

                    $('#color_id').combobox('setValues', color);
                }

            } else {
                $('#proformainvoice_product_input_form').form('clear');
                $('#pi_category').combobox('setValue', 0);
                $('#pi_product_allocation_type').combobox('setValue', 1);
            }
        }
    });
}

function proformainvoice_product_add() {
    var row = $('#proformainvoice').datagrid('getSelected');
    if (row !== null) {
        proformainvoice_input_product_form('add', 'ADD PRODUCT', null, row.id)
        pi_url = base_url + 'proformainvoice/product_save/' + row.id + '/0';
    } else {
        $.messager.alert('No Product Selected', 'Please Select Product', 'warning');
    }
}

function proformainvoice_product_edit() {
    var row = $('#proformainvoice_product').datagrid('getSelected');
    if (row !== null) {
        proformainvoice_input_product_form('edit', 'EDIT PRODUCT', row, row.proformainvoice_id)
        pi_url = base_url + 'proformainvoice/product_save/' + row.proformainvoice_id + '/' + row.id;
    } else {
        $.messager.alert('No Proforma Invoice Selected', 'Please Select Proforma Invoice', 'warning');
    }
}

function proformainvoice_product_save(pi_id) {
    if ($('#proformainvoice_product_input_form').form('validate')) {
        $.post(pi_url, $('#proformainvoice_product_input_form').serializeObject(), function (content) {
            var result = eval('(' + content + ')');
            if (result.success) {
                proformainvoice_product_search();
//                $('#proformainvoice_product').datagrid('reload', {
//                    proformainvoiceid: pi_id
//                });
                $('#proformainvoice_dialog').dialog('close');
            } else {
                $.messager.alert('Error', result.msg, 'error');
            }
        });
    }
}

function proformainvoice_product_delete() {
    var row = $('#proformainvoice_product').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'Are you sure you want to remove this data?', function (r) {
            if (r) {
                $.post(base_url + 'proformainvoice/product_delete', {
                    id: row.id
                }, function (result) {
                    console.log(result)
                    if (result.success) {
                        $('#proformainvoice_product').datagrid('reload', {
                            proformainvoiceid: row.proformainvoice_id
                        });
                    } else {
                        $.messager.alert('Error', result.msg, 'error');
                    }
                }, 'json');
            }
        });
    } else {
        $.messager.alert('No Product Selected', 'Please Select Product', 'warning');
    }
}

function proformainvoice_download() {
    var row = $('#proformainvoice').datagrid('getSelected');
    if (row !== null) {
        open_target('post', base_url + 'proformainvoice/download', {
            id: row.id
        }, '_blank');
    } else {
        $.messager.alert('No Proforma Invoice Selected', 'Please Select Proforma Invoice', 'warning');
    }
}

function proformainvoice_excel() {
    var row = $('#proformainvoice').datagrid('getSelected');
    if (row !== null) {
        open_target('post', base_url + 'proformainvoice/excel', {
            id: row.id
        }, 'box_iframe');
    } else {
        $.messager.alert('No Proforma Invoice Selected', 'Please Select Proforma Invoice', 'warning');
    }
}

function proformainvoice_product_component_delete(id, pi_id) {

    $.messager.confirm('Confirm', 'Are you sure you want to remove this component?', function (r) {
        if (r) {
            $.post(base_url + 'proformainvoice/product_component_delete', {
                id: id
            }, function (result) {
                console.log(result)
                if (result.success) {
                    $('#sub_grid' + pi_id).datagrid('reload');
                } else {
                    $.messager.alert('Error', result.msg, 'error');
                }
            }, 'json');
        }
    });
}

function pi_product_source(pi_product_id, products_id, width, depth, height, source_type) {
    if ($('#pi_product_source_dialog')) {
        $('#bodydata').append("<div id='pi_product_source_dialog' style='border:none'></div>");
    }
    $('#pi_product_source_dialog').dialog({
        title: 'Product Source',
        width: '98%',
        height: '98%',
        href: base_url + 'proformainvoice/product_source/' + pi_product_id + '/' + products_id + '/' + width + '/' + depth + '/' + height + '/' + source_type,
        modal: true,
        border: false,
        resizable: true,
        shadow: false,
        maximizable: true,
        collapsible: true,
        buttons: [{
                text: 'Close',
                iconCls: 'icon-remove',
                handler: function () {
                    $('#pi_product_source_dialog').dialog('close');
                }
            }],
        onLoad: function () {
            $(this).dialog('center');
        },
        onClose: function () {
            $('#proformainvoice_product').datagrid('reload');
        }
    });
}

function pi_allocated_stock(pi_product_id) {
    var rows = $('#pi_product_stock_list').datagrid('getSelections');
    if (rows.length > 0) {
        var serial_number = new Array();
        for (var i = 0; i < rows.length; i++) {
            serial_number.push(rows[i].serial_number);
        }
        $.get(base_url + 'proformainvoice/get_ots_allocated/' + pi_product_id, function (content) {
            var ct = parseInt(content);
            if (ct >= serial_number.length) {
                $.messager.confirm('Confirm', 'Are you sure to allocated selections stock?', function (r) {
                    if (r) {
                        $.post(base_url + 'proformainvoice/allocated_stock', {
                            pi_product_id: pi_product_id,
                            serial_number: serial_number
                        }, function (content) {
                            console.log(content);
                            $('#pi_product_stock_allocated').datagrid('reload');
                            $('#pi_product_stock_list').datagrid('reload');
                        });
                    }
                });
            } else {
                $.messager.alert('System Interupted', 'Out of outstanding allocated stock<br>Ots = ' + ct, 'warning');
            }
        });

    } else {
        $.messager.alert('No Products Selected', 'Please Select Products', 'warning');
    }
}

function pi_allocated_stock_for_re_production(pi_product_id) {
    var row = $('#proformainvoice').datagrid('getSelected');
    if (row.submit === 'f') {
        var rows = $('#pi_product_stock_list').datagrid('getSelections');
        if (rows.length > 0) {
            var serial_number = new Array();
            for (var i = 0; i < rows.length; i++) {
                serial_number.push(rows[i].serial_number);
            }
            if ($('#pi_allocated_stock_for_re_production_dialog')) {
                $('#bodydata').append("<div id='pi_allocated_stock_for_re_production_dialog' style='border:none'></div>");
            }
            $('#pi_allocated_stock_for_re_production_dialog').dialog({
                title: 'Allocated Stock For Re-Production',
                width: '400',
                height: 'auto',
                href: base_url + 'proformainvoice/stock_starting_point_production',
                modal: true,
                border: false,
                resizable: true,
                shadow: false,
                maximizable: true,
                collapsible: true,
                buttons: [
                    {
                        text: 'Save',
                        iconCls: 'icon-save',
                        handler: function () {
                            if ($('#pi_stock_starting_point_form').form('validate')) {
                                $.messager.confirm('Confirm', 'Are you sure to allocated selections stock?', function (r) {
                                    if (r) {
                                        var production_process_id = $('#pi_stock_starting_point_form input[name="production_process_id"]').val();
                                        $.post(base_url + 'proformainvoice/allocated_stock', {
                                            pi_product_id: pi_product_id,
                                            serial_number: serial_number,
                                            production_process_id: production_process_id
                                        }, function (content) {
                                            var result = eval('(' + content + ')');
                                            if (result.success) {
                                                $('#pi_product_stock_allocated').datagrid('reload');
                                                $('#pi_product_stock_list').datagrid('reload');
                                                $('#pi_allocated_stock_for_re_production_dialog').dialog('close');
                                            } else {
                                                $.messager.alert('Error', result.msg, 'error');
                                            }
                                        });
                                    }
                                });
                            }
                        }
                    },
                    {
                        text: 'Close',
                        iconCls: 'icon-remove',
                        handler: function () {
                            $('#pi_allocated_stock_for_re_production_dialog').dialog('close');
                        }
                    }],
                onLoad: function () {
                    $(this).dialog('center');
                }
            });

        } else {
            $.messager.alert('No Products Selected', 'Please Select Products', 'warning');
        }
    } else {
        $.messager.alert('System interupted', 'Unable to change stock allocated,<br/> P.I. already submitted', 'error');
    }
}

function pi_disallocated_stock(pi_product_id) {
    var rows = $('#pi_product_stock_allocated').datagrid('getSelections');
    if (rows.length > 0) {
        var serial_number = new Array();
        for (var i = 0; i < rows.length; i++) {
            serial_number.push(rows[i].serial_number);
        }

        $.messager.confirm('Confirm', 'Are you sure to return selections stock?', function (r) {
            if (r) {
                $.post(base_url + 'proformainvoice/disallocated_stock', {
                    pi_product_id: pi_product_id,
                    serial_number: serial_number
                }, function (content) {
                    console.log(content);
                    $('#pi_product_stock_allocated').datagrid('reload');
                    $('#pi_product_stock_list').datagrid('reload');
                });
            }
        });
    } else {
        $.messager.alert('No Products Selected', 'Please Select Products', 'warning');
    }
}