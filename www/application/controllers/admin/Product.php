<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . 'core/MY_AdminController.php');

class Product extends MY_AdminController {
	private $page_key = 3;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/Product_Model' , 'product');
	}

	public function index()	{		
		$this->header_data['page_key'] = $this->page_key;
		$this->header_data['plugin_css'] = array(
			'datatables/plugins/bootstrap/dataTables.bootstrap.css' , 
			'fancybox/source/jquery.fancybox.css' , 
		);
		$view_data = array();
		$view_data['category'] = $this->product->get_product_newcategory_sorted();

		// footer data
		$footer_data = array();
		$footer_data['plugin_js'] = array(
			'jquery-validation/js/jquery.validate.min.js' , 
			'fancybox/source/jquery.fancybox.pack.js' ,
			'datatables/media/js/jquery.dataTables.min.js' , 
			'datatables/plugins/bootstrap/dataTables.bootstrap.js' , 
			'../scripts/datatable.js'
		);

		$this->template->pageview('product/product_view' , 'product_js' , $this->header_data , $view_data , $footer_data , 'admin');
	}

	public function get_data(){
		$criteria = array();
		if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'filter') {
			if (!empty($_REQUEST['pro_title'])) {
				$criteria['tbl_product.pro_title LIKE '] = '%' . $_REQUEST['pro_title'] . '%';
			}
			if (!empty($_REQUEST['pro_cat_new_id'])) {
				$criteria['tbl_product.pro_cat_new_id'] = $_REQUEST['pro_cat_new_id'];
			}
			if (!empty($_REQUEST['min_pro_rate'])) {
				$criteria['tbl_product.pro_rate >= '] = $_REQUEST['min_pro_rate'];
			}
			if (!empty($_REQUEST['max_pro_rate'])) {
				$criteria['tbl_product.pro_rate <= '] = $_REQUEST['max_pro_rate'];
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

		$iTotalRecords = $this->product->tb_data_count('tbl_product' , $criteria);
		$iDisplayLength = intval($_REQUEST['length']);
		$iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
		$iDisplayStart = intval($_REQUEST['start']);
		$sEcho = intval($_REQUEST['draw']);

		$products = $this->product->get_products($criteria , $order , $limit);
		$records = array();
		$records["data"] = array(); 

		$end = $iDisplayStart + $iDisplayLength;
		$end = $end > $iTotalRecords ? $iTotalRecords : $end;

		$i = $iDisplayStart;
		foreach ($products as $key => $item) {
			$id = ($i + 1);
			if (empty($item['pro_image']) || !$this->product->file_exist($item['pro_image'])) {
				$image_url = base_url(PRODUCTDEFAULTIMAGEURL);
			}
			else {
				$image_url = base_url($item['pro_image']);
			}
			$records["data"][] = array(
				$id,
				'<a class="fancybox-button" title="' . $item['pro_title'] . '" data-rel="fancybox-button" href="' . $image_url . '"><img src="' . $image_url . '" width="80" height="80"></a>' , 
				$item['pro_title'],
				$item['pro_cat_new_id'] > 0 ? $item['cat_new_name'] : '其他' ,
				$item['pro_rate'],
				'<a href="'. site_url('admin/product/update?pro_id=' . $item['pro_id']) .'" class="btn btn-sm btn-success"  ><i class="fa fa-edit"></i></a>
				<a href="javascript:void(0);" class="btn btn-sm btn-danger btn-delete" pro-id="' . $item['pro_id'] . '"><i class="fa fa-trash"></i></a>',
			);
			$i ++;
		}

		$records["draw"] = $sEcho;
		$records["recordsTotal"] = $iTotalRecords;
		$records["recordsFiltered"] = $iTotalRecords;

		echo json_encode($records);
	}

	public function delete(){
		if ($this->input->post('pro_id')) {
			$cur_records = $this->product->get_singletbdata('tbl_product' , array('pro_id' => $this->input->post('pro_id')) , 'pro_image');
			if (count($cur_records) > 0) {
				$delete_file_name = $cur_records[0]['pro_image'];
				$this->product->delete_file($delete_file_name);
			}
			$this->product->tb_deletedata('tbl_product_sellers' , array('pro_id' => $this->input->post('pro_id')));
			$this->product->tb_deletedata('tbl_blog' , array('b_pro_id' => $this->input->post('pro_id')));
			$result = $this->product->tb_deletedata('tbl_product' , array('pro_id' => $this->input->post('pro_id')));
			echo json_encode(array('success' => $result));
		}
	}

	public function update(){
		if ($this->input->get('pro_id') && $this->input->get('pro_id') > 0) {		
			$this->header_data['page_key'] = $this->page_key;
			$this->header_data['plugin_css'] = array(
				'rateit/src/rateit.css' , 
				'fancybox/source/jquery.fancybox.css' , 
				'bootstrap-select/bootstrap-select.min.css' , 
				'select2/select2.css' , 
				'jquery-file-upload/css/jquery.fileupload.css'
			);
			$view_data = array();
			$view_data['pro_id'] = $this->input->get('pro_id');
			// $view_data['product_category'] = $this->product->get_singletbdata('tbl_category' , array() , '*' , 'cat_name ASC');
			$view_data['product_category'] = $this->product->get_product_newcategory_sorted();
			$view_data['shopping_category'] = $this->product->get_singletbdata('tbl_shoppingcategory' , array() , '*' , 'shoppingcat_name ASC');
			$view_data['product_data'] = $this->product->get_singletbdata('tbl_product' , array('pro_id' => $view_data['pro_id']));
			if (count($view_data['product_data']) > 0) {
				$view_data['product_data'] = $view_data['product_data'][0];
				$view_data['company_data'] = $this->product->get_singletbdata('tbl_companys' , array('com_id' => $view_data['product_data']['pro_company_id']));
				if (count($view_data['company_data']) > 0) {
					$view_data['company_data'] = $view_data['company_data'][0];
				}
			}
			$view_data['pro_ingredients'] = $this->product->get_product_ingredient($view_data['product_data']['pro_ingredients']);
			$view_data['product_sellers'] = $this->product->get_singletbdata('tbl_product_sellers' , array('pro_id' => $view_data['pro_id']) , '*' , 'shop_name ASC');
			
			if ($this->session->has_userdata('POST_RESULT_ALARM_MESSAGE')) {
				$view_data['post_result_alarm_message'] = $this->session->userdata('POST_RESULT_ALARM_MESSAGE');
				$this->session->unset_userdata('POST_RESULT_ALARM_MESSAGE');
			}
			// footer data
			$footer_data = array();
			$footer_data['plugin_js'] = array(
				'jquery-validation/js/jquery.validate.min.js' , 
				'rateit/src/jquery.rateit.js' , 
				'fancybox/source/jquery.fancybox.pack.js' ,
				'bootstrap-select/bootstrap-select.min.js' , 
				'select2/select2.min.js' , 
			);

			$this->template->pageview('product/productupdate_view' , 'productupdate_js' , $this->header_data , $view_data , $footer_data , 'admin');
		}
		else {	
			$this->header_data['page_key'] = $this->page_key;
			$this->header_data['plugin_css'] = array(
				'rateit/src/rateit.css' , 
				'fancybox/source/jquery.fancybox.css' , 
				'bootstrap-select/bootstrap-select.min.css' , 
				'select2/select2.css' , 
				'jquery-file-upload/css/jquery.fileupload.css'
			);
			$view_data = array();
			$view_data['pro_id'] = $this->input->get('pro_id');
			// $view_data['product_category'] = $this->product->get_singletbdata('tbl_category' , array() , '*' , 'cat_name ASC');
			$view_data['product_category'] = $this->product->get_product_newcategory_sorted();
			$view_data['shopping_category'] = $this->product->get_singletbdata('tbl_shoppingcategory' , array() , '*' , 'shoppingcat_name ASC');
			// footer data
			$footer_data = array();
			$footer_data['plugin_js'] = array(
				'jquery-validation/js/jquery.validate.min.js' , 
				'rateit/src/jquery.rateit.js' , 
				'fancybox/source/jquery.fancybox.pack.js' ,
				'bootstrap-select/bootstrap-select.min.js' , 
				'select2/select2.min.js' , 
			);

			$this->template->pageview('product/productupdate_view' , 'productupdate_js' , $this->header_data , $view_data , $footer_data , 'admin');
		}
	}

	public function insert(){
		if ($this->input->post()) {
			$result = $this->product->insert($this->input->post() , $this->uploadpath_product);
			if ($result['pro_id'] && $result['pro_id'] > 0) {
				$this->session->set_userdata('POST_RESULT_ALARM_MESSAGE' , $result);
				redirect('admin/product/update?pro_id=' . $result['pro_id']);
			}
		}
		redirect('admin/product');
	}

	public function get_ingredient(){
		if ($this->input->get()) {
			$remote_data = $this->product->get_singletbdata('tbl_ingredient' , array('ing_name LIKE ' => '%' . $_REQUEST['q'] . '%') , 'ing_id as id , ing_name' , 'ing_name ASC');
			echo json_encode(array('results' => $remote_data));
		}
	}

	public function get_company(){
		if ($this->input->get()) {
			$remote_data = $this->product->get_companys(array('com_name LIKE ' => '%' . $_REQUEST['q'] . '%' , 'com_alias LIKE ' => '%' . $_REQUEST['q'] . '%') , 'com_id as id , com_name' , 'com_name ASC');
			echo json_encode(array('results' => $remote_data));
		}
	}
}
