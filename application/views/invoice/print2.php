<html>
    <head>
        <title>Invoice</title>
        <style>
            *{
                font-family: Tahoma;
                font-size: 11px;
            }
            .cell_border{
                border: 1px #000 solid;
                padding: 2px;
            }
        </style>
    </head
    <body>
        <?php
//        var_dump($invoice);
        ?>
        <div style="width: 800px;">
            <table cellspacing="0" cellpadding="0" border="0" width="100%" style="border-collapse: collapse;">
                <tr valign="top">
                    <td width="50%" style="border: 1px solid #000;padding: 2px;">
                        <div style="font-size: 80px;padding: 0;font-weight: bold;">
                            <img src="<?php echo base_url('files/bl_logo.png') ?>" style="height: 70px;width: 70px;"/><br/>
                        </div>
                        <div style="font-size: 14px;margin-top: 10px;font-weight: bold">
                            Invoice<br/>
                            <span><?php echo $invoice->transaction_number ?></span><br/><br/>
                            <span style="font-weight: bold">Statement Date : <?php echo date('d-M-Y', strtotime($invoice->date)); ?></span>
                        </div>
                    </td>
                    <td width = "50%" style = "border: 1px solid #000;padding: 2px;">
                        <div style = "font-size: 16px;font-weight: bold;">PT Generasi Produk Indonesia</div>
                        <div>
                            Jl. Rumah Makan Sayang, Kp. Pasir Ipis, RT 002 RW 007<br/>
                            Citereup, Jawa Barat - Indonesia<br/>
                        </div>
                        <div style = "margin-top: 15px;">
                            <span>Showroom: </span><br/>
                            JL Rambai No 1/3 Kebayoran Baru<br/>
                            Kebayoran Baru, Jakarta Selatan - Indonesia<br/>
                            Telp: +62 722 10 53, +62 73 307 41
                        </div>
                    </td>
                </tr>
                <tr valign = "top">
                    <td style = "border: 1px solid #000;padding: 2px;">
                        <span style = "font-weight: bold;">Client</span><br/>
                        <div><?php echo nl2br($invoice->ship_to) ?></div>
                    </td>
                    <td style="border: 1px solid #000;padding: 2px;">
                        <span style="font-weight: bold;">Detail</span><br/>
                        <table width="100%">
                            <tr>
                                <td width="40%" style="font-weight: bold;">PO Number</td>
                                <td width="60%">&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;">Contact Person</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;">Notes</td>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <div style="font-weight: bold;border-left: 1px #000 solid;border-right: 1px #000 solid;padding: 5px"><span style="margin: 5px 0;">INVOICE REFERENCE</span></div>
            <?php // print_r($products) ?>
            <table width="100%" style="border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="width: 2%" class="cell_border">NO</th>
                        <th style="width: 15%" class="cell_border">CODE</th>
                        <th class="cell_border">DESCRIPTION</th>
                        <th style="width: 20%" class="cell_border">SPECIFICATION</th>
                        <th style="width: 5%" class="cell_border">QTY</th>
                        <th style="width: 15%" class="cell_border">UNIT PRICE</th>
                        <th style="width: 15%" class="cell_border">TOTAL AMOUNT PRICE</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $count = 10;
                    foreach ($products as $result) {
                        ?>
                        <tr valign="top">
                            <td class="cell_border" align="center"><?php echo $no++; ?></td>
                            <td class="cell_border"><?php echo $result->product_code ?></td>
                            <td class="cell_border"><?php echo $result->product_name ?></td>
                            <td class="cell_border"><?php echo $result->material ?></td>
                            <td class="cell_border" align="center"><?php echo $result->qty ?></td>
                            <td class="cell_border"><?php echo $invoice->currency_code ?><span style="float: right"><?php echo format_price($result->net_factory) ?></span></td>
                            <td class="cell_border"><?php echo $invoice->currency_code ?><span style="float: right"><?php echo format_price($result->line_total) ?></span></td>
                        </tr>
                        <?php
                        $count--;
                    }
                    if ($count > 0) {
                        for ($i = 0; $i < $count; $i++) {
                            ?>
                            <tr>
                                <td style="border-left: 1px #000 solid;">&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td style="border-right: 1px #000 solid;">&nbsp;</td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                    <tr>
                        <td style="border-left: 1px #000 solid;border-bottom: 1px #000 solid;">&nbsp;</td>
                        <td style="border-bottom: 1px #000 solid;">&nbsp;</td>
                        <td style="border-bottom: 1px #000 solid;">&nbsp;</td>
                        <td style="border-bottom: 1px #000 solid;">&nbsp;</td>
                        <td style="border-bottom: 1px #000 solid;">&nbsp;</td>
                        <td style="border-bottom: 1px #000 solid;">&nbsp;</td>
                        <td style="border-right: 1px #000 solid;border-bottom: 1px #000 solid;">&nbsp;</td>
                    </tr>
                </tbody>
            </table>

            <table cellspacing="0" cellpadding="0" border="0" width="100%" style="border-collapse: collapse;">
                <tr>
                    <td width="55%" style="border: 1px solid #000;padding: 2px;border-top: none;">
                        This Commercial invoice is subject to our final confirmation
                    </td>
                    <td width="45%" style="border: 1px solid #000;border-top: none;">
                        <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                            <tr>
                                <td class="cell_border" width="40%" style="border-left: none;border-top: none;font-weight: bold;">Order Amount</td>
                                <td class="cell_border" width="60%" style="border-top: none;border-right: none;"><?php echo $invoice->currency_code ?><span style="float: right"><?php echo format_price($invoice->order_amount) ?></span></td>
                            </tr>
                            <tr>
                                <td class="cell_border" style="border-left: none;font-weight: bold;">Invoice Amount</td>
                                <td class="cell_border"><?php echo $invoice->currency_code ?><span style="float: right"><?php echo format_price($invoice->amount) ?></span></td>
                            </tr>
                            <tr>
                                <td class="cell_border" style="border-left: none;font-weight: bold;">VAT / PPN 10%</td>
                                <td class="cell_border"><?php echo $invoice->currency_code ?><span style="float: right"><?php echo format_price($invoice->tax) ?></span></td>
                            </tr>
                            <tr>
                                <td class="cell_border" style="border-left: none;border-bottom: none;font-weight: bold;">TOTAL</td>
                                <td class="cell_border" style="border-bottom: none;"><?php echo $invoice->currency_code ?><span style="float: right"><?php echo format_price($invoice->amount_due) ?></span></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr valign = "top">
                    <td style = "border: 1px solid #000;padding: 2px;border-top: none;">
                        Sincerely Yours,
                        <table width="100%">
                            <tr>
                                <td width="50%" align="center">
                                    <br/><br/><br/><br/><br/><br/>
                                    <span style="text-decoration: underline;font-weight: bold;">Indah Sulistyarini</span><br/>
                                    FINANCE & ACCT
                                </td>
                                <td width="50%" align="center">
                                    <br/><br/><br/><br/><br/><br/>
                                    <span style="text-decoration: underline;font-weight: bold;">Indra Maulana</span><br/>
                                    SALES MANAGER
                                </td>
                            </tr>
                        </table>

                    </td>
                    <td style="border: 1px solid #000;padding: 2px;font-weight: bold;">
                        <br/>
                        NO ACCOUNT BANK:<br/>
                        <?php
                        echo $invoice->bank_name . "<br/>";
                        echo $invoice->bank_address . "<br/>";
                        ?>
                        <br/>
                        <br/>
                        BENEFICIARY:<br/>
                        <?php
                        echo $invoice->on_behalf_of . "<br/>";
                        echo "Act# " . $invoice->bank_account_number . "<br/>";
                        ?>
                    </td>
                </tr>
            </table>

        </div>
    </body>
</html>