<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . 'core/MY_UserController.php');

class Product extends MY_UserController {
	private $page_key = 3;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Product_Model' , 'product');
	}

	public function index()	{	
		$this->header_data['page_key'] = $this->page_key;
		$this->header_data['plugin_css'] = array(
			'rateit/src/rateit.css' , 
		);

		$view_data = array();
		$criteria = array();
		$order = 'pro_image DESC , pro_rate DESC , pro_id DESC , pro_title ASC';
		$limit = array(
			'length' => LOADDATAPERPAGE , 
			'start' => 0
		);
		if ($this->input->get('per_page')) {
			$limit['start'] = $this->input->get('per_page');
		}
		// $condition = array();
		if ($this->input->get('category')) {
			$criteria['pro_cat_new_id'] = $this->input->get('category');
			$view_data['cat_id'] = $this->input->get('category');
			$view_data['sub_categories'] = $this->product
				->GetTopAndSubCategories($this->input->get('category'))['subCategories'];
			$view_data['top_id'] = $this->product
				->GetTopAndSubCategories($this->input->get('category'))['top_id'];
			// $condition[] = 'category=' . $view_data['cat_id'];
		}
		if ($this->input->get('ingredient')) {
			$criteria['pro_ingredients LIKE '] = '%,' . $this->input->get('ingredient') . ',%';
			$view_data['ingredient'] = $this->input->get('ingredient');
			// $condition[] = 'ingredient=' . $this->input->get('ingredient');
			// $order = 'pro_title ASC';
		}
		if ($this->input->get('keyword')) {
			$view_data['keyword'] = $this->input->get('keyword');
			$criteria['pro_title LIKE'] = '%' . $this->input->get('keyword') . '%';
			// $condition[] = 'keyword=' . $this->input->get('keyword');
		}
		if ($this->input->get('companyid')) {
			$criteria['pro_company_id'] = $this->input->get('companyid');
			$view_data['companyid'] = $this->input->get('companyid');
			// $condition[] = 'companyid=' . $this->input->get('companyid');
		}

		// $conditionalurl = '';
		// if (count($condition) > 0) {
		// 	$conditionalurl .= '?' . implode('&' , $condition);
		// }
		// $this->load->library('pagination');
		// $config['base_url'] = site_url('product');		
		// $config['base_url'] = site_url('product' . $conditionalurl);
		$view_data['product_total_count'] = $this->product->tb_data_count('tbl_product' , $criteria);

		// $config['full_tag_open'] = '<ul class="pagination">';
		// $config['full_tag_close'] = '</ul>';
		// $config['first_tag_open'] = '<li class="no_num_link">';
		// $config['first_tag_close'] = '</li>';
		// $config['first_link'] = '<i class="fa fa-arrow-left"></i>';
		// $config['last_tag_open'] = '<li class="no_num_link">';
		// $config['last_tag_close'] = '</li>';
		// $config['last_link'] = '<i class="fa fa-arrow-right"></i>';
		// $config['prev_tag_open'] = '<li class="no_num_link">';
		// $config['prev_tag_close'] = '</li>';
		// $config['next_tag_open'] = '<li class="no_num_link">';
		// $config['next_tag_close'] = '</li>';
		// $config['num_tag_open'] = '<li>';
		// $config['num_tag_close'] = '</li>';
		// $config['cur_tag_open'] = '<li><span>';
		// $config['cur_tag_close'] = '</span></li>';
		// $config['next_link'] = '<i class="fa fa-chevron-right"></i>';
		// $config['prev_link'] = '<i class="fa fa-chevron-left"></i>';
		// $config['total_rows'] = $view_data['product_total_count'];
		// $config['per_page'] = LOADDATAPERPAGE;
		// $config['page_query_string'] = TRUE;
		// $config['page_num_links'] = 1;

		// $this->pagination->initialize($config);

		// $view_data['page_links'] = $this->pagination->create_links();
		$view_data['product_list'] = $this->product->get_product_list($criteria , $order , $limit);
		// $view_data['product_category'] = $this->product->get_singletbdata('tbl_category' , array() , '*');
		$view_data['product_category'] = $this->product->get_product_newcategory_sorted();
		$view_data['top_categories'] = $this->product->GetTopCategories();
		
		// footer data
		$footer_data = array();
		$footer_data['plugin_js'] = array(
			'bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js' , 
			'rateit/src/jquery.rateit.js' , 
		);

		$this->template->pageview('product/product_view' , 'product_js' , $this->header_data , $view_data , $footer_data);
	}

	public function loadMoreData(){
		$post_data = $this->input->get();
		$criteria = array();
		$order = 'pro_image DESC , pro_rate DESC , pro_id DESC , pro_title ASC';
		$limit = array(
			'length' => LOADDATAPERPAGE , 
			'start' => $post_data['page_offset_num']
		);

		$condition = array();
		if (!empty($post_data['cat_id'])) {
			$criteria['pro_cat_new_id'] = $post_data['cat_id'];
		}
		if (!empty($post_data['ingredient'])) {
			$criteria['pro_ingredients LIKE '] = '%,' . $post_data['ingredient'] . ',%';
		}
		if (!empty($post_data['keyword'])) {
			$criteria['pro_title LIKE'] = '%' . $post_data['keyword'] . '%';
		}
		if (!empty($post_data['companyid'])) {
			$criteria['pro_company_id'] = $post_data['companyid'];
		}

		$data = $this->product->get_product_list($criteria , $order , $limit);

		$datacount = count($data);
		$page_offset_num = $post_data['page_offset_num'] + count($data);
		$retHtml = '';
		$i = $post_data['page_offset_num'] + 1;
		for ($j = 0 ; $j < count($data) ; $j += 2) {
            $retHtml .= '<div class="row"><div class="col-md-12">';
            for($k = 0 ; $k < 2 ; $k ++) {
            	if (!isset($data[$j + $k])) {
            		break;
            	}
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
		$retVal = array(
			'datacount'	=> $datacount , 
			'page_offset_num'	=> $page_offset_num , 
			'html'	=> $retHtml
		);
		echo json_encode($retVal);
	}

	public function item(){
		if ($this->input->get('pro_id')) {
			$pro_id = $this->input->get('pro_id');
			$this->header_data['page_key'] = $this->page_key;
			$this->header_data['plugin_css'] = array(
				'rateit/src/rateit.css' , 
				'jquery-file-upload/css/jquery.fileupload.css' , 
				'fancybox/source/jquery.fancybox.css' , 
			);

			$view_data = array();
			$view_data['pro_id'] = $pro_id;
			$view_data['product'] = $this->product->get_product_item($pro_id);
			if (empty($view_data['product'])) {
				redirect('product');
			}
			$view_data['product_sellers'] = $this->product->get_product_sellers($pro_id);
			$view_data['shoppingcatimage_path'] = $this->uploadpath_shoppingcategory_image;
			$login_info = $this->get_loggedin_userdata();
			if (empty($login_info)) {
				$view_data['login_status'] = FALSE;
			}
			else {
				$view_data['login_status'] = TRUE;
			}
			
			if ($this->session->has_userdata('POST_RESULT_ALARM_MESSAGE')) {
				$view_data['post_result_alarm_message'] = $this->session->userdata('POST_RESULT_ALARM_MESSAGE');
				$this->session->unset_userdata('POST_RESULT_ALARM_MESSAGE');
			}
			// footer data
			$footer_data = array();
			$footer_data['plugin_js'] = array(
				'rateit/src/jquery.rateit.js' , 
				'fancybox/source/jquery.fancybox.pack.js' , 
			);

			$this->template->pageview('product/productitem_view' , 'productitem_js' , $this->header_data , $view_data , $footer_data);
		}
		else {
			redirect('product');
		}
	}

	public function loadBlogMoreData(){
		if ($this->input->post()) {
			$post_data = $this->input->post();
        	$login_info = $this->get_loggedin_userdata();
        	if (!empty($login_info)) {
        		$login_status = TRUE;
        	}
        	else {
        		$login_status = FALSE;
        	}
			$retVal = $this->product->loadBlogMoreData($post_data['pro_id'] , $post_data['blog_last_id'] , $login_status , $this->uploadpath_avatar_image);
			echo json_encode($retVal);
		}
	}

	public function leavecomment(){
		$b_id = $this->input->get('b_id');
		$pro_id = $this->input->get('pro_id');
		$this->load->view('product/leavecomment_view' , array('b_id' => $b_id , 'pro_id' => $pro_id));
	}

	public function savecomment(){
		$login_info = $this->get_loggedin_userdata();
		if (!empty($login_info)) {
			$post_data = $this->input->post();
			$acc_id = $login_info['acc_id'];
			$insert_data = array(
				'b_pro_id'	=> $post_data['pro_id'] , 
				// 'b_title'	=> $post_data['b_title'] , 
				'b_acc_id'	=> $acc_id , 
				'b_comment_parent_id'	=> $post_data['b_id'] , 
				// 'b_user_rate'	=> $post_data['b_user_rate'] , 
			);
			if (isset($post_data['b_user_rate'])) {
				$insert_data['b_user_rate'] = $post_data['b_user_rate'];
			}
            $upload_image_name = random_string('alnum', 16);
	        $upload_result = $this->product->file_upload($this->uploadpath_blog_image , 'comment_image' , $upload_image_name);
	        $uploaded_filename = '';
	        if ($upload_result['success']) {
	        	$insert_data['b_image'] = $upload_result['file_name'];	        	
	        }	
	        $insert_data['b_content'] = nl2br($post_data['b_content'], FALSE);
	        
			$insert_status = $this->product->tb_insertdata('tbl_blog' , $insert_data);
			$this->session->set_userdata('POST_RESULT_ALARM_MESSAGE' , $insert_status);
				
			redirect('product/item?pro_id=' . $post_data['pro_id']);
		}
	}

	public function leaveblog(){
		$pro_id = $this->input->get('pro_id');
		$tags = $this->product->get_singletbdata('tbl_blog_tags' , array() , 'tag_name' , 'tag_name ASC');
		$tags_array = array();
		foreach ($tags as $key => $item) {
			$tags_array[] = $item['tag_name'];
		}
		$this->load->view('product/leaveblog_view' , array('pro_id' => $pro_id , 'tags' => $tags_array));
	}

	public function saveblog(){
		$login_info = $this->get_loggedin_userdata();
		if (!empty($login_info)) {
			$post_data = $this->input->post();
			$tag_content = '';
			if (!empty($post_data['tags'])) {
				$tag_content = '<ul><li>' . implode('</li><li>', $post_data['tags']) . '</li></ul>';
			}
			$acc_id = $login_info['acc_id'];
			$insert_data = array(
				'b_pro_id'	=> $post_data['pro_id'] , 
				'b_title'	=> $post_data['b_title'] , 
				'b_tags'	=> $tag_content , 
				'b_acc_id'	=> $acc_id , 
				'b_user_rate'	=> $post_data['b_user_rate'] , 
			);

            $upload_image_name = random_string('alnum', 16);
	        $upload_result = $this->product->file_upload($this->uploadpath_blog_image , 'comment_image' , $upload_image_name);
	        $uploaded_filename = '';
	        if ($upload_result['success']) {
	        	$insert_data['b_image'] = $upload_result['file_name'];	   
	        }	
	        $insert_data['b_content'] = nl2br($post_data['b_content'], FALSE);

			$insert_status = $this->product->tb_insertdata('tbl_blog' , $insert_data);
			if ($insert_status['success']) {
				$average_rate = $this->db->select('SUM(b_user_rate) / COUNT(b_pro_id) AS average_rate')
					->from('tbl_blog')
					->where('b_pro_id' , $post_data['pro_id'])
					->get()
					->row_array();
				if (isset($average_rate['average_rate'])) {
					$this->product->tb_updatedata('tbl_product' , array('pro_id' => $post_data['pro_id']) , array('pro_rating_point' => $average_rate['average_rate']));
				}
			}
			$this->session->set_userdata('POST_RESULT_ALARM_MESSAGE' , $insert_status);
			
			redirect('product/item?pro_id=' . $post_data['pro_id']);
		}
	}

	public function addToFavorite(){
		if ($this->input->post('pro_id')) {
			$user_data = $this->get_loggedin_userdata();
			if (!empty($user_data)) {
				$acc_id = $user_data['acc_id'];
				$pro_id = $this->input->post('pro_id');
				echo json_encode(array('success' => $this->product->addToFavorite($pro_id , $acc_id)));
			}
		}
	}

	public function increaseShopVisitCount(){
		$seller_id = $_REQUEST['seller_id'];
		if ($seller_id > 0) {
			$query = 'UPDATE tbl_product_sellers SET visit_count = visit_count + 1 WHERE seller_id = ' . $seller_id;
			$res = $this->db->query($query);
		}		
	}
}