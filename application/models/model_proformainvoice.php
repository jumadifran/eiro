<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of model_proformainvoice
 *
 * @author hp
 */
class model_proformainvoice extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    function get($type = "") {
        $query = "
        with t as (
            select 
            proformainvoice.*,
            client.code client_code,
            client.name client_name,
            client.contact_name client_contact_name,
            client_shipto.code client_shipto_code,
            client_shipto.name client_shipto_name,
            client_shipto.company client_shipto_company_name,
            client_shipto.email client_shipto_email,
            client_shipto.contact_name client_shipto_contact_name,
            country.common_name client_shipto_country_name,
            currency.code currency_code,
            payment_term.name payment_term,c.code as order_company_code,
            users.name as salesman_name,
            (select count(*) from commercial_invoice where pi_id=proformainvoice.id) dp_count,
            poe.id poe_id
            from proformainvoice
            join client on proformainvoice.client_id=client.id
            join client client_shipto on proformainvoice.ship_to = client_shipto.id
            join country on client_shipto.country_id=country.id
            join currency on proformainvoice.currency_id=currency.id
            join company c on proformainvoice.company_id=c.id 
            left join payment_term on proformainvoice.order_payment_term::integer=payment_term.id
            left join purchaseordereditorial poe on proformainvoice.id=poe.proformainvoice_id
            left join users on users.id=proformainvoice.salesman_id
        ) select t.* from t where true 
            ";

        $q = $this->input->post('q');
        if (!empty($q)) {
            $query .= " and (t.order_id ilike '%$q%' or t.client_code ilike '%$q%'"
                    . " or t.client_name ilike '%$q%' or t.client_shipto_company_name ilike '%$q%' or t.currency_code ilike '%$q%')";
        }

        $order_id = $this->input->post("order_id");
        if (!empty($order_id)) {
            $query .= " and t.order_id ilike '%$q%'";
        }
        $start_date = $this->input->post("start_date");
        $end_date = $this->input->post("end_date");
        if (!empty($start_date) && !empty($end_date)) {
            $query .= " and t.order_confirm_date between '$start_date' and '$end_date'";
        }if (empty($start_date) && !empty($end_date)) {
            $query .= " and t.order_confirm_date='$start_date'";
        }if (!empty($start_date) && empty($end_date)) {
            $query .= " and t.order_confirm_date='$end_date'";
        }
        $client_id = $this->input->post("client_id");
        if (!empty($client_id)) {
            $query .= " and t.client_id='$client_id'";
        }

        if ($type == "open") {
            $query .= " and t.close is false";
        }

        $query .= " order by t.id desc ";
        
        if($type == "last_ten"){
                $query .= " limit 10 ";
        }
//        echo $type;
        $page = $this->input->post('page');
        $rows = $this->input->post('rows');
        $result = array();
        $data = "";
        if (!empty($page) && !empty($rows)) {
            $offset = ($page - 1) * $rows;
            $result['total'] = $this->db->query($query)->num_rows();
            if($type == "last_ten"){
                $query .= " offset $offset";
            }else{
                $query .= " limit $rows offset $offset";
            }
            $result = array_merge($result, array('rows' => $this->db->query($query)->result()));
            $data = json_encode($result);
        } else {
            $data = json_encode($this->db->query($query)->result());
        }
        return $data;
    }

    function get_available_to_create_po_editorial() {
        $query = "
                select 
                proformainvoice.*,
                client.code client_code,
                client.name client_name,
                client_shipto.code client_shipto_code,
                client_shipto.name client_shipto_name,
                client_shipto.company client_shipto_company_name,
                client_shipto.email client_shipto_email,
                client_shipto.contact_name client_shipto_contact_name,
                country.common_name client_shipto_country_name,
                currency.code currency_code
                from proformainvoice
                join client on proformainvoice.client_id=client.id
                join client client_shipto on proformainvoice.ship_to = client_shipto.id
                join country on client_shipto.country_id=country.id
                join currency on proformainvoice.currency_id=currency.id
                where proformainvoice.id not in (select proformainvoice_id from purchaseordereditorial)
                and proformainvoice.submit=true 
            ";

        $q = $this->input->post('q');

        if (!empty($q)) {
            $query .= " and proformainvoice.t.order_id ilike '%$q%' ";
        }

        $query .= " order by id desc ";
        $page = $this->input->post('page');
        $rows = $this->input->post('rows');
        $result = array();
        $data = "";
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

    function get_available_to_shipping() {
        $query = "
            with t as (
                select 
                proformainvoice.*,
                client.code client_code,
                client.name client_name,
                client_shipto.code client_shipto_code,
                client_shipto.name client_shipto_name,
                client_shipto.company client_shipto_company_name,
                client_shipto.email client_shipto_email,
                client_shipto.contact_name client_shipto_contact_name,
                country.common_name client_shipto_country_name,
                currency.code currency_code
                from proformainvoice
                join client on proformainvoice.client_id=client.id
                join client client_shipto on proformainvoice.ship_to = client_shipto.id
                join country on client_shipto.country_id=country.id
                join currency on proformainvoice.currency_id=currency.id
                where proformainvoice.id in (select proformainvoice_id from purchaseordereditorial)
                and proformainvoice.close=false
            ) select t.* from t where true
            ";
        $q = $this->input->post('q');

        if (!empty($q)) {
            $query .= " and t.code ilike '%$q%' ";
        }

        $query .= " order by id desc ";
        $page = $this->input->post('page');
        $rows = $this->input->post('rows');
        $result = array();
        $data = "";
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

    function selectAllResult() {
        return $this->db->get('proformainvoice')->result();
    }

    function insert($data) {
        $data['order_id'] = $this->get_next_order_id($data['client_id']);
        return $this->db->insert('proformainvoice', $data);
    }

    function update($data, $where) {
        return $this->db->update('proformainvoice', $data, $where);
    }

    function delete($where) {
        return $this->db->delete('proformainvoice', $where);
    }

    function product_get() {
        $proformainvoiceid = $this->input->post('proformainvoiceid');

        if (empty($proformainvoiceid)) {
            $proformainvoiceid = 0;
        }

        $query = "select proformainvoice_product.*,products.code product_code,products.name product_name,products.image product_image,
                (select string_agg(code,',') from materials where id = ANY(proformainvoice_product.material_id)) material,(select string_agg(name,',') from color where id = ANY(proformainvoice_product.color_id)) color,
                (select count(*) from proformainvoice_product_stock_allocated where proformainvoice_product_id=proformainvoice_product.id) stock_set,
                fabric.code fabric_code from proformainvoice_product join products on proformainvoice_product.products_id=products.id left join fabric on proformainvoice_product.fabric_id=fabric.id
                where proformainvoice_product.proformainvoice_id=$proformainvoiceid";

        $q = $this->input->post('q');
        if (!empty($q)) {
            $query .= " and (products.code ilike '%$q%' or products.name ilike '%$q%')";
        }


        $query .= " order by proformainvoice_product.id desc ";
        $page = $this->input->post('page');
        $rows = $this->input->post('rows');
        $result = array();
        $data = "";
        if (!empty($page) && !empty($rows)) {
            $offset = ($page - 1) * $rows;
            $result['total'] = $this->db->query($query)->num_rows();
            $query .= " limit $rows offset $offset";
            $qty_total = $this->db->query("select sum(qty) qty_total from proformainvoice_product where proformainvoice_id=$proformainvoiceid")->row()->qty_total;
            $total = $this->db->query("select total from proformainvoice where id=$proformainvoiceid")->row()->total;
            $footer = array(array('product_code' => '<b>Total</b>', 'qty' => $qty_total, 'line_total' => $total));
            $result = array_merge($result, array('rows' => $this->db->query($query)->result(), 'footer' => $footer));
            $data = json_encode($result);
        } else {
            $data = json_encode($this->db->query($query)->result());
        }
        return $data;
    }

    function get_last_id() {
        return $this->db->query("select id from proformainvoice_product order by id desc")->row()->id;
    }

    function product_insert($data) {
        return $this->db->insert('proformainvoice_product', $data);
    }

    function product_update($data, $where) {
        return $this->db->update('proformainvoice_product', $data, $where);
    }

    function product_delete($where) {
        return $this->db->delete('proformainvoice_product', $where);
    }

    function product_fabric_insert_batch($data) {
        return $this->db->insert_batch('proformainvoice_product_fabric', $data);
    }

    function product_fabric_delete($where) {
        return $this->db->delete('proformainvoice_product_fabric', $where);
    }

    function select_by_id($id) {
        $query = "
                select proformainvoice.*,client.code client_code,client.name client_name,client_shipto.code client_shipto_code,client_shipto.name client_shipto_name,
                client_shipto.company client_shipto_company_name,client_shipto.email client_shipto_email,client_shipto.contact_name client_shipto_contact_name,
                country.common_name client_shipto_country_name,payment_term.name payment_term,currency.code currency_code,company.name company_name,company.address company_address,
                bank_account.account_number bank_account_number,bank_account.on_behalf_of,bank_account.bank_address,bank.name bank_name,bank.swift swift_code,c.common_name bank_country_name
                from proformainvoice
                join client on proformainvoice.client_id=client.id
                join client client_shipto on proformainvoice.ship_to = client_shipto.id
                join country on client_shipto.country_id=country.id
                join currency on proformainvoice.currency_id=currency.id
                join payment_term on proformainvoice.order_payment_term=payment_term.id
                join company on proformainvoice.company_id=company.id
                join bank_account on proformainvoice.bank_account_id=bank_account.id
                join bank on bank_account.bankid=bank.id
                join country c on bank_account.countryid=c.id
                where proformainvoice.id=$id
        ";
        return $this->db->query($query)->row();
    }

    function product_select_by_proformainvoice_id($proformainvoiceid) {
        $query = "select proformainvoice_product.*,products.code product_code,products.name product_name,products.image,
                (select string_agg(code,',') from materials where id = ANY(proformainvoice_product.material_id)) material,
                (select string_agg(name,',') from color where id = ANY(proformainvoice_product.color_id)) color,
                (select count(*) from products_box where products_id=proformainvoice_product.products_id) box,
                fabric.code fabric
                from proformainvoice_product
                join products on proformainvoice_product.products_id=products.id
                left join fabric on proformainvoice_product.fabric_id=fabric.id
                where proformainvoice_product.proformainvoice_id=$proformainvoiceid 
                order by proformainvoice_product.id desc";
        return $this->db->query($query)->result();
    }

    function product_component_get($component_id) {
        $query = "select ppc.*,ct.name component_type,pc.uom,pc.width,pc.depth,pc.height,pc.remark
            from proformainvoice_product_component ppc
            join component_type ct on ppc.component_type_id=ct.id
            join products_component pc on ppc.products_component_id=pc.id  
            where ppc.proformainvoice_product_id=$component_id";

        $query .= " order by ct.id asc ";
        $page = $this->input->post('page');
        $rows = $this->input->post('rows');
        $result = array();
        $data = "";
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

    function product_component_delete($where) {
        return $this->db->delete('proformainvoice_product_component', $where);
    }

    function get_next_order_id($client_id) {
       // var_dump($client_id);
       // var_dump($this->db->query("select proformainvoice_get_next_order_id($client_id) order_id")->row()->order_id);
        //exit();
        return $this->db->query("select proformainvoice_get_next_order_id($client_id) order_id")->row()->order_id;
    }

    function product_stock_allocated_get($pi_product_id) {
        $query = "
                with t as (
                        select 
                        product_order_detail.*,
                        proformainvoice.order_id,
                        products.code product_code,
                        products.name product_name,
                        products.image product_image,
                        fabric.code fabric_code,
                        fabric.description fabric_description,
                        (select string_agg(code,',') from materials where id = ANY(proformainvoice_product.material_id)) material,
                        (select string_agg(name,',') from color where id = ANY(proformainvoice_product.color_id)) color,
                        proformainvoice_product.width,
                        proformainvoice_product.depth,
                        proformainvoice_product.height,
                        proformainvoice_product.volume,
                        (select production_process_id from order_tracking where serial_number=product_order_detail.serial_number order by id desc limit 1) production_process_id,
                        (select date from order_tracking where serial_number=product_order_detail.serial_number order by id desc limit 1) date,
                        purchaseorder.id purchaseorder_id,
                        purchaseorder.po_no,
                        purchaseorder.date po_date,
                        vendor.name vendor_name
                        from product_order_detail
                        join purchaseorder_item on product_order_detail.purchaseorder_item_id=purchaseorder_item.id
                        left join purchaseorder on purchaseorder_item.purchaseorder_id=purchaseorder.id
                        left join vendor on purchaseorder.vendor_id=vendor.id
                        left join products on  purchaseorder_item.products_id=products.id
                        left join proformainvoice_product_component on purchaseorder_item.ppc_id=proformainvoice_product_component.id
                        left join proformainvoice_product on proformainvoice_product_component.proformainvoice_product_id=proformainvoice_product.id
                        left join proformainvoice on proformainvoice_product.proformainvoice_id=proformainvoice.id
                        left join fabric on proformainvoice_product.fabric_id=fabric.id
                        where true order by product_order_detail.id asc
                ) select t.*,production_process.name production_process_name,production_process.percent production_process_percent
                  from t
                  left join production_process on t.production_process_id=production_process.id
                  where t.serial_number in (select serial_number from proformainvoice_product_stock_allocated where proformainvoice_product_id=$pi_product_id)
        ";

        $query .= " order by t.id asc";

        $page = $this->input->post('page');
        $rows = $this->input->post('rows');

        $data = "";
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
    
    

}

?>
