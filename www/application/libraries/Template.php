<?php defined('BASEPATH') OR exit('No direct script access allowed');

class template {
	protected $CI;

	public function __construct() {
		// Assign the CodeIgniter super-object
		$this->CI =& get_instance();
	}

	public function pageview($view_page_name , $js_page_name , $header_data = array() , $view_data = array() , $footer_data = array() , $path = '') {		
		// IMPORT CORE CSS 
		$this->CI->load->view($path . '/' . 'common/header' , $header_data);
		
		// SIDEBAR
		$this->CI->load->view($path . '/' . 'common/sidebar' , $header_data);
		// // MAIN PAGE VIEW
		// $this->CI->load->view($path . '/' . $page_name . '/' . $page_name . '_view' , $view_data);
		$this->CI->load->view($path . '/' . $view_page_name , $view_data);
		
		// IMPORT PLUGIN JS
		$this->CI->load->view($path . '/' . 'common/footer' ,  $footer_data);
		// CUSTOMIZING PAGE JS
		// $this->CI->load->view($path . '/pagescripts/' . $page_name . '_js' ,  $footer_data);
		$this->CI->load->view($path . '/pagescripts/' . $js_page_name ,  $footer_data);
		$this->CI->load->view($path . '/' . 'common/html_footer');
	}
}
