<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of model_purchaseordereditorial
 *
 * @author user
 */
class model_purchaseordereditorial extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }
    
    function get_count_outstanding_approve(){
        $query = "
            select count(*) ct
            from purchaseordereditorial poe
            where poe.status = 1
            and ((poe.approval1=".$this->session->userdata('id')." and approval1_status = 0) or 
                 (poe.approval2=".$this->session->userdata('id')." and approval1_status = 1 and approval2_status = 0) or 
                 (poe.approval3=".$this->session->userdata('id')." and approval1_status = 1 and approval2_status = 1 and approval3_status = 0))
        ";
        return $this->db->query($query)->row()->ct;
    }
    
    function get_outstanding_approve(){
        $query = "
            select poe.*,pi.order_id,pi.order_confirm_date,client.code client_code,client.name client_name,client.company client_company,
            users.email email_approval1,u.email email_approval2,u3.email email_approval3
            from purchaseordereditorial poe
            join proformainvoice pi on poe.proformainvoice_id=pi.id
            join client on pi.client_id=client.id 
            left join users on poe.approval1=users.id
            left join users u on poe.approval2=u.id
            left join users u3 on poe.approval3=u3.id
            where poe.status = 1
            and ((poe.approval1=".$this->session->userdata('id')." and approval1_status = 0) or 
                 (poe.approval2=".$this->session->userdata('id')." and approval1_status = 1 and approval2_status = 0) or 
                 (poe.approval3=".$this->session->userdata('id')." and approval1_status = 1 and approval2_status = 1 and approval3_status = 0))
        ";
        
        $query .= " order by poe.id desc";
        
//        echo "<pre>".$query."</pre>";
        
        
        $result = array();
        $data = "";
        $page = $this->input->post('page');
        $rows = $this->input->post('rows');
        if (!empty($page) && !empty($rows)) {
            $offset = ($page - 1) * $rows;
            $result['total'] = $this->db->query($query)->num_rows();
            $query .= " limit $rows offset $offset";
            $result = array_merge($result, array('rows' => $this->db->query($query)->result()));
            $data = json_encode($result);
        } else {
            $data = json_encode($this->db->query($query)->result());
        }
        return $data;
    }

    function select_by_id($id) {
        $query = "
            select poe.*,users.name name_approval1,users.email email_approval1,u.name name_approval2,u.email email_approval2,u3.name name_approval3,u3.email email_approval3,
            pi.order_id,pi.order_confirm_date,order_invoice_date,client.code client_code,client.name client_name,client.company client_company,
            (select count(*) from purchaseordereditorial_comment where po_editorial_id=poe.id) count_comment
            from purchaseordereditorial poe
            join proformainvoice pi on poe.proformainvoice_id=pi.id
            join client on pi.client_id=client.id 
            left join users on poe.approval1=users.id
            left join users u on poe.approval2=u.id
            left join users u3 on poe.approval3=u3.id
            where poe.id=$id;
        ";
        return $this->db->query($query)->row();
    }

    function select_by_id_and_register_key($id, $register_key) {
        $query = "
            select poe.*,users.name name_approval1,users.email email_approval1,u.name name_approval2,u.email email_approval2,u3.name name_approval3,u3.email email_approval3,
            pi.order_id,pi.order_confirm_date,order_invoice_date,client.code client_code,client.name client_name,client.company client_company,
            (select count(*) from purchaseordereditorial_comment where po_editorial_id=poe.id) count_comment
            from purchaseordereditorial poe
            join proformainvoice pi on poe.proformainvoice_id=pi.id
            join client on pi.client_id=client.id 
            left join users on poe.approval1=users.id
            left join users u on poe.approval2=u.id
            left join users u3 on poe.approval3=u3.id
            where poe.id=$id and poe.register_key='" . $register_key . "';
        ";
        return $this->db->query($query)->row();
    }

    function get() {
        $query = "
            select poe.*,users.name name_approval1,users.email email_approval1,u.name name_approval2,u.email email_approval2,u3.name name_approval3,u.email email_approval3,
            pi.order_id,pi.order_confirm_date,order_invoice_date,client.code client_code,client.name client_name,client.company client_company,
            (select count(*) from purchaseordereditorial_comment where po_editorial_id=poe.id) count_comment,c.code as order_company_code 
            from purchaseordereditorial poe
            join proformainvoice pi on poe.proformainvoice_id=pi.id
            join client on pi.client_id=client.id 
            join company c on pi.company_id=c.id 
            left join users on poe.approval1=users.id
            left join users u on poe.approval2=u.id
            left join users u3 on poe.approval3=u3.id
            where true 
        ";
        
        $q= $this->input->post("q");
        if(!empty($q)){
            $query .= " and (pi.order_id ilike '%$q%' or client.code ilike '%$q%') ";
        }
        
        $query .= " order by poe.id desc";
        
        $result = array();
        $data = "";
        $page = $this->input->post('page');
        $rows = $this->input->post('rows');
        if (!empty($page) && !empty($rows)) {
            $offset = ($page - 1) * $rows;
            $result['total'] = $this->db->query($query)->num_rows();
            $query .= " limit $rows offset $offset";
            $result = array_merge($result, array('rows' => $this->db->query($query)->result()));
            $data = json_encode($result);
        } else {
            $data = json_encode($this->db->query($query)->result());
        }
        return $data;
    }

    function save() {
        $proformainvoice_id = $this->input->post('proformainvoice_id');
        $query = "select purchaseordereditorial_create($proformainvoice_id)";
        if ($this->db->query($query)) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function update($data, $where) {
        return $this->db->update('purchaseordereditorial', $data, $where);
    }

    function delete($where) {
        if ($this->db->delete('purchaseordereditorial', $where)) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function vendor_update() {
        $purchaseorderediotrial_id = $this->input->post('purchaseorderediotrial_id');
        $vendor_id = $this->input->post('vendor_id');
        $currency_id = $this->input->post('currency_id');
        $target_ship_date = $this->input->post('target_ship_date');
        $down_payment_date = $this->input->post('down_payment_date');
        $down_payment = $this->input->post('down_payment');
        $vat = $this->input->post('vat');
        $remark = $this->input->post('remark');


        $data = array(
            'target_ship_date' => empty($target_ship_date) ? null : $target_ship_date,
            'down_payment_date' => empty($down_payment_date) ? null : $down_payment_date,
            'down_payment' => (double) $down_payment,
            'vat' => (double) $vat,
            'remark' => $remark
        );

        $where = array(
            'purchaseorderediotrial_id' => $purchaseorderediotrial_id,
            'vendor_id' => $vendor_id,
            'currency_id' => $currency_id
        );
        if ($this->db->update('po_plan', $data, $where)) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function vendor_get_result($po_editorial_id) {
        $query = "
            select po_plan.*,vendor.code vendor_code,vendor.name vendor_name,vendor.flag vendor_flag,currency.code currency_code
            from po_plan
            left join vendor on po_plan.vendor_id=vendor.id
            join currency on po_plan.currency_id=currency.id
            where po_plan.purchaseorderediotrial_id = $po_editorial_id
        ";
        
//        echo $query;exit;
        return $this->db->query($query)->result();
    }

    function vendor_get() {
        $po_editorial_id = $this->input->post('po_editorial_id');
        if (empty($po_editorial_id)) {
            $po_editorial_id = 0;
        }
        $query = "
            select po_plan.*,vendor.code vendor_code,vendor.name vendor_name,vendor.flag vendor_flag,currency.code currency_code
            from po_plan
            left join vendor on po_plan.vendor_id=vendor.id
            join currency on po_plan.currency_id=currency.id
            where po_plan.purchaseorderediotrial_id = $po_editorial_id
        ";

        $q = $this->input->post("q");

        if (!empty($q)) {
            $query .= " and (vendor.code ilike '%$q%' or vendor.name ilike '%$q%')";
        }

//        echo $query;
        $result = array();
        $data = "";
        $page = $this->input->post('page');
        $rows = $this->input->post('rows');
        if (!empty($page) && !empty($rows)) {
            $offset = ($page - 1) * $rows;
            $result['total'] = $this->db->query($query)->num_rows();
            $query .= " limit $rows offset $offset";
            $result = array_merge($result, array('rows' => $this->db->query($query)->result()));
            $data = json_encode($result);
        } else {
            $data = json_encode($this->db->query($query)->result());
        }
        return $data;
    }

    function vendor_item_get() {
        $po_ediotrial_id = $this->input->post("po_ediotrial_id");
        $vendor_id = $this->input->post("vendor_id");
        $currency_id = $this->input->post("currency_id");
        $flag = $this->input->post("flag");

        if (empty($po_ediotrial_id) || empty($vendor_id) || empty($vendor_id)) {
            $po_ediotrial_id = 0;
            $vendor_id = 0;
            $currency_id = 0;
        }
        $query = "
            with t as(
                select * from purchaseorderediotrial_get_vendor_item($po_ediotrial_id,$vendor_id,$currency_id,$flag)
            ) select t.* from t where true
        ";

//        echo $query;

        $data = json_encode($this->db->query($query)->result());
        return $data;
    }

    function vendor_item_get_result($po_ediotrial_id=0,$vendor_id=0,$currency_id=0,$flag=0) {
        $query = "
            with t as(
                select * from purchaseorderediotrial_get_vendor_item($po_ediotrial_id,$vendor_id,$currency_id,$flag)
            ) select t.* from t where true
        ";
        return $this->db->query($query)->result();
    }

    function product_component_vendor_get() {
        $proformainvoice_product_id = $this->input->post('proformainvoice_product_id');
        if (empty($proformainvoice_product_id)) {
            $proformainvoice_product_id = 0;
        }

        $query = "
                select 
                pcv.*,
                ppc.proformainvoice_product_id,
                ppc.component_type_id,
                component_type.name component_type_name,
                vendor.code vendor_code,
                vendor.name vendor_name,
                vendor.flag,
                pp.product_allocation_type,
                currency.code currency_code
                from purchaseordereditorial_component_vendor pcv
                join proformainvoice_product_component ppc on pcv.proformainvoice_product_component_id=ppc.id
                join products_component pc on ppc.products_component_id=pc.id
                left join vendor on pcv.vendor_id=vendor.id
                join currency on pcv.currency_id=currency.id
                join component_type on ppc.component_type_id=component_type.id
                join proformainvoice_product pp on ppc.proformainvoice_product_id=pp.id
                where ppc.proformainvoice_product_id=$proformainvoice_product_id
                order by component_type.id asc
        ";

//        echo $query;
        $result = array();
        $data = "";
        $page = $this->input->post('page');
        $rows = $this->input->post('rows');
        if (!empty($page) && !empty($rows)) {
            $offset = ($page - 1) * $rows;
            $result['total'] = $this->db->query($query)->num_rows();
            $query .= " limit $rows offset $offset";
            $result = array_merge($result, array('rows' => $this->db->query($query)->result()));
            $data = json_encode($result);
        } else {
            $data = json_encode($this->db->query($query)->result());
        }
        return $data;
    }

    function vendor_item_delete($where) {
        return $this->db->delete('purchaseordereditorial_component_vendor', $where);
    }

    function select_comment_by_poe_id($id) {
        $query = "
            select
            purchaseordereditorial_comment.*,
            users.name user_comment
            from
            purchaseordereditorial_comment
            join users on purchaseordereditorial_comment.userid=users.id
            where purchaseordereditorial_comment.po_editorial_id=$id
            order by purchaseordereditorial_comment.id desc
        ";
        return $this->db->query($query)->result();
    }

    function get_register_key($id) {
        return $this->db->query("select register_key from purchaseordereditorial where id=$id")->row()->register_key;
    }

}

?>
