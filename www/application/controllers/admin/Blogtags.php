<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . 'core/MY_AdminController.php');

class Blogtags extends MY_AdminController {
	private $page_key = 7;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/Blogtags_Model' , 'blogtags');
	}

	public function index()	{
		
		$this->header_data['page_key'] = $this->page_key;
		$view_data = array();
		$view_data['data'] = $this->blogtags->get_data();
		$view_data['img_path'] = $this->uploadpath_shoppingcategory_image;
		if ($this->session->has_userdata('POST_RESULT_ALARM_MESSAGE')) {
			$view_data['post_result_alarm_message'] = $this->session->userdata('POST_RESULT_ALARM_MESSAGE');
			$this->session->unset_userdata('POST_RESULT_ALARM_MESSAGE');
		}

		// footer data
		$footer_data = array();
		$footer_data['plugin_js'] = array(
			'bootbox/bootbox.min.js' , 
			'jquery-validation/js/jquery.validate.min.js' , 
		);

		$this->template->pageview('blogtags/blogtags_view' , 'blogtags_js' , $this->header_data , $view_data , $footer_data , 'admin');
	}

	public function insert(){
		if ($this->input->post()) {
			$post_result = $this->blogtags->insert($this->input->post() , $this->uploadpath_shoppingcategory_image);
			$this->session->set_userdata('POST_RESULT_ALARM_MESSAGE' , $post_result);
		}
		redirect('admin/blogtags');
	}

	public function delete(){
		if ($this->input->post('tag_id')) {
			$result = TRUE;
			$result = $result && $this->blogtags->tb_deletedata('tbl_blog_tags' , array('tag_id' => $this->input->post('tag_id')));
			echo json_encode(array('success' => $result));
		}
	}

}
