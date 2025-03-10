<?php
$my_pdf = new Pdf($orientation = 'P', $unit = 'cm', array(21, 30));
//$my_pdf->setPageOrientation('P', true, 1);
$my_pdf->SetCompression(true);
$my_pdf->setPrintHeader(false);
$my_pdf->setPrintFooter(false);
$my_pdf->SetMargins(3, 5, 1);
$my_pdf->SetFont('', 'R', 5);
$my_pdf->AddPage();

$style = array(
    'border' => true,
    'vpadding' => '1',
    'hpadding' => '1',
    'fgcolor' => array(0, 0, 0),
    'bgcolor' => false, //array(255,255,255)
    'module_width' => 1, // width of a single module in points
    'module_height' => 1 // height of a single module in points
);

$style2 = array(
    'position' => '',
    'align' => 'C',
    'stretch' => false,
    'fitwidth' => false,
    'cellfitalign' => '',
    'border' => FALSE,
    'hpadding' => '2',
    'vpadding' => '2',
    'fgcolor' => array(0, 0, 0),
    'bgcolor' => false, //array(255,255,255),
    'text' => true,
    'font' => 'helvetica',
    'fontsize' => 6,
    'stretchtext' => 4
);

$tbl = '<br/><br/><table cellpadding="2.5" cellspacing="1" border=1 width=100%>';
$x = 1;
//print_r($serial_number);
foreach ($serial_number as $result) {
    $serial=$result->serial_number.'C &nbsp; &nbsp;&nbsp;:&nbsp;'. $result->client_name . '<br />'
                . 'PO &nbsp;&nbsp;:&nbsp;' . $result->po_no . '<br />'
                . 'EC &nbsp;&nbsp;:&nbsp;' . $result->ebako_code . '<br />'
                . 'CC &nbsp;&nbsp;:&nbsp;' . $result->customer_code . '<br />'
                . 'F &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;' . $result->finishing . '<br />'
                . 'OQ &nbsp;&nbsp;:&nbsp;' . $result->item_order_seq_no." of ".$result->qty . '<br />'
                . 'BQ &nbsp;&nbsp;:&nbsp;' . $result->item_order_seq_no."".$result->packing_code." of ".$result->qty ."".$result->packing_code. '<br />';
   // echo $serial.'<br>';
   // $params = $my_pdf->serializeTCPDFtagParameters(array($result->serial_number, 'QRCODE,C', '', '', '18', '18', $style, 'C','FALSE'));
    $params = $my_pdf->serializeTCPDFtagParameters(array($serial, 'QRCODE,H', '', '', '18', '18', $style, 'N','FALSE'));
    $params2 = $my_pdf->serializeTCPDFtagParameters(array($serial, 'C128', '', '', 0, 10, 0.4, $style2, 'N'));
    $barcodeobj = new TCPDFBarcode('123456', 'C128');
    if (($x % 3) == 1) {
        $tbl .= '<tr nobr="true">';
    }
    
    //$tbl .= '<td halign=center valign=top width=25%><tcpdf method="write2DBarcode" params="' . $params . '" /></td>' '
             $tbl .= '<div><tcpdf method="write2DBarcode" params="' . $params . '" /></div>'
                     . '<div><tcpdf method="write1DBarcode" params="' . $params2 . '" /></div>'
            .'<td width=75% style="font-size:5pt;">'
                . '<b>'.$result->serial_number . '</b><br />'
                . 'C &nbsp; &nbsp;&nbsp;:&nbsp;'. $result->client_name . '<br />'
                . 'PO &nbsp;&nbsp;:&nbsp;' . $result->po_no . '<br />'
                . 'EC &nbsp;&nbsp;:&nbsp;' . $result->ebako_code . '<br />'
                . 'CC &nbsp;&nbsp;:&nbsp;' . $result->customer_code . '<br />'
                . 'F &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;' . $result->finishing . '<br />'
                . 'OQ &nbsp;&nbsp;:&nbsp;' . $result->item_order_seq_no." of ".$result->qty . '<br />'
                . 'BQ &nbsp;&nbsp;:&nbsp;' . $result->item_order_seq_no."".$result->packing_code." of ".$result->qty ."".$result->packing_code. '<br />'
            .'</td>';
    if($x==count($serial_number))
    {
        if($x%3==1)
            $tbl.="<td colspan=4></td></tr>";
        elseif($x%3==2)
            $tbl.="<td colspan=2></td></tr>";
    }
    $x++;
    if (($x % 3) == 1) {
        $tbl.= '</tr><tr><td colspan=8><br><br><br><br><br><br><br><br></td></tr>';
    }
}
$tbl.= '</table>';
$my_pdf->writeHTML($tbl, true, false, true, false, 'center');
$file_name = $po->po_no . "_label.pdf";
//echo $tbl;
$my_pdf->Output($file_name, 'D');