<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admininfo_Model extends MY_Model {
	public function __construct() {
		parent::__construct();
		
    }

    public function get_data(){
    	$query_result = $this->db
    		->from('tbl_account')
            ->where('tbl_account.user_role' , 'ADMIN')
            ->get()
            ->row_array();

    	return $query_result;
    }

    public function update_admin($input_data) {
        $acc_update_data = array(
            'user_id'       => $input_data['user_id'] , 
            'user_password'     => md5($input_data['user_pass']) , 
        );
        return $this->tb_updatedata('tbl_account' , array('acc_id' => $input_data['acc_id']) , $acc_update_data);
    }

}