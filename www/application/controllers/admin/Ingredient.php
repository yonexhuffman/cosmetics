<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . 'core/MY_AdminController.php');

class Ingredient extends MY_AdminController {
	private $page_key = 4;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/Ingredient_Model' , 'ingredient');
	}

	public function index()	{		
		$this->header_data['page_key'] = $this->page_key;
		$this->header_data['plugin_css'] = array(
			'datatables/plugins/bootstrap/dataTables.bootstrap.css' , 
		);
		$view_data = array();
		$view_data['is_active'] = $this->config->item('is_active');

		// footer data
		$footer_data = array();
		$footer_data['plugin_js'] = array(
			'jquery-validation/js/jquery.validate.min.js' , 
			'datatables/media/js/jquery.dataTables.min.js' , 
			'datatables/plugins/bootstrap/dataTables.bootstrap.js' , 
			'../scripts/datatable.js'
		);

		$this->template->pageview('ingredient/ingredient_view' , 'ingredient_js' , $this->header_data , $view_data , $footer_data , 'admin');
	}

	public function get_data(){
		$criteria = array(
			'is_delete'	=> 0
		);
		if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'filter') {
			if (!empty($_REQUEST['ing_name'])) {
				$criteria['ing_name LIKE '] = '%' . $_REQUEST['ing_name'] . '%';
			}
			if (!empty($_REQUEST['ing_csano'])) {
				$criteria['ing_csano LIKE '] = '%' . $_REQUEST['ing_csano'] . '%';
			}

			if ($_REQUEST['ing_active'] != '') {
				$criteria['ing_active'] = $_REQUEST['ing_active'];
			}
			if ($_REQUEST['ing_acne_risk'] != '') {
				$criteria['ing_acne_risk'] = $_REQUEST['ing_acne_risk'];
			}
			if ($_REQUEST['ing_flavor'] != '') {
				$criteria['ing_flavor'] = $_REQUEST['ing_flavor'];
			}
			if ($_REQUEST['ing_preservation'] != '') {
				$criteria['ing_preservation'] = $_REQUEST['ing_preservation'];
			}
			if ($_REQUEST['ing_pregantcaution'] != '') {
				$criteria['ing_pregantcaution'] = $_REQUEST['ing_pregantcaution'];
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

		$iTotalRecords = $this->ingredient->tb_data_count('tbl_ingredient' , $criteria);
		$iDisplayLength = intval($_REQUEST['length']);
		$iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
		$iDisplayStart = intval($_REQUEST['start']);
		$sEcho = intval($_REQUEST['draw']);

		$products = $this->ingredient->get_ingredients($criteria , $order , $limit);
		$records = array();
		$records["data"] = array(); 

		$end = $iDisplayStart + $iDisplayLength;
		$end = $end > $iTotalRecords ? $iTotalRecords : $end;

		$i = $iDisplayStart;
		foreach ($products as $key => $item) {
			$id = ($i + 1);
			$good_state_img = '<img src="' . base_url(ING_GOOD_STATE_IMGURL) . '">';
			$warning_state_img = '<img src="' . base_url(ING_WARNING_STATE_IMGURL) . '">';
			$security_risk = explode('-', $item['ing_security_risk']);
			$max = intval($security_risk[count($security_risk) - 1]);
			if ($max > 7) {
				$security_risk_output = '<span class="label label-danger security_risk_label">' . $item['ing_security_risk'] . '</span>';
			}
			else if ($max < 8 && $max >= 3) {
				$security_risk_output = '<span class="label label-warning security_risk_label">' . $item['ing_security_risk'] . '</span>';			
			}
			else {
				$security_risk_output = '<span class="label label-primary security_risk_label">' . $item['ing_security_risk'] . '</span>';			
			}
			$records["data"][] = array(
				$id,
				$item['ing_name'],
				$item['ing_csano'],
				$security_risk_output ,
				$item['ing_active'] == 1 ? $good_state_img : '' ,
				$item['ing_acne_risk'] == 1 ? $warning_state_img : '' ,
				$item['ing_flavor'] == 1 ? $good_state_img : '' ,
				$item['ing_preservation'] == 1 ? $good_state_img : '' ,
				$item['ing_pregantcaution'] == 1 ? $warning_state_img : '' ,
				'<a href="'. site_url('admin/ingredient/update?ing_id=' . $item['ing_id']) .'" class="btn btn-sm btn-success"  ><i class="fa fa-edit"></i></a>
				<a href="javascript:void(0);" class="btn btn-sm btn-danger btn-delete" ing-id="' . $item['ing_id'] . '"><i class="fa fa-trash"></i></a>',
			);
			$i ++;
		}

		$records["draw"] = $sEcho;
		$records["recordsTotal"] = $iTotalRecords;
		$records["recordsFiltered"] = $iTotalRecords;

		echo json_encode($records);
	}

	public function delete(){
		if ($this->input->post('ing_id')) {
			$result = $this->ingredient->tb_deletedata('tbl_ingredient' , array('ing_id' => $this->input->post('ing_id')));
			echo json_encode(array('success' => $result));
		}
	}

	public function update(){
		if ($this->input->get('ing_id') && $this->input->get('ing_id') > 0) {		
			$this->header_data['page_key'] = $this->page_key;
			$this->header_data['plugin_css'] = array();
			$view_data = array();
			$view_data['ing_id'] = $this->input->get('ing_id');
			$view_data['is_active'] = $this->config->item('is_active');
			$view_data['ingredient_data'] = $this->ingredient->get_singletbdata('tbl_ingredient' , array('ing_id' => $view_data['ing_id']));
			if (count($view_data['ingredient_data']) > 0) {
				$view_data['ingredient_data'] = $view_data['ingredient_data'][0];
			}

			if ($this->session->has_userdata('POST_RESULT_ALARM_MESSAGE')) {
				$view_data['post_result_alarm_message'] = $this->session->userdata('POST_RESULT_ALARM_MESSAGE');
				$this->session->unset_userdata('POST_RESULT_ALARM_MESSAGE');
			}
			// footer data
			$footer_data = array();
			$footer_data['plugin_js'] = array(
				'jquery-validation/js/jquery.validate.min.js' , 
			);

			$this->template->pageview('ingredient/ingredientupdate_view' , 'ingredientupdate_js' , $this->header_data , $view_data , $footer_data , 'admin');
		}
		else {	
			$this->header_data['page_key'] = $this->page_key;
			$this->header_data['plugin_css'] = array();
			$view_data = array();
			$view_data['ing_id'] = $this->input->get('ing_id');
			$view_data['is_active'] = $this->config->item('is_active');
			$view_data['ingredient_data'] = $this->ingredient->get_singletbdata('tbl_ingredient' , array('ing_id' => $view_data['ing_id']));
			if (count($view_data['ingredient_data']) > 0) {
				$view_data['ingredient_data'] = $view_data['ingredient_data'][0];
			}

			// footer data
			$footer_data = array();
			$footer_data['plugin_js'] = array(
				'jquery-validation/js/jquery.validate.min.js' , 
			);

			$this->template->pageview('ingredient/ingredientupdate_view' , 'ingredientupdate_js' , $this->header_data , $view_data , $footer_data , 'admin');
		}
	}

	public function insert(){
		if ($this->input->post()) {
			$result = $this->ingredient->insert($this->input->post());
			if ($result['ing_id'] && $result['ing_id'] > 0) {
				$this->session->set_userdata('POST_RESULT_ALARM_MESSAGE' , $result);
				redirect('admin/ingredient/update?ing_id=' . $result['ing_id']);
			}
		}
		redirect('admin/ingredient');
	}

}
