<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . 'core/MY_UserController.php');

class Search extends MY_UserController {
	private $page_key = 1;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Search_Model' , 'search');
	}

	public function index()	{	
		$this->header_data['page_key'] = $this->page_key;
		$this->header_data['plugin_css'] = array(
			'carousel-owl-carousel/owl-carousel/owl.carousel.css' , 
			'slider-layer-slider/css/layerslider.css' , 
			'../../frontend/pages/css/style-layer-slider.css'
		);
		$view_data = array();
		$view_data['fav_keys'] = $this->config->item('favkey');
		$view_data['product_total_count'] = $this->search->tb_data_count('tbl_product');
		shuffle($view_data['fav_keys']);
		$view_data['fav_cat'] = $this->search->get_fav_category();
		// footer data
		$footer_data = array();
		$footer_data['plugin_js'] = array(
			'carousel-owl-carousel/owl-carousel/owl.carousel.min.js' , 
			'slider-layer-slider/js/greensock.js' , 
			'slider-layer-slider/js/layerslider.transitions.js' , 
			'slider-layer-slider/js/layerslider.kreaturamedia.jquery.js' , 			
			'../../frontend/pages/scripts/layerslider-init.js'
		);

		$this->template->pageview('search/search_view' , 'search_js' , $this->header_data , $view_data , $footer_data);
	}

}
