<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Account_Model extends MY_Model {
	
    public function __construct() {
		parent::__construct();
		
    }

    public function get_account_item($acc_id){
        $query = $this->db->select('*')
            ->from('tbl_account')
            ->where('acc_id' , $acc_id)
            ->get()
            ->row_array();
        return $query;
    }

    public function get_account($criteria = array() , $order = array() , $limit = array()){
    	$query = $this->db->select('*')
    		->from('tbl_account')
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

    public function insert($post_data , $photo_path){
        $update_userdata = array(
            'user_nickname' => $post_data['user_nickname'] , 
            'user_id'   => $post_data['user_id'] , 
            'user_email'   => $post_data['user_email'] , 
            'user_phonenumber'   => $post_data['user_phonenumber'] , 
            'user_role'   => $post_data['user_role'] , 
        );
        if (isset($post_data['is_valid'])) {
            $update_userdata['is_valid'] = 1;
        }
        else {
            $update_userdata['is_valid'] = 0;
        }
        if (!empty($_FILES['acc_image']['name'])) {
            if (!empty($post_data['prev_acc_image'])) {
                $del_result = $this->delete_file($photo_path . $post_data['prev_acc_image']);
                if ($del_result) {
                    $update_userdata['acc_image'] = '';
                }
            }
            $upload_image_name = random_string('alnum', 16);
            if ($post_data['acc_id'] > 0) {
                $upload_image_name = $post_data['acc_id'] . $upload_image_name;
            }
            $upload_result = $this->file_upload($photo_path , 'acc_image' , $upload_image_name);
            if ($upload_result) {
                $update_userdata['acc_image'] = $upload_result['file_name'];
                    
                $this->load->library('image_lib');
                $config = array();
                $config['source_image'] = $photo_path . $update_userdata['acc_image'];
                $config['width']    = DEFAULTIMGWIDTH;
                $config['height']   = DEFAULTIMGWIDTH;
                $config['maintain_ratio']   = FALSE;
                $config['quality']  = '100%';
                $this->image_lib->initialize($config);
                $this->image_lib->resize();
            }
        }

        if ($post_data['acc_id'] > 0) {
            return $this->tb_updatedata('tbl_account' , array('acc_id' => $post_data['acc_id']) , $update_userdata);
        }
        else {
            $update_userdata['user_password'] = md5(DEFAULTPASSWORD);
            $res = $this->tb_insertdata('tbl_account' , $update_userdata);
            return $res['success'];
        }
    }

}