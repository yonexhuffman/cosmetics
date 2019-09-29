<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . 'core/MY_AdminController.php');

class Company extends MY_AdminController {
	private $page_key = 8;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/Company_Model' , 'company');
	}

	public function index()	{		
		$this->header_data['page_key'] = $this->page_key;
		$this->header_data['plugin_css'] = array(
			'datatables/plugins/bootstrap/dataTables.bootstrap.css' , 
			'fancybox/source/jquery.fancybox.css' , 
		);
		$view_data = array();
		$view_data['is_reset_rankingnumber'] = $this->company->is_reset_rankingnumber();
		if ($this->session->has_userdata('POST_RESULT_ALARM_MESSAGE')) {
			$view_data['post_result_alarm_message'] = $this->session->userdata('POST_RESULT_ALARM_MESSAGE');
			$this->session->unset_userdata('POST_RESULT_ALARM_MESSAGE');
		}

		// footer data
		$footer_data = array();
		$footer_data['plugin_js'] = array(
			'jquery-validation/js/jquery.validate.min.js' , 
			'fancybox/source/jquery.fancybox.pack.js' ,
			'datatables/media/js/jquery.dataTables.min.js' , 
			'datatables/plugins/bootstrap/dataTables.bootstrap.js' , 
			'../scripts/datatable.js'
		);

		$this->template->pageview('company/company_view' , 'company_js' , $this->header_data , $view_data , $footer_data , 'admin');
	}

	public function get_data(){
		$criteria = array();
		if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'filter') {
			if (!empty($_REQUEST['com_name'])) {
				$criteria['tbl_companys.com_name LIKE '] = '%' . $_REQUEST['com_name'] . '%';
			}
			if (!empty($_REQUEST['com_alias'])) {
				$criteria['tbl_companys.com_alias LIKE '] = '%' . $_REQUEST['com_alias'] . '%';
			}
			if (!empty($_REQUEST['com_country'])) {
				$criteria['tbl_companys.com_country LIKE '] = '%' . $_REQUEST['com_country'] . '%';
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

		$iTotalRecords = $this->company->tb_data_count('tbl_companys' , $criteria);
		$iDisplayLength = intval($_REQUEST['length']);
		$iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
		$iDisplayStart = intval($_REQUEST['start']);
		$sEcho = intval($_REQUEST['draw']);

		$products = $this->company->get_companys($criteria , $order , $limit);
		$records = array();
		$records["data"] = array(); 

		$end = $iDisplayStart + $iDisplayLength;
		$end = $end > $iTotalRecords ? $iTotalRecords : $end;

		$i = $iDisplayStart;
		foreach ($products as $key => $item) {
			$id = ($i + 1);
			if (empty($item['com_image']) || !$this->company->file_exist($this->uploadpath_company_image . $item['com_image'])) {
				$image_url = base_url(COMPANYDEFAULTIMAGEURL);
			}
			else {
				$image_url = base_url($this->uploadpath_company_image . $item['com_image']);
			}
			$records["data"][] = array(
				$id,
				'<a class="fancybox-button" title="' . $item['com_name'] . '" data-rel="fancybox-button" href="' . $image_url . '"><img src="' . $image_url . '" width="80" height="80"></a>' , 
				$item['com_name'],
				$item['com_alias'],
				$item['com_country'],
				$item['ranking_number'],
				'<a href="'. site_url('admin/company/update?com_id=' . $item['com_id']) .'" class="btn btn-sm btn-success"  ><i class="fa fa-edit"></i></a>',
			);
			$i ++;
		}

		$records["draw"] = $sEcho;
		$records["recordsTotal"] = $iTotalRecords;
		$records["recordsFiltered"] = $iTotalRecords;

		echo json_encode($records);
	}

	public function update(){
		if ($this->input->get('com_id') && $this->input->get('com_id') > 0) {		
			$this->header_data['page_key'] = $this->page_key;
			$this->header_data['plugin_css'] = array(
				'fancybox/source/jquery.fancybox.css' , 
				'jquery-file-upload/css/jquery.fileupload.css'
			);
			$view_data = array();
			$view_data['com_id'] = $this->input->get('com_id');
			$view_data['image_path'] = $this->uploadpath_company_image;
			$view_data['company_data'] = $this->company->get_singletbdata('tbl_companys' , array('com_id' => $view_data['com_id']));
			if (count($view_data['company_data']) > 0) {
				$view_data['company_data'] = $view_data['company_data'][0];
			}

			if ($this->session->has_userdata('POST_RESULT_ALARM_MESSAGE')) {
				$view_data['post_result_alarm_message'] = $this->session->userdata('POST_RESULT_ALARM_MESSAGE');
				$this->session->unset_userdata('POST_RESULT_ALARM_MESSAGE');
			}
			// footer data
			$footer_data = array();
			$footer_data['plugin_js'] = array(
				'jquery-validation/js/jquery.validate.min.js' , 
				'fancybox/source/jquery.fancybox.pack.js' ,
			);

			$this->template->pageview('company/companyupdate_view' , 'companyupdate_js' , $this->header_data , $view_data , $footer_data , 'admin');
		}
		else {		
			$this->header_data['page_key'] = $this->page_key;
			$this->header_data['plugin_css'] = array(
				'fancybox/source/jquery.fancybox.css' , 
				'jquery-file-upload/css/jquery.fileupload.css'
			);
			$view_data = array();
			$view_data['com_id'] = -1;
			$view_data['image_path'] = $this->uploadpath_company_image;

			if ($this->session->has_userdata('POST_RESULT_ALARM_MESSAGE')) {
				$view_data['post_result_alarm_message'] = $this->session->userdata('POST_RESULT_ALARM_MESSAGE');
				$this->session->unset_userdata('POST_RESULT_ALARM_MESSAGE');
			}
			// footer data
			$footer_data = array();
			$footer_data['plugin_js'] = array(
				'jquery-validation/js/jquery.validate.min.js' , 
				'fancybox/source/jquery.fancybox.pack.js' ,
			);

			$this->template->pageview('company/companyupdate_view' , 'companyupdate_js' , $this->header_data , $view_data , $footer_data , 'admin');
		}
	}

	public function insert(){
		if ($this->input->post()) {
			$post_result = $this->company->insert($this->input->post() , $this->uploadpath_company_image);
			$this->session->set_userdata('POST_RESULT_ALARM_MESSAGE' , $post_result);
			if ($post_result['success']) {
				redirect('admin/company/update?com_id=' . $post_result['insert_id']);
			}
		}
		redirect('admin/company');
	}

	public function decisionrankingnumber(){
		echo json_encode(array('success' => $this->company->decisionrankingnumber()));
	}

	public function delete(){
		if ($this->input->post('com_id')) {
			$result = TRUE;
			if (!empty($this->input->post('com_img'))) {
				$result = TRUE && $this->company->delete_file($this->uploadpath_company_image . $this->input->post('com_img'));
			}
			$result = $result && $this->company->tb_deletedata('tbl_cosmetics_companys' , array('com_id' => $this->input->post('com_id')));
			echo json_encode(array('success' => $result));
		}
	}

}
