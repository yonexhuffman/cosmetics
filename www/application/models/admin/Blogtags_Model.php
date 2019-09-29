<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Blogtags_Model extends MY_Model {
	
    public function __construct() {
		parent::__construct();
		
    }

    public function get_data($criteria = array()){
    	return $this->db->select('*')
    		->from('tbl_blog_tags')
    		->where($criteria)
    		->order_by('tag_name' , 'ASC')
    		->get()
    		->result_array();
    }

    public function insert($input_data , $upload_path){
        $update_data = array(
            'tag_name'  => $input_data['tag_name'] , 
        );      
    	if ($input_data['tag_id'] < 0) {
    		return $this->tb_insertdata('tbl_blog_tags' , $update_data);
    	}
    	else {
    		return array('success' => $this->tb_updatedata('tbl_blog_tags' , array('tag_id' => $input_data['tag_id']) , $update_data));
    	}
    }
}