<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Search_Model extends MY_Model {
	public function __construct() {
		parent::__construct();
		
    }

    public function get_fav_category(){
    	$cat_arr = $this->db
    		// ->select('tbl_category_new.* , SUM(tbl_product.pro_rating_point) / COUNT(tbl_product.pro_cat_new_id) AS pro_ratesum')
    		// ->select('tbl_category_new.* , SUM(tbl_product.pro_rating_point) AS pro_ratesum')
    		->select('*')
    		->from('tbl_category_new')
    		// ->join('tbl_product' , 'tbl_category_new.cat_new_id = tbl_product.pro_cat_new_id' , 'left')
    		// ->group_by('tbl_product.pro_cat_new_id')
    		// ->order_by('pro_ratesum DESC')
    		// ->limit(5 , rand(0 , 30))
    		->get()
    		->result_array();
    	shuffle($cat_arr);
    	$cat_arr = array_slice($cat_arr , rand(0 , 40) , 5);
    	return $cat_arr;
    }
    
}