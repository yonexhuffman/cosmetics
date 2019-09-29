<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_BaseController extends CI_Controller {
	public $uploadpath_product = "./uploads/product/";
	public $uploadpath_shoppingcategory_image = "./uploads/shoppingcategory/";	
	public $uploadpath_blog_image = "./uploads/blog/";	
	public $uploadpath_company_image = "./uploads/companyimages/";	
	public $uploadpath_avatar_image = "./uploads/avatars/";	
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('MY_Model' , 'basemodel');
		// date_default_timezone_set('Asia/Shanghai');
	}	

	public function file_exist($filepathname){
		return $this->basemodel->file_exist($filepathname);
	}
	
}