<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$this->excel->setActiveSheetIndex(0);


$coloum = array(
    'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N',
    'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB',
    'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN',
    'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ',
    'BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG', 'BH', 'BI', 'BJ', 'BK', 'BL',
    'BM', 'BN', 'BO', 'BP', 'BQ', 'BR', 'BS', 'BT', 'BU', 'BV', 'BW', 'BX',
    'BY', 'BZ', 'CA', 'CB', 'CC', 'CD', 'CE', 'CF', 'CG', 'CH', 'CI', 'CJ',
    'CK', 'CL', 'CM', 'CN', 'CO', 'CP', 'CQ', 'CR', 'CS', 'CT', 'CU', 'CV'
);

$col = 0;
$row = 3;
$this->excel->getActiveSheet()->setCellValue($coloum[$col] . "" . $row, 'NO');
$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getFont()->setSize(8);
$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getFont()->setBold(true);
$this->excel->getActiveSheet()->getColumnDimension($coloum[$col])->setWidth(4);

$col++;
$this->excel->getActiveSheet()->setCellValue($coloum[$col] . "" . $row, 'PO No');
$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getFont()->setSize(8);
$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getFont()->setBold(true);
$this->excel->getActiveSheet()->getColumnDimension($coloum[$col])->setWidth(12);

$col++;
$this->excel->getActiveSheet()->setCellValue($coloum[$col] . "" . $row, 'Vendor');
$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getFont()->setSize(8);
$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getFont()->setBold(true);
$this->excel->getActiveSheet()->getColumnDimension($coloum[$col])->setWidth(12);

$col++;
$this->excel->getActiveSheet()->setCellValue($coloum[$col] . "" . $row, 'Serial Number');
$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getFont()->setSize(8);
$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getFont()->setBold(true);
$this->excel->getActiveSheet()->getColumnDimension($coloum[$col])->setWidth(12);

//$col++;
//$this->excel->getActiveSheet()->setCellValue($coloum[$col] . "" . $row, 'Produc Image');
//$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getFont()->setSize(8);
//$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getFont()->setBold(true);
//$this->excel->getActiveSheet()->getColumnDimension($coloum[$col])->setWidth(12);

$col++;
$this->excel->getActiveSheet()->setCellValue($coloum[$col] . "" . $row, 'Category');
$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getFont()->setSize(8);
$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getFont()->setBold(true);
$this->excel->getActiveSheet()->getColumnDimension($coloum[$col])->setWidth(12);

$col++;
$this->excel->getActiveSheet()->setCellValue($coloum[$col] . "" . $row, 'Product Code');
$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getFont()->setSize(8);
$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getFont()->setBold(true);
$this->excel->getActiveSheet()->getColumnDimension($coloum[$col])->setWidth(12);

$col++;
$this->excel->getActiveSheet()->setCellValue($coloum[$col] . "" . $row, 'Product Description');
$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getFont()->setSize(8);
$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getFont()->setBold(true);
$this->excel->getActiveSheet()->getColumnDimension($coloum[$col])->setWidth(25);

$col++;
$this->excel->getActiveSheet()->setCellValue($coloum[$col] . "" . $row, 'Width');
$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getFont()->setSize(8);
$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getFont()->setBold(true);
$this->excel->getActiveSheet()->getColumnDimension($coloum[$col])->setWidth(7);

$col++;
$this->excel->getActiveSheet()->setCellValue($coloum[$col] . "" . $row, 'Depth');
$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getFont()->setSize(8);
$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getFont()->setBold(true);
$this->excel->getActiveSheet()->getColumnDimension($coloum[$col])->setWidth(7);

$col++;
$this->excel->getActiveSheet()->setCellValue($coloum[$col] . "" . $row, 'Height');
$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getFont()->setSize(8);
$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getFont()->setBold(true);
$this->excel->getActiveSheet()->getColumnDimension($coloum[$col])->setWidth(7);

$col++;
$this->excel->getActiveSheet()->setCellValue($coloum[$col] . "" . $row, 'Volume');
$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getFont()->setSize(8);
$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getFont()->setBold(true);
$this->excel->getActiveSheet()->getColumnDimension($coloum[$col])->setWidth(10);

$col++;
$this->excel->getActiveSheet()->setCellValue($coloum[$col] . "" . $row, 'Material');
$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getFont()->setSize(8);
$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getFont()->setBold(true);
$this->excel->getActiveSheet()->getColumnDimension($coloum[$col])->setWidth(15);

$col++;
$this->excel->getActiveSheet()->setCellValue($coloum[$col] . "" . $row, 'Fabric');
$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getFont()->setSize(8);
$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getFont()->setBold(true);
$this->excel->getActiveSheet()->getColumnDimension($coloum[$col])->setWidth(15);

$col++;
$this->excel->getActiveSheet()->setCellValue($coloum[$col] . "" . $row, 'Color');
$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getFont()->setSize(8);
$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getFont()->setBold(true);
$this->excel->getActiveSheet()->getColumnDimension($coloum[$col])->setWidth(15);

$col++;
$this->excel->getActiveSheet()->setCellValue($coloum[$col] . "" . $row, 'Progress (%)');
$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getFont()->setSize(8);
$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getFont()->setBold(true);
$this->excel->getActiveSheet()->getColumnDimension($coloum[$col])->setWidth(10);

$col++;
$this->excel->getActiveSheet()->setCellValue($coloum[$col] . "" . $row, 'Production Week');
$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getFont()->setSize(8);
$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getFont()->setBold(true);
$this->excel->getActiveSheet()->getColumnDimension($coloum[$col])->setWidth(12);




$total_id_idr = 0;
$no = 1;
$row++;

foreach ($data as $result) {

    $col = 0;
    $this->excel->getActiveSheet()->getRowDimension($row)->setRowHeight(11);
    $this->excel->getActiveSheet()->setCellValue($coloum[$col] . "" . $row, $no++);
    $this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getFont()->setSize(8);
    $this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


    $col++;
    $this->excel->getActiveSheet()->setCellValue($coloum[$col] . "" . $row, $result->po_no);
    $this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getFont()->setSize(8);
    $this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);

    $col++;
    $this->excel->getActiveSheet()->setCellValue($coloum[$col] . "" . $row, $result->vendor_name);
    $this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getFont()->setSize(8);
    $this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);


    $col++;
    $this->excel->getActiveSheet()->setCellValue($coloum[$col] . "" . $row, trim(str_replace(" ", "", $result->serial_number)));
    $this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getFont()->setSize(8);
    $this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);

//    $col++;
//    $objDrawing = new PHPExcel_Worksheet_Drawing();
//    if ($result->product_image != "") {
//        $path = 'files/products_image/' . $result->product_image;
//        if (!file_exists($path)) {
//            $path = 'files/products_image/no-image.jpg';
//        }
//        $objDrawing->setPath($path);
//        $objDrawing->setWidthAndHeight(30, 30);
//        $objDrawing->setResizeProportional(true);
//        $objDrawing->setOffsetX(10);
//        $objDrawing->setOffsetY(10);
//        $objDrawing->setCoordinates($coloum[$col] . $row);
//        $objDrawing->setWorksheet($this->excel->getActiveSheet());
//    }

    $col++;
    $this->excel->getActiveSheet()->setCellValue($coloum[$col] . "" . $row, $result->component_category);
    $this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getFont()->setSize(8);
    $this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);

    $col++;
    $this->excel->getActiveSheet()->setCellValue($coloum[$col] . "" . $row, trim(str_replace(" ", "", $result->product_code)));
    $this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getFont()->setSize(8);
    $this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);

    $col++;
    $this->excel->getActiveSheet()->setCellValue($coloum[$col] . "" . $row, $result->product_name);
    $this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getFont()->setSize(8);
    $this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);

    $col++;
    $this->excel->getActiveSheet()->setCellValue($coloum[$col] . "" . $row, $result->width);
    $this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getFont()->setSize(8);
    $this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

    $col++;
    $this->excel->getActiveSheet()->setCellValue($coloum[$col] . "" . $row, $result->depth);
    $this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getFont()->setSize(8);
    $this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

    $col++;
    $this->excel->getActiveSheet()->setCellValue($coloum[$col] . "" . $row, $result->height);
    $this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getFont()->setSize(8);
    $this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

    $col++;
    $this->excel->getActiveSheet()->setCellValue($coloum[$col] . "" . $row, $result->volume);
    $this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getFont()->setSize(8);
    $this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);


    $col++;
    $this->excel->getActiveSheet()->setCellValue($coloum[$col] . "" . $row,$result->material);
    $this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getFont()->setSize(8);
    $this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);

    $col++;
    $this->excel->getActiveSheet()->setCellValue($coloum[$col] . "" . $row, $result->fabric_code);
    $this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getFont()->setSize(8);
    $this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);

    $col++;
    $this->excel->getActiveSheet()->setCellValue($coloum[$col] . "" . $row, $result->color);
    $this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getFont()->setSize(8);
    $this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);

    $col++;
    $this->excel->getActiveSheet()->setCellValue($coloum[$col] . "" . $row, $result->production_process_percent);
    $this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getFont()->setSize(8);
    $this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
    
    $col++;
    $this->excel->getActiveSheet()->setCellValue($coloum[$col] . "" . $row, $result->production_week);
    $this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getFont()->setSize(8);
    $this->excel->getActiveSheet()->getStyle($coloum[$col] . "" . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);



    $row++;
}


$row++;
$this->excel->getActiveSheet()->getStyle("R" . $row)->getFont()->setBold(true);
$this->excel->getActiveSheet()->setCellValue("R" . $row, $total_id_idr);
$this->excel->getActiveSheet()->getStyle("R" . $row)->getFont()->setSize(8);
$this->excel->getActiveSheet()->getStyle("R" . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$this->excel->getActiveSheet()->getStyle("R" . $row)->getNumberFormat()->setFormatCode('#,##0.00');

$styleArray = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
        )
    )
);

$this->excel->getActiveSheet()->getStyle("A3:" . $coloum[$col] . "" . $row)->applyFromArray($styleArray);

$filename = "file.xls";
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
$objWriter->save('php://output');
