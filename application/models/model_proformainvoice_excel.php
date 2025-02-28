<?php

/**
 * Copyright (C) 2013 BOX Living
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * 		http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @author eq
 * @copyright Copyright (c) 2013 BOX Living Pte, Ltd.
 * @package
 * @filesource model_proformainvoice_excel.php
 */

/**
 *
 * @author eq
 * @name mod_excel
 * @package package_name
 * @since
 *
 */
class model_proformainvoice_excel extends CI_Model {

    private $options = null;
    private $proformainvoice = null;
    private $page;
    private $sheet;
    private $margin;
    private $default_margin = 0;
    private $border = array();
    private $detail_info;
    private $drawing = null;
    private $private = null;
    private $client = null;
    private $order = null;
    private $shipping = null;
    private $volumes = 0;
    private $cellStart = 0;
    private $cells = array();
    private $cellsWidth = array();
    private $mergeCells = array();
    private $cellsHeader = array();
    private $writer = null;

    public function __construct() {
        parent::__construct();

        $this->load->library('phpexcel');
        $this->load->helper('download');
        $this->load->model('model_products');

        $this->border['outline'] = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array(
                        'argb' => 'FF000000'
                    )
                )
            )
        );

        $this->border['left'] = array(
            'borders' => array(
                'left' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array(
                        'argb' => 'FF000000'
                    )
                )
            )
        );

        $this->border['right'] = array(
            'borders' => array(
                'right' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array(
                        'argb' => 'FF000000'
                    )
                )
            )
        );

        $this->border['leftright'] = array(
            'borders' => array(
                'right' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array(
                        'argb' => 'FF000000'
                    )
                ),
                'left' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array(
                        'argb' => 'FF000000'
                    )
                )
            )
        );

        $this->border['top'] = array(
            'borders' => array(
                'top' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array(
                        'argb' => 'FF000000'
                    )
                )
            )
        );

        $this->border['bottom'] = array(
            'borders' => array(
                'botom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array(
                        'argb' => 'FF000000'
                    )
                )
            )
        );
    }

    /**
     * @author eq
     * @method initialize
     * @access
     * @since
     *
     * @param unknown $options
     */
    public function initialize($proformainvoice) {
        $this->proformainvoice = $proformainvoice;
//        $this->options = $options;
//
//        if (isset($this->options['orders']))
//            $this->order = $this->options['orders'];
//        if (isset($this->options['shipping']))
//            $this->shipping = $this->options['shipping'];

        $this->default_margin = 0.5 / 2.54;

        // ** page setup
        $this->page = new PHPExcel_Worksheet_PageSetup();
        $this->page->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $this->page->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $this->phpexcel->getActiveSheet()->setPageSetup($this->page);
        $this->sheet = $this->phpexcel->getActiveSheet();
        $this->margins = $this->sheet->getPageMargins();

        // margin is set in inches (0.5cm)
        $this->margins->setTop($this->default_margin);
        $this->margins->setBottom($this->default_margin);
        $this->margins->setLeft($this->default_margin);
        $this->margins->setRight($this->default_margin);

        //** header
        $this->phpexcel->getProperties()
                ->setCreator("BOX Living Marketing Team")
                ->setLastModifiedBy("EQ")
                ->setTitle("Order Confirmation " . date('Y'))
                ->setSubject("Order Confirmation " . date('Y'))
                ->setDescription("Order Confirmation " . date('Y'));

        // Set default font
        $this->phpexcel->getDefaultStyle()
                ->getFont()->setName('Arial')
                ->setSize(10);

        // Fill the cells / header
        $this->phpexcel->getActiveSheet()
                ->setCellValue('A1', 'Order Confirmation ' . date('Y') . ' ' . $this->proformainvoice->order_id)
                ->getStyle('A1')->getFont()
                ->setBold(true);
        $this->phpexcel->getActiveSheet()->mergeCells('A1:M1');

        $this->phpexcel->getActiveSheet()
                ->setCellValue('N1', 'OC ' . date('Y'))
                ->getStyle('N1')->getFont()
                ->setSize(20)
                ->setBold(true);
        $this->phpexcel->getActiveSheet()
                ->getStyle('N1')
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $this->phpexcel->getActiveSheet()->mergeCells('N1:P1');

        $this->phpexcel->getActiveSheet()
                ->getRowDimension(1)
                ->setRowHeight(30);

        $this->phpexcel->getActiveSheet()
                ->getStyle('P1')
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

        $this->phpexcel->getActiveSheet()
                ->getStyle('A2:P2')
                ->applyFromArray($this->border['outline']);

        $this->phpexcel->getActiveSheet()
                ->getStyle('A2:P2')
                ->applyFromArray(
                        array(
                            'fill' => array(
                                'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
                                'startcolor' => array('argb' => 'FF008F00'),
                                'endcolor' => array('argb' => 'FF008F00')
                            )
                        )
        );

        $this->phpexcel->getActiveSheet()->mergeCells('A2:O2');

        //** client information
        $this->detail_info = array(
            'A' => array(
                'start' => 3,
                'dataCell' => array(null, 'B', 'B', 'B', 'B', 'B', 'B', 'B', 'B'),
                'mergeCellsText' => array('A{0}:C{0}', null, null, null, null, null, null, null, null),
                'mergeCellsData' => array(null, 'B{0}:C{0}', 'B{0}:C{0}', 'B{0}:C{0}', 'B{0}:C{0}', 'B{0}:C{0}', 'B{0}:C{0}', 'B{0}:C{0}', 'B{0}:C{0}'),
                'text' => array('Bill To', 'Name', 'Company', 'Address 1', 'Address 2', 'Country', 'Phone', 'Fax', 'Email'),
                'data' => array(null, $this->proformainvoice->client_company_name, $this->proformainvoice->client_company_name, $this->proformainvoice->client_address, "", $this->proformainvoice->client_country, $this->proformainvoice->client_phone_fax, "", $this->proformainvoice->client_email)
            ),
            'D' => array(
                'start' => 3,
                'dataCell' => array(null, 'F', 'F', 'F', 'F', 'F', 'F', 'F', 'F'),
                'mergeCellsText' => array('D{0}:G{0}', 'D{0}:E{0}', 'D{0}:E{0}', 'D{0}:E{0}', 'D{0}:E{0}', 'D{0}:E{0}', 'D{0}:E{0}', 'D{0}:E{0}', 'D{0}:E{0}'),
                'mergeCellsData' => array(null, 'F{0}:G{0}', 'F{0}:G{0}', 'F{0}:G{0}', 'F{0}:G{0}', 'F{0}:G{0}', 'F{0}:G{0}', 'F{0}:G{0}', 'F{0}:G{0}'),
                'text' => array('Order Details', 'Order ID', 'Order Conf Date:', '', '', '', '', '', ''),
                'data' => array(null, $this->proformainvoice->order_id, date('F, jS Y', strtotime($this->proformainvoice->order_confirm_date)), '', '', '', '', '', ''),
            ),
            'H' => array(
                'start' => 3,
                'dataCell' => array(null, 'I', 'I', 'I', 'I', 'I', 'I', 'I', 'I'),
                'mergeCellsText' => array('H{0}:J{0}', null, null, null, null, null, null, null, null),
                'mergeCellsData' => array(null, 'I{0}:J{0}', 'I{0}:J{0}', 'I{0}:J{0}', 'I{0}:J{0}', 'I{0}:J{0}', 'I{0}:J{0}', 'I{0}:J{0}', 'I{0}:J{0}'),
                'text' => array('Shipping Details', 'Port of Loading:', 'Port of Destination:', 'Ship Via:', 'Notes:', '', '', '', ''),
                'data' => array(null, $this->proformainvoice->ship_port_of_loading, $this->proformainvoice->ship_port_of_destination, '', $this->proformainvoice->note, '', '', '', ''),
            ),
            'K' => array(
                'start' => 3,
                'dataCell' => array(null, 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L'),
                'mergeCellsText' => array('K{0}:P{0}', null, null, null, null, null, null, null, null),
                'mergeCellsData' => array(null, 'L{0}:P{0}', 'L{0}:P{0}', 'L{0}:P{0}', 'L{0}:P{0}', 'L{0}:P{0}', 'L{0}:P{0}', 'L{0}:P{0}', 'L{0}:P{0}'),
                'text' => array('Ship To', 'Name', 'Company', 'Address 1', 'Address 2', 'Country', 'Phone', 'Fax', 'Email'),
                'data' => array(null, $this->proformainvoice->client_shipto_name, $this->proformainvoice->client_shipto_company_name, $this->proformainvoice->ship_address, "", $this->proformainvoice->client_shipto_country_name, $this->proformainvoice->ship_phone_fax, '', $this->proformainvoice->client_shipto_email),
                'endCell' => 'P'
            )
        );

        //** apply the client information

        foreach ($this->detail_info as $k => $v) {
            $index = $v['start'];
            $c = 0;

            foreach ($v['text'] as $i => $text) {
                if (isset($v['text'])) {
                    $this->phpexcel->getActiveSheet()
                            ->getStyle($k . $index)
                            ->applyFromArray($this->border['left']);
                    $this->phpexcel->getActiveSheet()
                            ->setCellValue($k . $index, $text);

                    if ($index == $v['start']) {
                        $this->phpexcel->getActiveSheet()
                                ->getStyle($k . $index)->getFont()
                                ->setBold(true);
                    }

                    if (!is_null($v['mergeCellsText'][$c]) && $index >= $v['start']) {
                        $merge = $v['mergeCellsText'][$c];
                        $merge = str_replace('{0}', $index, $merge);
                        $this->phpexcel->getActiveSheet()->mergeCells($merge);
                    }
                }

                if (isset($v['endCell'])) {
                    $this->phpexcel->getActiveSheet()
                            ->getStyle($v['endCell'] . $index)
                            ->applyFromArray($this->border['right']);
                }

                if ($i == count($v['text'])) {
                    $this->phpexcel->getActiveSheet()
                            ->getStyle($v['endCell'] . $index)
                            ->applyFromArray($this->border['bottom']);
                }

                if (isset($v['data'])) {
                    if (!is_null($v['mergeCellsData'][$c]) && $index > $v['start']) {
                        $merge = $v['mergeCellsData'][$c];
                        $merge = str_replace('{0}', $index, $merge);
                        $this->phpexcel->getActiveSheet()->mergeCells($merge);
                    }

                    if (!is_null($v['dataCell'][$c])) {
                        $this->phpexcel->getActiveSheet()
                                ->setCellValue($v['dataCell'][$c] . $index, $v['data'][$i]);
                    }
                }

                $index++;
                $c++;
            }
        }

        $this->cellStart = '12';
        $this->cells = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P');
        $this->cellsWidth = array(17, 40, 5.3, 8.5, 8.5, 8.5, 8.5, 17, 17, 17, 12, 10, 20, 20, 10, 10);
        $this->mergeCells = array(null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
        $this->cellsHeader = array(
            'CODE',
            'NAME',
            'QTY',
            'WIDTH', 'DEPTH', 'HEIGHT',
            'VOLUME',
            'COLOR',
            'FABRIC',
            'MATERIAL',
            'MSRP (' . $this->proformainvoice->currency_code . ')',
            'DISC (%)',
            'FACTORY NET (' . $this->proformainvoice->currency_code . ')',
            'LINE TOTAL (' . $this->proformainvoice->currency_code . ')',
            'NOTES',
            'IMAGE'
        );

        foreach ($this->cells as $i => $c) {
            $this->phpexcel->getActiveSheet()
                    ->getStyle($c . $this->cellStart)
                    ->applyFromArray($this->border['outline']);

            if (!is_null($this->mergeCells[$i])) {
                $merge = $this->mergeCells[$i];
                $merge = str_replace('{0}', $this->cellStart, $merge);
                $this->phpexcel->getActiveSheet()->mergeCells($merge);
            }

            $this->phpexcel->getActiveSheet()->setCellValue($c . $this->cellStart, $this->cellsHeader[$i]);
            $this->phpexcel->getActiveSheet()->getColumnDimension($c)->setWidth($this->cellsWidth[$i]);
            $this->phpexcel->getActiveSheet()
                    ->getStyle($c . $this->cellStart)
                    ->getAlignment()
                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->phpexcel->getActiveSheet()
                    ->getStyle($c . $this->cellStart)->getFont()
                    ->setBold(true);
        }

        $this->phpexcel->getActiveSheet()
                ->getStyle('O' . $this->cellStart)
                ->applyFromArray($this->border['outline']);
    }

    /**
     * @author eq
     * @method display_image
     * @access
     * @since
     *
     * @param unknown $image
     * @param unknown $sheet
     * @param unknown $width
     * @param unknown $pos
     * @return boolean
     */
    protected function display_image($image, $sheet, $width, $pos) {
        $path = ROOT . "files/products_image" . DS . $image;
//        $path = ROOT . DS . 'assets' . DS . 'media' . DS . 'products' . DS . $image;

        if (is_file($path) && file_exists($path)) {
            $this->drawing = new PHPExcel_Worksheet_Drawing();
            $this->drawing->setPath($path);
            $this->drawing->setWidth($width);
            $this->drawing->setCoordinates($pos);
            $this->drawing->setOffsetY(2);
            $this->drawing->setOffsetX(0);
            $this->drawing->setWorksheet($sheet);

            return true;
        }

        return false;
    }

    /**
     * @author eq
     * @method generate_content
     * @access
     * @since
     *
     * @param unknown $products
     */
    public function generate_content($products) {
        
        $index = 1;
        
        foreach ($products as $p) {
            $boxes = $this->model_products->box_select_by_product_id($p->id);

            $volume = 0;
            foreach ($boxes as $key => $value) {
                $volume += ($value->width * $value->height * $value->depth) / 1000000000;
            }

            $this->volumes += $volume;

            $data = array(
                $p->product_code,
                $p->product_name,
                $p->qty,
                $p->width,
                $p->depth,
                $p->height,
                $p->volume,
                $p->color,
                $p->fabric,
                $p->material,
                $p->price,
                $p->discount,
                $p->net_factory,
                $p->line_total,
                $p->notes,
                $p->image
            );

            $this->phpexcel->getActiveSheet()->getRowDimension(12 + $index)->setRowHeight(55);
            foreach ($this->cells as $i => $c) {
                if (!is_null($this->mergeCells[$i])) {
                    $merge = $this->mergeCells[$i];
                    $merge = str_replace('{0}', ($index + $this->cellStart), $merge);
                    $o = explode(':', $merge);
                    $this->phpexcel->getActiveSheet()->mergeCells($merge);
                    $this->phpexcel->getActiveSheet()
                            ->getStyle($o[1])
                            ->applyFromArray($this->border['outline']);
                }

                if ($i == count($this->cells) - 1) {
                    if (!$this->display_image($data[$i], $this->phpexcel->getActiveSheet(), 68, $c . ($index + $this->cellStart))) {
                        $this->phpexcel->getActiveSheet()->setCellValue($c . ($index + $this->cellStart), 'No Image');
                    }
                } else {
                    $this->phpexcel->getActiveSheet()->setCellValue($c . ($index + $this->cellStart), $data[$i]);
                    $number_cells = array(2, 3, 4, 5, 10, 12, 13);
                    $wrapped_cells = array(7, 8, 9, 14);

                    if (in_array($i, $number_cells)) {
                        $this->phpexcel->getActiveSheet()
                                ->getStyle($c . ($index + $this->cellStart))
                                ->getNumberFormat()
                                ->setFormatCode('#0;[RED]-#0');
                    }

                    $number_cells = array(6);
                    if (in_array($i, $number_cells)) {
                        $this->phpexcel->getActiveSheet()
                                ->getStyle($c . ($index + $this->cellStart))
                                ->getNumberFormat()
                                ->setFormatCode('#,##0.000;[RED]-#,##0.000');
                    }

                    if (in_array($i, $wrapped_cells)) {
                        $this->phpexcel->getActiveSheet()
                                ->getStyle($c . ($index + $this->cellStart))
                                ->getAlignment()
                                ->setWrapText(true);
                    }
                }

                $this->phpexcel->getActiveSheet()
                        ->getStyle($c . ($index + $this->cellStart))
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->phpexcel->getActiveSheet()
                        ->getStyle($c . ($index + $this->cellStart))
                        ->getAlignment()
                        ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $this->phpexcel->getActiveSheet()
                        ->getStyle($c . ($index + $this->cellStart))
                        ->applyFromArray($this->border['outline']);
            }

            $index++;
        }

        $this->cells = array('A', 'I', 'P');
        foreach ($this->cells as $k => $v) {
            for ($i = 0; $i < 8; $i++) {
                if ($k == 0) {
                    $this->phpexcel->getActiveSheet()
                            ->getStyle($v . ($index + $this->cellStart + $i))
                            ->applyFromArray($this->border['left']);
                } else {
                    $this->phpexcel->getActiveSheet()
                            ->getStyle($v . ($index + $this->cellStart + $i))
                            ->applyFromArray($this->border['right']);
                }
            }
        }

        $this->footer($index);
    }

    /**
     * @author eq
     * @method footer
     * @access
     * @since
     *
     * @param unknown $index
     * @param unknown $total
     */
    private function footer($index) {
        $this->phpexcel->getActiveSheet()->setCellValue('A' . ($index + $this->cellStart), 'SINCERELY');
        $this->phpexcel->getActiveSheet()
                ->getStyle('A' . ($index + $this->cellStart))
                ->getAlignment()
                ->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

        $this->phpexcel->getActiveSheet()->setCellValue('C' . ($index + $this->cellStart), 'TOTAL VOLUME');
        $this->phpexcel->getActiveSheet()
                ->getStyle('C' . ($index + $this->cellStart))->getFont()
                ->setBold(true);
        $this->phpexcel->getActiveSheet()
                ->getStyle('C' . ($index + $this->cellStart))
                ->getAlignment()
                ->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $this->phpexcel->getActiveSheet()
                ->getStyle('C' . ($index + $this->cellStart))
                ->applyFromArray($this->border['left']);

        $this->phpexcel->getActiveSheet()->setCellValue('G' . ($index + $this->cellStart), $this->volumes);
        $this->phpexcel->getActiveSheet()
                ->getStyle('G' . ($index + $this->cellStart))
                ->getAlignment()
                ->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $this->phpexcel->getActiveSheet()
                ->getStyle('G' . ($index + $this->cellStart))
                ->getNumberFormat()
                ->setFormatCode('#,##0.000;[RED]-#,##0.000');
        $this->phpexcel->getActiveSheet()
                ->getStyle('G' . ($index + $this->cellStart))
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->phpexcel->getActiveSheet()
                ->getStyle('G' . ($index + $this->cellStart))
                ->getAlignment()
                ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->phpexcel->getActiveSheet()
                ->getStyle('G' . ($index + $this->cellStart))
                ->applyFromArray($this->border['right']);

        for ($i = $index; $i < ($index + 8); $i++) {
            $this->phpexcel->getActiveSheet()
                    ->getStyle('C' . ($i + $this->cellStart))
                    ->applyFromArray($this->border['left']);
            $this->phpexcel->getActiveSheet()
                    ->getStyle('G' . ($i + $this->cellStart))
                    ->applyFromArray($this->border['right']);
        }

        $this->phpexcel->getActiveSheet()->setCellValue('J' . ($index + $this->cellStart), 'SUB TOTAL');
        $this->phpexcel->getActiveSheet()
                ->getStyle('J' . ($index + $this->cellStart))->getFont()
                ->setBold(true);
        $this->phpexcel->getActiveSheet()->setCellValue('N' . ($index + $this->cellStart), number_format($this->proformainvoice->total, 0, '.', ','));
        $this->phpexcel->getActiveSheet()
                ->getStyle('N' . ($index + $this->cellStart))
                ->getNumberFormat()
                ->setFormatCode('#,##0;[RED]-#,##0');
        $this->phpexcel->getActiveSheet()
                ->getStyle('N' . ($index + $this->cellStart))->getFont()
                ->setBold(true);
        $this->phpexcel->getActiveSheet()
                ->getStyle('N' . ($index + $this->cellStart))
                ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);


        $index += 2;
        $this->phpexcel->getActiveSheet()->setCellValue('J' . ($index + $this->cellStart), 'TOTAL PAYMENTS');
        $this->phpexcel->getActiveSheet()
                ->getStyle('J' . ($index + $this->cellStart))->getFont()
                ->setBold(true);


        $index++;
        $this->phpexcel->getActiveSheet()->setCellValue('K' . ($index + $this->cellStart), 'DP');
        $this->phpexcel->getActiveSheet()
                ->getStyle('K' . ($index + $this->cellStart))->getFont()
                ->setBold(true);
        $this->phpexcel->getActiveSheet()->setCellValue('L' . ($index + $this->cellStart), $this->proformainvoice->down_payment . '%');
        $this->phpexcel->getActiveSheet()
                ->getStyle('L' . ($index + $this->cellStart))->getFont()
                ->setBold(true);
        $this->phpexcel->getActiveSheet()->setCellValue('N' . ($index + $this->cellStart), number_format($this->proformainvoice->down_payment_nominal, 0, '.', ','));
        $this->phpexcel->getActiveSheet()
                ->getStyle('N' . ($index + $this->cellStart))
                ->getNumberFormat()
                ->setFormatCode('#,##0;[RED]-#,##0');
        $this->phpexcel->getActiveSheet()
                ->getStyle('N' . ($index + $this->cellStart))->getFont()
                ->setBold(true);
        $this->phpexcel->getActiveSheet()
                ->getStyle('N' . ($index + $this->cellStart))
                ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

        $index++;
        $this->phpexcel->getActiveSheet()->setCellValue('K' . ($index + $this->cellStart), 'VAT');
        $this->phpexcel->getActiveSheet()
                ->getStyle('K' . ($index + $this->cellStart))->getFont()
                ->setBold(true);
        $this->phpexcel->getActiveSheet()->setCellValue('L' . ($index + $this->cellStart), $this->proformainvoice->vat . '%');
        $this->phpexcel->getActiveSheet()
                ->getStyle('L' . ($index + $this->cellStart))->getFont()
                ->setBold(true);
        $this->phpexcel->getActiveSheet()->setCellValue('N' . ($index + $this->cellStart), number_format($this->proformainvoice->vat_nominal, 0, '.', ','));
        $this->phpexcel->getActiveSheet()
                ->getStyle('N' . ($index + $this->cellStart))
                ->getNumberFormat()
                ->setFormatCode('#0;[RED]-#0');
        $this->phpexcel->getActiveSheet()
                ->getStyle('N' . ($index + $this->cellStart))->getFont()
                ->setBold(true);
        $this->phpexcel->getActiveSheet()
                ->getStyle('N' . ($index + $this->cellStart))
                ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

        $index += 3;
        $this->phpexcel->getActiveSheet()->setCellValue('J' . ($index + $this->cellStart), 'TOTAL');
        $this->phpexcel->getActiveSheet()
                ->getStyle('J' . ($index + $this->cellStart))->getFont()
                ->setBold(true);
        $this->phpexcel->getActiveSheet()->setCellValue('N' . ($index + $this->cellStart), number_format($this->proformainvoice->balance_due, 0, '.', ','));
        $this->phpexcel->getActiveSheet()
                ->getStyle('N' . ($index + $this->cellStart))
                ->getNumberFormat()
                ->setFormatCode('#0;[RED]-#0');
        $this->phpexcel->getActiveSheet()
                ->getStyle('N' . ($index + $this->cellStart))->getFont()
                ->setBold(true);
        $this->phpexcel->getActiveSheet()
                ->getStyle('N' . ($index + $this->cellStart))
                ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

        $index++;
        $cells = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P');
        foreach ($cells as $k => $v) {
            $this->phpexcel->getActiveSheet()
                    ->getStyle($v . ($index + $this->cellStart))
                    ->applyFromArray($this->border['top']);
        }

        // Rename worksheet
        $this->phpexcel->getActiveSheet()->setTitle($this->proformainvoice->order_id);

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $this->phpexcel->setActiveSheetIndex(0);
    }

    /**
     * @author eq
     * @method download
     * @access
     * @since
     *
     */
    public function download() {
        // Redirect output to a client’s web browser (Excel2007)
        $path = ROOT . DS . 'temp' . DS;
        $filename = $this->proformainvoice->order_id . '.xlsx';

        //** get the result
        $this->writer = PHPExcel_IOFactory::createWriter($this->phpexcel, 'Excel2007');
        $this->writer->save($path . $filename);

        //** get the content of the file
        $content = file_get_contents($path . $filename);
        //** delete the original file before downloading
        unlink($path . $filename);

        force_download($filename, $content);
    }

}