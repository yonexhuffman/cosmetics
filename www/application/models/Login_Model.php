<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login_Model extends CI_Model {
	public function __construct() {
		parent::__construct();
		
    }

    public function signin($criteria){
		$record = $this->db
			->from('tbl_account')
			->where('user_id' , $criteria['user_id'])
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
	}

	public function is_signin(){
		return $this->session->has_userdata('LOGGEDIN_BEVOL_USER_DATA');
	}

	public function get_loggedin_user_data(){
		return $this->session->userdata('LOGGEDIN_BEVOL_USER_DATA');
	}

	public function createaccount($insert_data){
		$this->db->insert('tbl_account' , $insert_data);
		return $this->db->insert_id();
	}

	public function email_exists($email)
	{
		$query = $this->db->from('tbl_account')
			->where('user_email', $email)
			->select('user_email', 'user_password')
			->get()
			->row_array(); 
	    if($query)   return TRUE;
	    else  return FALSE;
	}

	public function temp_reset_password($temp_pass){
	    $data =array(
            'user_email' =>$this->input->post('email'),
            'reset_pass'=>$temp_pass
        );
        
        $email = $data['user_email'];

	    if($data){
	        $this->db->where('user_email', $email);
	        $this->db->update('tbl_account', $data);  
	        return TRUE;
	    }else{
	        return FALSE;
	    }

	}

	public function is_temp_pass_valid($temp_pass){
	    $this->db->where('reset_pass', $temp_pass);
	    $query = $this->db->get('tbl_account');
	    if($query->num_rows() == 1){
	        return TRUE;
	    }
	    else return FALSE;
	}

	public function update_password($new, $reset_pass)
	{
		$data =array(
            'user_password'=>$new
        );
        if($data){
	        $this->db->where('reset_pass', $reset_pass);
	        $this->db->update('tbl_account', $data);  
	        return TRUE;
	    }else{
	        return FALSE;
	    }

	}

}