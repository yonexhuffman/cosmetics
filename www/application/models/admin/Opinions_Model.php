<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Opinions_Model extends MY_Model {
	
    public function __construct() {
		parent::__construct();
		
    }

    public function get_opinions_item($op_id){
        $query = $this->db->select('*')
            ->from('tbl_opiniontoadmin')
            ->join('tbl_account' , 'tbl_account.acc_id = tbl_opiniontoadmin.acc_id' , 'left')
            ->where('tbl_opiniontoadmin.op_id' , $op_id)
            ->get()
            ->row_array();
        return $query;
    }

    public function get_opinions($criteria = array() , $order = array() , $limit = array()){
    	$query = $this->db->select('*')
    		->from('tbl_opiniontoadmin')
            ->join('tbl_account' , 'tbl_account.acc_id = tbl_opiniontoadmin.acc_id' , 'left')
    		->where($criteria);
        if (isset($limit['length']) && $limit > 0) {
            $query = $query->order_by($order['field'] , $order['direction']);
        }            		
        if (isset($limit['length']) && $limit > 0) {
            $query = $query->limit($limit['length'] , $limit['start']);
        }        
        $query = $query->get()->result_array();
        return $query;
    }

}