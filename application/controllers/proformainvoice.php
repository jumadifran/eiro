<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of proformainvoice
 *
 * @author user
 */
class proformainvoice extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('model_proformainvoice');
    }

    function index() {
        $this->load->view('proformainvoice/index');
    }

    function view() {
        $data['action'] = explode('|', $this->model_user->get_action($this->session->userdata('id'), 1));
        $this->load->view('proformainvoice/proformainvoice', $data);
    }

    function input() {
        $data['payment_term'] = $this->db->get('payment_term')->result();
        $this->load->view('proformainvoice/input', $data);
    }

    function get($type = "") {
        echo $this->model_proformainvoice->get($type);
    }

    function get_available_to_create_po_editorial() {
        echo $this->model_proformainvoice->get_available_to_create_po_editorial();
    }

    function get_available_to_shipping() {
        echo $this->model_proformainvoice->get_available_to_shipping();
    }

    function product_view() {
        $data['action'] = explode('|', $this->model_user->get_action($this->session->userdata('id'), 1));
        $this->load->view('proformainvoice/proformainvoice_product', $data);
    }

    function save($id) {
        $down_payment_date = $this->input->post('down_payment_date');
        $order_target_ship_date = $this->input->post('order_target_ship_date');
        $data = array(
            "client_id" => $this->input->post('client_id'),
            "client_company_name" => $this->input->post('client_company_name'),
            "client_address" => $this->input->post('client_address'),
            "client_country" => $this->input->post('client_country'),
            "client_phone_fax" => $this->input->post('client_phone_fax'),
            "client_email" => $this->input->post('client_email'),
            "order_confirm_date" => $this->input->post('order_confirm_date'),
            "order_invoice_date" => $this->input->post('order_invoice_date'),
            "order_target_ship_date" => (empty($order_target_ship_date) ? null : $order_target_ship_date),
            "order_payment_term" => $this->input->post('order_payment_term'),
            "order_contract_term" => $this->input->post('order_contract_term'),
            "ship_to" => $this->input->post('ship_to'),
            "ship_address" => $this->input->post('ship_address'),
            "ship_phone_fax" => $this->input->post('ship_phone_fax'),
            "ship_contact_name" => $this->input->post('ship_contact_name'),
            "ship_port_of_loading" => $this->input->post('ship_port_of_loading'),
            "ship_port_of_destination" => $this->input->post('ship_port_of_destination'),
            "currency_id" => $this->input->post('currency_id'),
            "down_payment_date" => (empty($down_payment_date) ? null : $down_payment_date),
            "down_payment" => (double) $this->input->post('down_payment'),
            "vat" => (double) $this->input->post('vat'),
            "remark" => $this->input->post('remark'),
            "company_id" => $this->input->post('company_id'),
            "bank_account_id" => $this->input->post('bank_account_id'),
            "salesman_id" => $this->input->post('salesman_id')
        );

        if ($id == 0) {
            $data['user_added'] = $this->session->userdata('id');
            if ($this->model_proformainvoice->insert($data)) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('msg' => $this->db->_error_message()));
            }
        } else {
            $data['user_updated'] = $this->session->userdata('id');
            $data['updated_time'] = date("Y-m-d H:i:s");
            if ($this->model_proformainvoice->update($data, array("id" => $id))) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('msg' => $this->db->_error_message()));
            }
        }
    }

    function delete() {
        $id = $this->input->post('id');
        if ($this->model_proformainvoice->delete(array("id" => $id))) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function submit() {
        $id = $this->input->post('id');
        if ($this->model_proformainvoice->update(array("submit" => 'true', 'submit_time' => "now()"), array("id" => $id))) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function revision() {
        $id = $this->input->post('id');
        if ($this->model_proformainvoice->update(array("submit" => 'false'), array("id" => $id))) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function product_get() {
        echo $this->model_proformainvoice->product_get();
    }

    function product_input() {
        $this->load->view('proformainvoice/product_input');
    }

    function product_save($proformainvoiceid, $id) {
        $discount = round(($this->input->post('price') * $this->input->post('discount')) / 100,2);
        $net_factory = round(($this->input->post('price') - $discount),2);
        $volume = round((((double) $this->input->post('width') * (double) $this->input->post('depth') * (double) $this->input->post('height')) / 1000000000), 4, PHP_ROUND_HALF_UP);
        $data = array(
            "products_id" => $this->input->post('products_id'),
            "width" => (double) $this->input->post('width'),
            "depth" => (double) $this->input->post('depth'),
            "height" => (double) $this->input->post('height'),
            "volume" => $volume,
            "qty" => $this->input->post('qty'),
            "price" => (double) $this->input->post('price'),
            "discount" => (double) $this->input->post('discount'),
            'fabric_id' => (int) $this->input->post('fabric_id'),
            "net_factory" => $net_factory,
            "line_total" => ((double) $this->input->post('qty') * $net_factory),
            "notes" => $this->input->post('notes'),
            "special_instruction" => $this->input->post('special_instruction'),
            "notes" => $this->input->post('notes'),
            "product_allocation_type" => $this->input->post('product_allocation_type'),
            "category" => (int) $this->input->post('category')
        );
        $material_id = $this->input->post('material_id');
        if (!empty($material_id)) {
            $data['material_id'] = "{" . implode(',', $material_id) . "}";
        }
        $color_id = $this->input->post('color_id');
        if (!empty($color_id)) {
            $data['color_id'] = "{" . implode(',', $color_id) . "}";
        }

        if ($id == 0) {
            $data['proformainvoice_id'] = $proformainvoiceid;
            $data['user_added'] = $this->session->userdata('id');
            if ($this->model_proformainvoice->product_insert($data)) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('msg' => $this->db->_error_message()));
            }
        } else {
            $data['user_updated'] = $this->session->userdata('id');
            $data['updated_time'] = date("Y-m-d H:i:s");

            if ($this->model_proformainvoice->product_update($data, array("id" => $id))) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('msg' => $this->db->_error_message()));
            }
        }
    }

    function product_delete() {
        $id = $this->input->post('id');
        if ($this->model_proformainvoice->product_delete(array("id" => $id))) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function product_component_get($component_id) {
        echo $this->model_proformainvoice->product_component_get($component_id);
    }

    function product_component_delete() {
        $id = $this->input->post('id');
        if ($this->model_proformainvoice->product_component_delete(array("id" => $id))) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function product_source($pi_product_id, $product_id, $width, $depth, $height, $source_type) {
        $data['pi_product_id'] = $pi_product_id;
        $data['product_id'] = $product_id;
        $data['width'] = $width;
        $data['depth'] = $depth;
        $data['height'] = $height;
        $data['source_type'] = $source_type;
        $this->load->view('proformainvoice/product_source', $data);
    }

    function stock_view() {
        $data['product_id'] = $this->input->get('product_id');
        $data['width'] = $this->input->get('width');
        $data['depth'] = $this->input->get('depth');
        $data['height'] = $this->input->get('height');
        $this->load->view('proformainvoice/stock_view', $data);
    }

    function product_stock_allocated() {
        $data['pi_product_id'] = $this->input->get('pi_product_id');
        //echo $data['pi_product_id'];
        $this->load->view('proformainvoice/product_stock_allocated', $data);
    }

    function allocated_stock() {
        $pi_product_id = $this->input->post('pi_product_id');
        $serial_number = $this->input->post('serial_number');

        $production_process_id = $this->input->post('production_process_id');
        if (empty($production_process_id)) {
            $production_process_id = 0;
        }

        $data = array();
        for ($i = 0; $i < count($serial_number); $i++) {
            $data[] = array(
                "proformainvoice_product_id" => $pi_product_id,
                "serial_number" => $serial_number[$i],
                "production_process_id" => $production_process_id
            );
        }
        if ($this->db->insert_batch("proformainvoice_product_stock_allocated", $data)) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function disallocated_stock() {
        $serial_number = $this->input->post('serial_number');
        $msg = "";
        $this->db->trans_start();
        for ($i = 0; $i < count($serial_number); $i++) {
            if (!$this->db->delete("proformainvoice_product_stock_allocated", array('serial_number' => $serial_number[$i]))) {
                $msg = $this->db->_error_message();
            }
        }
        $this->db->trans_complete();

        if ($this->db->trans_status() === TRUE) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $msg));
        }
    }

    function product_stock_allocated_get($pi_product_id) {
        echo $this->model_proformainvoice->product_stock_allocated_get($pi_product_id);
    }

    function download() {
        $id = $this->input->post('id');
        $this->load->library('zip');
        $this->load->library('pdf');
        $this->load->model('model_proformainvoice_pdf');
        $this->load->model('model_proformainvoice_os_pdf');
        $this->load->model('model_products');
        $data['sesid'] = $this->session->userdata('session_id');
        $data['proforma_invoice'] = $this->model_proformainvoice->select_by_id($id);
        $data['products'] = $this->model_proformainvoice->product_select_by_proformainvoice_id($id);
        $this->load->view('proformainvoice/download2', $data);
    }

    function excel() {
        $this->load->model('model_products');
        $id = $this->input->post('id');
        $data['proforma_invoice'] = $this->model_proformainvoice->select_by_id($id);
        $data['products'] = $this->model_proformainvoice->product_select_by_proformainvoice_id($id);

        $this->load->model('model_proformainvoice_excel');
        $this->model_proformainvoice_excel->initialize($data['proforma_invoice']);

        $this->model_proformainvoice_excel->generate_content($data['products']);
        $this->model_proformainvoice_excel->download();
    }

    function stock_starting_point_production() {
        $this->load->view('proformainvoice/stock_starting_point_production');
    }

    function get_ots_allocated($pi_product_detail_id) {

        $query = "with t as
                (
                select 
                qty,
                (select count(*) from proformainvoice_product_stock_allocated where proformainvoice_product_id=proformainvoice_product.id) count_allocated
                from 
                proformainvoice_product where id=$pi_product_detail_id
                ) select (qty - count_allocated) ots from t ";

        echo $this->db->query($query)->row()->ots;
    }

    function get_pi_ots_allocated_stock($pi_id) {
        $query = "select proformainvoice_get_ots_allocated_stock($pi_id) ct";
        echo $this->db->query($query)->row()->ct;
    }

    function load_tooltip_search_form() {
        $this->load->view("proformainvoice/pid_tooltip_search_form");
    }
    
    function last_order(){
        $this->load->view("proformainvoice/last_order");
    }

}
