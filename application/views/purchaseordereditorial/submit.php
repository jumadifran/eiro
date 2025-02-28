<form id="pio_submit_form" onsubmit="return false;" class="table_form" method="POST">
    <table width="100%">
        <tr valign="top">
            <td width="25%"><strong>Approval 1</strong></td>
            <td width="75%">
                <input type="text" 
                       name="approval1" 
                       class="easyui-combobox" 
                       data-options="
                       url: '<?php echo site_url('users/get') ?>',
                       method: 'post',
                       valueField: 'id',
                       textField: 'name',
                       panelHeight: '200'"
                       style="width: 100%"
                       required="true"
                       mode="remote"/>
            </td>
        </tr>
        <tr>
            <td><strong>Approval 2</strong></td>
            <td>
                <input type="text" 
                       name="approval2" 
                       class="easyui-combobox" 
                       data-options="
                       url: '<?php echo site_url('users/get') ?>',
                       method: 'post',
                       valueField: 'id',
                       textField: 'name',
                       panelHeight: '200'"
                       style="width: 100%"
                       required="true"
                       mode="remote"/>
            </td>
        </tr>
        <tr>
            <td><strong>Approval 3</strong></td>
            <td>
                <input type="text" 
                       name="approval3" 
                       class="easyui-combobox" 
                       data-options="
                       url: '<?php echo site_url('users/get') ?>',
                       method: 'post',
                       valueField: 'id',
                       textField: 'name',
                       panelHeight: '200'"
                       style="width: 100%"
                       required="true"
                       mode="remote"/>
            </td>
        </tr>
    </table>
</form>