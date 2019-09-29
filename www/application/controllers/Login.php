<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . 'core/MY_UserController.php');

class Login extends MY_UserController {

	private $post_message = "";
	
	private $page_key = 6;
	
	public function __construct() {
		parent::__construct();		
		$this->load->model('Login_Model' , 'login');
	}

	public function index()	{	

		$this->header_data['page_key'] = $this->page_key;
		$this->header_data['plugin_css'] = array(
			'simple-line-icons/simple-line-icons.min.css' ,
			'uniform/css/uniform.default.css', 
		);

		if ($this->session->has_userdata('POSTERROR_MESSAGE')) {
			$this->post_message = $this->session->userdata('POSTERROR_MESSAGE');
			$this->session->unset_userdata('POSTERROR_MESSAGE');
		}
		$view_data = array();
		$view_data['error']		= $this->post_message;
		
		$footer_data = array();
		$footer_data['plugin_js'] = array(
			'jquery.blockui.min.js' , 
			'uniform/jquery.uniform.min.js' , 
			'jquery-validation/js/jquery.validate.min.js',
			'backstretch/jquery.backstretch.min.js',
		);

		$this->template->pageview('login/login_view' , 'login_js' , $this->header_data , $view_data , $footer_data);
	}

	public function signIn(){
		$criteria = $this->input->post();
		$status = $this->login->signin($criteria);
		if ($status['login_status'] == 0) {
			$post_message = "您输入的用户不存在。";
			$this->session->set_userdata('POSTERROR_MESSAGE' , $post_message);
			redirect('login');
		}
		else if ($status['login_status'] == 1) {
			$post_message = "密码不正确。";
			$this->session->set_userdata('POSTERROR_MESSAGE' , $post_message);
			redirect('login');
		}
		else {
			$this->login->registerSession($status['user_data']);
			redirect('/dashboard');
		}
	}	

	public function signUp(){
		$this->login->destroySession();
		redirect('/');
	}

	public function checkuserid(){
		$user_id = $_REQUEST['user_id'];
		$criteria = array('user_id'	=> $user_id);
		$retVal = array('success' => FALSE);
		if ($this->db->from('tbl_account')->where($criteria)->count_all_results() > 0) {
			$retVal['success'] = TRUE;
		}
		echo json_encode($retVal);
	}

	public function createaccount(){
		if ($this->input->post()) {
			$post_data = $this->input->post();
			$insert_data = array(
				'user_id'	=> $post_data['user_id'] , 
				'user_password' => md5($post_data['user_password']) , 
				'user_email'	=> $post_data['user_email'] , 
				'user_phonenumber'	=> $post_data['user_phonenumber'] , 
				'user_nickname'	=> $post_data['user_nickname'] , 
				'is_valid'	=> 1
			);
			$result = $this->login->createaccount($insert_data);
			if ($result > 0) {
				$criteria = array(
					'user_id'	=> $post_data['user_id'] , 
					'user_password' => $post_data['user_password'] , 
				);

				$status = $this->login->signin($criteria);
				$this->login->registerSession($status['user_data']);
				redirect('dashboard');
			}
		}
		redirect('login');
	}

	public function recover_password(){
		$email = $this->input->post('email');
		$view_data = array();

        //check if email is in the database
        if($this->login->email_exists($email)){
            //$them_pass is the varible to be sent to the user's email 
            $temp_pass = md5(uniqid());

            //send email with #temp_pass as a link
	    	$user = '845195854@qq.com';
	    	$pass = 'mzfcdijrotzkbcaj';

            $config = Array(
			  'protocol' => 'smtp',
			  'mailpath' => '/usr/sbin/sendmail',
			  'smtp_host' => 'smtp.qq.com',
			  'smtp_port' => 465,
			  'smtp_timeout' => 30,
			  'charset' => 'utf-8',
			  'smtp_user' => $user,
			  'smtp_pass' => $pass,
			  'smtp_crypto' => 'ssl',
			  'mailtype' => 'html',
			  'charset' => 'iso-8859-1',
			  'wordwrap' => TRUE,
			  'newline' => "\r\n",
			  'crlf' => "\r\n"
			);
			$from = '845195854@qq.com';

			$this->load->library('email', $config);
			$this->email->from($from, 'Vannaer 瓦呐尔'); // change it to yours
			$this->email->to($email);// change it to yours
			$this->email->subject("重置你的密码");

            $message = "<p>此电子邮件已作为重置密码的请求发送</p>";
            $message .= "<p>如果你想重置密码<a href='".site_url()."login/reset_password?temp_pass=$temp_pass'>点击这里 </a>,
                        如果不, 然后忽略</p>";
            $this->email->message($message);

            if($this->email->send()){
                if($this->login->temp_reset_password($temp_pass)){
                    $view_data['string'] = "检查你的电子邮件是否有指示，谢谢";
					$view_data['color'] = "pass-success";
					$this->load->view('login/passview' , $view_data);
                }
            }
            else{
                $view_data['string'] = "电子邮件未发送，请与您的管理员联系";
				$view_data['color'] = "pass-success";
				$this->load->view('login/passview' , $view_data);
            }

        }else{
			$view_data['string'] = "您的电子邮件不在我们的数据库中";
			$view_data['color'] = "pass-danger";
			$this->load->view('login/passview' , $view_data);
        }
	}


	public function reset_password(){
		$temp_pass = $this->input->get('temp_pass');
	    if($this->login->is_temp_pass_valid($temp_pass)){
	    	$view_data['temp_pass'] = $temp_pass;
			$this->load->view('login/passview', $view_data);

	    }else{
	        $view_data['string'] = "密钥无效";
			$view_data['color'] = "pass-danger";
			$this->load->view('login/passview' , $view_data);
	    }

	}


	public function update_password(){
	    $this->load->library('form_validation');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        $this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|trim|matches[password]');
	    $reset_pass = $this->input->post('reset_pass');

        if($this->form_validation->run()){
	        $new = md5($this->input->post('password'));
	        if ($this->login->update_password($new, $reset_pass)) {
	        	redirect('login');
	        }
        }else{
        	$view_data['nomatch'] = "密码不匹配";
        	$view_data['temp_pass'] = $reset_pass;
			$this->load->view('login/passview', $view_data);
        }
	}

}
