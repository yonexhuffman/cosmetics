<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Product_Model extends MY_Model {
	
    public function __construct() {
		parent::__construct();
		
    }

    public function get_companys($or_where = array() , $select_cols = '*' , $order = ''){
        return $this->db->select($select_cols)
            ->from('tbl_companys')
            ->or_where($or_where)
            ->order_by($order)
            ->get()
            ->result_array();
    }

    public function get_products($criteria = array() , $order = array() , $limit = array()){
    	$query = $this->db->select('*')
    		->from('tbl_product')
            ->join('tbl_category_new' , 'tbl_category_new.cat_new_id = tbl_product.pro_cat_new_id' , 'left')
    		->where($criteria)
    		->order_by($order['field'] , $order['direction']);
        if (isset($limit['length']) && $limit > 0) {
            $query = $query->limit($limit['length'] , $limit['start']);
        }        
        $query = $query->get()->result_array();
        return $query;
    }

    public function get_product_ingredient($ing_id_str){
        if (!empty($ing_id_str)) {
            $ing_ids = explode(',', $ing_id_str);
            $ing_ids = array_slice(array_slice($ing_ids, 1), 0 , count($ing_ids) - 2);
            $ing_query = $this->db->select('ing_id , ing_name')->from('tbl_ingredient');
            foreach ($ing_ids as $key => $ing) {
                $ing_query = $ing_query->or_where('ing_id' , $ing);
            }
            $ing_query = $ing_query->get()->result_array();

            return $ing_query;
        }
        return NULL;
    }

    public function insert($input_data , $upload_path){        
        $update_data = array(
            'pro_title' => $input_data['pro_title'] , 
            'pro_alias' => $input_data['pro_alias'] , 
            'pro_remark' => $input_data['pro_remark'] , 
            'pro_cat_new_id'  => $input_data['pro_cat_new_id'] , 
            'pro_rate'  => $input_data['pro_rate'] , 
            'pro_company_id'  => $input_data['pro_company_id'] , 
            // 'update_datetime'   => $this->get_current_datetime() , 
        );   
        if (count($input_data['pro_ingredients']) > 0) {
            sort($input_data['pro_ingredients']);
            $update_data['pro_ingredients'] = ',' . implode(',' , $input_data['pro_ingredients']) . ',';
        }
        else {
            $update_data['pro_ingredients'] = '';
        }
        if (count($input_data['pro_efficacy_ingredients']) > 0) {
            sort($input_data['pro_efficacy_ingredients']);
            $update_data['pro_efficacy_ingredients'] = ',' . implode(',' , $input_data['pro_efficacy_ingredients']) . ',';
        }
        else {
            $update_data['pro_efficacy_ingredients'] = '';
        }

		$uploaded_filename = '';
        $upload_result = $this->file_upload($upload_path , 'pro_image');
        if ($upload_result['success']) {
        	$uploaded_filename = $upload_result['file_name'];
            $update_data['pro_image'] = $upload_path . $uploaded_filename;
                
            $this->load->library('image_lib');
            $config = array();
            $config['source_image'] = $upload_path . $uploaded_filename;
            $config['width']    = DEFAULTIMGWIDTH;
            $config['height']   = DEFAULTIMGHEIGHT;
            $config['maintain_ratio']   = FALSE;
            $config['quality']  = '100%';
            $this->image_lib->initialize($config);
            $this->image_lib->resize();
        }	

    	if ($input_data['pro_id'] < 0) {
    		$insert_status = $this->tb_insertdata('tbl_product' , $update_data);
            $pro_id = $insert_status['insert_id'];
    	}
    	else {
            $pro_id = $input_data['pro_id'];
            if (isset($update_data['pro_image']) && ($update_data['pro_image'] != $input_data['prev_pro_image'])) {
                // if upload file success
                $this->delete_file($input_data['prev_pro_image']);
            }                

    		$result = $this->tb_updatedata('tbl_product' , array('pro_id' => $input_data['pro_id']) , $update_data);
    	}

        if (isset($input_data['update_seller_id'])) {
            $del_query = $this->db->where('pro_id' , $pro_id);
            foreach ($input_data['update_seller_id'] as $key => $update_seller_id) {
                $del_query = $del_query->where('seller_id != ' , $update_seller_id);
            }
            $del_query->delete('tbl_product_sellers');
        }
        else {
            $del_query = $this->db->where('pro_id' , $pro_id)->delete('tbl_product_sellers');
        }

        if (isset($input_data['shop_name'])) {
            foreach ($input_data['shop_name'] as $key => $shop_name) {
                if ($input_data['shop_name'][$key] == '') {
                    continue;
                }
                $update_seller_data = array(
                    'pro_id'    => $pro_id , 
                    'shop_cat_id'   => $input_data['shop_cat_id'][$key] , 
                    'shop_name' => $input_data['shop_name'][$key] , 
                    'shop_url'  => $input_data['shop_url'][$key] , 
                    'price'  => $input_data['price'][$key] , 
                );
                if (isset($input_data['update_seller_id'][$key])) {
                    $this->tb_updatedata('tbl_product_sellers' , array('seller_id' => $input_data['update_seller_id'][$key]) , $update_seller_data);
                }
                else {
                    $this->tb_insertdata('tbl_product_sellers' , $update_seller_data);   
                }
            }
        }
        return array('success' => TRUE , 'pro_id' => $pro_id , 'message' => '조작이 성공하였습니다.');
    }
}