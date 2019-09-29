<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . 'core/MY_BaseController.php');

class MY_AdminController extends MY_BaseController {
	public $header_data = array();
	
	public function __construct()
	{
		parent::__construct();
		$LOGGEDIN_USER_DATA = $this->basemodel->getLoggedUserData();
		if (!$LOGGEDIN_USER_DATA && $LOGGEDIN_USER_DATA['user_role'] != 'ADMIN') {
			redirect('/admin/login');
		}		
		else {
			$this->header_data['cur_userdata']		= $LOGGEDIN_USER_DATA;
			$this->config->load('custom/admin/base_config');	

			$menu = $this->config->item('menu');
			$this->header_data['menu'] = $menu;
		}
 		ini_set('max_execution_time', -1);
 		ini_set('memory_limit', '4096M');
	}	
	
}