<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . 'core/MY_AdminController.php');

class Blogingredient extends MY_AdminController {
	private $page_key = 16;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/Blogingredient_Model' , 'blog');
	}

	public function index()	{		
		$this->header_data['page_key'] = $this->page_key;
		$this->header_data['plugin_css'] = array(
			'datatables/plugins/bootstrap/dataTables.bootstrap.css' , 
		);
		$view_data = array();
		// $view_data['category'] = $this->blog->get_singletbdata('tbl_category' , array() , '*' , 'cat_name ASC');

		// footer data
		$footer_data = array();
		$footer_data['plugin_js'] = array(
			'datatables/media/js/jquery.dataTables.min.js' , 
			'datatables/plugins/bootstrap/dataTables.bootstrap.js' , 
			'../scripts/datatable.js'
		);

		$this->template->pageview('blogingredient/blogingredient_view' , 'blogingredient_js' , $this->header_data , $view_data , $footer_data , 'admin');
	}

	public function get_data(){
		$criteria = array();
		if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'filter') {
			if (!empty($_REQUEST['ing_name'])) {
				$criteria['ing.ing_name LIKE '] = '%' . $_REQUEST['ing_name'] . '%';
			}
			if (!empty($_REQUEST['ing_csano'])) {
				$criteria['ing.ing_csano LIKE '] = '%' . $_REQUEST['ing_csano'] . '%';
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

		$iTotalRecords = $this->blog->tb_data_count('tbl_ingredient AS ing' , $criteria);
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
			$records["data"][] = array(
				$id,
				$item['ing_name'],
				$item['ing_csano'],
				$item['blog_count'] != '' ? $item['blog_count'] : 0 ,
				'<a href="'. site_url('admin/blogingredient/detail?ing_id=' . $item['ing_id']) .'" class="btn btn-sm btn-success"  ><i class="fa fa-folder-open"></i></a>',
			);
			$i ++;
		}

		$records["draw"] = $sEcho;
		$records["recordsTotal"] = $iTotalRecords;
		$records["recordsFiltered"] = $iTotalRecords;

		echo json_encode($records);
	}

	public function detail(){
		if ($this->input->get('ing_id') && $this->input->get('ing_id') > 0) {		
			$this->header_data['page_key'] = $this->page_key;
			$this->header_data['plugin_css'] = array(
				'rateit/src/rateit.css' , 
			);
			$view_data = array();
			$view_data['ing_id'] = $this->input->get('ing_id');
			$view_data['ingredient_data'] = $this->blog->get_ingredient_data($view_data['ing_id']);
			$view_data['avatar_upload_path'] = $this->uploadpath_avatar_image;
			$view_data['blog_list'] = $this->blog->getMoreData($view_data['ing_id'] , 0 , $this->uploadpath_avatar_image , $this->uploadpath_blog_image);
			// footer data
			$footer_data = array();
			$footer_data['plugin_js'] = array(
				'jquery-validation/js/jquery.validate.min.js' , 
				'rateit/src/jquery.rateit.js' , 
			);

			$this->template->pageview('blogingredient/blogingredientdetail_view' , 'blogingredientdetail_js' , $this->header_data , $view_data , $footer_data , 'admin');
		}
		else {	
			redirect('admin/blog');
		}
	}

	public function loadMoreData(){
		if ($this->input->post()) {
			$post_data = $this->input->post();
			$retVal = $this->blog->loadMoreData($post_data['ing_id'] , $post_data['blog_last_id'] , $this->uploadpath_avatar_image , $this->uploadpath_blog_image);
			echo json_encode($retVal);
		}
	}

	public function delete(){
		if ($this->input->post('b_id')) {
			$b_id = $this->input->post('b_id');
			echo json_encode(array('success' => $this->blog->deleteBlogingredient($b_id , $this->uploadpath_blog_image)));		
			// $result = $this->blog->tb_deletedata('tbl_blog_ingredient' , array('b_id' => $this->input->post('b_id')));
			// $oResult = $this->blog->tb_deletedata('tbl_blog_ingredient' , array('b_comment_parent_id' => $this->input->post('b_id')));
			// echo json_encode(array('success' => ($result && $oResult)));
		}
	}

	public function update(){
		if ($this->input->post()) {
			$post_data = $this->input->post();
			$b_id = $post_data['b_id'];
			$update_data = array(
				'b_content'	=> nl2br($post_data['b_content'], FALSE) , 
			);
			if (isset($post_data['b_user_rate'])) {
				$update_data['b_user_rate'] = $post_data['b_user_rate'];
			}
			$update_status = $this->blog->tb_updatedata('tbl_blog_ingredient' , array('b_id' => $b_id) , $update_data);
			if ($update_status) {
				$get_ing_id = $this->db->select('b_ing_id')
					->from('tbl_blog_ingredient')
					->where('b_id' , $b_id)
					->get()
					->row_array();
				$ing_id = isset($get_ing_id['b_ing_id']) ? $get_ing_id['b_ing_id'] : 0;
				// if ($ing_id > 0) {
				// 	$average_rate = $this->db->select('SUM(b_user_rate) / COUNT(b_ing_id) AS average_rate , b_ing_id')
				// 		->from('tbl_blog_ingredient')
				// 		->where('b_ing_id' , $ing_id)
				// 		->get()
				// 		->row_array();

				// 	if (isset($average_rate['average_rate'])) {
				// 		$this->blog->tb_updatedata('tbl_product' , array('ing_id' => $average_rate['b_ing_id']) , array('pro_rating_point' => $average_rate['average_rate']));
				// 	}
				// }
			}
			echo json_encode(array('success' => $update_status));
		}
	}

}
