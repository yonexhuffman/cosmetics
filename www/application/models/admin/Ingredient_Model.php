<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ingredient_Model extends MY_Model {
	
    public function __construct() {
		parent::__construct();
		
    }

    public function get_ingredients($criteria = array() , $order = array() , $limit = array()){
    	$query = $this->db->select('*')
    		->from('tbl_ingredient')
    		->where($criteria)
    		->order_by($order['field'] , $order['direction']);
        if (isset($limit['length']) && $limit > 0) {
            $query = $query->limit($limit['length'] , $limit['start']);
        }        
        $query = $query->get()->result_array();
        return $query;
    }

    public function insert($input_data){  
        $update_data = array(
            'ing_name' => $input_data['ing_name'] ,            
            'ing_alias'  => $input_data['ing_alias'] , 
            'ing_remark'  => $input_data['ing_remark'] , 
            'ing_csano'  => $input_data['ing_csano'] , 
            'ing_usage_purpose'  => $input_data['ing_usage_purpose'] , 
            'ing_overview'  => $input_data['ing_overview'] , 
            'ing_security_risk'  => $ing_security_risk , 
            'ing_active' => $input_data['ing_active'] , 
            'ing_acne_risk' => $input_data['ing_acne_risk'] , 
            'ing_flavor'  => $input_data['ing_flavor'] , 
            'ing_preservation'  => $input_data['ing_preservation'] , 
            'ing_pregantcaution'  => $input_data['ing_pregantcaution'] ,  
            'ing_cleansing'  => $input_data['ing_cleansing'] ,  
            'ing_aminoacid'  => $input_data['ing_aminoacid'] ,  
            'ing_sls_sles'  => $input_data['ing_sls_sles'] ,  
        );     
        if (!empty($input_data['ing_security_risk'][0]) && !empty($input_data['ing_security_risk'][1])) {
            $update_data['ing_security_risk'] = $input_data['ing_security_risk'][0] . '-' . $input_data['ing_security_risk'][1];
        }
        else if (!empty($input_data['ing_security_risk'][0])) {
            $update_data['ing_security_risk'] = $input_data['ing_security_risk'][0];
        }

        $retVal = array(
            'success'   => FALSE , 
            'message'   => ''
        );
    	if ($input_data['ing_id'] < 0) {
    		$insert_status = $this->tb_insertdata('tbl_ingredient' , $update_data);
            $ing_id = $insert_status['insert_id'];
            $retVal['success'] = $insert_status['success'];
            $retVal['ing_id'] = $insert_status['insert_id'];
    	}
    	else {
            $ing_id = $input_data['ing_id'];
    		$result = $this->tb_updatedata('tbl_ingredient' , array('ing_id' => $input_data['ing_id']) , $update_data);
            $retVal['success'] = $result;
            $retVal['ing_id'] = $ing_id;
    	}
        if ($retVal['success']) {
            $retVal['message'] = '조작이 성공하였습니다.';
        }
        else {
            $retVal['message'] = '조작이 실패하였습니다.';
        }

        return $retVal;
    }
}