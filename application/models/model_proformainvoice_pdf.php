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
 * @filesource model_proformainvoice_pdf.php
 */
class model_proformainvoice_pdf extends CI_Model {

    private $total_box = 0;
    private $total_volume = 0;
    private $total_price = 0;
    private $current_page = 1;
    private $current_line = 0;
    private $current_row = 1;
    private $margin_top = 83.7;
    private $pages = 1;
    private $total_pages = 0;
    private $filename = "";
    private $path = "";
    private $pdf = null;

    public function __construct() {
        parent::__construct();

        $this->load->library('session');
        $this->load->library('tcpdf/tcpdf');
        $this->load->model('model_products');
        $this->load->helper('date');
        $this->load->helper('download');

        $this->path = ROOT . 'temp' . DS;
        $this->pdf = new TCPDF();
    }

    public function initialize() {
        $this->pdf->setPageOrientation('P', true, 2);
        $this->pdf->SetCompression(true);
        $this->pdf->setPrintHeader(false);
        $this->pdf->setPrintFooter(false);
        $this->pdf->SetMargins(4, 4, 4);
        // set image scale factor
        $this->pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $this->pdf->AddPage();
    }

    public function set_path($path) {
        $this->path = $path;
    }

    private function content_header($order) {
        $this->pdf->SetFont('', 'B', 6);
        $this->pdf->setCellPaddings(2.50, 0, 2.50, 0);
        $this->pdf->MultiCell(19, 6, "PRODUCT ID\n\n\n", array('BR' => array('width' => 0.25), 'LT' => array('width' => 0.50)), 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell(28, 6, "PRODUCT NAME\n\n\n", array('BR' => array('width' => 0.25), 'T' => array('width' => 0.50)), 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell(21, 6, "IMAGE\n\n\n", array('BR' => array('width' => 0.25), 'T' => array('width' => 0.50)), 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell(32, 6, "DIMENSION\n(mm)\n\n", array('BR' => array('width' => 0.25), 'T' => array('width' => 0.50)), 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell(10, 6, "VOL\n(m3)\n\n", array('BR' => array('width' => 0.25), 'T' => array('width' => 0.50)), 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell(18, 6, "MATERIAL\n\n\n", array('BR' => array('width' => 0.25), 'T' => array('width' => 0.50)), 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell(10, 6, "QTY\n\n\n", array('BR' => array('width' => 0.25), 'T' => array('width' => 0.50)), 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell(18, 6, "UNIT PRICE\n(" . $order->currency_code . ")\n\n", array('BR' => array('width' => 0.25), 'T' => array('width' => 0.50)), 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell(11, 6, "DISC\n(%)\n\n", array('BR' => array('width' => 0.25), 'T' => array('width' => 0.50)), 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell(18, 6, "NET FACTORY\n(" . $order->currency_code . ")", array('BR' => array('width' => 0.25), 'T' => array('width' => 0.50)), 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell(17, 6, "LINE TOTAL\n(" . $order->currency_code . ")", array('B' => array('width' => 0.25), 'TR' => array('width' => 0.50)), 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->Ln();
    }

    public function create_header($proforma_invoice) {
        $this->load->model('model_company', 'company');
        $company = $this->company->select_by_id($proforma_invoice->company_id);
        $this->pdf->SetCellPadding(2);
        $this->pdf->SetFont('', 'B', 7);
        $this->pdf->Cell(50, 5, $company->name, array('LT' => array('width' => 0.50), 'B' => array('width' => 0.25)));
        $this->pdf->SetFont('', '', 7);
        $this->pdf->Cell(0, 5, $company->address /* . ($company->telp != '' ? ', Telp: ' . $company->telp : '') . ($company->fax != '' ? ', Fax: ' . $company->fax : '') */, array('TR' => array('width' => 0.50), 'B' => array('width' => 0.25)), '', 'R');
        $this->pdf->Ln();

        $this->pdf->SetFont('', 'B', 7);
        $this->pdf->setCellPaddings(2.50, 0, 2.50, 0);
        $this->pdf->Cell(33, 0, "", array('L' => array('width' => 0.50)));
        $this->pdf->Cell(107, 0, "", array('R' => array('width' => 0.25)));
        $this->pdf->Cell(0, 0, "", array('R' => array('width' => 0.50)));
        $this->pdf->Ln();
        $this->pdf->setCellPaddings(2.50, 0, 2.50, 0);
        $this->pdf->Cell(33, 0, "CLIENT ID", array('L' => array('width' => 0.50)));
        $this->pdf->SetFont('', '', 7);
        $this->pdf->Cell(107, 0, ": " . $proforma_invoice->client_code, array('R' => array('width' => 0.25)));
        $this->pdf->Cell(0, 0, "", array('R' => array('width' => 0.50)));
        $this->pdf->Ln();
        $this->pdf->SetFont('', 'B', 7);
        $this->pdf->setCellPaddings(2.50, 0, 2.50, 0);
        $this->pdf->Cell(33, 0, "COMPANY NAME", array('L' => array('width' => 0.50)));
        $this->pdf->SetFont('', '', 7);
        $this->pdf->Cell(107, 0, ": " . $proforma_invoice->client_company_name, array('R' => array('width' => 0.25)));
        $this->pdf->Cell(0, 0, "", array('R' => array('width' => 0.50)));
        $this->pdf->Ln();
        $this->pdf->SetFont('', 'B', 7);
        $this->pdf->setCellPaddings(2.50, 0, 2.50, 0);
        $this->pdf->Cell(33, 0, "ADDRESS", array('L' => array('width' => 0.50)));
        $this->pdf->SetFont('', '', 7);
        $this->pdf->Cell(107, 0, ": " . $proforma_invoice->client_address, array('R' => array('width' => 0.25)));
        $this->pdf->Cell(0, 0, "", array('R' => array('width' => 0.50)));
        $this->pdf->Ln();
        $this->pdf->SetFont('', 'B', 7);
        $this->pdf->setCellPaddings(2.50, 0, 2.50, 0);
        $this->pdf->Cell(33, 0, "COUNTRY", array('L' => array('width' => 0.50)));
        $this->pdf->SetFont('', '', 7);
        $this->pdf->Cell(107, 0, ": " . $proforma_invoice->client_country, array('R' => array('width' => 0.25)));
        $this->pdf->Cell(0, 0, "", array('R' => array('width' => 0.50)));
        $this->pdf->Ln();
        $this->pdf->SetFont('', 'B', 7);
        $this->pdf->setCellPaddings(2.50, 0, 2.50, 0);
        $this->pdf->Cell(33, 0, "PHONE / FAX", array('L' => array('width' => 0.50)));
        $this->pdf->SetFont('', '', 7);
        $this->pdf->Cell(107, 0, ": " . $proforma_invoice->client_phone_fax, array('R' => array('width' => 0.25)));
        $this->pdf->Cell(0, 0, "", array('R' => array('width' => 0.50)));
        $this->pdf->Ln();
        $this->pdf->SetFont('', 'B', 7);
        $this->pdf->setCellPaddings(2.50, 0, 2.50, 0);
        $this->pdf->Cell(33, 0, "EMAIL", array('L' => array('width' => 0.50)));
        $this->pdf->SetFont('', '', 7);
        $this->pdf->Cell(107, 0, ": " . $proforma_invoice->client_email, array('R' => array('width' => 0.25)));
        $this->pdf->Cell(0, 0, "", array('R' => array('width' => 0.50)));
        $this->pdf->SetFont('', 'B', 28);
        $this->pdf->Text(143.8, 20.3, "P.I.");
        $this->pdf->Ln();
        $this->pdf->SetFont('', 'B', 7);
        $this->pdf->Cell(33, 0, "CONTACT NAME", array('L' => array('width' => 0.50)));
        $this->pdf->SetFont('', '', 7);
        $this->pdf->Cell(107, 0, ": " . $proforma_invoice->client_name, array('R' => array('width' => 0.25)));
        $this->pdf->SetFont('', 'B', 7);
        $this->pdf->Cell(0, 0, "PROFORMA INVOICE", array('R' => array('width' => 0.50)));
        $this->pdf->Ln();
        $this->pdf->setCellPaddings(2.50, 0, 2.50, 0);
        $this->pdf->Cell(33, 0, "", array('L' => array('width' => 0.50), 'B' => array('width' => 0.25)));
        $this->pdf->Cell(107, 0, "", array('R' => array('width' => 0.25), 'B' => array('width' => 0.25)));
        $this->pdf->Cell(0, 0, "", array('R' => array('width' => 0.50), 'B' => array('width' => 0.25)));
        $this->pdf->Ln();
        $this->pdf->SetFont('', '', 2);
        $this->pdf->Cell(0, 0, "", array('LR' => array('width' => 0.50), 'TB' => array('width' => 0.25)));
        $this->pdf->Ln();
        $this->pdf->SetFont('', 'B', 7);
        $this->pdf->SetFont('', 'B', 7);
        $this->pdf->setCellPaddings(2.50, 0, 2.50, 0);
        $this->pdf->Cell(98, 0, "", array('L' => array('width' => 0.50), 'R' => array('width' => 0.25)));
        $this->pdf->Cell(0, 0, "", array('R' => array('width' => 0.50)));
        $this->pdf->Ln();
        $this->pdf->setCellPaddings(2.50, 0, 2.50, 0);
        $this->pdf->Cell(98, 0, "ORDER DETAILS", array('L' => array('width' => 0.50), 'R' => array('width' => 0.25)));
        $this->pdf->Cell(0, 0, "SHIPPING DETAILS", array('R' => array('width' => 0.50)));
        $this->pdf->Ln();
        $this->pdf->SetFont('', 'B', 7);
        $this->pdf->Cell(33, 0, "ORDER ID", array('L' => array('width' => 0.50)));
        $this->pdf->SetFont('', '', 7);
        $this->pdf->Cell(65, 0, ": " . $proforma_invoice->order_id, array('R' => array('width' => 0.25)));
        $this->pdf->SetFont('', 'B', 7);
        $this->pdf->Cell(33, 0, "SHIP TO", 0);
        $this->pdf->SetFont('', '', 7);
        $this->pdf->Cell(0, 0, ": " . $proforma_invoice->client_shipto_company_name, array('R' => array('width' => 0.50)));
        $this->pdf->Ln();
        $this->pdf->SetFont('', 'B', 7);
        $this->pdf->Cell(33, 0, "P.I DATE", array('L' => array('width' => 0.50)));
        $this->pdf->SetFont('', '', 7);
        $this->pdf->Cell(65, 0, ": " . date('d M Y', strtotime($proforma_invoice->order_confirm_date)), array('R' => array('width' => 0.25)));
        $this->pdf->SetFont('', 'B', 7);
        $this->pdf->Cell(33, 0, "ADDRESS", 0);
        $this->pdf->SetFont('', '', 7);
        $this->pdf->Cell(0, 0, ": " . $proforma_invoice->ship_address, array('R' => array('width' => 0.50)));
        $this->pdf->Ln();
        $this->pdf->SetFont('', 'B', 7);
        $this->pdf->Cell(33, 0, "INVOICE DATE", array('L' => array('width' => 0.50)));
        $this->pdf->SetFont('', '', 7);
        $this->pdf->Cell(65, 0, ": " . date('d M Y', strtotime($proforma_invoice->order_invoice_date)), array('R' => array('width' => 0.25)));
        $this->pdf->SetFont('', 'B', 7);
        $this->pdf->Cell(33, 0, "PHONE / FAX", 0);
        $this->pdf->SetFont('', '', 7);
        $this->pdf->Cell(0, 0, ": " . $proforma_invoice->ship_phone_fax, array('R' => array('width' => 0.50)));
        $this->pdf->Ln();
        $this->pdf->SetFont('', 'B', 7);
        $this->pdf->Cell(33, 0, "TARGET SHIP DATE", array('L' => array('width' => 0.50)));
        $this->pdf->SetFont('', '', 7);
        $this->pdf->Cell(65, 0, ": " . date('d M Y', strtotime($proforma_invoice->order_target_ship_date)), array('R' => array('width' => 0.25)));
        $this->pdf->SetFont('', 'B', 7);
        $this->pdf->Cell(33, 0, "EMAIL", 0);
        $this->pdf->SetFont('', '', 7);
        $this->pdf->Cell(0, 0, ": " . $proforma_invoice->client_shipto_email, array('R' => array('width' => 0.50)));
        $this->pdf->Ln();
        $this->pdf->SetFont('', 'B', 7);
        $this->pdf->Cell(33, 0, "PAYMENT TERMS", array('L' => array('width' => 0.50)));
        $this->pdf->SetFont('', '', 7);
        $this->pdf->Cell(65, 0, ": " . $proforma_invoice->payment_term, array('R' => array('width' => 0.25)));
        $this->pdf->SetFont('', 'B', 7);
        $this->pdf->Cell(33, 0, "CONTACT NAME", 0);
        $this->pdf->SetFont('', '', 7);
        $this->pdf->Cell(0, 0, ": " . $proforma_invoice->client_shipto_contact_name, array('R' => array('width' => 0.50)));
        $this->pdf->Ln();
        $this->pdf->SetFont('', 'B', 7);
        $this->pdf->Cell(33, 0, "CONTRACT TERMS", array('L' => array('width' => 0.50)));
        $this->pdf->SetFont('', 'B', 7);
        $this->pdf->Cell(65, 0, ": " . $proforma_invoice->order_contract_term, array('R' => array('width' => 0.25)));
        $this->pdf->SetFont('', 'B', 7);
        $this->pdf->Cell(33, 0, "PORT OF LOADING", 0);
        $this->pdf->SetFont('', '', 7);
        $this->pdf->Cell(0, 0, ": " . $proforma_invoice->ship_port_of_loading, array('R' => array('width' => 0.50)));
        $this->pdf->Ln();
        $this->pdf->SetFont('', 'B', 7);
        $this->pdf->Cell(33, 0, "", array('L' => array('width' => 0.50)));
        $this->pdf->SetFont('', '', 7);
        $this->pdf->Cell(65, 0, " ", array('R' => array('width' => 0.25)));
        $this->pdf->SetFont('', 'B', 7);
        $this->pdf->Cell(33, 0, "PORT OF DESTINATION", 0);
        $this->pdf->SetFont('', '', 7);
        $this->pdf->Cell(0, 0, ": " . $proforma_invoice->ship_port_of_destination, array('R' => array('width' => 0.50)));
        $this->pdf->Ln();
        $this->pdf->SetFont('', 'B', 7);
        $this->pdf->Cell(33, 0, "", array('L' => array('width' => 0.50)));
        $this->pdf->SetFont('', '', 7);
        $this->pdf->Cell(65, 0, "", array('R' => array('width' => 0.25)));
        $this->pdf->SetFont('', 'B', 7);
        $this->pdf->Cell(33, 0, "COUNTRY", 0);
        $this->pdf->SetFont('', '', 7);
        $this->pdf->Cell(0, 0, ": " . $proforma_invoice->client_shipto_country_name, array('R' => array('width' => 0.50)));
        $this->pdf->Ln();
        $this->pdf->SetFont('', '', 5);
        $this->pdf->Cell(33, 0, "", array('LB' => array('width' => 0.50)));
        $this->pdf->SetFont('', '', 5);
        $this->pdf->Cell(65, 0, "", array('R' => array('width' => 0.25), 'B' => array('width' => 0.50)));
        $this->pdf->SetFont('', '', 5);
        $this->pdf->Cell(33, 0, "", array('B' => array('width' => 0.50)));
        $this->pdf->SetFont('', '', 5);
        $this->pdf->Cell(0, 0, "", array('RB' => array('width' => 0.50)));
        $this->pdf->Ln(4);
    }

    private function add_empty_row($row, $max) {
        $lines = array('R' => array('width' => 0.25));
        $left = array('L' => array('width' => 0.50), 'R' => array('width' => 0.25));

        if ($row == $max) {
            $lines['B'] = array('width' => 0.25);
            $left['B'] = array('width' => 0.25);
        }

        $this->pdf->MultiCell(19, 20.5, " ", $left, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell(28, 20.5, " ", $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell(21, 20.5, " ", $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell(10.66, 20.5, " ", $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell(10.66, 20.5, " ", $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell(10.66, 20.5, " ", $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell(10, 20.5, " ", $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell(18, 20.5, " ", $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell(10, 20.5, " ", $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell(18, 20.5, " ", $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell(11, 20.5, " ", $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell(18, 20.5, " ", $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $lines['R'] = array('width' => 0.50);
        $this->pdf->MultiCell(17, 20.5, " ", $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->Ln();
    }

    public function generate_content($order, $products) {
        $this->content_header($order);

        $total_product = count($products);
        if ($total_product < 9) {
            $this->total_pages = 1;
        } else {
            $t = $total_product - 9;
            $pages = 1 + ceil($t / 14) + ($t % 14);
            $this->total_pages = $pages;
        }

        foreach ($products as $p) {

            $boxes = $this->model_products->box_select_by_product_id($p->products_id);
            $box_count = 0;
            $volume = 0;

            //** boxes volume
            foreach ($boxes as $b) {
                $volume += ($b->width * $b->height * $b->depth) / 1000000000;
                $box_count++;
            }

            //** total volume
            $this->total_volume += $volume;

            $this->total_box += ($box_count * $p->qty);
            $this->total_volume += ($volume * $p->qty);

            $lines = array();
            $leftLines = array('L' => array('width' => 0.50), 'R' => array('width' => 0.25));

            if ($this->total_pages == 1) {
                if ($this->current_row == 10 && count($products) > 10) {
                    $lines = array('B' => array('width' => 0.50), 'R' => array('width' => 0.25));
                    $leftLines['B'] = array('width' => 0.50);
                } else {
                    $lines = array('R' => array('width' => 0.25));
                }
            } else {
                if ($this->current_page == 1) {
                    if ($this->current_row == 10) {
                        $lines = array('B' => array('width' => 0.50), 'R' => array('width' => 0.25));
                        $leftLines['B'] = array('width' => 0.50);
                    } else {
                        $lines = array('R' => array('width' => 0.25));
                    }
                } else {
                    if ($this->current_row == 13) {
                        $lines = array('B' => array('width' => 0.50), 'R' => array('width' => 0.25));
                        $leftLines['B'] = array('width' => 0.50);
                    } else {
                        $lines = array('R' => array('width' => 0.25));
                    }
                }
            }

            $this->pdf->SetFont('', '', 6);
            $this->pdf->SetCellPadding(0.75);

            $imagePath = ROOT . "files/products_image" . DS . $p->image;
//            echo $imagePath."<br/>";
            if (file_exists($imagePath) && is_file($imagePath)) {
                $image = $this->pdf->Image(
                        $imagePath, 51.5, $this->margin_top + (20.5 * $this->current_line), 20, 20, '', '', '', true, 300, '', false, false, 0, true, false, false, false);
            }
            $this->pdf->MultiCell(19, 20.5, $p->product_code . ' ' . $this->total_pages, $leftLines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
            $this->pdf->MultiCell(28, 20.5, $p->product_name, $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
            $this->pdf->MultiCell(21, 20.5, "", $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
            $this->pdf->MultiCell(10.66, 20.5, $p->width, $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
            $this->pdf->MultiCell(10.66, 20.5, $p->depth, $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
            $this->pdf->MultiCell(10.66, 20.5, $p->height, $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
            $this->pdf->MultiCell(10, 20.5, number_format($p->volume, 3, '.', '.'), $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
            $this->pdf->MultiCell(18, 20.5, $p->material, $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
            $this->pdf->MultiCell(10, 20.5, $p->qty, $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
            $this->pdf->MultiCell(18, 20.5, number_format($p->price, 0), $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
            $this->pdf->MultiCell(11, 20.5, $p->discount, $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
            $this->pdf->MultiCell(18, 20.5, number_format($p->net_factory, 0), $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
            $lines['R'] = array('width' => 0.50);
            $this->pdf->MultiCell(17, 20.5, number_format($p->line_total, 0), $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
            $this->pdf->Ln(20.5);



            $this->current_row++;
            ++$this->current_line;

            if ($this->total_pages == 1) {
                if (count($products) > 8) {
                    if ($this->current_row == 10) {
                        $this->current_page++;
                        $this->current_row = 1;
                        $this->margin_top = 13;
                        $this->current_line = 0;
                        $this->pdf->AddPage();
                        $this->content_header($order);
                    }
                }
            } else {
                if ($this->current_page == 1) {
                    if ($this->current_row == 11) {
                        $this->current_page++;
                        $this->current_row = 1;
                        $this->margin_top = 13;
                        $this->current_line = 0;
                        $this->pdf->AddPage();
                        $this->content_header($order);
                    }
                } else {
                    //** count last page first
                    if ($this->current_page == $this->total_pages) {
                        if ($this->current_row == 12) {
                            $this->current_page++;
                            $this->current_row = 1;
                            $this->margin_top = 13;
                            $this->current_line = 0;
                            $this->pdf->AddPage();
                            $this->content_header($order);
                        }
                    } else {
                        if ($this->current_row == 14) {
                            $this->current_page++;
                            $this->current_row = 1;
                            $this->margin_top = 13;
                            $this->current_line = 0;
                            $this->pdf->AddPage();
                            $this->content_header($order);
                        }
                    }
                }
            }
        }

        if ($this->total_pages == 1) {
            if (count($products) <= 10) {
                if ($this->current_row < 8) {
                    $max = 8 - $this->current_row;
                    for ($i = 0; $i < $max; $i++) {
                        $this->add_empty_row($i + 1, $max);
                    }
                }
            } else {
                if ($this->current_row < 12) {
                    $max = 12 - $this->current_row;
                    for ($i = 0; $i < $max; $i++) {
                        $this->add_empty_row($i + 1, $max);
                    }
                }
            }
        } else {
            if ($this->current_row < 12) {
                $max = 12 - $this->current_row;
                for ($i = 0; $i < $max; $i++) {
                    $this->add_empty_row($i + 1, $max);
                }
            }
        }

        $this->pdf->SetFont('', '0', 2);
        $this->pdf->SetCellPadding(0);
        $this->pdf->Cell(0, 0, " ", array('B' => array('width' => 0.25), 'LR' => array('width' => 0.50)));
        $this->pdf->Ln();



        $this->pdf->SetFont('', 'B', 6);
        $this->pdf->setCellPaddings(2.50, 1.50, 2.50, 0);
        $this->pdf->Cell(79, 0, "REMARKS : " . $order->remark, array('R' => array('width' => 0.25), 'L' => array('width' => 0.50)));
        $this->pdf->Cell(21, 0, "BOX :", array('R' => array('width' => 0.25)));
        $this->pdf->Cell(67, 0, "TOTAL :", array('BR' => array('width' => 0.25)));
        $this->pdf->Cell(9, 0, $order->currency_code, array('B' => array('width' => 0.25)));
        $this->pdf->Cell(26, 0, number_format($order->total, 0, '.', '.'), array('B' => array('width' => 0.25), 'R' => array('width' => 0.50)), '', 'R');
        $this->pdf->Ln();

        $this->pdf->setCellPaddings(2.50, 1.50, 2.50, 0);
        $this->pdf->Cell(79, 0, $order->note, array('R' => array('width' => 0.25), 'L' => array('width' => 0.50)));
        $this->pdf->Cell(21, 0, $this->total_box . " boxes", array('RB' => array('width' => 0.25)), '', 'R');
        $this->pdf->Cell(38, 0, "DOWN PAYMENT", array('RB' => array('width' => 0.25)));
        $this->pdf->Cell(18, 0, date('d M Y', strtotime($order->down_payment_date)), array('RB' => array('width' => 0.25)));
        $this->pdf->Cell(11, 0, $order->down_payment . " %", array('RB' => array('width' => 0.25)));
        $this->pdf->Cell(9, 0, $order->currency_code, array('B' => array('width' => 0.25)));
        $this->pdf->Cell(26, 0, number_format($order->down_payment_nominal, 0, '.', '.'), array('B' => array('width' => 0.25), 'R' => array('width' => 0.50)), '', 'R');
        $this->pdf->Ln();

        $this->pdf->setCellPaddings(2.50, 1.50, 2.50, 0);
        $this->pdf->Cell(79, 0, "", array('R' => array('width' => 0.25), 'L' => array('width' => 0.50)));
        $this->pdf->Cell(21, 0, "VOLUME :", array('R' => array('width' => 0.25)));
        $this->pdf->Cell(38, 0, "VAT.", array('RB' => array('width' => 0.25)));
        $this->pdf->Cell(29, 0, $order->vat . " %", array('RB' => array('width' => 0.25)));
        $this->pdf->Cell(9, 0, $order->currency_code, array('B' => array('width' => 0.25)));
        $this->pdf->Cell(26, 0, number_format($order->vat_nominal, 0, '.', '.'), array('B' => array('width' => 0.25), 'R' => array('width' => 0.50)), '', 'R');
        $this->pdf->Ln();

        $this->pdf->setCellPaddings(2.50, 1.50, 2.50, 0);
        $this->pdf->Cell(79, 0, "", array('R' => array('width' => 0.25), 'LB' => array('width' => 0.50)));
        $this->pdf->Cell(21, 0, number_format($this->total_volume, 2, '.', ',') . " m3", array('R' => array('width' => 0.25), 'B' => array('width' => 0.50)), '', 'R');
        $this->pdf->Cell(67, 0, "BALANCE DUE", array('R' => array('width' => 0.25), 'B' => array('width' => 0.50)));
        $this->pdf->Cell(9, 0, $order->currency_code, array('B' => array('width' => 0.50)));
        $this->pdf->Cell(26, 0, number_format($order->balance_due, 0, '.', '.'), array('RB' => array('width' => 0.50)), '', 'R');
        $this->pdf->Ln(6);

        $this->pdf->setCellPaddings(2.50, 0, 2.50, 0);
        $this->pdf->Cell(33, 0, "", array('TL' => array('width' => 0.50)));
        $this->pdf->Cell(66, 0, "", array('TR' => array('width' => 0.50)));
        $this->pdf->Cell(0, 0, "", array('TR' => array('width' => 0.50)));
        $this->pdf->Ln(2);
        $this->pdf->Cell(33, 0, "BILL TO BANK", array('L' => array('width' => 0.50)));
        $this->pdf->Cell(66, 0, ": ANZ PANIN BANK", array('R' => array('width' => 0.50)));
        $this->pdf->Cell(0, 0, "This Proforma Invoice will be confirmed as a Commercial Invoice once deposit funds", array('R' => array('width' => 0.50)));
        $this->pdf->Ln();

        $this->pdf->setCellPaddings(2.50, 0, 2.50, 0);
        $this->pdf->SetFont('', 'B', 6);
        $this->pdf->Cell(33, 0, "ADDRESS", array('L' => array('width' => 0.50)));
        $this->pdf->SetFont('', '', 6);
        $this->pdf->Cell(66, 0, ": ANZ TOWER, JL. JENDRAL SUDIRMAN KAV. 33A, JAKARTA", array('R' => array('width' => 0.50)));
        $this->pdf->SetFont('', 'B', 6);
        $this->pdf->Cell(0, 0, "have been received.", array('R' => array('width' => 0.50)));
        $this->pdf->Ln();

        $this->pdf->setCellPaddings(2.50, 0, 2.50, 0);
        $this->pdf->SetFont('', 'B', 6);
        $this->pdf->Cell(33, 0, "COUNTRY", array('L' => array('width' => 0.50)));
        $this->pdf->SetFont('', '', 6);
        $this->pdf->Cell(66, 0, ": INDONESIA", array('R' => array('width' => 0.50)));
        $this->pdf->Cell(0, 0, "", array('R' => array('width' => 0.50)));
        $this->pdf->Ln();

        $this->pdf->setCellPaddings(2.50, 0, 2.50, 0);
        $this->pdf->SetFont('', 'B', 6);
        $this->pdf->Cell(33, 0, "ACCOUNT NO.", array('L' => array('width' => 0.50)));
        $this->pdf->SetFont('', '', 6);
        $this->pdf->Cell(66, 0, ": 403881241209", array('R' => array('width' => 0.50)));
        $this->pdf->Cell(0, 0, "", array('R' => array('width' => 0.50)));
        $this->pdf->Ln();

        $this->pdf->setCellPaddings(2.50, 0, 2.50, 0);
        $this->pdf->SetFont('', 'B', 6);
        $this->pdf->Cell(33, 0, "SWIFT CODE", array('L' => array('width' => 0.50)));
        $this->pdf->SetFont('', '', 6);
        $this->pdf->Cell(66, 0, ": ANZBIDJX", array('R' => array('width' => 0.50)));
        $this->pdf->Cell(0, 0, "", array('R' => array('width' => 0.50)));
        $this->pdf->Ln();

        $this->pdf->setCellPaddings(2.50, 0, 2.50, 0);
        $this->pdf->SetFont('', 'B', 6);
        $this->pdf->Cell(33, 0, "BENEFICIARY", array('L' => array('width' => 0.50)));
        $this->pdf->SetFont('', '', 6);
        $this->pdf->Cell(66, 0, ": PT. GENERASI PRODUK INDONESIA", array('R' => array('width' => 0.50)));
        $this->pdf->Cell(0, 0, "", array('R' => array('width' => 0.50)));
        $this->pdf->Ln(2);

        $this->pdf->setCellPaddings(2.50, 0, 2.50, 0);
        $this->pdf->Cell(33, 0, "", array('BL' => array('width' => 0.50)));
        $this->pdf->Cell(66, 0, "", array('BR' => array('width' => 0.50)));
        $this->pdf->Cell(0, 0, "", array('BR' => array('width' => 0.50)));
        $this->pdf->Ln();

        if (!is_dir($this->path))
            mkdir($this->path);

        $this->filename = 'PI-' . $order->order_id . '.pdf';
        $this->pdf->Output($this->path . $this->filename, 'F');
        $this->pdf->Close();
    }

    public function get_filename() {
        return $this->path . $this->filename;
    }

    public function get_name() {
        return $this->filename;
    }

    public function path() {
        return $this->path;
    }

    public function download() {
        //** get the content of the file
        $content = file_get_contents($this->path . $this->filename);
        //** delete the original file before downloading
        unlink($this->path . $this->filename);

        force_download($this->filename, $content);
    }

}
