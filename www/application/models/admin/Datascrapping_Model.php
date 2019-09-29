<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Datascrapping_Model extends MY_Model {
    public function __construct() {
		parent::__construct();
		// $maxp = $this->db->query( 'SELECT @@global.max_allowed_packet' )->row_array();
		// var_dump($maxp);
		// $this->db->query( 'SET @@global.max_allowed_packet = ' . 500 * 1024 * 1024 );
		// $maxp = $this->db->query( 'SELECT @@global.max_allowed_packet' )->row_array();
		// var_dump($maxp);
		// exit();
    }

 	function search_in_array($find , $array , $field) {
 		foreach ($array as $key => $value) {
 			if ($value[$field] == $find) {
 				return $key;
 			}
 		}
 		return NULL;
 	}

 	public function checkdistinct(){
 		$distinctquery = $this->db->select('pro_id , pro_title , COUNT(pro_title) AS distinctcount')
 			->from('tbl_product')
 			->group_by('pro_title')
 			->having('distinctcount > ' , '1')
 			->order_by('distinctcount DESC')
 			->limit(1000000 , 0)
 			->get()
 			->result_array();
 		if (count($distinctquery) > 0) {
	 		foreach ($distinctquery as $key => $record) {
	 			$item = $this->db->select('pro_id , pro_title')->from('tbl_product')->where('pro_title LIKE ' , $record['pro_title'])->get()->result_array();
	 			for ($i = 1 ; $i < count($item) ; $i ++){
	 				echo 'pro_id -> ' . $item[$i]['pro_id'] . ' distinctcount-> ' . $record['distinctcount'];
	 				echo ' blogcount=' . $this->tb_data_count('tbl_blog' , array('b_pro_id' => $item[$i]['pro_id']));

	 				$this->tb_deletedata('tbl_blog' , array('b_pro_id' => $item[$i]['pro_id']));
	 				echo ' delete->' . $this->tb_deletedata('tbl_product' , array('pro_id' => $item[$i]['pro_id'])) . '<br>';
	 			}
	 		}
 		}
 		else {
 			echo "Empty Distinct Data !";
 		}

 		$distinctquery = $this->db->select('ing_id , ing_name , COUNT(ing_name) AS distinctcount')
 			->from('tbl_ingredient')
 			->group_by('ing_name')
 			->having('distinctcount > ' , '1')
 			->order_by('distinctcount DESC')
 			->limit(1000000 , 0)
 			->get()
 			->result_array();
 		if (count($distinctquery) > 0) {
	 		foreach ($distinctquery as $key => $record) {
	 			$item = $this->db->select('ing_id , ing_name')->from('tbl_ingredient')->where('ing_name LIKE ' , $record['ing_name'])->get()->result_array();
	 			if (count($item) > 1) {
		 			for ($i = 1 ; $i < count($item) ; $i ++){
		 				echo 'ing_id -> ' . $item[$i]['ing_id'] . ' distinctcount-> ' . $record['distinctcount'];
		 				echo ' delete->' . $this->tb_deletedata('tbl_ingredient' , array('ing_id' => $item[$i]['ing_id'])) . '<br>';
		 			}
	 			}
	 		}
 		}
 		else {
 			echo "Empty Distinct Data !";
 		}

 		exit();
 	}

 	public function getid_ifexist_notexistinsert($table_name , $get_field , $criteria , $push_data){
 		if ($this->tb_data_count($table_name , $criteria) > 0) { 			
            $query = $this->db->select($get_field)->from($table_name)->where($criteria)->get()->row_array();
            if (!empty($query)) {
            	return $query[$get_field];
            }
 		}
 		else {
 			$result = $this->tb_insertdata($table_name , $push_data);
 			if ($result['success']) {
 				return $result['insert_id'];
 			}
 		}
 		return -1;
 	}

    public function tb_updatedata_getid($tb_name , $criteria , $update_data , $select_col = '*') {
        if ($this->db->where($criteria)->update($tb_name , $update_data)) {
            $query = $this->db->select($select_col)->from($tb_name)->where($criteria)->get()->row_array();
            if (!empty($query)) {
            	return $query[$select_col];
            }
        }
        return FALSE;
    }

    public function tb_insertorupdatedata($tb_name , $criteria , $pushdata){
    	if ($this->tb_data_count($tb_name , $criteria) > 0) {
    		return $this->tb_updatedata($tb_name , $criteria , $pushdata);
    	}
    	else {
    		return $this->tb_insertdata($tb_name , $pushdata);
    	}
    }

    public function get_scrap_log($logflag = 'CATSCRAP' , $menu_kinds = 1){
    	if ($menu_kinds == 1) {
	    	if ($logflag == 'CATSCRAP') {
				$log_item = $this->db->select('pro_cat_id , log_datetime , scrap_type')
					->from('tbl_scraplogs')
					->where('pro_cat_id' , 0)
					->where('scrap_type' , $logflag)
					->where('menu_kinds' , $menu_kinds)
					->order_by('log_datetime' , 'DESC')
					->get()
					->row_array();
				$retVal = array(
					'log_datetime' => ''
				);
				if (!empty($log_item)) {
					$retVal['log_datetime'] = $log_item['log_datetime'];
				}
				return $retVal;
	    	}
	    	else {
				$category = $this->datascrapping->get_singletbdata('tbl_category' , array('is_delete' => 0));
				foreach ($category as $key => $record) {
					$cat_id = $record['cat_id'];
					$log_item = $this->db->select('pro_cat_id , log_datetime , scrap_type')
						->from('tbl_scraplogs')
						->where('pro_cat_id' , $cat_id)
						->where('scrap_type' , $logflag)
						->order_by('log_datetime' , 'DESC')
						->get()
						->row_array();
					$mergeitem = array(
						'log_datetime'	=> '' , 
					);
					if (!empty($log_item)) {
						$mergeitem['log_datetime'] = $log_item['log_datetime'];
					}
					$category[$key] = array_merge($record , $mergeitem);
				}
				return $category;	
	    	}
    	}
    	else if ($menu_kinds == 2) {
    		$retCategory = array();
    		$criteria = array(
    			'cat_new_parent_id'	=> 0 , 
    			'is_delete'			=> 0
    		);
			$parentcategory = $this->datascrapping->get_singletbdata('tbl_category_new' , $criteria);
			foreach ($parentcategory as $key => $record) {
				$retCategory[] = $record;
				$criteria['cat_new_parent_id'] = $record['cat_new_id'];
				$sub_category = $this->datascrapping->get_singletbdata('tbl_category_new' , $criteria);
				foreach ($sub_category as $key => $sub_item) {
					$retCategory[] = $sub_item;
				}
			}
			foreach ($retCategory as $key => $record) {
				$logcriteria = array(
	    			'pro_cat_id'	=> $record['cat_new_id'] , 
	    			'scrap_type'	=> $logflag , 
	    			'menu_kinds'	=> $menu_kinds
				);
				$log_item = $this->db->select('pro_cat_id , log_datetime , scrap_type')
					->from('tbl_scraplogs')
					->where($logcriteria)
					->order_by('log_datetime' , 'DESC')
					->get()
					->row_array();
				$mergeitem = array(
					'log_datetime'	=> '' , 
				);
				if (!empty($log_item)) {
					$mergeitem['log_datetime'] = $log_item['log_datetime'];
				}
				$retCategory[$key] = array_merge($record , $mergeitem);
			}
			return $retCategory;
    	}
    }
 
 	public function scrape_category() {
 		$retVal = array(
 			'success'	=> TRUE , 
 			'message'	=> '操作成功'
 		);
 		$html = file_get_html(RESOURCE_PAGE_URL);
 		$res = $html->find('div[class=main-cosmetics-class-info-more] a');
 		if (count($res) == 0) {
 			$retVal['success'] = FALSE;
 			$retVal['message'] = 'Operation Failed !';
 		}
 		else {
 			$target_url = RESOURCE_PAGE_URL . $res[0]->href;
 			$html = file_get_html($target_url);
 			$res = $html->find('div[class=goods-category] ul li a');
 			$category_data = array();
 			foreach ($res as $key => $value) {
 				$category_item = array();
 				$category_item['cat_name'] = $value->innertext();
 				$category_item['bevol_url'] = $value->href;
 				$category_item['bevol_cat_id'] = substr($value->href , 18);
 				$category_data[] = $category_item;
	 		}

	 		if (count($category_data) > 0) {
	 			foreach ($category_data as $key => $loadedcategory_item) {
	 				$insert_status = FALSE;
	 				if ($this->tb_data_count('tbl_category' , array('cat_name' => $loadedcategory_item['cat_name'])) > 0) {
	 					$insert_status = $this->tb_updatedata_getid('tbl_category' , array('cat_name' => $loadedcategory_item['cat_name']) , $loadedcategory_item , 'cat_id');
	 					if ($insert_status > 0) {
	 						$retVal['category_data'][$key] = $loadedcategory_item;
	 						$retVal['category_data'][$key]['cat_id'] = $insert_status;
	 					}
	 				}
	 				else {
	 					$insert_status = $this->tb_insertdata('tbl_category' , $loadedcategory_item);	
	 					if ($insert_status > 0) {
	 						$retVal['category_data'][$key] = $loadedcategory_item;
	 						$retVal['category_data'][$key]['cat_id'] = $insert_status;
	 					}
	 				}
	 			}

	 			$log_insert_data = array(
	 				'pro_cat_id'	=> 0 , 
	 				'log_datetime'	=> $this->get_current_datetime() , 
	 				'scrap_type'	=> 'CATSCRAP'
	 			);
	 			$this->db->where($log_insert_data)->delete('tbl_scraplogs');
	 			$this->db->insert('tbl_scraplogs' , $log_insert_data);
	 		}
	 		else {
	 			$retVal['success'] = FALSE;
 				$retVal['message'] = '操作失败';
	 		}
 		}
 		return $retVal;
 	}   

 	/*******
	***** Scrape Product's some details *****
 	********/
 	public function scrape_product($cat_id , $uploadpath_product) {
 		$query = $this->db->select('cat_id , bevol_cat_id')
 			->from('tbl_category')
 			->where('cat_id' , $cat_id)
 			->get()
 			->row_array();
 		if (intval($query['bevol_cat_id']) > 0) {
 			$bevol_cat_id = $query['bevol_cat_id'];
 			$per_page = 20; 			
 			$target_url = GET_PRODUCTLIST_APIURL . 'p=1&category=' . $bevol_cat_id;
 			$productlist = json_decode(file_get_contents($target_url));
 			$product_total_count = $productlist->data->total;
 			$page_count = $product_total_count / $per_page;
 			for ($i = 1 ; $i <= $page_count ; $i ++) {
 				if ($i != 1) { 					
		 			$target_url = GET_PRODUCTLIST_APIURL . 'p=' . $i . '&category=' . $bevol_cat_id;
		 			$productlist = json_decode(@file_get_contents($target_url)); 					
 				}

 				if (isset($productlist->data->items) && (count($productlist->data->items) > 0)) {
 					$cur_pagedata = $productlist->data->items;
	 				foreach ($cur_pagedata as $key => $record) {
	 					$newproduct_pushdata = array();
	 					$newproduct_pushdata['pro_cat_id'] = $cat_id;
	 					// $newproduct_pushdata['pro_title'] = $record->title;
	 					$newproduct_pushdata['pro_title'] = preg_replace("/\s+/", "", $record->title);
	 					
	 					$newproduct_pushdata['pro_alias'] = $record->alias;
	 					$newproduct_pushdata['pro_remark'] = $record->remark;
	 					$newproduct_pushdata['pro_bevol_url'] = $record->mid . '.html';
	 					$newproduct_pushdata['update_datetime'] = $this->get_current_datetime();

	 					if (empty($record->image)) {
	 						$this->tb_insertorupdatedata('tbl_product' , array('pro_title' => $newproduct_pushdata['pro_title'] , 'pro_cat_id' => $cat_id) , $newproduct_pushdata); 						
	 					}
	 					else {
	 						$upload_productimage_name = $uploadpath_product . $record->image;
	 						if (@write_file($upload_productimage_name , file_get_contents($record->imageSrc))) {
		 						$newproduct_pushdata['pro_image'] = $upload_productimage_name;
	 							$this->tb_insertorupdatedata('tbl_product' , array('pro_title' => $newproduct_pushdata['pro_title'] , 'pro_cat_id' => $cat_id) , $newproduct_pushdata);
		 					}
	 					}
	 				}
 				}
 				else 
 					break;
 			}

 			$log_insert_data = array(
 				'pro_cat_id'	=> $query['cat_id'] , 
 				'log_datetime'	=> $this->get_current_datetime() , 
 				'scrap_type'	=> 'PROSCRAP'
 			);
 			$this->db->where($log_insert_data)->delete('tbl_scraplogs');
 			$this->db->insert('tbl_scraplogs' , $log_insert_data);
 		}
 		return array(
 			'success' => TRUE , 
 			'message'	=> '操作成功' , 
 			'log_datetime'	=> $this->get_current_datetime() , 
 		);
 	}

 	/*******
	***** Scrape Product's some details *****
 	********/
 	public function scrape_newcategoryproduct($cat_new_id , $uploadpath_product) {
 		$query = $this->db->select('cat_new_id , cat_new_name')
 			->from('tbl_category_new')
 			->where('cat_new_id' , $cat_new_id)
 			->get()
 			->row_array();
 		if (!empty($query['cat_new_name'])) {
 			$cat_new_id = $query['cat_new_id'];
 			$cat_new_name = $query['cat_new_name'];
 			$keywords = explode('/', $cat_new_name);
 			foreach ($keywords as $key => $keyword) {
	 			$per_page = 20; 			
	 			$target_url = GET_PRODUCTLIST_APIURL . 'p=1&keywords=' . urlencode($keyword);
	 			$productlist = json_decode(@file_get_contents($target_url));

	 			$product_total_count = $productlist->data->total;
	 			$page_count = $product_total_count / $per_page;

	 			for ($i = 1 ; $i <= $page_count ; $i ++) {
	 				if ($i != 1) { 					
	 					$target_url = GET_PRODUCTLIST_APIURL . 'p=' . $i . '&keywords=' . urlencode($keyword);
			 			$productlist = json_decode(@file_get_contents($target_url)); 					
	 				}

	 				if (isset($productlist->data->items) && (count($productlist->data->items) > 0)) {
	 					$cur_pagedata = $productlist->data->items;
		 				foreach ($cur_pagedata as $key => $record) {
		 					$newproduct_pushdata = array();
		 					$newproduct_pushdata['pro_cat_new_id'] = $cat_new_id;
		 					// $newproduct_pushdata['pro_title'] = $record->title;
	 						$newproduct_pushdata['pro_title'] = preg_replace("/\s+/", "", $record->title);
		 					$newproduct_pushdata['pro_alias'] = $record->alias;
		 					$newproduct_pushdata['pro_remark'] = $record->remark;
		 					$newproduct_pushdata['pro_bevol_url'] = $record->mid . '.html';
		 					$newproduct_pushdata['update_datetime'] = $this->get_current_datetime();

		 					$exist_product = $this->get_singletbdata('tbl_product' , array('pro_title' => $newproduct_pushdata['pro_title']));
		 					if (!empty($record->image)) {
		 						$upload_productimage_name = $uploadpath_product . $record->image;
		 						if (@write_file($upload_productimage_name , file_get_contents($record->imageSrc))) {
			 						$newproduct_pushdata['pro_image'] = $upload_productimage_name;
			 					}						
		 					}

		 					if (count($exist_product) > 0) {
		 						$pro_id = $exist_product[0]['pro_id'];
		 						$this->tb_updatedata('tbl_product' , array('pro_id' => $pro_id) , $newproduct_pushdata);
		 					}
		 					else {
		 						$this->tb_insertdata('tbl_product' , $newproduct_pushdata);
		 					}
		 				}
	 				}
	 				else {
	 					break;
	 				}
	 			}
 			}

 			$log_insert_data = array(
 				'pro_cat_id'	=> $query['cat_new_id'] , 
 				'log_datetime'	=> $this->get_current_datetime() , 
 				'scrap_type'	=> 'PROSCRAP' , 
 				'menu_kinds'	=> 2
 			);
 			$this->db->where($log_insert_data)->delete('tbl_scraplogs');
 			$this->db->insert('tbl_scraplogs' , $log_insert_data);
 		}
 		return array(
 			'success' => TRUE , 
 			'message'	=> '操作成功' , 
 			'log_datetime'	=> $this->get_current_datetime() , 
 		);
 	}

	function url_exists($url){
		if ((strpos($url, "http")) === false) $url = "http://" . $url;
		$headers = @get_headers($url);
		//print_r($headers);
		if (is_array($headers)){
			//Check for http error here....should add checks for other errors too...
			if(strpos($headers[0], '404 Not Found'))
			    return false;
			else
			    return true;    
		}         
		else
			return false;
	}

 	/*******
	***** Scrape Product's ingredients , ingredient's details , company data *****
 	********/
 	public function scrape_ingredient($product_whole_criteria , $start , $length , $result_index , $menu_kinds = 1){
 		$cat_id = $menu_kinds == 1 ? $product_whole_criteria['pro_cat_id'] : $product_whole_criteria['pro_cat_new_id'];
 		$productlist = $this->db->select('pro_id , pro_cat_id , pro_bevol_url , pro_ingredients')
 			->from('tbl_product')
 			->where($product_whole_criteria);
 		if ($menu_kinds == 1) {
 			$productlist = $productlist->order_by('pro_cat_id ASC , pro_title ASC');
 		}
 		else {
 			$productlist = $productlist->order_by('pro_cat_new_id ASC , pro_title ASC');
 		}

 		if ($start != -1 && $length != -1) {
 			$productlist = $productlist->limit($length , $start);
 		}
 		$productlist = $productlist->get()->result_array();

 		$ingredient_fetchlist = array();
 		$insertorupdate_ing_id = array();
 		$insertorupdated_ing_name = array();
 		if (count($productlist) > 0) {
	 		foreach ($productlist as $key => $record) {
	 			$pro_id = $record['pro_id'];
	 			if ($record['pro_bevol_url'] == '#' || count(explode('.', $record['pro_bevol_url'])) < 2) {
	 				continue;
	 			}
	 			$target_url = PRODUCTDETAIL_PAGE_URL . $record['pro_bevol_url'];
	 			if (!$this->url_exists($target_url)) {
	 				$this->tb_updatedata('tbl_product' , array('pro_id' => $record['pro_id']) , array('pro_ingredients' => ' '));
	 				continue;
	 			}
	 			$productdetail_html = @file_get_html($target_url);
	 			if ($productdetail_html) {
	 				$pro_company_id = -1;
			 		$company_data = array();
			 		$approval_dom = $productdetail_html->find('div[class=approval_box] p');
			 		foreach ($approval_dom as $key => $approval_item) {
			 			$buffer_approval_array = explode('：', $approval_item->innertext());
			 			if (count($buffer_approval_array) > 1) {
			 				switch ($buffer_approval_array[0]) {
			 					case COM_COUNTRY_LABEL:
			 						// $company_data['com_country'] = $buffer_approval_array[1];
	 								$company_data['com_country'] = preg_replace("/\s+/", "", $buffer_approval_array[1]);
			 						break;
			 					case COM_NAME_LABEL:
			 						// $company_data['com_name'] = $buffer_approval_array[1];
	 								$company_data['com_name'] = preg_replace("/\s+/", "", $buffer_approval_array[1]);
			 						break;
			 					case COM_NAME_ALIAS_LABEL:
			 						$company_data['com_alias'] = $buffer_approval_array[1];
			 						break;
			 				}
			 			}
			 		}

			 		if (!empty($company_data['com_name'])) {
						if ($this->tb_data_count('tbl_companys' , array('com_name' => $company_data['com_name'])) > 0) {
							$com_search_criteria = array(
								'com_name'	=> $company_data['com_name'] , 
								'com_country'	=> isset($company_data['com_country']) ? $company_data['com_country'] : ''
							);
							$pro_company_id = $this->tb_updatedata_getid('tbl_companys' , $com_search_criteria , $company_data , 'com_id');
						}
						else {
							$pro_company_id = $this->tb_insertdata('tbl_companys' , $company_data);	
							$pro_company_id = $pro_company_id['insert_id'];
						}	
			 		}

			 		$ingredient_name = $productdetail_html->find('div[class=cosmetics-info-title] table tbody tr td[class=td1] a');
			 		$ingredient_active = $productdetail_html->find('div[class=cosmetics-info-title] table tbody tr td[class=td3]');
			 		$ingredient_acne = $productdetail_html->find('div[class=cosmetics-info-title] table tbody tr td[class=td4]');
			 		$ing_usage_purpose = $productdetail_html->find('div[class=cosmetics-info-title] table tbody tr td[class=td5]');

			 		$product_ing_count = count($ingredient_name);
			 		$product_ingdata_list = array();
			 		for ($i = 0 ; $i < $product_ing_count ; $i ++) {
			 			$push_ingdata = array();
			 			// $push_ingdata['ing_name'] = $ingredient_name[$i]->innertext();
	 					$push_ingdata['ing_name'] = preg_replace("/\s+/", "", $ingredient_name[$i]->innertext());
			 			$push_ingdata['ing_bevol_url'] = $ingredient_name[$i]->href;
			 			$active_status = $ingredient_active[$i]->find('img');
			 			$push_ingdata['ing_active'] = count($active_status);
			 			$acne_status = $ingredient_acne[$i]->find('img');
			 			$push_ingdata['ing_acne_risk'] = count($acne_status);
			 			$push_ingdata['ing_usage_purpose'] = $ing_usage_purpose[$i]->innertext();

			 			$product_ingdata_list[] = $push_ingdata;
			 		}

	 				$rate_dom = $productdetail_html->find('div[class=cosmetics-info-title] div[class=xingji] img');
			 		$product_rate = 0;
			 		foreach ($rate_dom as $key => $xingji_star) {
			 			if (strpos($xingji_star->src , 'xiaostar.png') > 0) {
			 				$product_rate += 1;
			 			}
			 			else if (strpos($xingji_star->src , 'xiaobanstar.png') > 0) {
			 				$product_rate += 0.5;
			 			}
			 		}

	 				$anquanshuo_box = $productdetail_html->find('div[class=anquanshuo-box]');
	 				foreach ($anquanshuo_box as $key => $box) {
	 					$box_data_label = $box->getAttribute('data');
	 					switch ($box_data_label) {
	 						case FLAVOR_LABEL:
	 							$ing_name_list = $box->find('table tbody tr td[class=td1] a');
	 							foreach ($ing_name_list as $key => $ing_name) {
	 								$find = $ing_name->innertext();
	 								$search_index = $this->search_in_array($find , $product_ingdata_list , 'ing_name');
	 								if (isset($product_ingdata_list[$search_index])) {
	 									$product_ingdata_list[$search_index]['ing_flavor'] = 1;
	 								}
	 							}
	 							break;
	 						case PRESERVATIVE_LABEL:
	 							$ing_name_list = $box->find('table tbody tr td[class=td1] a');
	 							foreach ($ing_name_list as $key => $ing_name) {
	 								$find = $ing_name->innertext();
	 								$search_index = $this->search_in_array($find , $product_ingdata_list , 'ing_name');
	 								if (isset($product_ingdata_list[$search_index])) {
	 									$product_ingdata_list[$search_index]['ing_preservation'] = 1;
	 								}
	 							}
	 							break;
	 						case PREGANTCAUTION_LABEL:
	 							$ing_name_list = $box->find('table tbody tr td[class=td1] a');
	 							foreach ($ing_name_list as $key => $ing_name) {
	 								$find = $ing_name->innertext();
	 								$search_index = $this->search_in_array($find , $product_ingdata_list , 'ing_name');
	 								if (isset($product_ingdata_list[$search_index])) {
	 									$product_ingdata_list[$search_index]['ing_pregantcaution'] = 1;
	 								}
	 							}
	 							break;
	 						case MAINFUNCTION_LABEL:
	 							$ing_name_list = $box->find('table tbody tr td[class=td1] a');
	 							foreach ($ing_name_list as $key => $ing_name) {
	 								$find = $ing_name->innertext();
	 								$search_index = $this->search_in_array($find , $product_ingdata_list , 'ing_name');
	 								if (isset($product_ingdata_list[$search_index])) {
	 									$product_ingdata_list[$search_index]['pro_efficacy_ingredient'] = 1;
	 								}
	 							}
	 							break;
	 						case CLEANSING_LABEL:
	 							$ing_name_list = $box->find('table tbody tr td[class=td1] a');
	 							foreach ($ing_name_list as $key => $ing_name) {
	 								$find = $ing_name->innertext();
	 								$search_index = $this->search_in_array($find , $product_ingdata_list , 'ing_name');
	 								if (isset($product_ingdata_list[$search_index])) {
	 									$product_ingdata_list[$search_index]['ing_cleansing'] = 1;
	 								}
	 							}
	 							break;
	 						case AMINOACID_LABEL:
	 							$ing_name_list = $box->find('table tbody tr td[class=td1] a');
	 							foreach ($ing_name_list as $key => $ing_name) {
	 								$find = $ing_name->innertext();
	 								$search_index = $this->search_in_array($find , $product_ingdata_list , 'ing_name');
	 								if (isset($product_ingdata_list[$search_index])) {
	 									$product_ingdata_list[$search_index]['ing_aminoacid'] = 1;
	 								}
	 							}
	 							break;
	 						case SLS_SLES_LABEL:
	 							$ing_name_list = $box->find('table tbody tr td[class=td1] a');
	 							foreach ($ing_name_list as $key => $ing_name) {
	 								$find = $ing_name->innertext();
	 								$search_index = $this->search_in_array($find , $product_ingdata_list , 'ing_name');
	 								if (isset($product_ingdata_list[$search_index])) {
	 									$product_ingdata_list[$search_index]['ing_sls_sles'] = 1;
	 								}
	 							}
	 							break;
	 						
	 						default:
	 							# code...
	 							break;
	 					}
	 				}

	 				$pro_ingredients = '';
	 				$pro_efficacy_ingredient = '';
	 				if (count($product_ingdata_list) > 0) {
	 					$pro_ingredients = ',';
	 				}
	 				foreach ($product_ingdata_list as $key => $push_ingdata) {
	 					if (isset($push_ingdata['pro_efficacy_ingredient'])) {
	 						$is_pro_efficacy_ingredient = TRUE;
	 						unset($push_ingdata['pro_efficacy_ingredient']);
	 					} 					
	 					else{
	 						$is_pro_efficacy_ingredient = FALSE;
	 					}
						if ($this->tb_data_count('tbl_ingredient' , array('ing_name' => $push_ingdata['ing_name'])) > 0) {
							$ing_id = $this->tb_updatedata_getid('tbl_ingredient' , array('ing_name' => $push_ingdata['ing_name']) , $push_ingdata , 'ing_id');
						}
						else {
							$ing_id = $this->tb_insertdata('tbl_ingredient' , $push_ingdata);	
							$ing_id = $ing_id['insert_id'];
						}	

						if ($ing_id > 0) {
							$pro_ingredients .= $ing_id . ',';						
							$ingredient_fetchlist[] = array('ing_id' => $ing_id , 'ing_bevol_url' => $push_ingdata['ing_bevol_url']);
						}
						if ($ing_id > 0 && $is_pro_efficacy_ingredient) {
							$pro_efficacy_ingredient .= $ing_id . ',';			
						}
	 				}
	 				if ($pro_efficacy_ingredient != '') {
	 					$pro_efficacy_ingredient = ',' . $pro_efficacy_ingredient;
	 				}

	 				$product_update_data = array(
	 					'pro_rate' => $product_rate , 
	 					'pro_ingredients' => $pro_ingredients , 
	 					'pro_efficacy_ingredients' => $pro_efficacy_ingredient , 
	 				);
	 				if ($pro_company_id > 0) {
	 					$product_update_data['pro_company_id'] = $pro_company_id;
	 				}
			 		$this->tb_updatedata('tbl_product' , array('pro_id' => $record['pro_id']) , $product_update_data);
	 			}
	 		}
	 		foreach ($ingredient_fetchlist as $key => $record) {
	 			$ing_id = $record['ing_id'];
	 			$target_url = RESOURCE_PAGE_URL . $record['ing_bevol_url'];
	 			if ($record['ing_bevol_url'] == '#') {
	 				continue;
	 			}
	 			$update_data = array();
	 			$ingredientdetail_html = @file_get_html($target_url);
	 			if ($ingredientdetail_html) {
	 				$ptag_array = $ingredientdetail_html->find('div[class=component-info-title] p');
	 				foreach ($ptag_array as $key => $item) {
	 					$buffer = explode('：', $item->innertext());
	 					if (count($buffer) > 1) {
	 						$content = $buffer[count($buffer) - 1];
	 					}
	 					switch ($key) {
	 						case 0:
	 							$update_data['ing_alias'] = $content;
	 							break;
	 						case 1:
	 							$update_data['ing_remark'] = $content;
	 							break;
	 						case 2:
	 							$update_data['ing_csano'] = $content;
	 							break;
	 						case 4:
	 							$update_data['ing_security_risk'] = $content;
	 							break;
	 					}
	 				}
	 				$overview = $ingredientdetail_html->find('div[class=cosmetics-info-title] div[class=component-info-box] p');
	 				foreach ($overview as $key => $overview_item) {
	 					$update_data['ing_overview'] = $overview_item->innertext();
	 				}
	 				$this->tb_updatedata('tbl_ingredient' , array('ing_id' => $ing_id) , $update_data);
	 			}
	 		}
	 		$retVal = array(
	 			'success'	=> TRUE , 
	 			'message'	=> '操作成功' , 
				'log_datetime'	=> $this->get_current_datetime() , 
	 			'result_index'	=> $result_index , 
	 		);

 		}
 		else {
	 		$retVal = array(
	 			'success'	=> FALSE , 
	 			'message'	=> '没有产品。' , 
	 			'result_index'	=> $result_index
	 		); 			
 		}
		$log_insert_data = array(
			'pro_cat_id'	=> $cat_id , 
			'log_datetime'	=> $this->get_current_datetime() , 
			'scrap_type'	=> 'INGSCRAP'
		);
		if ($menu_kinds == 2) {
			$log_insert_data['menu_kinds'] = $menu_kinds;
		}
		$this->db->where($log_insert_data)->delete('tbl_scraplogs');
		$this->db->insert('tbl_scraplogs' , $log_insert_data);
		return $retVal;
 	}

 	public function scrapy_importedproduct_list($dataStartPageNum , $dataEndPageNum){
 		$scrapy_product_count = 0;
 		for ($i = $dataStartPageNum ; $i < $dataEndPageNum ; $i ++) {
			$cSession = curl_init(); 
			curl_setopt($cSession , CURLOPT_URL , INTERNATIONALSITEURL);
			curl_setopt($cSession , CURLOPT_POST , true);
			curl_setopt($cSession , CURLOPT_RETURNTRANSFER , true);
			curl_setopt($cSession , CURLOPT_HEADER , false); 
			$HTTP_HEADER_DATA = array(
				'Accept: application/json, text/javascript, */*; q=0.01' , 
				'Accept-Encoding: gzip, deflate' , 
				'Accept-Language: ko,en-US;q=0.9,en;q=0.8' , 
				'Connection: keep-alive' , 
				'Content-Type: application/x-www-form-urlencoded; charset=UTF-8' , 
				'Cookie: JSESSIONID=D51ADCAA09F995EA2E3D1E21542C7B2D' , 
				'Host: ' . IMPORTEDPRODUCT_HTTPHEADER_ORIGIN , 
				'Origin: http://' . IMPORTEDPRODUCT_HTTPHEADER_ORIGIN , 
				'Referer: ' . IMPORTEDPRODUCT_HTTPHEADER_REFERER , 
				'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36' , 
				'X-Requested-With: XMLHttpRequest' , 
			);
			curl_setopt($cSession , CURLOPT_HTTPHEADER , $HTTP_HEADER_DATA); 

			$post_data = array(
				'querytype' => 'productname' ,
				'pfid' => '' , 
				'content' => '' ,
				'dataPage' => $i ,
				'allPage' => '' ,
				'perPage' => '' ,
				'allRows' => '' ,
				'order' => '' ,
			);
			$post = ""; 
		    $amp = "&";                         
		    foreach($post_data as $key => $value) { 
		        $post .= $amp . $key . "=" . urlencode($value); 
		    } 
			curl_setopt($cSession , CURLOPT_POSTFIELDS , $post); 
			$result=curl_exec($cSession);
			curl_close($cSession);
			$data = json_decode($result);
			
			$product_list = $data->list;
			$newproduct_pushdata = array();
			$criteria = array();
			foreach ($product_list as $key => $record) {
	 			$criteria['pro_bevol_url LIKE '] = IMPORTEDPRODUCT_PROBEVOLURL_PREFIX . '%';
	 			$criteria['update_datetime >= '] = $record->updatepassdate;
				if ($this->tb_data_count('tbl_product' , $criteria) > 0) {
					return array(
			 			'success'	=> FALSE , 
			 			'scrapy_product_count'	=> $scrapy_product_count , 
			 			'dataStartPageNum'	=> $dataStartPageNum , 
			 			'dataEndPageNum'	=> $dataEndPageNum , 
					);
				}
	 			$newproduct_pushdata['pro_title'] = preg_replace("/\s+/", "", $record->productname);
				if ($this->tb_data_count('tbl_product' , $newproduct_pushdata) == 0) {
	 				$newproduct_pushdata['pro_bevol_url'] = IMPORTEDPRODUCT_PROBEVOLURL_PREFIX . '-' . $record->id;
	 				$newproduct_pushdata['update_datetime'] = $record->updatepassdate;
	 				$this->tb_insertdata('tbl_product' , $newproduct_pushdata);
	 				$scrapy_product_count ++;
				}
			}
 		}

 		$retVal = array(
 			'success'	=> TRUE , 
 			'scrapy_product_count'	=> $scrapy_product_count , 
 			'dataStartPageNum'	=> $dataStartPageNum , 
 			'dataEndPageNum'	=> $dataEndPageNum , 
 		);
 		return $retVal;
 	}

 	public function scrapy_importedproduct_detail($product_whole_criteria , $start , $length , $result_index){
 		$productlist = $this->db->select('pro_id , pro_bevol_url')
 			->from('tbl_product')
 			->where($product_whole_criteria)
 			->order_by('pro_title ASC');
 		if ($start != -1 && $length != -1) {
 			$productlist = $productlist->limit($length , $start);
 		}
 		$productlist = $productlist->get()->result_array();

 		$scrapy_product_count = 0;
 		if (count($productlist) > 0) {
 			foreach ($productlist as $key => $record) {
 				$site_id = explode('-' , $record['pro_bevol_url']);
 				if (count($site_id) > 1) {
 					$pro_id = $record['pro_id'];
 					$site_id = $site_id[1];
					$cSession = curl_init(); 
					curl_setopt($cSession , CURLOPT_URL , INTERNATIONALSITEURL_DETAIL);
					curl_setopt($cSession , CURLOPT_POST , true);
					curl_setopt($cSession , CURLOPT_RETURNTRANSFER , true);
					curl_setopt($cSession , CURLOPT_HEADER , false); 
					$HTTP_HEADER_DATA = array(
						'Accept: application/json, text/javascript, */*; q=0.01' , 
						'Accept-Encoding: gzip, deflate' , 
						'Accept-Language: ko,en-US;q=0.9,en;q=0.8' , 
						'Connection: keep-alive' , 
						'Content-Type: application/x-www-form-urlencoded; charset=UTF-8' , 
						'Cookie: JSESSIONID=D51ADCAA09F995EA2E3D1E21542C7B2D' , 
						'Host: ' . IMPORTEDPRODUCT_HTTPHEADER_ORIGIN , 
						'Origin: http://' . IMPORTEDPRODUCT_HTTPHEADER_ORIGIN , 
						'Referer: ' . IMPORTEDPRODUCT_HTTPHEADER_REFERER_DETAIL . $site_id , 
						'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36' , 
						'X-Requested-With: XMLHttpRequest' , 
					);
					curl_setopt($cSession , CURLOPT_HTTPHEADER , $HTTP_HEADER_DATA); 

					$post_data = array(
						'method' => 'show' ,
						'id' => $site_id , 
					);
					$post = ""; 
				    $amp = "&";                         
				    foreach($post_data as $key => $value) { 
				        $post .= $amp . $key . "=" . urlencode($value); 
				    } 
					curl_setopt($cSession , CURLOPT_POSTFIELDS , $post); 
					$result=curl_exec($cSession);
					curl_close($cSession);
					$data = json_decode($result);
					if (!empty($data)) {
						$update_product_data = array(
							'pro_alias'	=> $data->productnameen , 
							'pro_ingredients' => '' , 
						);

						$ingredients = explode(INTERNATIONALSITE_CFSTR_GLUE , preg_replace("/\s+/", "", $data->cf));
						$ingredients_arr = array();
						$ing_criteria = array();
						$ing_id = -1;
						foreach ($ingredients as $key => $ing_item) {
							$ing_criteria['ing_name'] = $ing_item;
							$ing_id = $this->getid_ifexist_notexistinsert('tbl_ingredient' , 'ing_id' , $ing_criteria , $ing_criteria);
							if ($ing_id > 0) {
								$ingredients_arr[] = $ing_id;
							}
							$ing_id = -1;
						}
						if (count($ingredients_arr) > 0) {
							$update_product_data['pro_ingredients'] = ',' . implode(',', $ingredients_arr) . ',';
						}

						$company_data = array(
							'com_name'	=> preg_replace("/\s+/", "", $data->enterprise) , 
							'com_country'	=> $data->Country , 
						);
						$company_id = $this->getid_ifexist_notexistinsert('tbl_companys' , 'com_id' , $company_data , $company_data);
						$update_product_data['pro_company_id'] = $company_id > 0 ? $company_id : '';

						if ($this->tb_updatedata('tbl_product' , array('pro_id' => $pro_id) , $update_product_data)) {
							$scrapy_product_count ++;
						}
					}
 				}
 			}
	 		$retVal = array(
	 			'success'	=> TRUE , 
	 			'result_index'	=> $result_index ,
	 			'scrapy_product_count'	=> $scrapy_product_count , 
	 		); 		
 		} 		
 		else {
	 		$retVal = array(
	 			'success'	=> FALSE , 
	 			'message'	=> '没有产品。' , 
	 			'result_index'	=> $result_index
	 		); 			
 		}

 		return $retVal;
 	}

 	public function scrapy_domesticproduct_list($dataStartPageNum , $dataEndPageNum){
 		$scrapy_product_count = 0;
 		$exist_product_count = 0;
 		$skip_product_count = 0;
		$newproduct_pushdata = array();
		$criteria = array();
 		for ($i = $dataStartPageNum ; $i < $dataEndPageNum ; $i ++) {
			$cSession = curl_init(); 
			curl_setopt($cSession , CURLOPT_URL , DOMESTICSITEURL);
			curl_setopt($cSession , CURLOPT_POST , true);
			curl_setopt($cSession , CURLOPT_RETURNTRANSFER , true);
			curl_setopt($cSession , CURLOPT_HEADER , false); 
			$HTTP_HEADER_DATA = array(
				'Accept: */*' , 
				'Accept-Encoding: gzip, deflate' , 
				'Accept-Language: ko,en-US;q=0.9,en;q=0.8' , 
				'Connection: keep-alive' , 
				'Content-Type: application/x-www-form-urlencoded; charset=UTF-8' , 
				'Cookie: JSESSIONID=D51ADCAA09F995EA2E3D1E21542C7B2D' , 
				'Host: ' . DOMESTICPRODUCT_HTTPHEADER_ORIGIN , 
				'Origin: http://' . DOMESTICPRODUCT_HTTPHEADER_ORIGIN , 
				'Referer: ' . DOMESTICPRODUCT_HTTPHEADER_REFERER , 
				'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36' , 
				'X-Requested-With: XMLHttpRequest' , 
			);
			curl_setopt($cSession , CURLOPT_HTTPHEADER , $HTTP_HEADER_DATA); 

			$post_data = array(
				'on' => 'true' ,
				'page' => $i , 
				'pageSize' => '15' ,
				'productName' => '' ,
				'conditionType' => '1' ,
				'applyname' => '' ,
				'applysn' => '' ,
			);
			$post = ""; 
		    $amp = "&";                         
		    foreach($post_data as $key => $value) { 
		        $post .= $amp . $key . "=" . urlencode($value); 
		    } 
			curl_setopt($cSession , CURLOPT_POSTFIELDS , $post); 
			$result = curl_exec($cSession);
			curl_close($cSession);
			$data = json_decode($result);
			
			if (!empty($data)) {
				$product_list = $data->list;
				// $newproduct_pushdata = array();
				$newproduct_pushdata['pro_title'] = '';
				$newproduct_pushdata['pro_bevol_url'] = '';
				$newproduct_pushdata['update_datetime'] = '';
				$criteria = array();
				foreach ($product_list as $key => $record) {
		 			$criteria['pro_bevol_url LIKE '] = DOMESTICPRODUCT_PROBEVOLURL_PREFIX . '%';
		 			$criteria['update_datetime >= '] = $record->provinceConfirm;
					if ($this->tb_data_count('tbl_product' , $criteria) > 0) {
						return array(
				 			'success'	=> FALSE , 
				 			'scrapy_product_count'	=> $scrapy_product_count , 
				 			'dataStartPageNum'	=> $dataStartPageNum , 
				 			'dataEndPageNum'	=> $dataEndPageNum , 
						);
					}
					if (empty($record->provinceConfirm)) {
						$skip_product_count ++;
						continue;
					}
					$criteria['pro_title'] = '';
		 			$criteria['pro_title'] = preg_replace("/\s+/", "", $record->productName);

					if ($this->tb_data_count('tbl_product' , $criteria) > 0) {
						$exist_product_count ++;
					}
					else {
		 				$newproduct_pushdata['pro_title'] = preg_replace("/\s+/", "", $record->productName);
		 				$newproduct_pushdata['pro_bevol_url'] = DOMESTICPRODUCT_PROBEVOLURL_PREFIX . '-' . $record->newProcessid;
		 				$newproduct_pushdata['update_datetime'] = $record->provinceConfirm;
		 				$this->tb_insertdata('tbl_product' , $newproduct_pushdata);
		 				$scrapy_product_count ++;
					}
				}
			}
 		}

 		$retVal = array(
 			'success'	=> TRUE , 
 			'scrapy_product_count'	=> $scrapy_product_count , 
 			'skip_product_count'	=> $skip_product_count , 
 			'exist_product_count'	=> $exist_product_count , 
 			'dataStartPageNum'	=> $dataStartPageNum , 
 			'dataEndPageNum'	=> $dataEndPageNum , 
 		);
 		return $retVal;
 	}

 	public function scrapy_domesticproduct_detail($product_whole_criteria , $start , $length , $result_index){
 		$productlist = $this->db->select('pro_id , pro_bevol_url')
 			->from('tbl_product')
 			->where($product_whole_criteria)
 			->order_by('pro_title ASC');
 		if ($start != -1 && $length != -1) {
 			$productlist = $productlist->limit($length , $start);
 		}
 		$productlist = $productlist->get()->result_array();

 		$scrapy_product_count = 0;
 		if (count($productlist) > 0) {
 			foreach ($productlist as $key => $record) {
 				$site_id = explode('-' , $record['pro_bevol_url']);
 				if (count($site_id) > 1) {
 					$pro_id = $record['pro_id'];
 					$site_id = $site_id[1];
					$cSession = curl_init(); 
					curl_setopt($cSession , CURLOPT_URL , DOMESTICSITEURL_DETAIL);
					curl_setopt($cSession , CURLOPT_POST , true);
					curl_setopt($cSession , CURLOPT_RETURNTRANSFER , true);
					curl_setopt($cSession , CURLOPT_HEADER , false); 
					$HTTP_HEADER_DATA = array(
						'Accept: application/json, text/javascript, */*; q=0.01' , 
						'Accept-Encoding: gzip, deflate' , 
						'Accept-Language: ko,en-US;q=0.9,en;q=0.8' , 
						'Connection: keep-alive' , 
						'Content-Type: application/x-www-form-urlencoded; charset=UTF-8' , 
						'Cookie: JSESSIONID=5DA45F90B1F766D20571A3DF35F33D8F; JSESSIONID=833D51928199AE5235AF62702F1F66A9' , 
						'Host: ' . DOMESTICPRODUCT_HTTPHEADER_ORIGIN , 
						'Origin: http://' . DOMESTICPRODUCT_HTTPHEADER_ORIGIN , 
						'Referer: ' . DOMESTICPRODUCT_HTTPHEADER_REFERER_DETAIL . '?processid=' . $site_id . '&nid=' . $site_id , 
						'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36' , 
						'X-Requested-With: XMLHttpRequest' , 
					);
					curl_setopt($cSession , CURLOPT_HTTPHEADER , $HTTP_HEADER_DATA); 

					$post_data = array(
						'processid' => $site_id , 
						'j_captcha' => 'null' ,
					);
					$post = ""; 
				    $amp = "&";                         
				    foreach($post_data as $key => $value) { 
				        $post .= $amp . $key . "=" . urlencode($value); 
				    } 
					curl_setopt($cSession , CURLOPT_POSTFIELDS , $post); 
					$result=curl_exec($cSession);
					curl_close($cSession);
					$data = json_decode($result);
					if (!empty($data)) {
						$update_product_data = array(
							'pro_ingredients' => '' , 
						);
						$ingredients_arr = array();
						if (isset($data->pfList)) {
							foreach ($data->pfList as $key => $ing_item) {
								$ing_criteria['ing_name'] = preg_replace("/\s+/", "", $ing_item->cname);
								$ing_id = $this->getid_ifexist_notexistinsert('tbl_ingredient' , 'ing_id' , $ing_criteria , $ing_criteria);
								if ($ing_id > 0) {
									$ingredients_arr[] = $ing_id;
								}
								$ing_id = -1;
							}
						}
						if (count($ingredients_arr) > 0) {
							$update_product_data['pro_ingredients'] = ',' . implode(',', $ingredients_arr) . ',';
						}
						if (isset($data->pfList)) {
							$company_data = array(
								'com_name'	=> preg_replace("/\s+/", "", $data->scqyUnitinfo->enterprise_name) , 
							);
							$company_id = $this->getid_ifexist_notexistinsert('tbl_companys' , 'com_id' , $company_data , $company_data);
							$update_product_data['pro_company_id'] = $company_id > 0 ? $company_id : '';
						}

						if ($this->tb_updatedata('tbl_product' , array('pro_id' => $pro_id) , $update_product_data)) {
							$scrapy_product_count ++;
						}
					}
 				}
 			}
	 		$retVal = array(
	 			'success'	=> TRUE , 
	 			'result_index'	=> $result_index ,
	 			'scrapy_product_count'	=> $scrapy_product_count , 
	 		); 		
 		} 		
 		else {
	 		$retVal = array(
	 			'success'	=> FALSE , 
	 			'message'	=> '没有产品。' , 
	 			'result_index'	=> $result_index
	 		); 			
 		}

 		return $retVal;
 	}

 	public function dailyscrap($categorylistindex = 0 , $uploadpath_product = '' , $scrap_step = 1 , $cat_new_id = -1 , $keyword = '' , $cur_endpagenum = 1) {
 		$scrapy_product_total_count = 0;
 		if ($scrap_step == 1) {
 			$retVal = array(
 				'success'	=> TRUE , 
 				'categorylist'	=> array()
 			);
 			$category_new = $this->get_singletbdata('tbl_category_new');
	 		foreach ($category_new as $key => $category) { 
	 			$cat_new_id = $category['cat_new_id'];
	 			$cat_new_name = $category['cat_new_name'];
	 			$keywords = explode('/', $cat_new_name);
	 			foreach ($keywords as $key => $keyword) {	 				
			 		$criteria = array(
			 			'cat_new_id'	=> $category['cat_new_id'] , 
			 			'cat_sub_keyword'	=> $keyword , 
			 		);
			 		if ($this->tb_data_count('tbl_scrap_endpagenums' , $criteria) == 0) {
			 			$this->tb_insertdata('tbl_scrap_endpagenums' , $criteria);
			 		}
			 		$retVal['categorylist'][] = $this->db->select('cat_new_id , cat_sub_keyword , end_page_number')->from('tbl_scrap_endpagenums')->where($criteria)->get()->row_array();
	 			}
	 		}
	 		return $retVal;
 		}
 		else if ($scrap_step == 2) {	
 			$retVal = array(
 				'success'	=> TRUE , 
 				'cat_new_id'	=> $cat_new_id , 
 				'scrapy_product_total_count'	=> $scrapy_product_total_count , 
 				'categorylistindex'	=> $categorylistindex
 			);

		 	$target_url = GET_PRODUCTLIST_APIURL . 'p=1&keywords=' . urlencode($keyword);
		 	$productlist = json_decode(@file_get_contents($target_url));
		 	$product_total_count = $productlist->data->total;
 			$per_page = 20; 		
		 	$page_count = $product_total_count / $per_page;

	 		$criteria = array(
	 			'cat_new_id'	=> $cat_new_id , 
	 			'cat_sub_keyword'	=> $keyword , 
	 		);
			 		
			if ($cur_endpagenum != 1) {
				$search_cat_end_page_num = $cur_endpagenum - 1;
			}
			else {
				$search_cat_end_page_num = $cur_endpagenum;
			}

			$update_data = array();
			$update_data['end_page_number'] = intval($page_count) + 1;

		 	for ($i = $search_cat_end_page_num ; $i <= $update_data['end_page_number'] ; $i ++) {
 				if ($i != $search_cat_end_page_num) { 					
 					$target_url = GET_PRODUCTLIST_APIURL . 'p=' . $i . '&keywords=' . urlencode($keyword);
		 			$productlist = json_decode(@file_get_contents($target_url)); 					
 				}	
 				if (isset($productlist->data->items) && (count($productlist->data->items) == 0)) {
	 				$update_data['end_page_number'] = $i;
	 				break;
 				}		 				
 				if (isset($productlist->data->items) && (count($productlist->data->items) > 0)) {
 					$cur_pagedata = $productlist->data->items;
	 				foreach ($cur_pagedata as $key => $record) {
	 					$newproduct_pushdata = array();
	 					$newproduct_pushdata['pro_cat_new_id'] = $cat_new_id;
 						$newproduct_pushdata['pro_title'] = preg_replace("/\s+/", "", $record->title);
	 					$newproduct_pushdata['pro_alias'] = $record->alias;
	 					$newproduct_pushdata['pro_remark'] = $record->remark;
	 					$newproduct_pushdata['pro_bevol_url'] = $record->mid . '.html';
	 					$newproduct_pushdata['update_datetime'] = $this->get_current_datetime();

	 					$exist_product = $this->get_singletbdata('tbl_product' , array('pro_title' => $newproduct_pushdata['pro_title']));
	 					if (!empty($record->image)) {
	 						$upload_productimage_name = $uploadpath_product . $record->image;
	 						if (@write_file($upload_productimage_name , file_get_contents($record->imageSrc))) {
		 						$newproduct_pushdata['pro_image'] = $upload_productimage_name;
		 					}						
	 					}

	 					if (count($exist_product) > 0) {
	 						$pro_id = $exist_product[0]['pro_id'];
	 						$this->tb_updatedata('tbl_product' , array('pro_id' => $pro_id) , $newproduct_pushdata);
	 					}
	 					else {
	 						$this->tb_insertdata('tbl_product' , $newproduct_pushdata);
	 						$scrapy_product_total_count ++;
	 					}
	 				}
 				}
 			}

 			$update_data = array_merge($criteria , $update_data);
 			if ($this->tb_data_count('tbl_scrap_endpagenums' , $criteria) > 0) {
 				$this->tb_updatedata('tbl_scrap_endpagenums' , $criteria , $update_data);
 			}
 			else {
 				$this->tb_insertdata('tbl_scrap_endpagenums' , $update_data);
 			}

			$start = -1;
			$length = -1;
			$result_index = 0;
	 		$product_whole_criteria = array(
	 			'pro_cat_new_id'	=> $cat_new_id , 
 				'pro_ingredients'	=> NULL , 
	 		);	

	 		$this->datascrapping->scrape_ingredient($product_whole_criteria , $start , $length , $result_index , 2);

 			$retVal['scrapy_product_total_count'] = $scrapy_product_total_count;
 			return $retVal;
 		}
 		else if ($scrap_step == 3) {
 			$retVal = array(
 				'success'	=> TRUE , 
 				'scrapy_product_total_count'	=> $scrapy_product_total_count
 			);
	 		$result = $this->scrapy_importedproduct_list(0 , 9999999);
	 		$scrapy_product_total_count += $result['scrapy_product_count'];

			$start = -1;
			$length = -1;
	 		$criteria = array(
				'pro_bevol_url LIKE'	=> IMPORTEDPRODUCT_PROBEVOLURL_PREFIX . '%' , 
				'pro_ingredients'		=> NULL
	 		);
			$this->scrapy_importedproduct_detail($criteria , $start , $length , 0);
			return $retVal;
 		}
 		else if ($scrap_step == 4) {
 			$retVal = array(
 				'success'	=> TRUE , 
 				'scrapy_product_total_count'	=> $scrapy_product_total_count
 			);
	 		$result = $this->scrapy_domesticproduct_list(0 , 9999999);
	 		$scrapy_product_total_count += $result['scrapy_product_count'];

			$start = -1;
			$length = -1;
	 		$criteria = array(
				'pro_bevol_url LIKE'	=> DOMESTICPRODUCT_PROBEVOLURL_PREFIX . '%' , 
				'pro_ingredients'		=> NULL
	 		);
			$this->datascrapping->scrapy_domesticproduct_detail($criteria , $start , $length , 0);

			return $retVal;
 		}
 	}

 	// public function complexscrap($uploadpath_product){
 	// 	$product_total_count = 0;
 	// 	$category_new = $this->get_singletbdata('tbl_category_new');
 	// 	// GET PRODUCT LIST (MEILISHUANG)
 	// 	foreach ($category_new as $key => $category) {
	 // 		if (!empty($category['cat_new_name'])) {
	 // 			$cat_new_id = $category['cat_new_id'];
	 // 			$cat_new_name = $category['cat_new_name'];
	 // 			$keywords = explode('/', $cat_new_name);
	 // 			foreach ($keywords as $key => $keyword) {
		//  			$per_page = 20; 			
		//  			$target_url = GET_PRODUCTLIST_APIURL . 'p=1&keywords=' . urlencode($keyword);
		//  			$productlist = json_decode(@file_get_contents($target_url));
		//  			$product_total_count = $productlist->data->total;
		//  			$page_count = $product_total_count / $per_page;

		// 	 		$criteria = array(
		// 	 			'cat_new_id'	=> $category['cat_new_id'] , 
		// 	 			'cat_sub_keyword'	=> $keyword , 
		// 	 		);
		// 	 		$search_cat_end_page_num = $this->db->select('end_page_number')->from('tbl_scrap_endpagenums')->where($criteria)->get()->row_array();
		// 	 		$search_cat_end_page_num = $search_cat_end_page_num['end_page_number'];
		// 	 		$update_data = array();
		// 	 		$update_data['end_page_number'] = intval($page_count) + 1;

		//  			for ($i = $search_cat_end_page_num ; $i <= $update_data['end_page_number'] ; $i ++) {
		//  				if ($i != $search_cat_end_page_num) { 					
		//  					$target_url = GET_PRODUCTLIST_APIURL . 'p=' . $i . '&keywords=' . urlencode($keyword);
		// 		 			$productlist = json_decode(@file_get_contents($target_url)); 					
		//  				}	
		//  				if (isset($productlist->data->items) && (count($productlist->data->items) == 0)) {
		// 	 				$update_data['end_page_number'] = $i;
		// 	 				break;
		//  				}		 				
		//  				if (isset($productlist->data->items) && (count($productlist->data->items) > 0)) {
		//  					$cur_pagedata = $productlist->data->items;
		// 	 				foreach ($cur_pagedata as $key => $record) {
		// 	 					$newproduct_pushdata = array();
		// 	 					$newproduct_pushdata['pro_cat_new_id'] = $cat_new_id;
		//  						$newproduct_pushdata['pro_title'] = preg_replace("/\s+/", "", $record->title);
		// 	 					$newproduct_pushdata['pro_alias'] = $record->alias;
		// 	 					$newproduct_pushdata['pro_remark'] = $record->remark;
		// 	 					$newproduct_pushdata['pro_bevol_url'] = $record->mid . '.html';
		// 	 					$newproduct_pushdata['update_datetime'] = $this->get_current_datetime();

		// 	 					$exist_product = $this->get_singletbdata('tbl_product' , array('pro_title' => $newproduct_pushdata['pro_title']));
		// 	 					if (!empty($record->image)) {
		// 	 						$upload_productimage_name = $uploadpath_product . $record->image;
		// 	 						if (@write_file($upload_productimage_name , file_get_contents($record->imageSrc))) {
		// 		 						$newproduct_pushdata['pro_image'] = $upload_productimage_name;
		// 		 					}						
		// 	 					}

		// 	 					if (count($exist_product) > 0) {
		// 	 						$pro_id = $exist_product[0]['pro_id'];
		// 	 						$this->tb_updatedata('tbl_product' , array('pro_id' => $pro_id) , $newproduct_pushdata);
		// 	 					}
		// 	 					else {
		// 	 						$this->tb_insertdata('tbl_product' , $newproduct_pushdata);
		// 	 						$product_total_count ++;
		// 	 					}
		// 	 				}
		//  				}
		//  			}

		//  			$update_data = array_merge($criteria , $update_data);
		//  			if ($this->tb_data_count('tbl_scrap_endpagenums' , $criteria) > 0) {
		//  				$this->tb_updatedata('tbl_scrap_endpagenums' , $criteria , $update_data);
		//  			}
		//  			else {
		//  				$this->tb_insertdata('tbl_scrap_endpagenums' , $update_data);
		//  			}
	 // 			}
	 // 		}
 	// 	}

 	// 	// GET PRODUCT ITEM DETAIL (MEILISHUANG)
 	// 	foreach ($category_new as $key => $category) {
		// 	$start = -1;
		// 	$length = -1;
		// 	$result_index = 0;
	 // 		$product_whole_criteria = array(
	 // 			'pro_cat_new_id'	=> $category['cat_new_id'] , 
 	// 			'pro_ingredients'	=> NULL , 
	 // 		);	

	 // 		$this->datascrapping->scrape_ingredient($product_whole_criteria , $start , $length , $result_index , 2);
 	// 	}

 	// 	$result = $this->scrapy_importedproduct_list(0 , 9999999);
 	// 	$product_total_count += $result['scrapy_product_count'];

		// $start = -1;
		// $length = -1;
 	// 	$criteria = array(
		// 	'pro_bevol_url LIKE'	=> IMPORTEDPRODUCT_PROBEVOLURL_PREFIX . '%' , 
		// 	'pro_ingredients'		=> NULL
 	// 	);
		// $this->scrapy_importedproduct_detail($criteria , $start , $length , 0);

 	// 	$result = $this->scrapy_domesticproduct_list(0 , 9999999);
 	// 	$product_total_count += $result['scrapy_product_count'];

		// $start = -1;
		// $length = -1;
 	// 	$criteria = array(
		// 	'pro_bevol_url LIKE'	=> DOMESTICPRODUCT_PROBEVOLURL_PREFIX . '%' , 
		// 	'pro_ingredients'		=> NULL
 	// 	);
		// $this->datascrapping->scrapy_domesticproduct_detail($criteria , $start , $length , 0);

		// return array(
		// 	'success'	=> TRUE , 
		// 	'product_total_count'	=> $product_total_count
		// );
 	// }

 	public function complexscrap($uploadpath_product) {
 		$scrap_step_1 = $this->dailyscrap();
 		$categorylist = $scrap_step_1['categorylist'];
 		foreach ($categorylist as $key => $category) {
 			$this->datascrapping->dailyscrap($key , $this->uploadpath_product , 2 , $category['cat_new_id'] , $category['cat_sub_keyword'] , $category['end_page_number']);
 		}

 		$this->datascrapping->dailyscrap(0 , $this->uploadpath_product , 3);
 		$this->datascrapping->dailyscrap(0 , $this->uploadpath_product , 4);
 	}
}