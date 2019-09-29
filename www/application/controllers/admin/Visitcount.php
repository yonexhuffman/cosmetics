<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . 'core/MY_AdminController.php');

class Visitcount extends MY_AdminController {
	private $page_key = 14;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/Visitcount_Model' , 'visitcount');
	}

	public function index()	{		
		$this->header_data['page_key'] = $this->page_key;
		$this->header_data['plugin_css'] = array(
			'datatables/plugins/bootstrap/dataTables.bootstrap.css' , 
		);
		$view_data = array();
		$view_data['category'] = $this->visitcount->get_singletbdata('tbl_shoppingcategory' , array() , '*' , 'disp_order_num ASC');

		// footer data
		$footer_data = array();
		$footer_data['plugin_js'] = array(
			'datatables/media/js/jquery.dataTables.min.js' , 
			'datatables/plugins/bootstrap/dataTables.bootstrap.js' , 
			'../scripts/datatable.js'
		);

		$this->template->pageview('visitcount/visitcount_view' , 'visitcount_js' , $this->header_data , $view_data , $footer_data , 'admin');
	}

	public function get_data(){
		$criteria = array();
		if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'filter') {
			if (!empty($_REQUEST['pro_title'])) {
				$criteria['pro.pro_title LIKE '] = '%' . $_REQUEST['pro_title'] . '%';
			}
			if (!empty($_REQUEST['shop_cat_id'])) {
				$criteria['seller_tb.shop_cat_id'] = $_REQUEST['shop_cat_id'];
			}
			if (!empty($_REQUEST['shop_name'])) {
				$criteria['seller_tb.shop_name LIKE '] = '%' . $_REQUEST['shop_name'] . '%';
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

		$iTotalRecords = $this->visitcount->get_visitcounts($criteria);
		$iDisplayLength = intval($_REQUEST['length']);
		$iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
		$iDisplayStart = intval($_REQUEST['start']);
		$sEcho = intval($_REQUEST['draw']);

		$products = $this->visitcount->get_visitcounts_data($criteria , $order , $limit);
		$records = array();
		$records["data"] = array(); 

		$end = $iDisplayStart + $iDisplayLength;
		$end = $end > $iTotalRecords ? $iTotalRecords : $end;

		$i = $iDisplayStart;
		foreach ($products as $key => $item) {
			$id = ($i + 1);
			$records["data"][] = array(
				$id,
				'<a href="' . site_url('/product/item?pro_id=') . $item['pro_id'] . '" target="_blank">' . $item['pro_title'] . '</a>' ,
				$item['shoppingcat_name'],
				'<a href="' . $item['shop_url'] . '" target="_blank">' . $item['shop_name'] . '</a>',
				$item['price'],
				$item['visit_count'] != '' ? $item['visit_count'] : 0 ,
			);
			$i ++;
		}

		$records["draw"] = $sEcho;
		$records["recordsTotal"] = $iTotalRecords;
		$records["recordsFiltered"] = $iTotalRecords;

		echo json_encode($records);
	}

}
