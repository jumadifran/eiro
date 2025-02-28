<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CommercialInvoice
 *
 * @author operational
 */
class commercial_invoice extends CI_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
        $this->load->model('model_commercial_invoice');
    }

    function index() {
        $this->load->view('commercial_invoice/index');
    }

    function get() {
        echo $this->model_commercial_invoice->get();
    }

    function input() {
        $this->load->view('commercial_invoice/input');
    }

    function save($id) {
        $data = array(
            "date" => $this->input->post('order_invoice_date'),
            "pi_id" => $this->input->post('pi_id'),
            "payment_type" => $this->input->post('payment_type'),
            "reference" => $this->input->post('reference'),
            "amount" => $this->input->post('amount'),
            "percent" => (double) $this->input->post('percent'),
            "vat_percent" => (double) $this->input->post('vat_percent'),
            "vat_nominal" => (double) $this->input->post('vat_nominal'),
            "total_amount" => (double) $this->input->post('total_amount')
        );

        if ($id == 0) {
            if ($this->model_commercial_invoice->insert($data)) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('msg' => $this->db->_error_message()));
            }
        } else {
            if ($this->model_commercial_invoice->insert($data, array("id" => $id))) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('msg' => $this->db->_error_message()));
            }
        }
    }

    function delete() {
        if ($this->model_commercial_invoice->insert($data, array("id" => $this->input->post("id")))) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function reload_type($f = 0) {
        $data = array();

        if ($f == 0) {
            $data[] = array("id" => "Down Payment", "text" => "Down Payment");
        }

        $data[] = array("id" => "Phased Payment", "text" => "Phased Payment");
        $data[] = array("id" => "Completion Payment", "text" => "Completion Payment");
        echo json_encode($data);
    }

}
