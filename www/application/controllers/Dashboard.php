<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . 'core/MY_UserController.php');

class Dashboard extends MY_UserController {
	private $page_key = 5;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Dashboard_Model' , 'dashboard');
		$this->load->model('Login_Model' , 'login');

		if (empty($this->cur_userdata)) {
			redirect('');
		}
	}

	public function index()	{	
		$this->header_data['page_key'] = $this->page_key;
		$this->header_data['plugin_css'] = array(
			'jquery-file-upload/css/jquery.fileupload.css' , 
		);
		$view_data = array();
		$view_data['product_total_count'] = $this->dashboard->tb_data_count('tbl_product');
		$view_data['fav_products'] = $this->dashboard->get_favoriteproduct($this->cur_userdata['acc_id'] , array('start' => 1 , 'length' => LOADDATAPERPAGE));
		$view_data['blogs'] = $this->dashboard->get_blogs($this->cur_userdata['acc_id'] , array('start' => 1 , 'length' => LOADDATAPERPAGE) , $this->uploadpath_blog_image);
		$view_data['cur_userdata'] = $this->cur_userdata;
		$view_data['avatar_image_path'] = $this->uploadpath_avatar_image;
		
		if ($this->session->has_userdata('POST_RESULT_ALARM_MESSAGE')) {
			$view_data['post_result_alarm_message'] = $this->session->userdata('POST_RESULT_ALARM_MESSAGE');
			$this->session->unset_userdata('POST_RESULT_ALARM_MESSAGE');
		}
		
		if ($this->session->has_userdata('POST_UPDATEUSER_RESULT_ALARM_MESSAGE')) {
			$view_data['post_result_updateuser_alarm_message'] = $this->session->userdata('POST_UPDATEUSER_RESULT_ALARM_MESSAGE');
			$this->session->unset_userdata('POST_UPDATEUSER_RESULT_ALARM_MESSAGE');
		}

		// footer data
		$footer_data = array();
		$footer_data['plugin_js'] = array(
			'jquery-validation/js/jquery.validate.min.js' , 
		);

		$this->template->pageview('dashboard/dashboard_view' , 'dashboard_js' , $this->header_data , $view_data , $footer_data);
	}

	public function get_favoriteproduct(){
		if ($this->input->post('page_index')) {
			$page_index = $this->input->post('page_index');
			echo json_encode($this->dashboard->get_favoriteproduct($this->cur_userdata['acc_id'] , array('start' => $page_index , 'length' => LOADDATAPERPAGE)));
		}
	}

	public function get_blogs(){
		if ($this->input->post('page_index')) {
			$page_index = $this->input->post('page_index');
			echo json_encode($this->dashboard->get_blogs($this->cur_userdata['acc_id'] , array('start' => $page_index , 'length' => LOADDATAPERPAGE) , $this->uploadpath_blog_image));
		}
	}

	public function deletefavoriteproduct(){
		if ($this->input->post('pro_id')) {
			$pro_id = $this->input->post('pro_id');
			echo json_encode(array('success' => $this->dashboard->deletefavoriteproduct($this->cur_userdata['acc_id'] , $pro_id)));
		}
	}

	public function deleteblog(){
		if ($this->input->post('b_id')) {
			$b_id = $this->input->post('b_id');
			echo json_encode(array('success' => $this->dashboard->deleteBlog($b_id , $this->uploadpath_blog_image)));
		}
	}

	public function sendopinion(){
		$cur_userdata = $this->get_loggedin_userdata();
		if (!empty($cur_userdata)) {
			$acc_id = $cur_userdata['acc_id'];
			$content = $_POST['content'];
			$insert_status = $this->dashboard->tb_insertdata('tbl_opiniontoadmin' , array('acc_id' => $acc_id , 'content' => $content , 'send_datetime' => $this->dashboard->get_current_datetime()));
			$this->session->set_userdata('POST_RESULT_ALARM_MESSAGE' , $insert_status);
		}
		redirect('dashboard');
	}

	public function updateuser(){
		if ($this->input->post()) {
			$retVal = array();
			$post_data = $this->input->post();
			$update_data = array(
				'user_nickname'	=> $post_data['user_nickname'] , 
				'user_id'	=> $post_data['user_id'] , 
				'user_email'	=> $post_data['user_email'] , 
				'user_phonenumber'	=> $post_data['user_phonenumber'] , 
			);
			if (!empty($post_data['prev_user_pass']) && !empty($post_data['user_password']) && !empty($post_data['new_user_password_confirm'])) {
	            if (md5($post_data['prev_user_pass']) == $this->cur_userdata['user_password']) {
	                if ($post_data['user_password'] != $post_data['new_user_password_confirm']) {
	                    // confirm password uncorrect
	                    $retVal['success'] = FALSE;
	                    $retVal['message'] = '确认密码不正确';
						$this->session->set_userdata('POST_UPDATEUSER_RESULT_ALARM_MESSAGE' , $retVal);
						redirect('dashboard');
	                }
	                else {
	                    $update_data['user_password'] = md5($post_data['user_password']);
	                }
	            }
	            else { // previous password uncorrect
	                $retVal['success'] = FALSE;
	                $retVal['message'] = '旧密码不正确';
					$this->session->set_userdata('POST_UPDATEUSER_RESULT_ALARM_MESSAGE' , $retVal);
					redirect('dashboard');
	            }
			}

			$retVal['success'] = $this->dashboard->updateuser($this->cur_userdata , $update_data , $this->uploadpath_avatar_image);
			if ($retVal['success']) {
				$this->updateCurSession();
			}
			$this->session->set_userdata('POST_RESULT_ALARM_MESSAGE' , $retVal);
			redirect('dashboard');
		}
	}

	public function update_userpassword(){
		if ($this->input->post()) {
			$retVal = array();
			$post_data = $this->input->post();
			$cur_userdata = $this->get_loggedin_userdata();
            if (md5($post_data['prev_user_pass']) == $cur_userdata['user_password']) {
                if ($post_data['user_password'] != $post_data['new_user_password_confirm']) {
                    // confirm password uncorrect
                    $retVal['success'] = FALSE;
                    $retVal['message'] = '确认密码不正确';
                }
                else {
                    $retVal['success'] = $this->dashboard->tb_updatedata('tbl_account' , array('acc_id' => $cur_userdata['acc_id']) , array('user_password' => md5($post_data['user_password'])));
                    $retVal['message'] = '操作成功';
                }
            }
            else { // previous password uncorrect
                $retVal['success'] = FALSE;
                $retVal['message'] = '旧密码不正确';
            }
			if ($retVal['success']) {
				$this->updateCurSession();
			}

            echo json_encode($retVal);
		}
	}

	public function updateCurSession(){
		$cur_acc_id = $this->cur_userdata['acc_id'];
		if ($cur_acc_id > 0) {
			$record = $this->dashboard->get_singletbdata('tbl_account' , array('acc_id' => $cur_acc_id));
			if (count($record) > 0) {
				$record = $record[0];
			}
			if (!empty($record)) {
				$this->login->destroySession();
				$this->login->registerSession($record);
			}
		}
	}
}
