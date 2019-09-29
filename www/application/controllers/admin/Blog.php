<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . 'core/MY_AdminController.php');

class Blog extends MY_AdminController {
	private $page_key = 5;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/Blog_Model' , 'blog');
	}

	public function index()	{		
		$this->header_data['page_key'] = $this->page_key;
		$this->header_data['plugin_css'] = array(
			'fancybox/source/jquery.fancybox.css' , 
			'datatables/plugins/bootstrap/dataTables.bootstrap.css' , 
		);
		$view_data = array();
		$view_data['category'] = $this->blog->get_singletbdata('tbl_category' , array() , '*' , 'cat_name ASC');

		// footer data
		$footer_data = array();
		$footer_data['plugin_js'] = array(
			'fancybox/source/jquery.fancybox.pack.js' ,
			'datatables/media/js/jquery.dataTables.min.js' , 
			'datatables/plugins/bootstrap/dataTables.bootstrap.js' , 
			'../scripts/datatable.js'
		);

		$this->template->pageview('blog/blog_view' , 'blog_js' , $this->header_data , $view_data , $footer_data , 'admin');
	}

	public function get_data(){
		$criteria = array();
		if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'filter') {
			if (!empty($_REQUEST['pro_title'])) {
				$criteria['pro.pro_title LIKE '] = '%' . $_REQUEST['pro_title'] . '%';
			}
			if (!empty($_REQUEST['pro_cat_id'])) {
				$criteria['pro.pro_cat_id'] = $_REQUEST['pro_cat_id'];
			}
			if (!empty($_REQUEST['min_pro_rate'])) {
				$criteria['pro.pro_rate >= '] = $_REQUEST['min_pro_rate'];
			}
			if (!empty($_REQUEST['max_pro_rate'])) {
				$criteria['pro.pro_rate <= '] = $_REQUEST['max_pro_rate'];
			}
		}

		$order = array();
		if ($_REQUEST['order']) {
			$order['field'] = $_REQUEST['columns'][$_REQUEST['order'][0]['column']]['name'];
			$order['direction'] = $_REQUEST['order'][0]['dir'];
		}
		$limit = array();
		$limit['start'] = $_REQUEST['start'];
		$limit['length'] = $_REQUEST['length'];

		$iTotalRecords = $this->blog->tb_data_count('tbl_product AS pro' , $criteria);
		$iDisplayLength = intval($_REQUEST['length']);
		$iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
		$iDisplayStart = intval($_REQUEST['start']);
		$sEcho = intval($_REQUEST['draw']);

		$products = $this->blog->get_blogs($criteria , $order , $limit);
		$records = array();
		$records["data"] = array(); 

		$end = $iDisplayStart + $iDisplayLength;
		$end = $end > $iTotalRecords ? $iTotalRecords : $end;

		$i = $iDisplayStart;
		foreach ($products as $key => $item) {
			$id = ($i + 1);
			if (empty($item['pro_image']) || !$this->blog->file_exist($item['pro_image'])) {
				$image_url = base_url(PRODUCTDEFAULTIMAGEURL);
			}
			else {
				$image_url = base_url($item['pro_image']);
			}
			$records["data"][] = array(
				$id,
				'<a class="fancybox-button" title="' . $item['pro_title'] . '" data-rel="fancybox-button" href="' . $image_url . '"><img src="' . $image_url . '" width="80" height="80"></a>' , 
				$item['pro_title'],
				$item['cat_name'],
				$item['pro_rate'],
				$item['blog_count'] != '' ? $item['blog_count'] : 0 ,
				'<a href="'. site_url('admin/blog/detail?pro_id=' . $item['pro_id']) .'" class="btn btn-sm btn-success"  ><i class="fa fa-folder-open"></i></a>',
			);
			$i ++;
		}

		$records["draw"] = $sEcho;
		$records["recordsTotal"] = $iTotalRecords;
		$records["recordsFiltered"] = $iTotalRecords;

		echo json_encode($records);
	}

	public function detail(){
		if ($this->input->get('pro_id') && $this->input->get('pro_id') > 0) {		
			$this->header_data['page_key'] = $this->page_key;
			$this->header_data['plugin_css'] = array(
				'rateit/src/rateit.css' , 
			);
			$view_data = array();
			$view_data['pro_id'] = $this->input->get('pro_id');
			$view_data['product_data'] = $this->blog->get_product_data($view_data['pro_id']);
			$view_data['avatar_upload_path'] = $this->uploadpath_avatar_image;
			$view_data['blog_list'] = $this->blog->getMoreData($view_data['pro_id'] , 0 , $this->uploadpath_avatar_image , $this->uploadpath_blog_image);
			// footer data
			$footer_data = array();
			$footer_data['plugin_js'] = array(
				'jquery-validation/js/jquery.validate.min.js' , 
				'rateit/src/jquery.rateit.js' , 
			);

			$this->template->pageview('blog/blogdetail_view' , 'blogdetail_js' , $this->header_data , $view_data , $footer_data , 'admin');
		}
		else {	
			redirect('admin/blog');
		}
	}

	public function loadMoreData(){
		if ($this->input->post()) {
			$post_data = $this->input->post();
			$retVal = $this->blog->loadMoreData($post_data['pro_id'] , $post_data['blog_last_id'] , $this->uploadpath_avatar_image , $this->uploadpath_blog_image);
			echo json_encode($retVal);
		}
	}

	public function delete(){
		if ($this->input->post('b_id')) {
			$b_id = $this->input->post('b_id');
			echo json_encode(array('success' => $this->blog->deleteBlog($b_id , $this->uploadpath_blog_image)));			
			// $result = $this->blog->tb_deletedata('tbl_blog' , array('b_id' => $this->input->post('b_id')));
			// $oResult = $this->blog->tb_deletedata('tbl_blog' , array('b_comment_parent_id' => $this->input->post('b_id')));
			// echo json_encode(array('success' => ($result && $oResult)));
		}
	}

	public function update(){
		if ($this->input->post()) {
			$post_data = $this->input->post();
			$b_id = $post_data['b_id'];
			$update_data = array(
				// 'b_title'	=> $post_data['b_title'] , 
				'b_content'	=> nl2br($post_data['b_content'], FALSE) , 
			);
			if (isset($post_data['b_user_rate'])) {
				$update_data['b_user_rate'] = $post_data['b_user_rate'];
			}
			$update_status = $this->blog->tb_updatedata('tbl_blog' , array('b_id' => $b_id) , $update_data);
			if ($update_status) {
				$get_pro_id = $this->db->select('b_pro_id')
					->from('tbl_blog')
					->where('b_id' , $b_id)
					->get()
					->row_array();
				$pro_id = isset($get_pro_id['b_pro_id']) ? $get_pro_id['b_pro_id'] : 0;
				if ($pro_id > 0) {
					$average_rate = $this->db->select('SUM(b_user_rate) / COUNT(b_pro_id) AS average_rate , b_pro_id')
						->from('tbl_blog')
						->where('b_pro_id' , $pro_id)
						->get()
						->row_array();

					if (isset($average_rate['average_rate'])) {
						$this->blog->tb_updatedata('tbl_product' , array('pro_id' => $average_rate['b_pro_id']) , array('pro_rating_point' => $average_rate['average_rate']));
					}
				}
			}
			echo json_encode(array('success' => $update_status));
		}
	}

}
