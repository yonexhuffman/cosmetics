<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . 'core/MY_AdminController.php');

class Datascrapping extends MY_AdminController {
	private $page_key = 1;
	private $bevolsearchpage_key = 12;
	private $statepage_key = 13;
	private $ultimatepage_key = 15;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/Datascrapping_Model' , 'datascrapping');
		$this->load->library('curl');
	}

	public function checkdistinct(){
		$this->datascrapping->checkdistinct();
	}

	public function index()	{
		// header data
		$this->header_data['page_key'] = $this->page_key;
		// view_data
		$view_data = array();
		$view_data['category_logs'] = $this->datascrapping->get_scrap_log('CATSCRAP');
		$view_data['product_logs'] = $this->datascrapping->get_scrap_log('PROSCRAP');
		$view_data['ingredient_logs'] = $this->datascrapping->get_scrap_log('INGSCRAP');
		// footer data
		$footer_data = array();
		$this->template->pageview('datascrapping/datascrapping_view' , 'datascrapping_js' , $this->header_data , $view_data , $footer_data , 'admin');	
	}

	public function scrape_category(){
		echo json_encode($this->datascrapping->scrape_category());
	}

	public function scrape_product(){
		if ($this->input->post('cat_id')) {
			echo json_encode($this->datascrapping->scrape_product($this->input->post('cat_id') , $this->uploadpath_product));
		}
	}

	public function scrape_ingredient(){
		$cat_id = $_REQUEST['cat_id'];
		$start = $_REQUEST['start'];
		$length = $_REQUEST['length'];
		$result_index = $_REQUEST['result_index'];
 		$product_whole_criteria = array(
 			'pro_cat_id'	=> $cat_id
 		);
		echo json_encode($this->datascrapping->scrape_ingredient($product_whole_criteria , $start , $length , $result_index));
	}

	public function newcategory() {
		// header data
		$this->header_data['page_key'] = $this->bevolsearchpage_key;
		// view_data
		$view_data = array();
		$view_data['product_logs'] = $this->datascrapping->get_scrap_log('PROSCRAP' , 2);
		$view_data['ingredient_logs'] = $this->datascrapping->get_scrap_log('INGSCRAP' , 2);

		// footer data
		$footer_data = array();
		$this->template->pageview('datascrapping/datascrappingnewcategory_view' , 'datascrappingnewcategory_js' , $this->header_data , $view_data , $footer_data , 'admin');	
	}

	public function scrape_newcategoryproduct(){
		$cat_new_id = $this->input->get('cat_new_id');
		echo json_encode($this->datascrapping->scrape_newcategoryproduct($cat_new_id , $this->uploadpath_product));
	}

	public function get_product_total_count(){
 		$criteria = array();
		if ($this->input->get('cat_id')) {
 			$criteria['pro_cat_id'] = $this->input->get('cat_id');
		}
		else {
 			$criteria['pro_cat_new_id'] = $this->input->get('cat_new_id');
		}
 		// $criteria['pro_ingredients'] = NULL;
		echo json_encode(array('productcount' => $this->datascrapping->tb_data_count('tbl_product' , $criteria)));
	}

	public function scrape_newcategoryingredient(){
		$cat_new_id = $_REQUEST['cat_new_id'];
		$start = $_REQUEST['start'];
		$length = $_REQUEST['length'];
		$result_index = $_REQUEST['result_index'];
 		$product_whole_criteria = array(
 			'pro_cat_new_id'	=> $cat_new_id , 
 			'pro_ingredients'	=> NULL , 
 		);
		echo json_encode($this->datascrapping->scrape_ingredient($product_whole_criteria , $start , $length , $result_index , 2));
	}

	public function statesite(){
		// header data
		$this->header_data['page_key'] = $this->statepage_key;
		// view_data
		$view_data = array();

		// footer data
		$footer_data = array();
		$this->template->pageview('datascrapping/datascrappingstate_view' , 'datascrappingstate_js' , $this->header_data , $view_data , $footer_data , 'admin');	
	}

	public function get_importedproduct_pagecount(){
		$cSession = curl_init(); 
		curl_setopt($cSession , CURLOPT_URL , INTERNATIONALSITEURL);
		curl_setopt($cSession , CURLOPT_POST , true);
		curl_setopt($cSession , CURLOPT_RETURNTRANSFER , true);
		curl_setopt($cSession , CURLOPT_HEADER , false); 
		$HTTP_HEADER_DATA = array(
			'Accept: application/json, text/javascript, */*; q=0.01' , 
			'Accept-Encoding: gzip, deflate' , 
			'Accept-Language: ko,en-US;q=0.9,en;q=0.8' , 
			'Connection: keep-alive' , 
			'Content-Type: application/x-www-form-urlencoded; charset=UTF-8' , 
			'Cookie: JSESSIONID=D51ADCAA09F995EA2E3D1E21542C7B2D' , 
			'Host: ' . IMPORTEDPRODUCT_HTTPHEADER_ORIGIN , 
			'Origin: http://' . IMPORTEDPRODUCT_HTTPHEADER_ORIGIN , 
			'Referer: ' . IMPORTEDPRODUCT_HTTPHEADER_REFERER , 
			'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36' , 
			'X-Requested-With: XMLHttpRequest' , 
		);
		curl_setopt($cSession , CURLOPT_HTTPHEADER , $HTTP_HEADER_DATA); 
		$result=curl_exec($cSession);
		curl_close($cSession);
		$data = json_decode($result);
		$this->output->set_content_type('application/json')->set_output($result);
	}

	public function scrapy_importedproduct_list(){
		$dataStartPageNum = $_REQUEST['dataStartPageNum'];
		$dataEndPageNum = $_REQUEST['dataEndPageNum'];
		$this->output->set_content_type('application/json')->set_output(json_encode($this->datascrapping->scrapy_importedproduct_list($dataStartPageNum , $dataEndPageNum)));		
	}

	public function get_scrapy_importedproduct_detail_count() {
		$criteria = array(
			'pro_bevol_url LIKE'	=> IMPORTEDPRODUCT_PROBEVOLURL_PREFIX . '%' , 
			'pro_ingredients'		=> NULL
		);
		echo json_encode(array('productcount' => $this->datascrapping->tb_data_count('tbl_product' , $criteria)));
	}

	public function scrapy_importedproduct_detail(){
		$start = $_REQUEST['start'];
		$length = $_REQUEST['length'];
		$result_index = $_REQUEST['result_index'];
 		$criteria = array(
			'pro_bevol_url LIKE'	=> IMPORTEDPRODUCT_PROBEVOLURL_PREFIX . '%' , 
			'pro_ingredients'		=> NULL
 		);
		$this->output->set_content_type('application/json')->set_output(json_encode($this->datascrapping->scrapy_importedproduct_detail($criteria , $start , $length , $result_index)));
	}

	public function get_domesticproduct_pagecount(){
		$cSession = curl_init(); 
		curl_setopt($cSession , CURLOPT_URL , DOMESTICSITEURL);
		curl_setopt($cSession , CURLOPT_POST , true);
		curl_setopt($cSession , CURLOPT_RETURNTRANSFER , true);
		curl_setopt($cSession , CURLOPT_HEADER , false); 
		$HTTP_HEADER_DATA = array(
			'Accept: application/json, text/javascript, */*; q=0.01' , 
			'Accept-Encoding: gzip, deflate' , 
			'Accept-Language: ko,en-US;q=0.9,en;q=0.8' , 
			'Connection: keep-alive' , 
			'Content-Type: application/x-www-form-urlencoded; charset=UTF-8' , 
			'Cookie: JSESSIONID=D51ADCAA09F995EA2E3D1E21542C7B2D' , 
			'Host: ' . DOMESTICPRODUCT_HTTPHEADER_ORIGIN , 
			'Origin: http://' . DOMESTICPRODUCT_HTTPHEADER_ORIGIN , 
			'Referer: ' . DOMESTICPRODUCT_HTTPHEADER_REFERER , 
			'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36' , 
			'X-Requested-With: XMLHttpRequest' , 
		);
		curl_setopt($cSession , CURLOPT_HTTPHEADER , $HTTP_HEADER_DATA); 
		$result=curl_exec($cSession);
		curl_close($cSession);
		$data = json_decode($result);
		$this->output->set_content_type('application/json')->set_output($result);
	}

	public function scrapy_domesticproduct_list(){
		$dataStartPageNum = $_REQUEST['dataStartPageNum'];
		$dataEndPageNum = $_REQUEST['dataEndPageNum'];
		$this->output->set_content_type('application/json')->set_output(json_encode($this->datascrapping->scrapy_domesticproduct_list($dataStartPageNum , $dataEndPageNum)));		
	}

	public function get_scrapy_domesticproduct_detail_count() {
		$criteria = array(
			'pro_bevol_url LIKE'	=> DOMESTICPRODUCT_PROBEVOLURL_PREFIX . '%' , 
			'pro_ingredients'		=> NULL
		);
		echo json_encode(array('productcount' => $this->datascrapping->tb_data_count('tbl_product' , $criteria)));
	}

	public function scrapy_domesticproduct_detail(){
		$start = $_REQUEST['start'];
		$length = $_REQUEST['length'];
		$result_index = $_REQUEST['result_index'];
 		$criteria = array(
			'pro_bevol_url LIKE'	=> DOMESTICPRODUCT_PROBEVOLURL_PREFIX . '%' , 
			'pro_ingredients'		=> NULL
 		);
		$this->output->set_content_type('application/json')->set_output(json_encode($this->datascrapping->scrapy_domesticproduct_detail($criteria , $start , $length , $result_index)));
	}

	public function ultimate(){
		// header data
		$this->header_data['page_key'] = $this->ultimatepage_key;
		// view_data
		$view_data = array();

		// footer data
		$footer_data = array();
		$this->template->pageview('datascrapping/datascrappingultimate_view' , 'datascrappingultimate_js' , $this->header_data , $view_data , $footer_data , 'admin');	
	}

	public function dailyscrap(){
		if ($this->input->post()) {
			$post_data = $this->input->post();
			$scrap_step = $post_data['scrap_step'];
			switch ($scrap_step) {
				case 1:
					$this->output->set_content_type('application/json')->set_output(json_encode($this->datascrapping->dailyscrap()));
					break;
				case 2:
					$this->output->set_content_type('application/json')->set_output(json_encode($this->datascrapping->dailyscrap($post_data['categorylist_index'] , $this->uploadpath_product , $scrap_step , $post_data['cat_new_id'] , $post_data['cat_sub_keyword'] , $post_data['end_page_number'])));
					break;
				case 3:
					$this->output->set_content_type('application/json')->set_output(json_encode($this->datascrapping->dailyscrap(0 , $this->uploadpath_product , $scrap_step)));
					break;
				case 4:
					$this->output->set_content_type('application/json')->set_output(json_encode($this->datascrapping->dailyscrap(0 , $this->uploadpath_product , $scrap_step)));
					break;
				
				default:
					$this->output->set_content_type('application/json')->set_output(json_encode($this->datascrapping->dailyscrap()));
					break;
			}
		}
	}

	public function ultimatescrap(){
		$result = $this->complexscrap($this->uploadpath_product);
		echo json_encode($result);
	}

	public function complexscrap(){
		$this->datascrapping->complexscrap($this->uploadpath_product);
	}

	// public function insert_endnums(){
	// 	$update_data = array(
	// 		'面部保养' , 
	// 		'卸妆' , 
	// 		'洁面' , 
	// 		'化妆水' , 
	// 		'乳液' , 
	// 		'面部精华' , 
	// 		'面膜' , 
	// 		'日霜' , 
	// 		'晚霜' , 
	// 		'防晒' , 
	// 		'喷雾' , 
	// 		'眼唇护理' , 
	// 		'眼霜' , 
	// 		'眼部精华' , 
	// 		'眼膜' , 
	// 		'润唇膏' , 
	// 		'唇部护理' , 
	// 		'唇妆' , 
	// 		'口红' , 
	// 		'唇膏' , 
	// 		'唇彩' , 
	// 		'唇线笔' , 
	// 		'眼眉妆' , 
	// 		'眼线笔' , 
	// 		'眼线液' , 
	// 		'眼线膏' , 
	// 		'眉笔' , 
	// 		'睫毛夹' , 
	// 		'假睫毛' , 
	// 		'眉粉' , 
	// 		'眉膏' , 
	// 		'睫毛膏' , 
	// 		'眼影' , 
	// 		'眼眉卸妆' , 
	// 		'脸部护理' , 
	// 		'妆前乳' , 
	// 		'隔离' , 
	// 		'BB霜' , 
	// 		'粉饼' , 
	// 		'粉底液' , 
	// 		'气垫' , 
	// 		'素颜霜' , 
	// 		'腮红' , 
	// 		'散粉' , 
	// 		'蜜粉' , 
	// 		'遮瑕' , 
	// 		'修颜' , 
	// 		'彩妆盘' , 
	// 		'手部美甲' , 
	// 		'指甲油' , 
	// 		'卸甲水' , 
	// 		'美甲贴' , 
	// 		'香水' , 
	// 		'女士香水' , 
	// 		'男士香水' , 
	// 		'中性香水' , 
	// 	);
	// 	foreach ($update_data as $key => $value) {
	// 		$this->datascrapping->tb_updatedata('tbl_scrap_endpagenums' , array('id' => ($key + 1)) , array('cat_sub_keyword' => $value));
	// 	}
	// 	var_dump($this->datascrapping->get_singletbdata('tbl_scrap_endpagenums'));
	// 	exit();
	// }
}