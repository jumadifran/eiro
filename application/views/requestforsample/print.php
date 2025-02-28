<html>
    <head>
        <title>Request For Sample</title>
        <style>
            @page {size: A4 landscape ; margin: 10px; }
            *{
                margin: 0;
                padding: 0;
                font-size: 12px;
            }
            body{
                margin: 2px;
                font-family: "Arial";

            }

            table.data thead th,table.data tbody td{
                padding: 2px;
            }
        </style>
    </head>
    <body>
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td style="border-bottom: 1px solid #000" colspan="3">
                    <span style="font-size: 18px;font-weight: bold;"><?php echo $rfs->company_name ?></span><br/>
                    <span><?php echo nl2br($rfs->company_address) ?></span>
                </td>
            </tr>
            <tr>
                <td width="35%">&nbsp;</td>
                <td width="30%" align="center">
                    <div style="font-size: 16px;font-weight: bold;border-bottom: 1px #000 solid;margin-top: 10px">REQUEST FOR SAMPLE</div>
                    <div style="font-size: 14px;font-weight: bold;">NO: <?php echo $rfs->number ?></div>
                </td>
                <td width="35%">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="3" width="100%">
                    <div style="margin-top: 10px;">
                        <table width="100%" border="0">
                            <tr valign="top">
                                <td width="15%"><strong>Date</strong></td>
                                <td width="1%"><strong>:</strong></td>
                                <td width="84%"><?php echo date('d/m/Y', strtotime($rfs->date)) ?></td>
                            </tr>
                            <tr valign="top">
                                <td><strong>Vendor</strong></td>
                                <td><strong>:</strong></td>
                                <td>
                                    <span style="font-size: 12px;font-weight: bold;"><?php echo $rfs->vendor_name ?></span><br/>
                                    <span><?php echo nl2br($rfs->vendor_address); ?></span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table><br/>
        <table width="100%" cellpadding="0" cellspacing="0" class="data">
            <thead>
                <tr>
                    <th width="2%" style="border-width: 1px 1px 1px 1px;border-style: solid;border-color: #000;">NO</th>
                    <th width="10%" style="border-width: 1px 1px 1px 0;border-style: solid;border-color: #000;">ITEM CODE</th>
                    <th width="20%" style="border-width: 1px 1px 1px 0;border-style: solid;border-color: #000;">ITEM DESCRIPTION</th>
                    <th width="15%" style="border-width: 1px 1px 1px 0;border-style: solid;border-color: #000;">DIMENSION</th>
                    <th width="15%" style="border-width: 1px 1px 1px 0;border-style: solid;border-color: #000;">MATERIAL</th>
                    <th width="15%" style="border-width: 1px 1px 1px 0;border-style: solid;border-color: #000;">COLOR</th>
                    <th width="10%" style="border-width: 1px 1px 1px 0;border-style: solid;border-color: #000;">FABRIC</th>
                    <th width="5%" style="border-width: 1px 1px 1px 0;border-style: solid;border-color: #000;">QTY</th>
                    <th width="8%" style="border-width: 1px 1px 1px 0;border-style: solid;border-color: #000;">DUE DATE</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $count = 10;
                if (!empty($rfs_detail)) {
                    $counter = 1;
                    foreach ($rfs_detail as $result) {
                        ?>
                        <tr>
                            <td style="border-width: 0 1px 1px 1px;border-style: solid;border-color: #000;" align="right"><?php echo $counter++ ?></td>
                            <td style="border-width: 0 1px 1px 0;border-style: solid;border-color: #000;"><?php echo $result->item_code ?></td>
                            <td style="border-width: 0 1px 1px 0;border-style: solid;border-color: #000;"><?php echo $result->item_description ?></td>
                            <td style="border-width: 0 1px 1px 0;border-style: solid;border-color: #000;"><?php echo $result->dimension ?></td>
                            <td style="border-width: 0 1px 1px 0;border-style: solid;border-color: #000;"><?php echo $result->material ?></td>
                            <td style="border-width: 0 1px 1px 0;border-style: solid;border-color: #000;"><?php echo $result->color ?></td>
                            <td style="border-width: 0 1px 1px 0;border-style: solid;border-color: #000;"><?php echo $result->fabric_code ?></td>
                            <td style="border-width: 0 1px 1px 0;border-style: solid;border-color: #000;" align="center"><?php echo $result->qty ?></td>
                            <td style="border-width: 0 1px 1px 0;border-style: solid;border-color: #000;" align="center"><?php echo date('d/m/Y', strtotime($result->due_date)) ?></td>
                        </tr>
                        <?php
                        $count--;
                    }
                }
                for ($i = 0; $i < $count; $i++) {
                    ?>
                    <tr>
                        <td style="border-width: 0 1px 1px 1px;border-style: solid;border-color: #000;">&nbsp;</td>
                        <td style="border-width: 0 1px 1px 0;border-style: solid;border-color: #000;">&nbsp;</td>
                        <td style="border-width: 0 1px 1px 0;border-style: solid;border-color: #000;">&nbsp;</td>
                        <td style="border-width: 0 1px 1px 0;border-style: solid;border-color: #000;">&nbsp;</td>
                        <td style="border-width: 0 1px 1px 0;border-style: solid;border-color: #000;">&nbsp;</td>
                        <td style="border-width: 0 1px 1px 0;border-style: solid;border-color: #000;">&nbsp;</td>
                        <td style="border-width: 0 1px 1px 0;border-style: solid;border-color: #000;">&nbsp;</td>
                        <td style="border-width: 0 1px 1px 0;border-style: solid;border-color: #000;">&nbsp;</td>
                        <td style="border-width: 0 1px 1px 0;border-style: solid;border-color: #000;">&nbsp;</td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
        <br/>
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="data">
            <tr>
                <td rowspan="2" valign="top" width="25%" style="border-width: 1px 1px 1px 1px;border-style: solid;border-color: #000;">
                    <strong>Request By: </strong> 
                    <br/>
                    <br/>
                </td>
                <td rowspan="2" valign="top" width="15%" style="border-width: 1px 1px 1px 0;border-style: solid;border-color: #000;">
                    <strong>Stamp: </strong> 
                </td>
                <td width="25%" style="border-width: 1px 1px 1px 0;border-style: solid;border-color: #000;">
                    <strong>Received By: </strong> 
                    <br/>
                    <br/>
                    <br/>
                </td>
                <td rowspan="2" valign="top" width="35%" style="border-width: 1px 1px 1px 0;border-style: solid;border-color: #000;">
                    <strong>Notes: </strong> 
                </td>
            </tr>
            <tr>
                <td style="border-width: 0 1px 1px 0;border-style: solid;border-color: #000;">
                    <strong>Date: </strong> 
                    <br/>
                    <br/>
                    <br/>
                </td>
            </tr>
        </table>
    </body>
    <script>
//        window.onload = function () {
//            window.print();
//            setTimeout(function () {
//                window.close();
//            }, 1);
//        };
    </script>
</html>

