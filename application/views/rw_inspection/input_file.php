<?php
//echo phpinfo();
//echo 'rw_inspectionid='.$rw_inspection_id.' dan idrw_inspection detal='.$id;
?>
<form id="rw_inspection_product_input_form"  method="post" novalidate class="table_form" enctype="multipart/form-data">
    <table width="100%" border="0">
        <tr>
            <td><strong>File</strong></td>
            <td>
                <input type='file' name='image-1' accept='image/*' capture='camera' onchange='rw_imagePreview2(this,1)' required=true>
                <div id='preview1'></div>
            </td>
        </tr>
        
    </table>        
</form>


<script>
    function rw_imagePreview2(fileInput, no) {
        if (fileInput.files && fileInput.files[0]) {
            var fileReader = new FileReader();
            fileReader.onload = function (event) {
                $('#preview1').html('<img src="' + event.target.result + '" width="150" height="auto"/>');
            };
            fileReader.readAsDataURL(fileInput.files[0]);
        }
    }
</script>