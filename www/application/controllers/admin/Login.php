<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	private $post_message = "";
	public function __construct() {
		parent::__construct();
		
		$this->load->model('admin/Login_Model' , 'login');
	}

	public function index()	{		
		if ($this->session->has_userdata('POSTERROR_MESSAGE')) {
			$this->post_message = $this->session->userdata('POSTERROR_MESSAGE');
			$this->session->unset_userdata('POSTERROR_MESSAGE');
		}
		$view_data = array();
		$view_data['error']		= $this->post_message;
		
		$this->load->view('admin/login/index' , $view_data);
	}

	public function signIn(){
		$criteria = $this->input->post();
		$status = $this->login->signin($criteria);
		if ($status['login_status'] == 0) {
			$post_message = "您输入的用户不存在。";
			$this->session->set_userdata('POSTERROR_MESSAGE' , $post_message);
			redirect('admin/login');
		}
		else if ($status['login_status'] == 1) {
			$post_message = "密码不正确。";
			$this->session->set_userdata('POSTERROR_MESSAGE' , $post_message);
			redirect('admin/login');
		}
		else {
			$this->login->registerSession($status['user_data']);
			redirect('admin/account');
		}
	}	

	public function signUp(){
		$this->login->destroySession();
		redirect('/admin');
	}

}
