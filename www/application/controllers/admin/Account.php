<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . 'core/MY_AdminController.php');

class Account extends MY_AdminController {
	private $page_key = 11;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/Account_Model' , 'account');
	}

	public function index()	{		
		$this->header_data['page_key'] = $this->page_key;
		$this->header_data['plugin_css'] = array(
			'fancybox/source/jquery.fancybox.css' , 
			'datatables/plugins/bootstrap/dataTables.bootstrap.css' , 
			'jquery-file-upload/css/jquery.fileupload.css' , 
		);
		$view_data = array();
		$view_data['user_role'] = $this->config->item('user_role');
		
		if ($this->session->has_userdata('POST_RESULT_ALARM_MESSAGE')) {
			$view_data['post_result_alarm_message'] = $this->session->userdata('POST_RESULT_ALARM_MESSAGE');
			$this->session->unset_userdata('POST_RESULT_ALARM_MESSAGE');
		}

		// footer data
		$footer_data = array();
		$footer_data['plugin_js'] = array(
			'fancybox/source/jquery.fancybox.pack.js' ,
			'datatables/media/js/jquery.dataTables.min.js' , 
			'datatables/plugins/bootstrap/dataTables.bootstrap.js' , 
			'../scripts/datatable.js' ,
			'jquery-validation/js/jquery.validate.min.js' , 
		);

		$this->template->pageview('account/account_view' , 'account_js' , $this->header_data , $view_data , $footer_data , 'admin');
	}

	public function get_data(){
		$criteria = array();
		if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'filter') {
			if (!empty($_REQUEST['user_nickname'])) {
				$criteria['user_nickname LIKE '] = '%' . $_REQUEST['user_nickname'] . '%';
			}
			if (!empty($_REQUEST['user_role'])) {
				$criteria['user_role'] = $_REQUEST['user_role'];
			}
			if (!empty($_REQUEST['user_id'])) {
				$criteria['user_id LIKE '] = '%' . $_REQUEST['user_id'] . '%';
			}
			if (!empty($_REQUEST['user_email'])) {
				$criteria['user_email LIKE '] = '%' . $_REQUEST['user_email'] . '%';
			}
			if (!empty($_REQUEST['user_phonenumber'])) {
				$criteria['user_phonenumber LIKE '] = '%' . $_REQUEST['user_phonenumber'] . '%';
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

		$iTotalRecords = $this->account->tb_data_count('tbl_account' , $criteria);
		$iDisplayLength = intval($_REQUEST['length']);
		$iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
		$iDisplayStart = intval($_REQUEST['start']);
		$sEcho = intval($_REQUEST['draw']);

		$accounts = $this->account->get_account($criteria , $order , $limit);
		$user_role = $this->config->item('user_role');
		$records = array();
		$records["data"] = array(); 

		$end = $iDisplayStart + $iDisplayLength;
		$end = $end > $iTotalRecords ? $iTotalRecords : $end;

		$i = $iDisplayStart;
		foreach ($accounts as $key => $item) {
			$id = ($i + 1);
			if (empty($item['acc_image']) || !file_exists($this->uploadpath_avatar_image . $item['acc_image'])) {
				$image_url = base_url(DEFAULT_AVATAR_IMGURL);
				$image = '<img src="' . $image_url . '" width="80" height="80">';
			}
			else {
				$image_url = base_url($this->uploadpath_avatar_image . $item['acc_image']);
				$image = '<a class="fancybox-button" title="' . $item['user_nickname'] . '" data-rel="fancybox-button" href="' . $image_url . '"><img src="' . $image_url . '" width="80" height="80"></a>';
			}
			$checked =  $item['is_valid'] == 1 ? 'checked' : '';
			$records["data"][] = array(
				$id,
				$image , 
				$item['user_nickname'],
				$user_role[$item['user_role']],
				$item['user_id'],
				$item['user_email'],
				$item['user_phonenumber'],
				'<input type="checkbox" class="user_is_valid" ' . $checked . ' acc-id="' . $item['acc_id'] . '">' , 
				'<a href="'. site_url('admin/account/update?acc_id=' . $item['acc_id']) .'" class="btn btn-sm btn-success fancybox fancybox.ajax opinion_view" op-id="' . $item['acc_id'] . '"><i class="fa fa-edit"></i></a>
				<a href="javascript:void(0);" class="btn btn-sm btn-danger btn-delete" acc-id="' . $item['acc_id'] . '" image-name="' . $item['acc_image'] . '" ><i class="fa fa-trash"></i></a>',
			);
			$i ++;
		}

		$records["draw"] = $sEcho;
		$records["recordsTotal"] = $iTotalRecords;
		$records["recordsFiltered"] = $iTotalRecords;

		echo json_encode($records);
	}

	public function update(){
		if ($this->input->get('acc_id') && $this->input->get('acc_id') > 0) {	
			$view_data = array();
			$view_data['acc_id'] = $this->input->get('acc_id');
			$view_data['avatar_image_path'] = $this->uploadpath_avatar_image;
			$view_data['user_role'] = $this->config->item('user_role');
			$view_data['account_data'] = $this->account->get_account_item($view_data['acc_id']);

			$this->load->view('admin/account/accountupdate_view' , $view_data);
		}
		else {
			$view_data = array();
			$view_data['user_role'] = $this->config->item('user_role');
			$view_data['avatar_image_path'] = $this->uploadpath_avatar_image;

			$this->load->view('admin/account/accountupdate_view' , $view_data);
		}
	}

	public function insert(){
		if ($this->input->post()) {
			$retVal = array();
			$post_data = $this->input->post();
			$retVal['success'] = $this->account->insert($post_data , $this->uploadpath_avatar_image);
			$this->session->set_userdata('POST_RESULT_ALARM_MESSAGE' , $retVal);
		}
		redirect('admin/account');
	}

	public function delete(){
		if ($this->input->post('acc_id')) {
			$acc_id = $this->input->post('acc_id');
			$acc_image = $this->input->post('acc_image');
			if (!empty($acc_image)) {
				$res = $this->account->delete_file($this->uploadpath_avatar_image . $acc_image);
			}
			$retVal = array();			
			$retVal['success'] = $this->account->tb_deletedata('tbl_account' , array('acc_id' => $acc_id));
			echo json_encode($retVal);
		}
	}

	public function accountCheckIsVaild(){
		if ($this->input->post()) {
			$acc_id = $this->input->post('acc_id');
			$is_valid = $this->input->post('is_valid');
			echo json_encode(array('success' => $this->account->tb_updatedata('tbl_account' , array('acc_id' => $acc_id) , array('is_valid' => $is_valid))));
		}
	}

}
