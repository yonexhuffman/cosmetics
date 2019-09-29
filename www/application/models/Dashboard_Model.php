<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_Model extends MY_Model {
	public function __construct() {
		parent::__construct();
		
    }

    public function get_blogs($acc_id , $limit = array() , $uploadpath_blog_image){
        $criteria = array(
            'blog.b_acc_id' => $acc_id , 
            'blog.b_comment_parent_id'  => 0
        );
        $total_blogcount = $this->tb_data_count('tbl_blog AS blog' , $criteria);
        if (($limit['start'] - 1) * $limit['length'] >= $total_blogcount && $limit['start'] > 1) {
            $limit['start'] --;
        }
        $blogs = $this->db->select('blog.b_id , blog.b_title , blog.b_tags , blog.b_content , blog.b_image , pro.pro_title')
            ->from('tbl_blog AS blog')
            ->join('tbl_product AS pro' , 'blog.b_pro_id = pro.pro_id' , 'left')
            ->where($criteria)
            ->limit($limit['length'] , ($limit['start'] - 1) * $limit['length'])
            ->get()
            ->result_array();
        foreach ($blogs as $key => $blog) {
            if (!empty($blog['b_image']) && file_exists($uploadpath_blog_image . $blog['b_image'])) {
                $blogs[$key]['b_content'] = '<p><img src="' . base_url($uploadpath_blog_image . $blog['b_image']) . '" class="pull-left" />' . $blog['b_content'] . '<div class="clearfix"></p></div>';
            }
        }
        $prev_page = -1;
        $next_page = -1;
        if ($limit['start'] > 1) {
            $prev_page = $limit['start'] - 1;
        }
        $total_page = intval($total_blogcount / $limit['length']);
        if (($total_blogcount % $limit['length']) > 0) {
            $total_page ++;
        }
        if ($limit['start'] < $total_page) {
            $next_page = $limit['start'] + 1;
        }
        if (empty($blogs)) {
            $limit['start'] = 0;
        }
        return array(
            'blog_list'  => $blogs ,
            'total_count'   => $total_blogcount , 
            'next_page'     => $next_page , 
            'prev_page'     => $prev_page , 
            'current_page'  => $limit['start'] , 
            'total_page'    => $total_page
        );
    }
    
    public function get_favoriteproduct($acc_id , $limit = array()){
    	$fav_pro_ids = $this->get_singletbdata('tbl_favorite_product' , array('acc_id' => $acc_id));
    	if (count($fav_pro_ids) > 0) {
    		$fav_pro_ids = $fav_pro_ids[0];
            if (!empty($fav_pro_ids['fav_pro_ids'])) {
                $pro_ids = explode(',' , $fav_pro_ids['fav_pro_ids']);
            }
            else {
                $pro_ids = array();
            }
    		$total_favcount = count($pro_ids);
            if (($limit['start'] - 1) * $limit['length'] >= $total_favcount && $limit['start'] > 1) {
                $limit['start'] --;
            }
    		$pro_ids = array_slice($pro_ids , ($limit['start'] - 1) * $limit['length'] , $limit['length']);
    		$prev_page = -1;
    		$next_page = -1;
    		if ($limit['start'] > 1) {
    			$prev_page = $limit['start'] - 1;
    		}
    		$total_page = intval($total_favcount / $limit['length']);
    		if (($total_favcount % $limit['length']) > 0) {
    			$total_page ++;
    		}
    		if ($limit['start'] < $total_page) {
    			$next_page = $limit['start'] + 1;
    		}
            $product_list = array();
            if (!empty($pro_ids)) {
                $product_list = $this->db->select('pro_id , pro_title')
                    ->from('tbl_product');
                foreach ($pro_ids as $key => $pro_id) {
                    $product_list = $product_list->or_where('pro_id' , $pro_id);
                }
                $product_list = $product_list->get()->result_array();
            }
            else {
                $limit['start'] = 0;
            }
    		return array(
    			'product_list'	=> $product_list ,
    			'total_count'	=> $total_favcount , 
    			'next_page'		=> $next_page , 
    			'prev_page'		=> $prev_page , 
    			'current_page'	=> $limit['start'] , 
    			'total_page'	=> $total_page
    		);
    	}
    	return array();
    }

    public function deletefavoriteproduct($acc_id , $pro_id){
    	$fav_pro_ids = $this->get_singletbdata('tbl_favorite_product' , array('acc_id' => $acc_id));
    	if (count($fav_pro_ids) > 0) {
    		$fav_pro_ids = $fav_pro_ids[0];
    		$pro_ids = explode(',' , $fav_pro_ids['fav_pro_ids']);
    		$search_key = array_search($pro_id , $pro_ids);
    		if ($search_key >= 0) {
    			unset($pro_ids[$search_key]);
    		}

            $fav_pro_ids_str = implode(',' , $pro_ids);
            return $this->tb_updatedata('tbl_favorite_product' , array('fav_id' => $fav_pro_ids['fav_id']) , array('fav_pro_ids' => $fav_pro_ids_str));
    	}
    	return FALSE;
    }

    // public function deleteblog($b_id){
    //     $criteria = array(
    //         'b_id'  => $b_id , 
    //         'b_comment_parent_id'   => $b_id
    //     );
    //     return $this->db->or_where($criteria)->delete('tbl_blog');
    // }

    public function updateuser($cur_userdata , $update_userdata , $photo_path){
        if (!empty($_FILES['acc_image']['name'])) {
            if (!empty($cur_userdata['acc_image'])) {
                $del_result = $this->delete_file($photo_path . $cur_userdata['acc_image']);
                if ($del_result) {
                    $update_userdata['acc_image'] = '';
                }
            }
            $upload_image_name = $cur_userdata['acc_id'] . random_string('alnum', 16);
            $upload_result = $this->file_upload($photo_path , 'acc_image' , $upload_image_name);
            if ($upload_result) {
                $update_userdata['acc_image'] = $upload_result['file_name'];
                    
                $this->load->library('image_lib');
                $config = array();
                $config['source_image'] = $photo_path . $update_userdata['acc_image'];
                $config['width']    = DEFAULTIMGWIDTH;
                $config['height']   = DEFAULTIMGWIDTH;
                $config['maintain_ratio']   = FALSE;
                $config['quality']  = '100%';
                $this->image_lib->initialize($config);
                $this->image_lib->resize();
            }
        }
        return $this->tb_updatedata('tbl_account' , array('acc_id' => $cur_userdata['acc_id']) , $update_userdata);
    }

}