<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Visitcount_Model extends MY_Model {
	
    public function __construct() {
		parent::__construct();
		
    }

    public function get_visitcounts($criteria = array()){
        $query = $this->db->select('*')
            ->from('tbl_product_sellers AS seller_tb')
            ->join('tbl_product AS pro' , 'pro.pro_id = seller_tb.pro_id' , 'left')
            ->join('tbl_shoppingcategory AS shopcategory_tb' , 'shopcategory_tb.shop_cat_id = seller_tb.shop_cat_id' , 'left')
            ->where($criteria)
            ->count_all_results();

        return $query;
    }

    public function get_visitcounts_data($criteria = array() , $order = array() , $limit = array()){
        $query = $this->db->select('*')
            ->from('tbl_product_sellers AS seller_tb')
            ->join('tbl_product AS pro' , 'pro.pro_id = seller_tb.pro_id' , 'left')
            ->join('tbl_shoppingcategory AS shopcategory_tb' , 'shopcategory_tb.shop_cat_id = seller_tb.shop_cat_id' , 'left')
            ->where($criteria)
            ->order_by($order['field'] , $order['direction']);
        if (isset($limit['length']) && $limit > 0) {
            $query = $query->limit($limit['length'] , $limit['start']);
        }        
        $query = $query->get()->result_array();

        return $query;
    }

}