<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Shoppingcategory_Model extends MY_Model {
	
    public function __construct() {
		parent::__construct();
		
    }

    public function get_data($criteria = array()){
    	return $this->db->select('*')
    		->from('tbl_shoppingcategory')
    		->where($criteria)
    		->order_by('disp_order_num' , 'ASC')
    		->get()
    		->result_array();
    }

    public function insert($input_data , $upload_path){
		$uploaded_filename = '';
        $upload_result = $this->file_upload($upload_path , 'shoppingcat_img' , $input_data['shoppingcat_name']);
        if ($upload_result['success']) {
        	$uploaded_filename = $upload_result['file_name'];
			$update_data = array(
				'shoppingcat_name'	=> $input_data['shoppingcat_name'] , 
				'shoppingcat_img'	=> $uploaded_filename , 
				'disp_order_num'	=> $input_data['disp_order_num']
			);    	
        
            $this->load->library('image_lib');
            $config = array();
            $config['source_image'] = $upload_path . $uploaded_filename;
            $config['width']    = DEFAULTSHOPPINGCATEGORYIMGWIDTH;
            $config['height']   = DEFAULTSHOPPINGCATEGORYIMGHEIGHT;
            $config['maintain_ratio']   = TRUE;
            $config['quality']  = '100%';
            $this->image_lib->initialize($config);
            $this->image_lib->resize();
        }	
        else {
			$update_data = array(
				'shoppingcat_name'	=> $input_data['shoppingcat_name'] , 
				'disp_order_num'	=> $input_data['disp_order_num']
			);    	
        }
    	if ($input_data['shop_cat_id'] < 0) {
    		return $this->tb_insertdata('tbl_shoppingcategory' , $update_data);
    	}
    	else {
    		return array('success' => $this->tb_updatedata('tbl_shoppingcategory' , array('shop_cat_id' => $input_data['shop_cat_id']) , $update_data));
    	}
    }
}