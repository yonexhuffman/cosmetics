<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . 'core/MY_UserController.php');

class Rating extends MY_UserController {
	private $page_key = 2;
	private $init_load_productcount = 50;
	private $order = '';
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Product_Model' , 'product');
		$this->order = 'pro_rating_point DESC , pro_id DESC';
	}

	public function index()	{	
		$this->header_data['page_key'] = $this->page_key;
		$this->header_data['plugin_css'] = array(
			'rateit/src/rateit.css' , 
		);

		$view_data = array();
		// $view_data['rating_menu'] = $this->config->item('ratingmenu');
		$view_data['product_category'] = $this->product->get_product_newcategory_sorted();
		$view_data['top_categories'] = $this->product->GetTopCategories();
		$rating_menu_index = 1;
		if ($this->input->get('pageindex') && ($this->input->get('pageindex') <= count($view_data['rating_menu']))) {
			$rating_menu_index = $this->input->get('pageindex');
		}
		$view_data['rating_menu_index'] = $rating_menu_index;

		$criteria = array();
		if ($this->input->get('category')) {
			$criteria['pro_cat_new_id'] = $this->input->get('category');
			$view_data['cat_id'] = $this->input->get('category');
			$view_data['sub_categories'] = $this->product
				->GetTopAndSubCategories($this->input->get('category'))['subCategories'];
			$view_data['top_id'] = $this->product
				->GetTopAndSubCategories($this->input->get('category'))['top_id'];
		}
		
		// footer data
		$footer_data = array();
		$footer_data['plugin_js'] = array(
			'rateit/src/jquery.rateit.js' , 
		);
		switch ($rating_menu_index) {
			case 1:	
				$view_data['product_list'] = $this->product->get_product_list($criteria , $this->order , array('length' => LOADDATAPERPAGE , 'start' => 0));
				$this->template->pageview('rating/rating_view' , 'rating_js' , $this->header_data , $view_data , $footer_data);
				break;
			case 2:
				$view_data['company_list'] = $this->product->get_companyrankinglist(array('length' => LOADDATAPERPAGE , 'start' => 0));
				$this->template->pageview('rating/ratingcompany_view' , 'ratingcompany_js' , $this->header_data , $view_data , $footer_data);
				break;
			case 3:
				$view_data['product_list'] = $this->product->get_product_list($criteria , 'update_datetime DESC , pro_id DESC , pro_title ASC' , array('length' => LOADDATAPERPAGE , 'start' => 0));
				$this->template->pageview('rating/rating_view' , 'rating_js' , $this->header_data , $view_data , $footer_data);
				break;			
			default:
				redirect('rating');
				break;
		}
	}

	public function loadMoreData(){
		if ($this->input->post()) {
			$post_data = $this->input->post();
			$criteria = array();
			if (!empty($post_data['cat_id'])) {
				$criteria['pro_cat_new_id'] = $post_data['cat_id'];
			}
			switch ($post_data['page_index']) {
				case 1:
					$data = $this->product->get_product_list($criteria , $this->order , array('length' => LOADDATAPERPAGE , 'start' => $post_data['page_offset_num']));
					break;
				case 2:
					$companydata = $this->product->get_companyrankinglist(array('length' => LOADDATAPERPAGE , 'start' => $post_data['page_offset_num']));
					break;
				case 3:
					$data = $this->product->get_product_list(array() , 'update_datetime DESC , pro_id DESC , pro_title ASC' , array('length' => LOADDATAPERPAGE , 'start' => $post_data['page_offset_num']));
					break;		
				
				default:
					$data = array();
					break;
			}
			$datacount = count($data);
			$page_offset_num = 0;
			$retHtml = '';
			if ($post_data['page_index'] == 1 || $post_data['page_index'] == 3) {
				$page_offset_num = $post_data['page_offset_num'] + count($data);
				$retHtml = '';
				$i = $post_data['page_offset_num'] + 1;
				for ($j = 0 ; $j < count($data) ; $j += 2) {
	                $retHtml .= '<div class="row"><div class="col-md-12">';
	                for($k = 0 ; $k < 2 ; $k ++) {
	                    $product = $data[$j + $k];

		                if (empty($product['pro_image']) || !file_exists($product['pro_image'])) {
		                    $pro_image = base_url(PRODUCTDEFAULTIMAGEURL);
		                }
		                else {                    
		                    $pro_image = base_url($product['pro_image']);
		                }
						$retHtml .= '
				            <li class="product_item col-md-6">
				                <a href="' . site_url('product/item?pro_id=' . $product['pro_id']) . '">
				                    <div class="raking_num pull-left"><p>
				                    ' . $i . '</p>
				                    </div>
				                    <div class="product_image pull-left">
				                        <img src="' . $pro_image . '" />
				                    </div>
				                    <div class="product_description pull-left">
				                        <p class="title">'. $product['pro_title'] .'</p>
				                        <p class="alias">'. $product['pro_alias'] .'</p>
				                        <div class="rateit" data-rateit-value="'. $product['pro_rate'] .'" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
				                    </div>
				                    <div class="clearfix"></div>
				                </a>
				            </li>
						';
						$i ++;	
					}
                	$retHtml .= '</div></div>';
				}
			}
			elseif ($post_data['page_index'] == 2) {
				$page_offset_num = $post_data['page_offset_num'] + count($companydata);
				$retHtml = '';
				$i = $post_data['page_offset_num'] + 1;
				for ($j = 0 ; $j < count($companydata) ; $j += 2) {
	                $retHtml .= '<div class="row"><div class="col-md-12">';
	                for($k = 0 ; $k < 2 ; $k ++) {
	                    $company = $companydata[$j + $k];
		                if (empty($company['com_image']) || !file_exists('./uploads/companyimages/' . $company['com_image'])) {
		                    $com_image = base_url(COMPANYDEFAULTIMAGEURL);
		                }
		                else {                    
		                    $com_image = base_url('./uploads/companyimages/' . $company['com_image']);
		                }
						$retHtml .= '
				            <li class="product_item col-md-6">
				                <a href="' . site_url('product?companyid=' . $company['com_id']) . '">
				                    <div class="raking_num pull-left">
				                    ' . $i . '
				                    </div>
				                    <div class="product_image pull-left">
				                        <img src="' . $com_image . '" style="height: 100px;" />
				                    </div>
				                    <div class="product_description pull-left">
				                        <p class="title">'. $company['com_name'] .'</p>
				                        <p class="title">'. $company['com_alias'] .'</p>
				                        <p class="title">'. $company['com_country'] .'</p>
				                    </div>
				                    <div class="clearfix"></div>
				                </a>
				            </li>
						';
						$i ++;
					}
                	$retHtml .= '</div></div>';
				}
			}

			echo json_encode(array('html' => $retHtml , 'page_offset_num' => $page_offset_num , 'datacount' => $datacount));
		}
	}

}
