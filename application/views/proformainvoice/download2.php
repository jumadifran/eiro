<?php

$my_pdf = new Pdf();
$my_pdf->setPageOrientation('L', true, 2);
$this->pdf->setCellPaddings(1, 0, 1, 0);
$my_pdf->SetCompression(true);
$my_pdf->setPrintHeader(false);
$my_pdf->setPrintFooter(false);
$my_pdf->SetMargins(1, 1, 1);
$my_pdf->SetFont('', '', 7);
$my_pdf->AddPage();

//print_r($po);

$tbl = '
<table cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr>     
        <td width="100%" style="border: 0.1px solid black;">
             <table width="100%" cellpadding="0" border="0" border="0">
                <tr>
                    <td width=".1%">&nbsp;</td>
                    <td width="58.9%">
                        <div style="font-size:15pt;"><b>' . $proforma_invoice->company_name . '</b></div>
                        <span>' . nl2br($proforma_invoice->company_address) . '</span><br/>
                    </td>
                    <td width="40%" align="right">
                        <span style="font-size:30pt"><b>P.I</span></b><br/>
                        <span style="font-size:10pt;"><b>PROFORMA INVOICE</b></span>
                    </td>
                    <td width="1%">&nbsp;</td>
                </tr>
             </table>
        </td>
    </tr>
    <tr>
        <td style="border: 0.1px solid black;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr valign="top">
                    <td width="50%">
                        <table width="100%">
                            <tr>
                                <td width="20%"><b>CLIENT ID</b></td>
                                <td width="2%">:</td>                                            
                                <td width="78%">' . $proforma_invoice->client_code . '</td>
                            </tr>
                            <tr>
                                <td><b>COMPANY NAME</b></td>
                                <td>:</td>
                                <td>' . $proforma_invoice->client_company_name . '</td>
                            </tr>
                            <tr>
                                <td><b>ADDRESS</b></td>
                                <td>:</td>
                                <td>' . $proforma_invoice->client_address . '</td>
                            </tr>
                            <tr>
                                <td><b>COUNTRY</b></td>
                                <td>:</td>
                                <td>' . $proforma_invoice->client_country . '</td>
                            </tr>
                            <tr>
                                <td><b>PHONE / FAX</b></td>
                                <td>:</td>
                                <td>' . $proforma_invoice->client_phone_fax . '</td>
                            </tr>
                            <tr>
                                <td><b>EMAIL</b></td>
                                <td>:</td>
                                <td>' . $proforma_invoice->client_email . '</td>
                            </tr>
                            <tr>
                                <td><b>CONTACT NAME</b></td>
                                <td>:</td>
                                <td>' . $proforma_invoice->client_name . '</td>
                            </tr>
                        </table>
                        <br/>
                    </td>
                    <td width="50%" style="border-left:0.1px solid #000000;">
                        <table width="100%">
                            <tr>
                                <td width="32%"><b>ORDER ID</b></td>
                                <td width="2%">:</td>                                            
                                <td width="66%">' . $proforma_invoice->order_id . '</td>
                            </tr>
                            <tr>
                                <td><b>P.I DATE</b></td>
                                <td>:</td>
                                <td>' . date('d M Y', strtotime($proforma_invoice->order_confirm_date)) . '</td>
                            </tr>
                            <tr>
                                <td><b>INVOICE DATE</b></td>
                                <td>:</td>
                                <td>' . date('d M Y', strtotime($proforma_invoice->order_invoice_date)) . '</td>
                            </tr>
                            <tr>
                                <td><b>TARGET SHIP DATE</b></td>
                                <td>:</td>
                                <td>' . date('d M Y', strtotime($proforma_invoice->order_target_ship_date)) . '</td>
                            </tr>
                            <tr>
                                <td><b>PAYMENT TERMS</b></td>
                                <td>:</td>
                                <td>' . $proforma_invoice->payment_term . '</td>
                            </tr>
                            <tr>
                                <td><b>CONTRACT TERMS</b></td>
                                <td>:</td>
                                <td>' . $proforma_invoice->order_contract_term . '</td>
                            </tr>
                            <tr>
                                <td><b>CONTACT NAME</b></td>
                                <td>:</td>
                                <td>' . '</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td> 
    </tr>
</table>';

////EOD;
////
$my_pdf->writeHTML($tbl, true, false, false, false, '');
//
//// -----------------------------------------------------------------------------
//// Table with rowspans and THEAD
$tbl = '
<table border="0" cellspacing="0" cellspacing="0" width="100%" style="border-collapse:collapse">
    <thead>
        <tr>
            <td width="2%" align="center" rowspan="2" style="border: 0.1px solid black;line-height:10px;"><b>NO</b></td>
            <td width="8%" valign="middle" align="center" rowspan="2" style="border: 0.1px solid black;line-height:10px;"><b>&nbsp;PRODUCT ID</b></td>
            <td width="12%" align="center" rowspan="2" style="border: 0.1px solid black;line-height:10px;"><b>PRODUCT NAME</b></td>
            <td width="7%" align="center" rowspan="2" style="border: 0.1px solid black;line-height:10px;"><b>IMAGE</b></td>
            <td width="9%" align="center" colspan="3" style="border: 0.1px solid black;line-height:5px;"><b>DIMENSION</b></td>
            <td width="3%" align="center" rowspan="2" style="border: 0.1px solid black;line-height:5px;"><b>Vol<br/>(m3)</b></td>
            <td width="3%" align="center" rowspan="2" style="border: 0.1px solid black;line-height:10px;"><b>QTY</b></td>
            <td width="10%" align="center" rowspan="2" style="border: 0.1px solid black;line-height:10px;"><b>MATERIAL</b></td>
            <td width="9%" align="center" rowspan="2" style="border: 0.1px solid black;line-height:10px;"><b>COLOR</b></td>
            <td width="9%" align="center" rowspan="2" style="border: 0.1px solid black;line-height:10px;"><b>FABRIC</b></td>
            <td width="7%" align="center" rowspan="2" style="border: 0.1px solid black;line-height:5px;"><b>UNIT PRICE<br/>(' . $proforma_invoice->currency_code . ')</b></td>
            <td width="3%" align="center" rowspan="2" style="border: 0.1px solid black;line-height:5px;"><b>DISC<BR>(%)</b></td>
            <td width="8%" align="center" rowspan="2" style="border: 0.1px solid black;line-height:5px;"><b>NET FACTORY<br/>(' . $proforma_invoice->currency_code . ')</b></td>
            <td width="10%" align="center" rowspan="2" style="border: 0.1px solid black;line-height:5px;"><b>LINE TOTAL<br>(' . $proforma_invoice->currency_code . ')</b></td>
        </tr>
        <tr valign="center">
            <td width="3%" align="center" style="border: 0.1px solid black;line-height:5px;"><b>W</b></td>
            <td width="3%" align="center" style="border: 0.1px solid black;line-height:5px;"><b>D</b></td>
            <td width="3%" align="center" style="border: 0.1px solid black;line-height:5px;"><b>H</b></td>
        </tr>
    </thead>';
$counter = 2;
$no = 1;
$total_qty = 0;
$total_box = 0;
foreach ($products as $result) {
    $img = 'files/products_image/' . $result->image;
    if (!file_exists($img)) {
        $img = 'files/products_image/no-image.jpg';
    }

    $tbl .= '<tr nobr="true">
        <td width="2%" align="right" style="border-right-color:#000000;border-right-width:0.1px;border-left-color:#000000;border-left-width:0.1px;border-left-style:solid;line-height:5px;">' . $no . '</td>
        <td width="8%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">' . $result->product_code . '</td>
        <td width="12%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">' . $result->product_name . '</td>
        <td width="7%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;"><img src="' . $img . '" width="40" height="40"> </td>
        <td width="3%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">' . $result->width . '</td>
        <td width="3%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">' . $result->depth . '</td>
        <td width="3%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">' . $result->height . '</td>
        <td width="3%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">' . number_format($result->volume, 3, '.', '.') . '</td>
        <td width="3%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">' . $result->qty . '</td>
        <td width="10%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">' . $result->material . '</td>
        <td width="9%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">' . $result->color . '</td>
        <td width="9%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">' . $result->fabric . '</td>
        <td width="7%" align="right" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">' . number_format($result->price, 2) . '</td>
        <td width="3%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">' . $result->discount . '</td>
        <td width="8%" align="right" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">' . number_format($result->net_factory, 2) . '</td>
        <td width="10%" align="right" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">' . number_format($result->line_total, 2) . '</td>
    </tr>';
    $counter--;
    $no++;
    $total_qty += $result->qty;
    $total_box += $result->box;
}

for ($i = 0; $i < $counter; $i++) {
    $tbl .= '<tr>
        <td style="border-right-color:#000000;border-right-width:0.1px;border-left-color:#000000;border-left-width:0.1px;border-left-style:solid;line-height:5px;"></td>
        <td align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;"></td>
        <td align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;"></td>
        <td align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;"></td>
        <td align="left" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;"></td>
        <td align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;"></td>
        <td align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;"></td>
        <td align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;"></td>
        <td align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;"></td>
        <td align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;"></td>
        <td align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;"></td>
        <td align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;"></td>
        <td align="right" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;"></td>
        <td align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;"></td>
        <td align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;"></td>
        <td align="right" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;"></td>
    </tr>';
}

$tbl .= '<tr>
        <td style="border-left-color:#000000;border-left-width:0.1px;border-left-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;"></td>
        <td align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;"></td>
        <td align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;"></td>
        <td align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;"></td>
        <td align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;"></td>
        <td align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;"></td>
        <td align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;"></td>
        <td align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;"></td>
        <td align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;"></td>
        <td align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;"></td>
        <td align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;"></td>
        <td align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;"></td>
        <td align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;"></td>
        <td align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;"></td>
        <td align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;"></td>
        <td align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;"><b>&nbsp;</b></td>
    </tr>';

$tbl .= '</table>';
//
$my_pdf->writeHTML($tbl, true, false, false, false, '');
////
////// -----------------------------------------------------------------------------
////// NON-BREAKING TABLE (nobr="true")
////

$tbl = '
<table border="0" cellspacing="0" cellspacing="0" width="100%" style="border-collapse:collapse" nobr="true">
    <tr>
        <td width="45%" colspan="8" rowspan="4" style="border-top-color:#000000;border-top-width:0.1px;border-top-style:solid;border-left-color:#000000;border-left-width:0.1px;border-left-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;"><b>REMARK : ' . $proforma_invoice->remark . '</b></td>        
        <td width="10%" rowspan="2" style="border-top-color:#000000;border-top-width:0.1px;border-top-style:solid;border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;line-height:10px;" align="center"><b>TOTAL QTY</b></td>
        <td width="10%" rowspan="2" style="border-top-color:#000000;border-top-width:0.1px;border-top-style:solid;border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;line-height:10px;" align="center"><b>' . $total_qty . '</b></td>
        <td width="20%" colspan="3" style="border-top-color:#000000;border-top-width:0.1px;border-top-style:solid;border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;line-height:5px;"><b>&nbsp;&nbsp;TOTAL</b></td>        
        <td width="15%" colspan="2" align="right" style="border-top-color:#000000;border-top-width:0.1px;border-top-style:solid;border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;line-height:5px;"><b>' . number_format($proforma_invoice->total, 0, '.', '.') . '</b></td>
    </tr>
    <tr>
        <td width="10%" colspan="2" style="border-top-color:#000000;border-top-width:0.1px;border-top-style:solid;border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;line-height:5px;"><b>&nbsp;&nbsp;VAT.</b></td>
        <td width="10%" align="right" style="border-top-color:#000000;border-top-width:0.1px;border-top-style:solid;border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;line-height:5px;"><b> ( ' . $proforma_invoice->vat . ' % )</b></td>
        <td width="15%" colspan="2" align="right" style="border-top-color:#000000;border-top-width:0.1px;border-top-style:solid;border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;line-height:5px;"><b>' . number_format($proforma_invoice->vat_nominal, 0, '.', '.') . '</b></td>
    </tr>
    <tr>
        <td width="10%" rowspan="2" style="border-top-color:#000000;border-top-width:0.1px;border-top-style:solid;border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;line-height:10px;" align="center"><b>TOTAL BOX</b></td>
        <td width="10%" rowspan="2" style="border-top-color:#000000;border-top-width:0.1px;border-top-style:solid;border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;line-height:10px;" align="center"><b>' . $total_box . '</b></td>
        <td width="10%" colspan=2 style="border-top-color:#000000;border-top-width:0.1px;border-top-style:solid;border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;line-height:5px;"><b>&nbsp;&nbsp;DOWN PAYMENT</b></td>        
        <td width="10%" align="right" style="border-top-color:#000000;border-top-width:0.1px;border-top-style:solid;border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;line-height:5px;"><b>' . (!empty($proforma_invoice->down_payment_date) ? date('d M Y', strtotime($proforma_invoice->down_payment_date)) : "") . ' ( ' . $proforma_invoice->down_payment . ' % )</b></td>
        <td width="15%"colspan="2" align="right" style="border-top-color:#000000;border-top-width:0.1px;border-top-style:solid;border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;line-height:5px;"><b>' . number_format($proforma_invoice->down_payment_nominal, 0, '.', '.') . '</b></td>
    </tr>
    <tr>
        <td width="20%" colspan=3 style="border-top-color:#000000;border-top-width:0.1px;border-top-style:solid;border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;line-height:5px;"><b>&nbsp;&nbsp;BALANCE DUE</b></td>
        <td width="15%" colspan="2" align="right" style="border-top-color:#000000;border-top-width:0.1px;border-top-style:solid;border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;line-height:5px;"><b>' . number_format($proforma_invoice->balance_due, 0, '.', '.') . '</b></td>
    </tr>
</table>';

$my_pdf->writeHTML($tbl, true, false, false, false, '');

$tbl = '
<table cellpadding="0" width="100%" cellspacing="0" nobr="true">
    <tr>
        <td width="50%" style="border:0.1px solid #000000;line-height:5px">
            <table cellpadding="0" width="100%" cellspacing="0">
                <tr>
                    <td width="40%" style="line-height:5px"><b>BILL TO BANK</b></td>
                    <td width="1%" style="line-height:5px"><b>:</b></td>
                    <td width="59%" style="line-height:5px"><b>' . $proforma_invoice->bank_name . '</b></td>
                </tr>
                <tr>
                    <td style="line-height:5px"><b>ADDRESS</b></td>
                    <td style="line-height:5px"><b>:</b></td>
                    <td style="line-height:5px"><b>' . $proforma_invoice->bank_address . '</b></td>
                </tr>
                <tr>
                    <td style="line-height:5px"><b>COUNTRY</b></td>
                    <td style="line-height:5px"><b>:</b></td>
                    <td style="line-height:5px"><b>' . $proforma_invoice->bank_country_name . '</b></td>
                </tr>
                <tr>
                    <td style="line-height:5px"><b>ACCOUNT NO.</b></td>
                    <td style="line-height:5px"><b>:</b></td>
                    <td style="line-height:5px"><b>' . $proforma_invoice->bank_account_number . '</b></td>
                </tr>
                <tr>
                    <td style="line-height:5px"><b>SWIFT CODE</b></td>
                    <td style="line-height:5px"><b>:</b></td>
                    <td style="line-height:5px"><b>' . $proforma_invoice->swift_code . '</b></td>
                </tr>
                <tr>
                    <td style="line-height:5px"><b>BENEFICIARY</b></td>
                    <td style="line-height:5px"><b>:</b></td>
                    <td style="line-height:5px"><b>' . $proforma_invoice->on_behalf_of . '</b></td>
                </tr>
           </table>
        </td>
        <td width="50%" style="border:0.1px solid #000000;line-height:5px">
        <b>
            This Proforma Invoice will be confirmed as a Commercial Invoice once deposit funds
            have been received.
        </b>
        </td>
    </tr>
</table>
';
// -----------------------------------------------------------------------------
//Close and output PDF document
$my_pdf->writeHTML($tbl, true, false, true, false, '');

$file_name = 'PI-' . $proforma_invoice->order_id . '.pdf';
$my_pdf->Output($file_name, 'D');
//============================================================+
// END OF FILE
//============================================================+
