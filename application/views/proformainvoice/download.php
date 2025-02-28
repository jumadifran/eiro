<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//echo $sesid;
$this->model_proformainvoice_pdf->set_path(ROOT . 'temp' . DS . $sesid . DS);
$this->model_proformainvoice_pdf->initialize();
$this->model_proformainvoice_pdf->create_header($proforma_invoice);
$this->model_proformainvoice_pdf->generate_content($proforma_invoice, $products);
$pi_pdf = $this->model_proformainvoice_pdf->get_filename();

$this->model_proformainvoice_os_pdf->set_path(ROOT . 'temp' . DS . $sesid . DS);
$this->model_proformainvoice_os_pdf->initialize();
$this->model_proformainvoice_os_pdf->create_header($proforma_invoice);
$this->model_proformainvoice_os_pdf->generate_content($proforma_invoice, $products);
$os_pdf = $this->model_proformainvoice_os_pdf->get_filename();


$file = array(
    $proforma_invoice->order_id . DS . $this->model_proformainvoice_pdf->get_name() => file_get_contents($pi_pdf),
    $proforma_invoice->order_id . DS . $this->model_proformainvoice_os_pdf->get_name() => file_get_contents($os_pdf)
);


//** immediately delete the files
$old = umask();
umask(0);
unlink($pi_pdf);
unlink($os_pdf);
rmdir(ROOT . 'temp' . DS . $sesid . DS);
umask($old);

$this->zip->add_data($file);
//$this->zip->download($orders->order_code.'.zip');
$this->zip->archive(ROOT . 'temp' . DS . $sesid . '-' . $proforma_invoice->order_id . '.zip');
//$this->zip->download($purchase->order_code.'.zip');
$data = file_get_contents(ROOT . 'temp' . DS . $sesid . '-' . $proforma_invoice->order_id . '.zip');
$name = $proforma_invoice->order_id . '.zip';

$old = umask();
umask(0);
unlink(ROOT . 'temp' . DS . $sesid . '-' . $proforma_invoice->order_id . '.zip');
umask($old);

force_download($name, $data);

