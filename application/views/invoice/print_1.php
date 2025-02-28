<div style="width: 800px;">
    <table cellspacing="0" cellpadding="0" border="0" width="100%">
        <tr>
            <td style="text-align: center;font-size: 25px;font-weight: bold;">
                <span style="border-bottom: 4px #000 solid;letter-spacing: 10px;">INVOICE</span>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;font-size: 18;font-weight: bold;padding: 5px;">047/INV/GPI/2017</td>
        </tr>
    </table>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="padding-top: 25px;">
        <tr>
            <td width="50%" style="padding: 2px;border: 1px #000 solid;border-bottom: none;"><span style="font-weight: bold;">Statement Date</span><span style="float: right;font-weight: bold;"><?php echo date('d-M-y', strtotime($invoice->date)); ?></span></td>
            <td width="50%" style="padding: 2px;border: 1px #000 solid;border-bottom: none;"><span style="font-weight: bold;"><?php echo $invoice->contact_name; ?></span><span style="float: right;font-weight: bold;">Contact Name</span></td>
        </tr>
        <tr>
            <td style="padding: 2px;border: 1px #000 solid;border-top: none;"><span style="font-weight: bold;">PO Number</span><span style="float: right;font-weight: bold;"><?php echo $invoice->order_id; ?></span></td>
            <td style="padding: 2px;border: 1px #000 solid;border-top: none;"><span style="font-weight: bold;"><?php echo ""; ?></span><span style="float: right;font-weight: bold;">Client PO No</span></td>
        </tr>
    </table>

    <table cellspacing="0" cellpadding="0" border="0" width="100%" style="margin-top: 20px;">
        <tr>
            <td style="border-bottom: 4px #000 solid">
                <span style="font-weight: bold;">Client : </span><br/>
                <div>
                    <?php echo nl2br($invoice->ship_to) ?>
                </div>
            </td>
        </tr>
        <tr>
            <td style="padding-top: 10px;"><span>INVOICE REFERENCE:</span></td>
        </tr>
    </table>

    <table cellspacing="0" cellpadding="0" border="0" width="100%" style="margin-top: 20px;">
        <tr>
            <td width="50%"><?php echo $invoice->description ?></td>
            <td width="20%"><?php echo $invoice->currency_code, " " . number_format($invoice->order_amount); ?></td>
            <td width="10%"><?php echo $invoice->down_payment . " %"; ?></td>
            <td width="20%"><span><?php echo $invoice->currency_code ?></span><span style="float: right"><?php echo number_format($invoice->amount); ?></span></td>
        </tr>
        <tr>
            <td style="padding-top: 20px;">PPN</td>
            <td style="padding-top: 20px;">&nbsp;</td>
            <td style="padding-top: 20px;">10 %</td>
            <td style="padding-top: 20px;border-bottom: 2px #000 solid;"><span><?php echo $invoice->currency_code ?></span><span style="float: right"><?php echo number_format($invoice->tax); ?></span></td>
        </tr>
        <tr>
            <td style="padding-top: 40px;"><strong>AMOUNT DUE</strong></td>
            <td style="padding-top: 40px;">&nbsp;</td>
            <td style="padding-top: 40px;">&nbsp;</td>
            <td style="padding-top: 40px;font-weight: bold;"><span><?php echo $invoice->currency_code ?></span><span style="float: right"><?php echo number_format($invoice->amount_due); ?></span></td>
        </tr>
    </table>

    <table cellspacing="0" cellpadding="0" border="0" width="100%" style="margin-top: 20px;">
        <tr>
            <td width="50%">
                This Commercial Invoice is subject to our final confirmation<br/>
                Sincerely Yours,
                <br/>
                <br/>
                <br/>
                <br/>
                Yayat Hendayana<br/>
                Marketing Manager
            </td>
            <td width="10%">&nbsp;</td>
            <td width="40%" valign="top">
                <div style="padding: 5px;border: 1px #000 solid;font-weight: bold;width: 100%">
                    Bank Details: <br/>
                    <?php
                    echo $invoice->on_behalf_of . "<br>";
                    echo "Act # " . $invoice->bank_account_number . "<br>";
                    echo "Bank " . $invoice->bank_name . "<br>";
                    echo $invoice->bank_address . " - " . $invoice->bank_country_name . "<br/>";
                    echo "Swift Code: " . $invoice->swift_code . "<br>";
                    ?>
                </div>
            </td>
        </tr>
    </table>
</div>

