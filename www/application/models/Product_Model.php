<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Product_Model extends MY_Model {
	public function __construct() {
		parent::__construct();
		
    }
    
    public function get_product_list($where = array() , $order = '' , $limit = array()){
        if (empty($where)) $where['pro_image !='] = NULL;
    	$retVal = $this->db->select('*')
    		->from('tbl_product')
    		->where($where)
    		->order_by($order);
    	if (!empty($limit)) {
    		$retVal = $retVal->limit($limit['length'] , $limit['start']);
    	}
    	$retVal = $retVal->get()->result_array();
    	return $retVal;
    }

    public function get_companyrankinglist($limit = array()){
        $company_query = $this->db->select('*')
            ->from('tbl_companys')
            ->order_by('ranking_number' , 'ASC');
        if (!empty($limit)) {
            $company_query = $company_query->limit($limit['length'] , $limit['start']);
        }
        $company_list = $company_query->get()->result_array();

        return $company_list;
    }   

    public function get_product_item($pro_id) {
        $retVal = array();
        $query = $this->db->select('*')
            ->from('tbl_product')
            ->where('pro_id' , $pro_id)
            ->get()
            ->row_array();
        if (!empty($query)) {
            $pro_eff_ing_ids = explode(',' , $query['pro_efficacy_ingredients']);
            $pro_eff_ing_ids = array_slice(array_slice($pro_eff_ing_ids, 1), 0 , count($pro_eff_ing_ids) - 2);
            $query['pro_efficacy_ingredients'] = $pro_eff_ing_ids;
            $retVal['detail'] = $query;
            $pro_ing_ids = explode(',' , $query['pro_ingredients']);
            $pro_ing_ids = array_slice(array_slice($pro_ing_ids, 1), 0 , count($pro_ing_ids) - 2);
            $pro_ingredients = array();
            // error
            $retVal['pro_ingredients'] = array();
            if (!empty($pro_ing_ids)) {
                $ing_query = $this->db->select('ing_id , ing_name , ing_security_risk , ing_active , ing_acne_risk , ing_usage_purpose , ing_flavor , ing_preservation , ing_pregantcaution , ing_cleansing , ing_aminoacid , ing_sls_sles')->from('tbl_ingredient');
                foreach ($pro_ing_ids as $key => $ing) {
                    $ing_query = $ing_query->or_where('ing_id' , $ing);
                }
                $pro_ingredients = $ing_query->get()->result_array();
            }

            $good_state_img = '<img src="' . base_url(ING_GOOD_STATE_IMGURL) . '">';
            $warning_state_img = '<img src="' . base_url(ING_WARNING_STATE_IMGURL) . '">';

            $retVal['flavor_data'] = array();
            $retVal['preservation_data'] = array();
            $retVal['pregantcaution_data'] = array();
            $retVal['risk_data'] = array();

            $retVal['moisturizer_data'] = array();
            $retVal['antioxidants_data'] = array();
            $retVal['whitening_data'] = array();

            $retVal['cleansing_data'] = array();
            $retVal['aminoacid_data'] = array();
            $retVal['sls_sles_data'] = array();

            foreach ($pro_ingredients as $key => $ing_item) {
                $ing_security_risk_str = '';
                $ing_security_risks = explode('-', $ing_item['ing_security_risk']);
                $max_risk_value = '';
                if (count($ing_security_risks) > 0) {
                    $max_risk_value = $ing_security_risks[count($ing_security_risks) - 1];
                    if ($max_risk_value > 6) {
                        $ing_security_risk_str = '<span class="label label-danger security_risk_label">' . $ing_item['ing_security_risk'] . '</span>';
                    }                       
                    else if ($max_risk_value < 7 && $max_risk_value >= 3) {
                        $ing_security_risk_str = '<span class="label label-warning security_risk_label ">' . $ing_item['ing_security_risk'] . '</span>';
                    }
                    else {
                        $ing_security_risk_str = '<span class="label label-primary security_risk_label ">' . $ing_item['ing_security_risk'] . '</span>';
                    }
                }
                $ing_active_str = $ing_item['ing_active'] == 1 ? $good_state_img : '';
                $ing_acne_risk_str = $ing_item['ing_acne_risk'] == 1 ? $warning_state_img : '';

                $new_ing_item = array_merge($ing_item , array(
                    'ing_active_str'        => $ing_active_str , 
                    'ing_acne_risk_str'     => $ing_acne_risk_str , 
                    'ing_security_risk_str' => $ing_security_risk_str , 
                ));
                $retVal['pro_ingredients'][$ing_item['ing_id']] = $new_ing_item;
                if ($ing_item['ing_flavor'] == 1) {
                    $retVal['flavor_data'][$key] = $new_ing_item['ing_id'];
                }
                if ($ing_item['ing_preservation'] == 1) {
                    $retVal['preservation_data'][$key] = $new_ing_item['ing_id'];
                }
                if ($ing_item['ing_pregantcaution'] == 1) {
                    $retVal['pregantcaution_data'][$key] = $new_ing_item['ing_id'];
                }
                if ($max_risk_value >= 7) {
                    $retVal['risk_data'][$key] = $new_ing_item['ing_id'];
                }

                if (mb_strpos($new_ing_item['ing_usage_purpose'] , MOISTURIZER_SEARCHKEY) != FALSE) {
                    $retVal['moisturizer_data'][$key] = $new_ing_item['ing_id'];
                }
                if (mb_strpos($new_ing_item['ing_usage_purpose'] , ANTIOXIDANTS_SEARCHKEY) != FALSE) {
                    $retVal['antioxidants_data'][$key] = $new_ing_item['ing_id'];
                }
                if (mb_strpos($new_ing_item['ing_usage_purpose'] , WHITENING_SEARCHKEY) != FALSE) {
                    $retVal['whitening_data'][$key] = $new_ing_item['ing_id'];
                }

                if ($ing_item['ing_cleansing'] == 1) {
                    $retVal['cleansing_data'][$key] = $new_ing_item['ing_id'];
                }
                if ($ing_item['ing_aminoacid'] == 1) {
                    $retVal['aminoacid_data'][$key] = $new_ing_item['ing_id'];
                }
                if ($ing_item['ing_sls_sles'] == 1) {
                    $retVal['sls_sles_data'][$key] = $new_ing_item['ing_id'];
                }
            }
        }

        return $retVal;
    }

    public function get_product_sellers($pro_id) {
        return $this->db->select('*')
            ->from('tbl_product_sellers')
            ->join('tbl_shoppingcategory' , 'tbl_shoppingcategory.shop_cat_id = tbl_product_sellers.shop_cat_id' , 'left')
            ->where('tbl_product_sellers.pro_id' , $pro_id)
            ->order_by('tbl_product_sellers.seller_id' , 'ASC')
            ->get()
            ->result_array();
    }

    public function getMoreData($pro_id , $blog_last_id , $avatar_upload_path){
        $blog_list = $this->db->select('tbl_blog.* , tbl_account.acc_image , tbl_account.user_id')
            ->from('tbl_blog')
            ->join('tbl_account' , 'tbl_account.acc_id = tbl_blog.b_acc_id' , 'left')
            ->where('b_pro_id' , $pro_id)
            ->where('b_comment_parent_id' , 0)
            ->where('b_id > ' , $blog_last_id)
            ->order_by('b_id' , 'ASC')
            ->limit(LOADDATAPERPAGE)
            ->get()
            ->result_array();
        foreach ($blog_list as $key => $blog) {
            $blog_list[$key]['commentHtml'] = '';
            $blog_comments = $this->db->select('tbl_blog.* , tbl_account.acc_image , tbl_account.user_id')
                ->from('tbl_blog')
                ->join('tbl_account' , 'tbl_account.acc_id = tbl_blog.b_acc_id' , 'left')
                ->where('b_pro_id' , $blog['b_pro_id'])
                ->where('b_comment_parent_id' , $blog['b_id'])
                ->order_by('b_id' , 'DESC')
                ->get()
                ->result_array();
            $comment_array = array();
            foreach ($blog_comments as $commentkey => $comment) {
                $avatar_image = base_url(DEFAULT_AVATAR_IMGURL);
                if (!empty($comment['acc_image']) && file_exists($avatar_upload_path . $comment['acc_image'])) {
                    $avatar_image = base_url($avatar_upload_path . $comment['acc_image']);
                }
                if (!empty($comment['b_image']) && file_exists($this->uploadpath_blog_image . $comment['b_image'])) {
                    $comment['b_content'] = '<p><img src="' . base_url($this->uploadpath_blog_image . $comment['b_image']) . '" class="pull-left" />' . $comment['b_content'] . '<div class="clearfix"></p></div>';
                }
                $comment_array[] = '
                    <div class="blog-comment">
                        <div class="xxs-info-content">
                            <div class="xxs-info-title">
                                <div class="xxs-info-title-img">
                                    <img src="' . $avatar_image . '" class="img-circle">
                                </div>
                                <div class="xxs-info-title-main">
                                    <p class="p1">' . $comment['user_id'] . '</p>
                                </div>
                                <div class="clear"></div>
                            </div>
                            <div class="xxs-info-content">' . $comment['b_content'] . '</div>
                        </div>
                    </div>
                ';
            }
            $commentHtml = implode(' ', $comment_array);
            $blog_list[$key]['commentHtml'] = $commentHtml;
        }
        return $blog_list;
    }

    public function loadBlogMoreData($pro_id , $blog_last_id , $login_status , $avatar_upload_path) {
        $blog_list = $this->getMoreData($pro_id , $blog_last_id , $avatar_upload_path);
        $retHtml = '';
        foreach ($blog_list as $key => $blog) {
            $btn_comment_html = '';
            if ($login_status) {
                $btn_comment_html = '
                        <div class="row margin-top">
                            <div class="col-md-12 text-right">
                                <a class="btn cosmetic-btn"  id="comment_btn" b_id="' . $blog['b_id'] . '">回复</a>
                            </div>
                        </div>';
            }
            $avatar_image = base_url(DEFAULT_AVATAR_IMGURL);
            if (!empty($blog['acc_image']) && file_exists($avatar_upload_path . $blog['acc_image'])) {
                $avatar_image = base_url($avatar_upload_path . $blog['acc_image']);
            }
            if (!empty($blog['b_image']) && file_exists($this->uploadpath_blog_image . $blog['b_image'])) {
                $blog['b_content'] = '<p><img src="' . base_url($this->uploadpath_blog_image . $blog['b_image']) . '" class="pull-left" />' . $blog['b_content'] . '<div class="clearfix"></p></div>';
            }
            $retHtml .= '
                <div class="xxs-info-box line" blog-id="' . $blog['b_id'] . '">
                    <div class="xxs-info-title">
                        <div class="xxs-info-title-img">
                            <img src="' . $avatar_image . '" class="img-circle">
                        </div>
                        <div class="xxs-info-title-main">
                            <p class="p1">' . $blog['user_id'] . '</p>
                            <!-- <div class="p2">' . $blog['b_tags'] . '</div> -->
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="xxs-info-content">' . $blog['b_content'] . '</div>
                    <input type="range" value="'. $blog['b_user_rate'] .'" step="0.25" id="backing_' . $blog['b_id'] . '">
                    <div class="rateit" data-rateit-readonly="true" data-rateit-backingfld="#backing_' . $blog['b_id'] . '" data-rateit-resetable="false"  data-rateit-ispreset="true" data-rateit-min="0" data-rateit-max="5"></div>
                    ' . $blog['commentHtml'] . $btn_comment_html . '
                </div>';
        }

        if (count($blog_list) < LOADDATAPERPAGE) {
            $blog_last_id = -1;
        }
        else {
            $blog_last_id = $blog_list[count($blog_list) - 1]['b_id'];
        }
        return array(
            'html'  => $retHtml , 
            'blog_last_id'  => $blog_last_id
        );
    }

    public function addToFavorite($pro_id , $acc_id){
        $cur_data = $this->get_singletbdata('tbl_favorite_product' , array('acc_id' => $acc_id) , '*');
        if (count($cur_data) > 0) {
            $cur_data = $cur_data[0];
            $buffer = explode(',' , $cur_data['fav_pro_ids']);
            if (!in_array($pro_id , $buffer)) {
                $buffer[] = $pro_id;
            }
            $fav_pro_ids_str = implode(',' , $buffer);
            return $this->tb_updatedata('tbl_favorite_product' , array('fav_id' => $cur_data['fav_id']) , array('fav_pro_ids' => $fav_pro_ids_str));
        }
        else {
            $res = $this->tb_insertdata('tbl_favorite_product' , array('acc_id' => $acc_id , 'fav_pro_ids' => $pro_id));
            return $res['success'];
        }
    }

    public function GetTopCategories()
    {
        $criteria = array(
            'cat_new_parent_id' => 0 , 
            'is_delete'         => 0
        );
        $topCategories = $this->get_singletbdata('tbl_category_new' , $criteria);
        return $topCategories;
    }

    public function GetTopAndSubCategories($cat_id)
    {
        $curCriteria = array(
            'cat_new_id' => $cat_id , 
            'is_delete'         => 0
        );
        $currentCategory = $this->get_singletbdata('tbl_category_new' , $curCriteria)[0];
        $cat_new_parent_id = $currentCategory['cat_new_parent_id'];
        if ($currentCategory['cat_new_parent_id'] == 0) $cat_new_parent_id = $cat_id;
        $subCriteria = array(
            'cat_new_parent_id' => $cat_new_parent_id, 
            'is_delete'         => 0
        );
        $subCategories = $this->get_singletbdata('tbl_category_new' , $subCriteria);
        $result = array('top_id' => $cat_new_parent_id, 
                        'subCategories' => $subCategories);
        return $result;
    }


}