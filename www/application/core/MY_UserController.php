<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . 'core/MY_BaseController.php');

class MY_UserController extends MY_BaseController {
	public $header_data = array();
	public $cur_userdata = NULL;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('MY_Model' , 'basemodel');

		$this->config->load('custom/user/frontend_config');	

		$menu = $this->config->item('menu');
		$this->header_data['menu'] = $menu;
		$this->cur_userdata = $this->get_loggedin_userdata();
		$this->header_data['LOGINSTATUS'] = FALSE;
		if (!empty($this->cur_userdata)) {
			$this->header_data['LOGINSTATUS'] = TRUE;
		}
	}	
	
	public function get_loggedin_userdata(){
		$LOGGEDIN_USER_DATA = $this->basemodel->getLoggedUserData();
		return $LOGGEDIN_USER_DATA;
	}
}