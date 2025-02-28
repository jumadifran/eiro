<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of purchaseordereditorial
 *
 * @author user
 */
class purchaseordereditorial extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('model_purchaseordereditorial');
    }

    function index() {
        $this->load->view('purchaseordereditorial/index');
    }

    function add() {
        $this->load->view('purchaseordereditorial/po_editorial_add_form');
    }

    function delete() {
        $id = $this->input->post('id');
        $this->model_purchaseordereditorial->delete(array("id" => $id));
    }

    function save() {
        $this->model_purchaseordereditorial->save();
    }

    function get() {
        echo $this->model_purchaseordereditorial->get();
    }

    function outstanding_approve() {
        $this->load->view('purchaseordereditorial/my_outstanding_approve');
    }

    function get_outstanding_approve() {
        echo $this->model_purchaseordereditorial->get_outstanding_approve();
    }

    function proformainvoice_view() {
        $data['action'] = explode('|', $this->model_user->get_action($this->session->userdata('id'), 20));
        $this->load->view('purchaseordereditorial/proformainvoice_view', $data);
    }

    function proformainvoice_product_view() {
        $data['action'] = explode('|', $this->model_user->get_action($this->session->userdata('id'), 20));
        $this->load->view('purchaseordereditorial/proformainvoice_product_view', $data);
    }

    function vendor_view() {
        $data['action'] = explode('|', $this->model_user->get_action($this->session->userdata('id'), 20));
        $this->load->view('purchaseordereditorial/vendor_view', $data);
    }

    function vendor_edit($flag = "") {
        $this->load->view('purchaseordereditorial/vendor_edit', array("flag" => $flag));
    }

    function vendor_update() {
        $this->model_purchaseordereditorial->vendor_update();
    }

    function vendor_get() {
        echo $this->model_purchaseordereditorial->vendor_get();
    }

    function vendor_item_view() {
        $this->load->view('purchaseordereditorial/vendor_item_view');
    }

    function vendor_item_delete() {
        $id = $this->input->post('id');
        if ($this->model_purchaseordereditorial->vendor_item_delete(array("id" => $id))) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function vendor_item_get() {
        echo $this->model_purchaseordereditorial->vendor_item_get();
    }

    function product_component_vendor() {
        $data['action'] = explode('|', $this->model_user->get_action($this->session->userdata('id'), 20));
        $this->load->view('purchaseordereditorial/product_component_vendor', $data);
    }

    function product_component_vendor_get() {
        echo $this->model_purchaseordereditorial->product_component_vendor_get();
    }

    function component_vendor_delete() {
        if ($this->db->delete('purchaseordereditorial_component_vendor', array("id" => $this->input->post('id')))) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function submit() {
        $this->load->view('purchaseordereditorial/submit');
    }

    function do_submit($id) {
        $data = array(
            "status" => 1,
            "approval1" => $this->input->post('approval1'),
            "approval2" => $this->input->post('approval2'),
            "approval3" => $this->input->post('approval3')
        );
        $next = "approval1";
        if ($this->model_purchaseordereditorial->update($data, array("id" => $id))) {
            echo json_encode(array('success' => true));
            $poe = $this->model_purchaseordereditorial->select_by_id($id);

            $name = $poe->name_approval1;
            $email = $poe->email_approval1;

            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                $this->load->library('encrypt');
                $key = $this->config->item('encryption_key');
                //$encrypt_next = $this->encrypt->safe_url_encode($next, $key);
                $encrypt_next = $next;
                $link_approve = "<a href='" . $this->config->item('domain_url') . "purchaseordereditorial/apv_url/" . $encrypt_next . "/" . $id . "/" . $poe->register_key . "'>Approve<a>&nbsp;&nbsp;&nbsp;&nbsp;<br/>";

                $ci = get_instance();
                $ci->load->library('email');
                $config = $this->config->item('email_config');
                $ci->email->initialize($config);
                $ci->email->from('crm.boxliving@gmail.com', 'CRM System');

                $list = array($email);
                $ci->email->to($list);
                $ci->email->subject('Approve New P.O for PI NO. ' . $poe->order_id);
                $message = "Dear $name<br><br>";
                $message .= "Please approve new P.O. editorial with the information below <br/><br/>";

                $message .= $this->email_content($poe->id);

                $message .= $link_approve;
                $message .= "<br/><br/>Thank You<br/><br/><br/>";
                $message .= "This email was sent by CRM System automatically, please do not reply";
                $ci->email->message($message);
                $ci->email->reply_to('no-replay@noreplay.com', 'No Replay');
                $ci->email->send();
            }
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function email_content($poeid) {
        $vendor = $this->model_purchaseordereditorial->vendor_get_result($poeid);
        $content = '<div style="min-width:500px;">';
        foreach ($vendor as $result) {
            $content .= '<table width="100%">
                <tr>
                    <td style="font-size:11px;">
                        <b>Vendor : </b>' . $result->vendor_name . ',&nbsp;&nbsp;&nbsp;
                        <b>Ship Date Target: </b>' . (!empty($result->target_ship_date) ? date('d/m/Y', strtotime($result->target_ship_date)) : "-") . ',&nbsp;&nbsp;&nbsp;
                        <b>DP : </b>' . $result->down_payment . '% at ' . (!empty($result->down_payment_date) ? date('d/m/Y', strtotime($result->down_payment_date)) : "-") . '
                    </td>
                </tr>
                <tr>
                    <td>
                        <table width="100%" style="border-collapse:collapse">
                            <thead>
                                <tr>
                                    <th style="font-size:10px;border:1px #000 solid;width:10px;text-align:right;">No</th>
                                    <th style="font-size:10px;border:1px #000 solid;width:80px;text-align:center">TYPE</th>
                                    <th style="font-size:10px;border:1px #000 solid;width:100px;text-align:center">PRODUCT ID</th>
                                    <th style="font-size:10px;border:1px #000 solid;width:150px;text-align:center">PRODUCT NAME</th>
                                    <th style="font-size:10px;border:1px #000 solid;width:120px;text-align:center">VENDOR CODE</th>
                                    <th style="font-size:10px;border:1px #000 solid;width:30px;text-align:center">W</th>
                                    <th style="font-size:10px;border:1px #000 solid;width:30px;text-align:center">D</th>
                                    <th style="font-size:10px;border:1px #000 solid;width:30px;text-align:center">H</th>
                                    <th style="font-size:10px;border:1px #000 solid;width:40px;text-align:center">VOLUME (m3)</th>
                                    <th style="font-size:10px;border:1px #000 solid;width:100px;text-align:center">MATERIAL</th>
                                    <th style="font-size:10px;border:1px #000 solid;width:100px;text-align:center">FABRIC</th>
                                    <th style="font-size:10px;border:1px #000 solid;width:100px;text-align:center">COLOR</th>
                                    <th style="font-size:10px;border:1px #000 solid;width:30px;text-align:center">QTY</th>
                                    <th style="font-size:10px;border:1px #000 solid;width:120px;text-align:center">PRICE</th>
                                    <th style="font-size:10px;border:1px #000 solid;width:30px;text-align:center">DISC (%)</th>
                                    <th style="font-size:10px;border:1px #000 solid;width:120px;text-align:center">TOTAL PRICE</th>
                                </tr>
                            </thead>
                            <tbody>';
            $item = $this->model_purchaseordereditorial->vendor_item_get_result($result->purchaseorderediotrial_id, $result->vendor_id, $result->currency_id);
            $no = 1;
            $total = 0;
            foreach ($item as $rst) {
                $sub_total = $rst->qty * $rst->price;
                $discount = ($rst->discount * $sub_total) / 100;
                $total_price = $sub_total - $discount;
                $total = $total + $total_price;
                $content .= '<tr>
                                        <td style="font-size:10px;border:1px #000 solid;text-align:right">' . $no++ . '</td>
                                        <td style="font-size:10px;border:1px #000 solid">' . $rst->component_type_name . '</td>
                                        <td style="font-size:10px;border:1px #000 solid">' . $rst->item_code . '</td>
                                        <td style="font-size:10px;border:1px #000 solid">' . $rst->item_description . '</td>
                                        <td style="font-size:10px;border:1px #000 solid">' . $rst->vendor_item_code . '</td>
                                        <td style="font-size:10px;border:1px #000 solid;text-align:center">' . $rst->width . '</td>
                                        <td style="font-size:10px;border:1px #000 solid;text-align:center">' . $rst->depth . '</td>
                                        <td style="font-size:10px;border:1px #000 solid;text-align:center">' . $rst->height . '</td>
                                        <td style="font-size:10px;border:1px #000 solid;text-align:center">' . $rst->volume . '</td>
                                        <td style="font-size:10px;border:1px #000 solid">' . $rst->material . '</td>
                                        <td style="font-size:10px;border:1px #000 solid">' . $rst->fabric . '</td>
                                        <td style="font-size:10px;border:1px #000 solid">' . $rst->color . '</td>
                                        <td style="font-size:10px;border:1px #000 solid;text-align:center">' . $rst->qty . '</td>
                                        <td style="font-size:10px;border:1px #000 solid;text-align:right">' . number_format($rst->price, 2) . '</td>
                                        <td style="font-size:10px;border:1px #000 solid;text-align:center">' . $rst->discount . '</td>
                                        <td style="font-size:10px;border:1px #000 solid;text-align:right">' . number_format($total_price, 2) . '</td>
                                    </tr>';
            }
            $total_vat = ($total * $result->vat) / 100;
            $grand_total = $total + $total_vat;
            $content.= '<tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="right">
                    <table width="300">
                        <tr>
                            <td width="30%" align="right" style="font-size:10px;"><b>Sub Total : </b></td>
                            <td width="70%" align="right" style="font-size:10px;"><b>' . number_format($total, 2) . '</b></td>
                        </tr>
                        <tr>
                            <td align="right" style="font-size:10px;"><b>Vat (' . $result->vat . '%) : </b></td>
                            <td align="right" style="font-size:10px;"><b>' . number_format($total_vat, 2) . '</b></td>    
                        <tr>
                        <tr>
                            <td align="right" style="font-size:10px;"><b>Grand Total : </b></td>
                            <td align="right" style="font-size:10px;"><b>' . number_format($grand_total, 2) . '</b></td>    
                        <tr>
                    </table>
                </td>
            </tr>
            </table>';
        }
        $content.= "</div>";
        return $content;
//        echo $content;
    }

    function appr() {
        $this->load->library('encrypt');
        $key = $this->config->item('encryption_key');
        $encrypt_next = $this->encrypt->safe_url_encode("approval2", "2a01732ee3072074e99e14454cdc357c");
        echo $encrypt_next . "<br/>";
        $who = $this->encrypt->safe_url_decode($encrypt_next, "2a01732ee3072074e99e14454cdc357c");
        echo $who . "<br/>";
    }

    function approve() {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        $who = $this->input->post('who');

        $data = array(
            $who . "_status" => $status,
            $who . "_time" => "now()"
        );

        $next = "approval" . (((int) substr($who, -1)) + 1);


        if ($this->model_purchaseordereditorial->update($data, array("id" => $id))) {
            echo json_encode(array('success' => true));
            $poe = $this->model_purchaseordereditorial->select_by_id($id);
            $email = '-';
            if ($who == "approval1") {
                $name = $poe->name_approval2;
                $email = $poe->email_approval2;
            } else if ($who == "approval2") {
                $name = $poe->name_approval3;
                $email = $poe->email_approval3;
            }
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                $this->load->library('encrypt');
                $key = $this->config->item('encryption_key');
                //$encrypt_next = $this->encrypt->safe_url_encode($next, $key);
                $encrypt_next = $next;
                $link_approve = "<a href='" . $this->config->item('domain_url') . "purchaseordereditorial/apv_url/" . $encrypt_next . "/" . $id . "/" . $poe->register_key . "'>Approve<a>&nbsp;&nbsp;&nbsp;&nbsp;<br/>";

                $ci = get_instance();
                $ci->load->library('email');
                $config = $this->config->item('email_config');
                $ci->email->initialize($config);
                $ci->email->from('crm.boxliving@gmail.com', 'CRM System');

                $list = array($email);
                $ci->email->to($list);
                $ci->email->subject('Approve New P.O for PI NO: ' . $poe->order_id);
                $message = "Dear $name<br><br>";
                $message .= "Please approve new P.O. editorial with the information below <br/><br/>";

                $message .= $this->email_content($poe->id);

                $message .= $link_approve;
                $message .= "<br/><br/>Thank You<br/><br/><br/>";
                $message .= "This email was sent by CRM System automatically, please do not reply";
                $ci->email->message($message);
                $ci->email->reply_to('no-replay@noreplay.com', 'No Replay');
                $ci->email->send();
//                echo $ci->email->print_debugger();
            }
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function apv_url($enc_who, $id, $register_key) {

        $this->load->library('encrypt');
        $key = $this->config->item('encryption_key');
        //$who = $this->encrypt->safe_url_decode($enc_who, $key);
        $who = $enc_who;
//        echo $enc_who."<br/>";
//        echo "wq".$who;
        $poe = $this->model_purchaseordereditorial->select_by_id_and_register_key($id, $register_key);
        if (!empty($poe)) {
            $data = array(
                $who . "_status" => 1,
                $who . "_time" => "now()"
            );
            if ($this->model_purchaseordereditorial->update($data, array("id" => $id))) {
                echo "<span style='font-size:18px'>Success!</span>";
                $approval = (((int) substr($who, -1)) + 1);
                if ($approval <= 3) {
                    $email = "-";
                    if ($who == "approval1") {
                        $name = $poe->name_approval2;
                        $email = $poe->email_approval2;
                    } else if ($who == "approval2") {
                        $name = $poe->name_approval3;
                        $email = $poe->email_approval3;
                    }
                    $next = "approval" . $approval;
//                    echo "Next :" . $next . "<br/>";
//                    echo "Name :" . $name . "<br/>";
//                    echo "Email :" . $email . "<br/>";

                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        //$encrypt_next = $this->encrypt->safe_url_encode($next, $key);
                        $encrypt_next = $next;
                        $link_approve = "<a href='" . $this->config->item('domain_url') . "purchaseordereditorial/apv_url/" . $encrypt_next . "/" . $id . "/" . $poe->register_key . "'>Approve<a>&nbsp;&nbsp;&nbsp;&nbsp;<br/>";
                        $ci = get_instance();
                        $ci->load->library('email');
                        $config = $this->config->item('email_config');
                        $ci->email->initialize($config);
                        $ci->email->from('crm.boxliving@gmail.com', 'CRM System');

                        $list = array($email);
                        $ci->email->to($list);
                        $ci->email->subject('Approve New P.O for PI NO: ' . $poe->order_id);
                        $message = "Dear $name<br><br>";
                        $message .= "Please approve new P.O. editorial with the information below <br/><br/>";
                        $message .= $this->email_content($poe->id);
                        $message .= $link_approve;
                        $message .= "<br/><br/>Thank You<br/><br/><br/>";
                        $message .= "This email was sent by CRM System automatically, please do not reply";
                        $ci->email->message($message);
                        $ci->email->reply_to('no-replay@noreplay.com', 'No Replay');
                        $ci->email->send();
//                        echo $ci->email->print_debugger();
                    }
                }
            } else {
                echo "Error" . $this->db->_error_message();
            }
        } else {
            echo "Data Not Found";
        }
    }

    function pending() {
        $this->load->view('purchaseordereditorial/pending');
    }

    function do_pending() {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        $who = $this->input->post('who');

        $data = array(
            $who . "_status" => $status,
            $who . "_time" => "now()",
        );

        $msg = '';
        $this->db->trans_start();
        if ($this->model_purchaseordereditorial->update($data, array("id" => $id))) {
            if (!$this->db->insert('purchaseordereditorial_comment', array(
                        "comment" => $this->input->post('notes'),
                        "userid" => $this->session->userdata('id'),
                        "po_editorial_id" => $id
                    ))) {
                $msg = $this->db->_error_message();
            }
        } else {
            $msg = $this->db->_error_message();
        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === TRUE) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $msg));
        }
    }

    function view_comment($id) {
        $this->load->view('purchaseordereditorial/view_comment', array("id" => $id));
    }

    function load_comment_list($id) {
        $data["comments"] = $this->model_purchaseordereditorial->select_comment_by_poe_id($id);
        $this->load->view('purchaseordereditorial/comment_list', $data);
    }

    function save_comment() {
        if ($this->db->insert('purchaseordereditorial_comment', array(
                    "comment" => $this->input->post('comment'),
                    "userid" => $this->session->userdata('id'),
                    "po_editorial_id" => $this->input->post('po_editorial_id')
                ))) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function component_edit_price($product_allocation_type) {
        if ($product_allocation_type == 2) {
            $data['flag'] = "iw";
        } else {
            $data['flag'] = "v";
        }
        $this->load->view('purchaseordereditorial/component_edit_price', $data);
    }

    function component_update_price($flag = 0) {

        $data = array(
            "vendor_item_code" => $this->input->post('vendor_item_code'),
            "price" => (double) $this->input->post('price'),
            "qty" => (double) $this->input->post('qty'),
            "uom" => $this->input->post('uom'),
            "currency_id" => $this->input->post('currency_id'),
            "discount" => (double) $this->input->post('discount'),
        );

        if ($flag == 0) {
            $data["vendor_id"] = $this->input->post('vendor_id');
        }


        if ($this->db->update('purchaseordereditorial_component_vendor', $data, array("id" => $this->input->post('id')))) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function my_outstanding_approve() {
        $this->load->view('purchaseordereditorial/my_outstanding_approve');
    }

    function set_to_draft() {
        $data = array(
            "status" => 0,
            "approval1" => null,
            "approval1_status" => 0,
            "approval1_time" => null,
            "approval2" => null,
            "approval2_status" => 0,
            "approval2_time" => null,
            "approval3" => null,
            "approval3_status" => 0,
            "approval3_time" => null,
        );
        if ($this->db->update('purchaseordereditorial', $data, array("id" => $this->input->post('id')))) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

}
