<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . 'core/MY_UserController.php');

class Ingredient extends MY_UserController {
	private $page_key = 4;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Ingredient_Model' , 'ingredient');
	}

	public function index()	{	
		$this->header_data['page_key'] = $this->page_key;
		$this->header_data['plugin_css'] = array(
			'rateit/src/rateit.css' , 
		);

		$view_data = array();
		$criteria = array();
		$order = 'ing_id ASC';
		$limit = array(
			'length' => LOADDATAPERPAGE , 
			'start' => 0
		);
		if ($this->input->get('per_page')) {
			$limit['start'] = $this->input->get('per_page');
		}

		if ($this->input->get('keyword')) {
			$view_data['keyword'] = $this->input->get('keyword');
			$criteria = ' ing_name LIKE "%' . $this->input->get('keyword') . '%" OR ing_csano LIKE "%' . $this->input->get('keyword') . '%" OR ing_alias LIKE "%' . $this->input->get('keyword') . '%" OR ing_remark LIKE "%' . $this->input->get('keyword') . '%" ';
		}
		$view_data['ingredient_total_count'] = $this->ingredient->tb_data_count('tbl_ingredient' , $criteria);
		$view_data['ingredient_list'] = $this->ingredient->get_ingredient_list($criteria , $order , $limit);
		
		// footer data
		$footer_data = array();
		$footer_data['plugin_js'] = array(
			'rateit/src/jquery.rateit.js' , 
		);

		$this->template->pageview('ingredient/ingredient_view' , 'ingredient_js' , $this->header_data , $view_data , $footer_data);
	}

	public function loadMoreData(){
		$post_data = $this->input->get();
		$criteria = array();
		$order = 'ing_id ASC';
		$limit = array(
			'length' => LOADDATAPERPAGE , 
			'start' => $post_data['page_offset_num']
		);

		$condition = array();
		if (!empty($post_data['keyword'])) {
			$criteria = ' ing_name LIKE "%' . $post_data['keyword'] . '%" OR ing_csano LIKE "%' . $post_data['keyword'] . '%" ';
		}

		$data = $this->ingredient->get_ingredient_list($criteria , $order , $limit);

		$datacount = count($data);
		$page_offset_num = $post_data['page_offset_num'] + count($data);
		$retHtml = '';
		$i = $post_data['page_offset_num'] + 1;

        foreach ($data as $key => $ingredient) {
            if (empty($ingredient['ing_name'])) {
                continue;
            }
            $security_risk_output = '';
            if (!empty($ingredient['ing_security_risk'])) {
                $security_risk = explode('-', $ingredient['ing_security_risk']);
                $max = intval($security_risk[count($security_risk) - 1]);
                if ($max > 7) {
                    $security_risk_output = '<span class="label label-danger security_risk_label">' . $ingredient['ing_security_risk'] . '</span>';
                }
                else if ($max < 8 && $max >= 3) {
                    $security_risk_output = '<span class="label label-warning security_risk_label">' . $ingredient['ing_security_risk'] . '</span>';
                }
                else {
                    $security_risk_output = '<span class="label label-primary security_risk_label">' . $ingredient['ing_security_risk'] . '</span>';
                }
            }
            $security_risk_output = !empty($security_risk_output) ? '<p>安全风险 : ' . $security_risk_output . '</p>' : '&nbsp;';
            $ing_usage_purpose_output = !empty($ingredient['ing_usage_purpose']) ? '<p>使用目的 : ' . $ingredient['ing_usage_purpose'] . '</p>' : '&nbsp;';
            $retHtml .= '
            <li class="product_item">
                <a href="' . site_url('ingredient/item?ing_id=' . $ingredient['ing_id']) . '">
                    <div class="row">
                        <div class="col-sm-5 col-md-5">
                            <p>' . $ingredient['ing_name'] . '</p>
                        </div>
                        <div class="col-sm-2 col-md-2">
                            ' . $security_risk_output . '
                        </div>
                        <div class="col-sm-5 col-md-5">
                            ' . $ing_usage_purpose_output . '
                        </div>
                    </div>
                </a>
            </li>';
            $i ++;
        }
		$retVal = array(
			'datacount'	=> $datacount , 
			'page_offset_num'	=> $page_offset_num , 
			'html'	=> $retHtml
		);
		echo json_encode($retVal);
	}

	public function item(){
		if ($this->input->get('ing_id')) {
			$ing_id = $this->input->get('ing_id');
			$this->header_data['page_key'] = $this->page_key;
			$this->header_data['plugin_css'] = array(
				'rateit/src/rateit.css' , 
				'jquery-file-upload/css/jquery.fileupload.css' , 
			);

			$view_data = array();
			$view_data['ing_id'] = $ing_id;
			$criteria = array('ing_id' => $ing_id);
			$ingredient = $this->ingredient->get_ingredient_list($criteria);
			if (count($ingredient) > 0) {
				$view_data['ingredient'] = $ingredient[0];
			}			
			$view_data['ing_products'] = $this->ingredient->get_ingredientproducts($ing_id);
			$login_info = $this->get_loggedin_userdata();
			if (empty($login_info)) {
				$view_data['login_status'] = FALSE;
			}
			else {
				$view_data['login_status'] = TRUE;
			}
			
			if ($this->session->has_userdata('POST_RESULT_ALARM_MESSAGE')) {
				$view_data['post_result_alarm_message'] = $this->session->userdata('POST_RESULT_ALARM_MESSAGE');
				$this->session->unset_userdata('POST_RESULT_ALARM_MESSAGE');
			}
			// footer data
			$footer_data = array();
			$footer_data['plugin_js'] = array(
				'rateit/src/jquery.rateit.js' , 
			);

			$this->template->pageview('ingredient/ingredientitem_view' , 'ingredientitem_js' , $this->header_data , $view_data , $footer_data);
		}
		else {
			redirect('ingredient');
		}
	}

	public function savecomment(){
		$login_info = $this->get_loggedin_userdata();
		if (!empty($login_info)) {
			$post_data = $this->input->post();
			$acc_id = $login_info['acc_id'];
			$insert_data = array(
				'b_ing_id'	=> $post_data['ing_id'] , 
				'b_acc_id'	=> $acc_id , 
				'b_comment_parent_id'	=> $post_data['b_id'] , 
			);
			if (isset($post_data['b_user_rate'])) {
				$insert_data['b_user_rate'] = $post_data['b_user_rate'];
			}
            $upload_image_name = random_string('alnum', 16);
	        $upload_result = $this->ingredient->file_upload($this->uploadpath_blog_image , 'comment_image' , $upload_image_name);
	        $uploaded_filename = '';
	        if ($upload_result['success']) {
	        	$insert_data['b_image'] = $upload_result['file_name'];	        	
	        }	
	        $insert_data['b_content'] = nl2br($post_data['b_content'], FALSE);
	        
			$insert_status = $this->ingredient->tb_insertdata('tbl_blog_ingredient' , $insert_data);
			$this->session->set_userdata('POST_RESULT_ALARM_MESSAGE' , $insert_status);
				
			redirect('ingredient/item?ing_id=' . $post_data['ing_id']);
		}
	}

	public function loadBlogMoreData(){
		if ($this->input->post()) {
			$post_data = $this->input->post();
        	$login_info = $this->get_loggedin_userdata();
        	if (!empty($login_info)) {
        		$login_status = TRUE;
        	}
        	else {
        		$login_status = FALSE;
        	}
			$retVal = $this->ingredient->loadBlogMoreData($post_data['ing_id'] , $post_data['blog_last_id'] , $login_status , $this->uploadpath_avatar_image);
			echo json_encode($retVal);
		}
	}

	public function leavecomment(){
		$b_id = $this->input->get('b_id');
		$ing_id = $this->input->get('ing_id');
		$this->load->view('ingredient/leavecomment_view' , array('b_id' => $b_id , 'ing_id' => $ing_id));
	}

}
