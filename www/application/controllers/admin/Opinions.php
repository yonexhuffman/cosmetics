<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . 'core/MY_AdminController.php');

class Opinions extends MY_AdminController {
	private $page_key = 9;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/Opinions_Model' , 'opinions');
	}

	public function index()	{		
		$this->header_data['page_key'] = $this->page_key;
		$this->header_data['plugin_css'] = array(
			'fancybox/source/jquery.fancybox.css' , 
			'datatables/plugins/bootstrap/dataTables.bootstrap.css' , 
		);
		$view_data = array();

		// footer data
		$footer_data = array();
		$footer_data['plugin_js'] = array(
			'fancybox/source/jquery.fancybox.pack.js' ,
			'datatables/media/js/jquery.dataTables.min.js' , 
			'datatables/plugins/bootstrap/dataTables.bootstrap.js' , 
			'../scripts/datatable.js'
		);

		$this->template->pageview('opinions/opinions_view' , 'opinions_js' , $this->header_data , $view_data , $footer_data , 'admin');
	}

	public function get_data(){
		$criteria = array();
		$order = array();
		if ($_REQUEST['order']) {
			$order['field'] = $_REQUEST['columns'][$_REQUEST['order'][0]['column']]['name'];
			$order['direction'] = $_REQUEST['order'][0]['dir'];
		}
		$limit = array();
		$limit['start'] = $_REQUEST['start'];
		$limit['length'] = $_REQUEST['length'];

		$iTotalRecords = $this->opinions->tb_data_count('tbl_opiniontoadmin' , $criteria);
		$iDisplayLength = intval($_REQUEST['length']);
		$iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
		$iDisplayStart = intval($_REQUEST['start']);
		$sEcho = intval($_REQUEST['draw']);

		$opinionss = $this->opinions->get_opinions($criteria , $order , $limit);
		$records = array();
		$records["data"] = array(); 

		$end = $iDisplayStart + $iDisplayLength;
		$end = $end > $iTotalRecords ? $iTotalRecords : $end;

		$i = $iDisplayStart;
		foreach ($opinionss as $key => $item) {
			$id = ($i + 1);
			$records["data"][] = array(
				$id,
				$item['user_nickname'],
				mb_strlen($item['content']) > 50 ? mb_strcut($item['content'], 0 , 50) . '...' : $item['content'] ,
				$item['send_datetime'],
				$item['is_adminchecked'] == 1 ? '<input type="checkbox" checked>' : '<input type="checkbox">' ,
				'<a href="'. site_url('admin/opinions/update?op_id=' . $item['op_id']) .'" class="btn btn-sm btn-success fancybox fancybox.ajax opinion_view" op-id="' . $item['op_id'] . '"><i class="fa fa-folder-open"></i></a>
				<a href="javascript:void(0);" class="btn btn-sm btn-danger btn-delete" op-id="' . $item['op_id'] . '"><i class="fa fa-trash"></i></a>',
			);
			$i ++;
		}

		$records["draw"] = $sEcho;
		$records["recordsTotal"] = $iTotalRecords;
		$records["recordsFiltered"] = $iTotalRecords;

		echo json_encode($records);
	}

	public function delete(){
		if ($this->input->post('op_id')) {
			$result = $this->opinions->tb_deletedata('tbl_opiniontoadmin' , array('op_id' => $this->input->post('op_id')));
			echo json_encode(array('success' => $result));
		}
	}

	public function itemcheck(){
		if ($this->input->post('op_id')) {
			$result = $this->opinions->tb_updatedata('tbl_opiniontoadmin' , array('op_id' => $this->input->post('op_id')) , array('is_adminchecked' => 1));
			echo json_encode(array('success' => $result));
		}
	}

	public function update(){
		if ($this->input->get('op_id') && $this->input->get('op_id') > 0) {	
			$this->header_data['plugin_css'] = array(

			);
			$view_data = array();
			$view_data['op_id'] = $this->input->get('op_id');
			$view_data['opinions_data'] = $this->opinions->get_opinions_item($view_data['op_id']);
			// footer data
			$footer_data = array();
			$footer_data['plugin_js'] = array(

			);
			$this->load->view('admin/opinions/opinionsupdate_view' , $view_data);
		}
	}
}
