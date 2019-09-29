<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . 'core/MY_AdminController.php');

class Admininfo extends MY_AdminController {
	private $page_key = 6;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/Admininfo_Model' , 'admininfo');
	}

	public function index()	{
		$this->header_data['page_key'] = $this->page_key;
		$view_data = array();
		$view_data['admindata'] = $this->basemodel->getLoggedUserData();
		
		if ($this->session->has_userdata('POST_RESULT_ALARM_MESSAGE')) {
			$view_data['post_result_alarm_message'] = $this->session->userdata('POST_RESULT_ALARM_MESSAGE');
			$this->session->unset_userdata('POST_RESULT_ALARM_MESSAGE');
		}

		// footer data
		$footer_data = array();
		$footer_data['plugin_js'] = array();
		$this->template->pageview('admininfo/admininfo_view' , 'admininfo_js' , $this->header_data , $view_data , $footer_data , 'admin');
	}

	public function confirmprevpassword(){
		if ($this->input->post()) {
			$result = array();
			$input_data = $this->input->post();

			$cur_pass = $input_data['cur_pass'];
			$prev_user_pass = md5($input_data['prev_user_pass']);
			if ($cur_pass != $prev_user_pass) {
				$result['success'] = FALSE;
			}
			else {
				$result['success'] = TRUE;
			}
			echo json_encode($result);
		}
	}

	public function update(){
		if ($this->input->post()) {
			$input_data = $this->input->post();
			$retVal['success'] = $this->admininfo->update_admin($input_data);
			$this->session->set_userdata('POST_RESULT_ALARM_MESSAGE' , $retVal);
		}
		redirect('admin/admininfo');
	}
}
