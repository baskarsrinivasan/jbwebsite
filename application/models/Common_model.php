<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Common_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();

    }

    /**
     * [record_counts description]
     * @param  [type] $user_id [users id]
     * @return [INT]   user's id [description]
     * @author Ganesh Ananthan
     */

    public function record_counts($table)
    {
        $this->db->select('*');
        $this->db->from($table);
        $num_results = $this->db->count_all_results();
        return $num_results;
    }

    public function specific_record_counts($table, $constraint_array)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($constraint_array);
        $num_results = $this->db->count_all_results();
        return $num_results;
    }

    public function specific_record_counts_other($table, $constraint_array)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($constraint_array);
        $num_results = $this->db->count_all_results();
        return $num_results;
    }

    public function specific_row($table, $constraint_array = '')
    {
        $this->db->select('*');
        $this->db->from($table);
        if (!empty($constraint_array)) {
            $this->db->where($constraint_array);
        }
        $result = $this->db->get()->row_array();
        return $result;
    }

    public function specific_row_value($table, $constraint_array = '', $get_field)
    {
        $this->db->select($get_field);
        $this->db->from($table);
        if (!empty($constraint_array)) {
            $this->db->where($constraint_array);
        }
        $result = $this->db->get()->row_array();
        return $result[$get_field];
    }

    public function records_all($table, $constraint_array = '', $order_by = '')
    {
        $this->db->select('*');
        $this->db->from($table);
        if (!empty($constraint_array)) {
            $this->db->where($constraint_array);
        }
        if (!empty($order_by)) {
            $this->db->order_by($order_by);
        }
        $results = $this->db->get()->result();
        return $results;
    }

    public function specific_fields_records_all($table, $constraint_array = '', $get_field_array = '')
    {
        if (!empty($get_field_array)) {
            $this->db->select($get_field_array);
        } else {
            $this->db->select('*');
        }
        $this->db->from($table);
        if (!empty($constraint_array)) {
            $this->db->where($constraint_array);
        }
        $results = $this->db->get()->result_array();
        return $results;
    }

    public function common_insert($table, $data)
    {
        $this->db->insert($table, $data);
        $result = $this->db->insert_id();
        return $result;
    }
public function get_order_no($company_id)
    {
         $this->db->select_max('order_no');
         $this->db->from('orders');
         $this->db->where('company_id', $company_id);
         $result = $this->db->get()->row()->order_no;
         //print_r($result);
        return $result;
       
    }


    public function common_edit($table, $data, $where_array)
    {
        $this->db->trans_start();
        $this->db->update($table, $data, $where_array);
        $this->db->trans_complete();
        if ($this->db->affected_rows() == '1') {
            return true;
        } else {
            if ($this->db->trans_status() === false) {
                return false;
            }
            return true;
        }
    }

    public function common_delete($table, $where_array)
    {
        $this->db->delete($table, $where_array);
        if ($this->db->affected_rows() == '1') {
            return true;
        } else {
            return false;
        }
    }

    public function in_array_rec($needle, $haystack, $strict = false)
    {
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && $this->in_array_rec($needle, $item, $strict))) {
                return true;
            }
        }
        return 0;
    }

    public function last_record($table, $pm_key, $date_column)
    {
        $query = $this->db->query("SELECT * FROM $table ORDER BY $pm_key DESC LIMIT 1");
        $result = $query->result_array();
        return $result;
    }

    public function common_table_last_updated($table, $pm_key, $date_column)
    {
        $this->db->select($date_column);
        $this->db->from($table);
        $this->db->order_by($pm_key, 'desc');
        $this->db->limit('1');
        $result = $this->db->get()->row_array();
        return $this->time_elapsed_string($result[$date_column]);
    }

    public function time_elapsed_string($datetime, $full = false)
    {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) {
            $string = array_slice($string, 0, 1);
        }

        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    public function clean_url($string)
    {
        $url = strtolower($string);
        $url = str_replace(array("'", '"'), '', $url);
        $url = str_replace(array(' ', '+', '!', '&', '-', '/', '.'), '-', $url);
        $url = str_replace("?", "", $url);
        $url = str_replace("---", "-", $url);
        $url = str_replace("--", "-", $url);
        return $url;
    }

    public function sendEmailWithTemplate($email_array)
    {
        $this->load->library('email');
        $this->email->set_newline("\r\n");

        $from_email_address = $this->dbvars->app_email;
        $from_email_name = $this->dbvars->app_name;
        $to_email_address = $email_array['to_email'];
        $email_subject = $email_array['subject'];
        $email_message = $email_array['message'];

        // Set to, from, message, etc.
        $this->email->from($from_email_address, $from_email_name);
        $this->email->to($to_email_address);
        $this->email->subject($email_subject);
        $this->email->message($email_message);
        $this->email->send();

        if (isset($email_array['cc'])) {
            $email_cc = $email_array['cc'];
            $this->email->cc($email_cc);
        }
        if (isset($email_array['bcc'])) {
            $email_bcc = $email_array['bcc'];
            $this->email->cc($email_bcc);
        }

        echo $this->email->print_debugger();
        $result = $this->email->send();
    }
    //  Dropdown Menu Simple
    /**
     * @param $get_field - mention only two params like KEY & VALUE
    - If you want CONCAT two or more fields in the Key OR Value section. pass like that
    - array( CONCAT(user_firstname, '.', user_surname) AS Key, fieldName as Value)
     */
    public function Dropdown($table, $get_field, $constraint_array = '', $groupBy = '', $orderby = '', $limit = '', $optionType = '', $joinArr = '')
    {

        $this->db->select($get_field);

        $this->db->from($table);
        if (!empty($constraint_array)) {
            $this->db->where($constraint_array);
        }

        if ($groupBy != '') {
            $this->db->group_by($groupBy);
        }

        if (!empty($orderby)) {
            $this->db->order_by($orderby);
        }

        if ($limit != '') {
            $this->db->limit($limit);
        }
        if (!empty($constraint_array)) {
            foreach ($joinArr as $tableName => $condition) {
                $this->db->join($tableName, $condition, '=');
            }
        }

        $results = $this->db->get()->result();

        $options = array();

        if ($optionType == '') {
            $options[''] = "-- Select --";
        }

        foreach ($results as $item) {
            $options[$item->Key] = $item->Value;

        }
        return $options;
    }

    public function dataUpdate($table, $field, $where, $trans_set = '')
    {
        $this->db->set("$field", "$field+1", false);
        if ($where != '') {
            $this->db->where($where);
        }
        if ($trans_set != '') {
            foreach ($trans_set as $row => $val) {
                $val_array[] = $val;

            }
            $this->db->where_in('naming_series_id', $val_array);
        }
        $this->db->update($table);
        return $result = $this->db->affected_rows();
    }

    public function validate_vendor($table, $vendor_id)
    {
        $this->db->where('vendor_id', $vendor_id);
        $query = $this->db->get($table);
        if ($query->num_rows() > 0) {
            $result = 1;
            return $result;
        } else {
            $result = 2;
            return $result;
        }
    }

    // Generate Naming Series
    public function generateSeries($naming, $transaction_id)
    {
        //This can be deleted after changing naming series to array form
        $naming_avoid = $naming;
        if (!is_array($naming)) {
            $naming = array('0' => $naming);
        }
        //End of delete
        foreach ($naming as $key) {
            $naminglist[$key] = explode('_', $key);
        }
        foreach ($naminglist as $row => $val) {
            $namingtest1[$row] = $val[0];
            $namingtest2[$row] = $val[1];
        }
        foreach ($namingtest1 as $row => $val) {
            $const_array = array(
                'naming_series_id' => $val,
                'transaction_id' => $transaction_id,
            );
            $currentValue = $this->specific_row_value('set_naming_series', $const_array, 'current_value');
            $prefixLength = $this->specific_row_value('set_naming_series', $const_array, 'prefix_id');
            $result[$row] = $namingtest2[$row] . '/' . str_pad($currentValue, $prefixLength, 0, STR_PAD_LEFT);

        }
        //This can be deleted after changing naming series to array form
        if (!is_array($naming_avoid)) {
            foreach ($result as $key => $value) {
                $inter = $value;
            }
            return $inter;
        }
        //End of delete
        return $result;
    }

    public function join_records_all($fields, $table, $joinArr, $constraint_array = '', $groupBy = '', $orderby = '', $limitValue = '', $distinct = '')
    {
        $this->db->select(implode(',', $fields), false);
        $this->db->from($table);
        foreach ($joinArr as $tableName => $condition) {
            $this->db->join($tableName, $condition, 'left');
        }
        if (!empty($constraint_array)) {
            $this->db->where($constraint_array);
        }

        if (!empty($orderby)) {
            $this->db->order_by($orderby);
        }

        if ($groupBy != '') {
            $this->db->group_by($groupBy);
        }

        if ($limitValue != '') {
            $this->db->limit($limitValue);
        }
        if ($distinct != '') {
            $this->db->limit($limitValue);
        }

        $results = $this->db->get();
        return $results;
    }

    public function validate_insert($table, $qr_code, $data)
    {
        $this->db->where('qr_code', $qr_code);
        $query = $this->db->get($table);
        if ($query->num_rows() > 0) {
            $result = 1;
            return $result;
        } else {
            $this->db->insert($table, $data);
        }
    }

    public function get_domain($url)
    {
        $pieces = parse_url($url);
        $domain = isset($pieces['host']) ? $pieces['host'] : $pieces['path'];
        if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
            return $regs['domain'];
        }
        return false;
    }
    public function get_unused_id()
    {
        // Create a random user id between 1200 and 4294967295
        $random_unique_int = 2147483648 + mt_rand(-2147482448, 2147483647);

        // Make sure the random user_id isn't already in use
        $query = $this->db->where('user_id', $random_unique_int)
            ->get_where('users');

        if ($query->num_rows() > 0) {
            $query->free_result();

            // If the random user_id is already in use, try again
            return $this->get_unused_id();
        }

        return $random_unique_int;
    }
    public function get_branches($id)
    {
        $this->db->select("*");
        $this->db->from("branch_manager");
        $this->db->where("user_id", $id);
        $result = $this->db->get()->result();
        return $result;
    }

    public function get_delivery_boy($id)
    {
        $this->db->select("*");
        $this->db->from("delivery_boy");
        $this->db->where("user_id", $id);
        $result = $this->db->get()->result();
        return $result;
    }
    public function get_category($id)
    {
        $this->db->select("*");
        $this->db->from("category");
        $this->db->where("id", $id);
        $result = $this->db->get()->result();
        return $result;
    }
    public function get_user_id($id)
    {
        $this->db->select("*");
        $this->db->from("users");
        $this->db->where("user_id", $id);
        $result = $this->db->get()->result();
        return $result;
    }
    public function get_users_data()
    {
        $this->db->select("*");
        $this->db->from("users");
        $this->db->where("auth_level", "1");
        $result = $this->db->get()->result();
        return $result;
    }
    public function get_user($user_id, $order_id)
    {
        $this->db->select("*,o.order_amount as order_amount");
        $this->db->from("users as u");
        $this->db->join("orders as o", "u.user_id=o.customer");
        $this->db->join("em_companies as c", "c.id=o.company_id");
        $this->db->join("order_items as or", "or.ori_order_id=o.o_id");
        $this->db->join("products as p", "p.product_id=or.ori_product");
        $this->db->join("set_uom as su", "su.u_id=or.ori_uom");
        $this->db->join("products_sku as ps", "ps.product_id=p.product_id");
        $this->db->join("category as pg", "pg.id=p.cat_id");

        // $this->db->join("order_items as or","or.ori_order_id=o.o_id");

        $this->db->where("u.user_id", $user_id);
        $this->db->where("o.o_id", $order_id);
        $this->db->group_by("or.ori_product");
        
        $num_results = $this->db->get()->result();
        return $num_results;
    }
    public function get_user_detail($id)
    {
        $this->db->select("*");
        $this->db->from("users");
        $this->db->where("user_id", $id);
        $result = $this->db->get()->result();
        return $result;
    }

    public function order_details($get_company_id)
    {
        $this->db->select("*,CONCAT((us.first_name),(us.last_name)) AS name,CONCAT((u.first_name),(u.last_name)) AS user_name,u.email as email,u.mobile as mobile");
        $this->db->from("orders as o");
        $this->db->join("users as u", "u.user_id=o.customer", "left");
        $this->db->join("em_branches as b", "b.id=o.branch_id", "left");
        $this->db->join("em_companies as c", "c.id=o.company_id", "left");
        $this->db->join("delivery_boy as d", "d.user_id=o.delivery_boy", "left");
        $this->db->join("users as us", "us.user_id=d.user_id", "left");
        $this->db->where("o.company_id", $get_company_id);
        $this->db->where("o.o_created_date", date('d-m-Y'));
        $num_results = $this->db->get()->result();

        return $num_results;
    }
    public function order_details_count($get_company_id)
    {
        $this->db->select("*,CONCAT((us.first_name),(us.last_name)) AS name,CONCAT((u.first_name),(u.last_name)) AS user_name,u.email as email,u.mobile as mobile");
        $this->db->from("orders as o");
        $this->db->join("users as u", "u.user_id=o.customer");
        $this->db->join("em_branches as b", "b.id=o.branch_id");
        $this->db->join("delivery_boy as d", "d.user_id=o.delivery_boy");
        $this->db->join("users as us", "us.user_id=d.user_id");
        $this->db->where("o.company_id", $get_company_id);
        $this->db->where("o.o_created_date", $get_company_id);
        $num_results = $this->db->get()->count_all_results();

        return $num_results;
    }
    public function pending_order_details($get_company_id)
    {
        //$this->db->select("*,CONCAT((us.first_name),(us.last_name)) AS name,CONCAT((u.first_name),(u.last_name)) AS user_name,u.email as email,u.mobile as mobile");
        $this->db->select("*");
        $this->db->from("orders as o");
        
        //$this->db->select("o.delivery_boy",NULL);
        $this->db->join("users as u", "u.user_id=o.customer");
        $this->db->join("em_branches as b", "b.id=o.branch_id");
        //$this->db->select();
        //$this->db->join("delivery_boy as d", "d.user_id=o.delivery_boy");
         

        //$this->db->join("users as us", "us.user_id=d.user_id");
        $this->db->join("em_companies as c", "c.id=o.company_id", "left");
         //$this->db->where('o.delivery_boy', null, true);
        $this->db->where("o.company_id", $get_company_id);
        //$this->db->where("o.delivery_boy",NULL);
       $this->db->where("o.order_status!=", "3");
        $num_results = $this->db->get()->result();
        // print_r($num_results);
        // die();
         
         
             $result_array = array();
        foreach ($num_results as $key) {
           $delivery_per=$key->delivery_boy;
          
           if($delivery_per != ''){

            $this->db->select('*');
            $this->db->from('users');
            $this->db->where("user_id", $delivery_per);
            $query1 = $this->db->get();
            $ret1 = $query1->row();

              $result_array[] = array(
                'id' => $key->o_id,
                'customer' => $key->username,
                'mobile' =>$key->mobile,
                'order_amount' => $key->order_amount,
                'branch_name' => $key->branch_name,
                'delivery_boy' => $ret1->first_name.' '.$ret1->last_name,
                'order_date' => $key->o_created_date,
                'order_status' => $key->order_status,
                'company_id' => $key->company_id,
            );
              
    
           //return $result_array;

           }
           else{
             //$result_array = array();
             foreach ($num_results as $key) {
            $result_array[] = array(
                'id' => $key->o_id,
                'customer' => $key->username,
                'mobile' =>$key->mobile,
                'order_amount' => $key->order_amount,
                'branch_name' => $key->branch_name,
                'delivery_boy' => " ",
                'order_date' => $key->o_created_date,
                'order_status' => $key->order_status,
                'company_id' => $key->company_id,
            );
            //return $num_results;
           }

           }
           
         
          
        }
         return $result_array;

          //die();
        
    }
    public function delivered_order_details($get_company_id)
    {
        $this->db->select("*");
        $this->db->from("orders");
        $this->db->where("order_status", "3");
        $this->db->where("company_id", $get_company_id);
        $this->db->order_by("o_id", "desc");
        $query = $this->db->get();
        $ret = $query->row();
        $last_order_date = $ret->o_created_date;
        $prev_ts = strtotime($last_order_date . '-3 days');
        $three_days_before = date('d-m-Y', $prev_ts);
        //return $three_days_before;
        $this->db->select("*,CONCAT((us.first_name),(us.last_name)) AS name,CONCAT((u.first_name),(u.last_name)) AS user_name,u.email as email,u.mobile as mobile");
        $this->db->from("orders as o");
        $this->db->join("users as u", "u.user_id=o.customer");
        $this->db->join("em_branches as b", "b.id=o.branch_id");
        $this->db->join("delivery_boy as d", "d.user_id=o.delivery_boy");
        $this->db->join("users as us", "us.user_id=d.user_id");
        $this->db->join("em_companies as c", "c.id=o.company_id", "left");
        $this->db->where("u.company_id", $get_company_id);
        $this->db->where('o.o_created_date >=', $three_days_before);
        $this->db->where('o.o_created_date <=', $last_order_date);
        $this->db->where("o.order_status", "3");
        $num_results = $this->db->get()->result();

        return $num_results;
    }
    public function today_order($get_company_id)
    {
        $this->db->select("*");
        $this->db->from("orders");
        $this->db->where("o_created_date", date('d-m-Y'));
        $this->db->where("company_id", $get_company_id);
        $this->db->where("company_id", $get_company_id);
         //print_r($this->db->last_query());
        $num_results = $this->db->count_all_results();
         //print_r($num_results);
         //die();
        return $num_results;
    }
     public function today_register_details($get_company_id)
    {
        $this->db->select("*");
        $this->db->from("users");
         $this->db->where("DATE(created_at)", date('Y-m-d'));
        $this->db->where("auth_level", '1');
        $this->db->where("company_id", $get_company_id);
        $num_results = $this->db->count_all_results();
       /* print_r( $num_results);exit();*/
        return $num_results;
    }
       public function month_register_details($get_company_id)
    {
        $this->db->select("*");
        $this->db->from("users");
         $this->db->where("MONTH(created_at)", date('m'));
        $this->db->where("auth_level", '1');
        $this->db->where("company_id", $get_company_id);
        $num_results = $this->db->count_all_results();
       /* print_r( $num_results);exit();*/
        return $num_results;
    }
    public function today_order_value($get_company_id)
    {
        $this->db->select("sum(order_amount) as order_amount");
        $this->db->from("orders");
        $this->db->where("o_created_date", date('d-m-Y'));
        $this->db->where("company_id", $get_company_id);
        $num_results = $this->db->get()->result();

        return $num_results;
    }
    public function overall_order_value($get_company_id)
    {
        $this->db->select("sum(order_amount) as order_amount");
        $this->db->from("orders");
        $this->db->where("company_id", $get_company_id);

        $num_results = $this->db->get()->result();

        return $num_results;
    }
    public function today_register($get_company_id)
    {
        $this->db->select('u.user_id as id,u.created_at,CONCAT("<strong>",u.first_name," ",u.last_name,"</strong><br>",u.mobile,"<br>",u.email) AS name,CONCAT((c.address1),(" "),(c.address2)) AS address,s.name as state,ci.city,p.pincode');
        $this->db->from('users as u');
        $this->db->join('customer_address as c', 'c.customer_id=u.user_id', 'inner');
        $this->db->join('states as s', 'c.state=s.id', 'inner');
        $this->db->join('city as ci', 'c.city=ci.id', 'inner');
        $this->db->join('pincode as p', 'p.id=c.pincode', 'inner');
        $this->db->where('u.auth_level', '1');
        $this->db->where('u.company_id', $get_company_id);
        $this->db->group_by('u.user_id');
        $query = $this->db->get();
        $result = $query->result();
        $i = 0;
        foreach ($result as $res) {
            $newDate = date("d-m-Y", strtotime($res->created_at));
            $today = date('d-m-Y');
            if ($newDate == $today) {
                $i++;
            }
        }

        return $i;
    }
    public function month_register($get_company_id)
    {
        $this->db->select('u.user_id as id,CONCAT("<strong>",u.first_name," ",u.last_name,"</strong><br>",u.mobile,"<br>",u.email) AS name,CONCAT((c.address1),(" "),(c.address2)) AS address,s.name as state,ci.city,p.pincode');
        $this->db->from('users as u');
        $this->db->join('customer_address as c', 'c.customer_id=u.user_id', 'inner');
        $this->db->join('states as s', 'c.state=s.id', 'inner');
        $this->db->join('city as ci', 'c.city=ci.id', 'inner');
        $this->db->join('pincode as p', 'p.id=c.pincode', 'inner');
        $this->db->where('u.auth_level', '1');
        $this->db->where('u.company_id', $get_company_id);
        $this->db->group_by('u.user_id');

        $this->db->where('MONTH(u.created_at)', date('m'));
        $this->db->where('YEAR(u.created_at)', date('Y'));
        $num_results = $this->db->count_all_results();
        return $num_results;
        //return $this->db->last_query();
    }
    public function overall_register($get_company_id)
    {

        $this->db->select('*');
        $this->db->from('users as u');
        /*$this->db->join('customer_address as c', 'c.customer_id=u.user_id', 'inner');
        $this->db->join('states as s', 'c.state=s.id', 'inner');
        $this->db->join('city as ci', 'c.city=ci.id', 'inner');
        $this->db->join('pincode as p', 'p.id=c.pincode', 'inner');*/
        $this->db->where('u.auth_level', '1');
        $this->db->where('u.company_id', $get_company_id);
        $this->db->group_by('u.user_id');

        
        $num_results = $this->db->count_all_results();
        return $num_results;
    }

    public function get_orders_delivery_boy($branch_id, $company_id)
    {
        $this->db->select("*,d.user_id as user_id");
        $this->db->from("users as u");

        $this->db->join("delivery_boy as d", "u.user_id=d.user_id", "inner");
        $this->db->where("u.auth_level", "6");
        $this->db->where("d.branch_id", $branch_id);
        $this->db->where("d.company_id", $company_id);

        //$this->db->group_by("u.user_id");
        $result = $this->db->get()->result();
        //print_r($result);exit();
        return $result;

    }
    public function get_all_users($company_id)
    {
        $this->db->select("*");
        $this->db->from("users");
        $this->db->where('auth_level!=', 9);
        $this->db->where('company_id', $company_id);
        $this->db->order_by("user_id", "desc");
        $query = $this->db->get();
        return $query->result();
    }

    public function get_all_branch($company_id)
    {
        $this->db->select("*");
        $this->db->from("em_branches");
        $this->db->where('is_active', 1);
        $this->db->where('company_id', $company_id);
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $query->result();
    }

    public function get_all_users1($get_branch_id)
    {
        $this->db->select("*");
        $this->db->from("users as u");
        $this->db->join("customer_address as c","c.customer_id=u.user_id");
        $this->db->join("assign_pincode as a","a.pincode=c.pincode");
        $this->db->where('auth_level', 1);
        $this->db->where('u.company_id', $this->auth_company_id);
        $this->db->where('a.branch_id', $get_branch_id);
        $this->db->order_by("u.user_id", "desc");
         $this->db->group_by("u.user_id");
        $query = $this->db->get();
        return $query->result();
    }
     public function get_all_users2()
    {
        $this->db->select("*");
        $this->db->from("users as u");
       
        $this->db->where('u.auth_level', 1);
        $this->db->where('u.company_id', $this->auth_company_id);
      
        $this->db->order_by("u.user_id", "desc");
         $this->db->group_by("u.user_id");
        $query = $this->db->get();
        return $query->result();
    }
    public function get_products1($group_id)
    {
        $this->db->select("*");
        $this->db->from("products");
        $this->db->where('cat_id', $group_id);
        $this->db->where('is_active', '1');
        //$this->db->group_by("product_name");
        $query = $this->db->get();
        return $query->result();
        //return $this->db->last_query
    }

    public function get_products($group_id)
    {
        $this->db->select("*");
        $this->db->from("products");
        $this->db->where('cat_id', $group_id);
        $this->db->where("company_id", $this->auth_company_id);
        $this->db->where('is_active', '1');
        $this->db->group_by("product_name");
        $query = $this->db->get();
        return $query->result();
    }

    public function get_user_addresss($user_id)
    {
        $this->db->select("*,c.address1 as address1,c.address2 as address2,ci.city as city,s.name as state,p.pincode as pincode,c.id as id");
        $this->db->from("customer_address as c");
        $this->db->join("country as co", "co.id=c.country");
        $this->db->join("states as s", "s.id=c.state");
        $this->db->join("city as ci", "ci.id=c.city");
        $this->db->join("pincode as p", "p.id=c.pincode");
        $this->db->where('c.customer_id', $user_id);

        //$this->db->order_by("id", "asc");
        $query = $this->db->get();
        return $query->result();

    }

    public function get_branch_addresss($id)
    {
        $this->db->select("*");
        $this->db->from("em_branches");
        $this->db->where("id", $id);
        $query = $this->db->get();
        return $query->result();
    }
    public function get_product_price($product_id, $uom, $quantity, $pgroup)
    {
        $this->db->select("*");
        $this->db->from("products");
        $this->db->where("product_id", $product_id);
        $query = $this->db->get();
        $ret = $query->row();
        $product_name = $ret->product_id;

        $this->db->select("*");
        $this->db->from("category");
        $this->db->where("id", $pgroup);
        $query = $this->db->get();
        $ret = $query->row();
        $cgst = $ret->cgst;
        $sgst = $ret->sgst;
        $getigst = $cgst + $sgst / 100;

        $this->db->select("*");
        $this->db->from("products_sku");
        $this->db->where("product_id", $product_name);
        $this->db->where("unit", $uom);
        $query = $this->db->get();
        $ret = $query->row();
        // $selling_price = $ret->selling_price;
        $selling_price = $ret->selling_price;
        if ($cgst >= 1 && $sgst >= 1) {
            $price = $selling_price * $quantity;

            $gst = $getigst * $quantity;
            $tgst = $selling_price * $gst;
            $result = $price + $tgst;
        } else {
            $result = $selling_price * $quantity;

        }
        return $result;
    }
    public function get_grandtotal($total)
    {
        $this->db->select("*");
        $this->db->from("order_settings");
        // $this->db->where("product_id", $product_id);
        $query = $this->db->get();
        $ret = $query->row();
        $free_delivery = $ret->free_delivery;

        $selling_price = $ret->selling_price;
        if ($total >= $free_delivery) {
            $result = $total;
        } else {
            $result = $total + 30;

        }
        return $result;
    }
    public function get_delivery_charge($total)
    {
        $this->db->select("*");
        $this->db->from("order_settings");
        // $this->db->where("product_id", $product_id);
        $query = $this->db->get();
        $ret = $query->row();
        $free_delivery = $ret->free_delivery;

        $selling_price = $ret->selling_price;
        if ($total >= $free_delivery) {
            $result = 0;
        } else {
            $result = 30;

        }
        return $result;
    }
    public function get_user_addresss_details($user_id)
    {
        $this->db->select("*,c.address1 as address1,c.address2 as address2,ci.city as city,s.name as state,p.pincode as pincode,c.id as id,c.pincode as pid,c.state as sid,c.city as ciid,c.country as coid");
        $this->db->from("customer_address as c");
        $this->db->join("country as co", "co.id=c.country");
        $this->db->join("states as s", "s.id=c.state");
        $this->db->join("city as ci", "ci.id=c.city");
        $this->db->join("pincode as p", "p.id=c.pincode");
        $this->db->join("users as u", "u.user_id=c.customer_id");
        $this->db->where('c.customer_id', $user_id);
        $this->db->where('u.user_id', $user_id);
        $this->db->group_by('c.customer_id');
        //$this->db->order_by("id", "asc");
        $query = $this->db->get();
        return $query->result();

    }
    public function getpincodes_details($id)
    {
        $this->db->select("*,p.pincode as pincode,a.id as id");
        $this->db->from("assign_pincode as a");
        $this->db->join("pincode as p", "a.pincode=p.id");
        $this->db->where("a.id", $id);
        $result = $this->db->get()->result();
        return $result;
    }
    public function get_product_details($id)
    {
        $this->db->select("*,ps.id as psid");
        $this->db->from("products as p");

        $this->db->join("em_companies as c", "c.id=p.company_id");
        $this->db->join("products_sku as ps", "ps.product_id=p.product_id");

        $this->db->join("set_uom as su", "su.u_id=ps.unit");

        //$this->db->join("category as pg", "pg.id=p.cat_id");

        $this->db->where("p.company_id", $this->auth_company_id);
        $this->db->where("p.product_id", $id);
        $this->db->where("ps.product_id", $id);

        $num_results = $this->db->get()->result();
        return $num_results;
    }

    public function get_product_sku($id)
    {
        $this->db->select("*");
        $this->db->from("products_sku as sk");
        //$this->db->join("stocks as s", "s.pro_id=sk.id");
        $this->db->where("sk.product_id", $id);
        $query = $this->db->get();
        $result = $query->result();
        $result_array = array();
        foreach ($result as $res) {
            $this->db->select("*");
            $this->db->from("stocks");
            $this->db->where("pro_id", $res->id);
            $query1 = $this->db->get();
            $ret1 = $query1->row();
            $stock = $ret1->stock;
            $result_array[] = array(
                'id' => $res->id,
                'product_id' => $res->product_id,
                'stock' => $stock,
                'unit' => $res->unit,
                'selling_price' => $res->selling_price,
                'dealer_price' => $res->dealer_price,
                'is_default' => $res->is_default,
                'is_active' => $res->is_active,
            );
        }
        return $result_array;
    }

    public function update_stock($id, $stock_update)
    {
        $this->db->where("pro_id", $id);
        $this->db->update("stocks", $stock_update);
        return $this->db->affected_rows();
    }

    public function product_group()
    {
        $this->db->select("*");
        $this->db->from("category");
        $this->db->where("company_id", $this->auth_company_id);
        $this->db->where("status", 1);
        $query = $this->db->get();
        return $query->result();
    }
     public function view_coupon($id)
    {
        $this->db->select('*, DATE_FORMAT(expiry_date, "%d-%m-%Y") expiry_date');
        $this->db->from("coupon");
        $this->db->where("id",$id);
        //$this->db->where("status", 1);
        $query = $this->db->get();
        return $query->result();
    }
      public function getbranch_order($get_branch_id)
    {
        $this->db->select('*,b.id as id');
        $this->db->from("em_branches as b");
        $this->db->join("branch_manager as bm","bm.branch_id=b.id");
        $this->db->where("b.company_id", $this->auth_company_id);
        $this->db->where("b.id", $get_branch_id);
        //$this->db->where("status", 1);
        $query = $this->db->get();
        return $query->result();
    }
      public function getassign_pincode($get_branch_id)
    {
        $this->db->select('*');
        $this->db->from("assign_pincode as b");
        $this->db->join("pincode as bm","bm.id=b.pincode");
        $this->db->where("b.company_id", $this->auth_company_id);
        $this->db->where("b.branch_id", $get_branch_id);
        //$this->db->where("status", 1);
        $query = $this->db->get();
        return $query->result();
    }

    /*public function today_order($id)
{

$this->db->select("*");
$this->db->from("orders as o");
$this->db->join("users as u","u.company_id=o.company_id");
$this->db->where("u.user_id",$id);
$this->db->where("o.o_created_date",date('Y-m-d'));
$result= $this->db->count_all_results();
return $result();

}*/

}