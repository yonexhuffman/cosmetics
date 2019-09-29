<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login_Model extends CI_Model {
	public function __construct() {
		parent::__construct();
		
    }

    public function signin($criteria){
		$record = $this->db
			->from('tbl_account')
			->where('user_id' , $criteria['user_id'])
			->where('user_role' , 'ADMIN')
			->where('is_valid' , 1)
			->get()
			->row_array();	
		$retVal = array(
			'login_status' => 0
		);
		if (!empty($record)) {
			if ($record['user_password'] == md5($criteria['user_password'])) {
				$retVal['login_status'] = 2;
				$retVal['user_data'] = $record;
			}
			else {
				$retVal['login_status'] = 1;
			}
		}
		return $retVal;
    }

	public function registerSession($user_data){
		$this->session->set_userdata('LOGGEDIN_BEVOL_USER_DATA' , $user_data);
	}

	public function destroySession(){
		$this->session->unset_userdata('LOGGEDIN_BEVOL_USER_DATA');
		// $this->session->sess_destroy();
	}

	public function is_signin(){
		return $this->session->has_userdata('LOGGEDIN_BEVOL_USER_DATA');
	}

	public function get_loggedin_user_data(){
		return $this->session->userdata('LOGGEDIN_BEVOL_USER_DATA');
	}

}