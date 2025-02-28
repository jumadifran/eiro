<?php

$my_pdf = new Pdf();
$my_pdf->setPageOrientation('P', true, 2);
$this->pdf->setCellPaddings(1, 0, 1, 0);
$my_pdf->SetCompression(true);
$my_pdf->setPrintHeader(false);
$my_pdf->setPrintFooter(false);
$my_pdf->SetMargins(15, 15, 15);
$my_pdf->SetFont('', '', 9);
$my_pdf->AddPage();

$tbl = '<table cellspacing="0" cellpadding="0" border="0" width="100%">
        <tr>
            <td width="100%" align="center" style="font-size: 45px;font-weight: bold;letter-spacing: 10px;line-height:5px;"><u>INVOICE</u></td>
        </tr>
        <tr>
            <td align="center" style="font-size: 30px;font-weight: bold;line-height:7px;letter-spacing: 1px;">' . $invoice->transaction_number . '</td>
        </tr>
    </table>';

$tbl .='<table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="50%" style="padding: 2px;border: 0.1px #000 solid;border-bottom: none;">
                <table width="100%">
                    <tr>
                        <td style="line-height: 5px;font-weight:bold;">&nbsp;Statement Date</td>
                        <td style="line-height: 5px;font-weight:bold;" align="right">' . date('d-M-y', strtotime($invoice->date)) . '&nbsp;&nbsp;</td>
                    </tr>
                </table>
            </td>
            <td width="50%" style="padding: 2px;border: 0.1px #000 solid;border-bottom: none;">
                <table width="100%">
                    <tr>
                        <td style="line-height: 5px;font-weight:bold;">&nbsp;' . $invoice->contact_name . '</td>
                        <td style="line-height: 5px;font-weight:bold;" align="right">Contact Name&nbsp;&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="border: 0.1px #000 solid;border-top: none;">
                <table width="100%">
                    <tr>
                        <td style="line-height: 5px;font-weight:bold;">&nbsp;PO Number</td>
                        <td style="line-height: 5px;font-weight:bold;" align="right">' . $invoice->order_id . '&nbsp;&nbsp;</td>
                    </tr>
                </table>
            </td>
            <td style="border: 0.1px #000 solid;border-top: none;">
                <table width="100%">
                    <tr>
                        <td style="line-height: 5px;font-weight:bold;">&nbsp;</td>
                        <td style="line-height: 5px;font-weight:bold;" align="right">Client PO No&nbsp;&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>';

$tbl .='<table cellspacing="0" cellpadding="0" border="0" width="100%" style="margin-top: 20px;">
        <tr>
            <td style="border-bottom: 1px #000 solid">
                <div><span style="font-weight: bold;">Client : </span><br/>' . nl2br($invoice->ship_to) . '</div>
                    <br/>
            </td>
        </tr>
        <tr>
            <td><br/><br/><br/><span>INVOICE REFERENCE:</span></td>
        </tr>
    </table>';
$my_pdf->writeHTML($tbl, true, false, false, false, '');

$tbl = '<table cellspacing="0" cellpadding="0" border="0" width="100%" style="margin-top: 20px;">
        <tr>
            <td width="50%" style="line-height: 10px;">' . $invoice->description . '</td>
            <td width="5%" style="line-height: 10px;">' . $invoice->currency_code . '</td>
            <td width="15%" style="line-height: 10px;">' . number_format($invoice->order_amount) . '</td>
            <td width="10%" style="line-height: 10px;" align="center">' . $invoice->down_payment . ' %' . '</td>
            <td width="5%" style="line-height: 10px;">' . $invoice->currency_code . '</td>
            <td width="15%" style="line-height: 10px;" align="right">' . number_format($invoice->amount) . '</td>
        </tr>
        <tr>
            <td style="line-height: 10px;">PPN</td>
            <td style="line-height: 10px;">&nbsp;</td>
            <td style="line-height: 10px;">&nbsp;</td>
            <td style="line-height: 10px;" align="center">' . ($invoice->ppn_flag == "on" ? "10%" : "0%") . '</td>
            <td style="line-height: 10px;">' . $invoice->currency_code . '</td>
            <td style="line-height: 10px;border-bottom: 1px solid #000;" align="right">' . number_format($invoice->tax) . '</td>
        </tr>
        <tr>
            <td style="line-height: 10px;"><strong>AMOUNT DUE</strong></td>
            <td style="line-height: 10px;">&nbsp;</td>
            <td style="line-height: 10px;">&nbsp;</td>
            <td style="line-height: 10px;">&nbsp;</td>
            <td style="line-height: 10px;">' . $invoice->currency_code . '</td>
            <td style="line-height: 10px;font-weight: bold;" align="right">' . number_format($invoice->amount_due) . '</td>
        </tr>
    </table>';


$tbl .= '<br/>
         <br/>
         <br/>
         <table cellspacing="0" cellpadding="0" border="0" width="100%" style="margin-top: 20px;">
        <tr>
            <td width="50%">This Commercial Invoice is subject to our final confirmation<br/>
                Sincerely Yours,
                <br/>
                <br/>
                <br/>
                <br/>
                Yayat Hendayana<br/>
                Marketing Manager
            </td>
            <td width="5%">&nbsp;</td>
            <td width="45%" valign="top">
                <div style="border: 0.1px #000 solid;font-weight: bold;width: 100%">
                    Bank Details: <br/>' .
        '&nbsp;&nbsp;' . $invoice->on_behalf_of . '<br/>' .
        '&nbsp;&nbsp;Act # ' . $invoice->bank_account_number . '<br/>' .
        '&nbsp;&nbsp;Bank ' . $invoice->bank_name . '<br/>' .
        '&nbsp;&nbsp;' . $invoice->bank_address . ' - ' . $invoice->bank_country_name . '<br/>' .
        '&nbsp;&nbsp;Swift Code: ' . $invoice->swift_code . '<br/>' .
        '</div>
            </td>
        </tr>
    </table>';
$my_pdf->writeHTML($tbl, true, false, false, false, '');
$my_pdf->Output('invoice.pdf', 'I');



