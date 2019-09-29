<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ingredient_Model extends MY_Model {
	public function __construct() {
		parent::__construct();
		
    }
    
    public function get_ingredient_list($where = array() , $order = '' , $limit = array()){
    	$retVal = $this->db->select('*')
    		->from('tbl_ingredient')
    		->where($where)
    		->order_by($order);
    	if (!empty($limit)) {
    		$retVal = $retVal->limit($limit['length'] , $limit['start']);
    	}
    	$retVal = $retVal->get()->result_array();
    	return $retVal;
    }

    public function get_ingredientproducts($ing_id) {
        $where = array(
            'pro_ingredients LIKE ' => '%,' . $ing_id . ',%'
        );
        $retVal = $this->db->select('*')
            ->from('tbl_product')
            ->where($where)
            ->order_by('pro_title ASC')
            ->limit(LOADDATAPERPAGE)
            ->get()
            ->result_array();
        return $retVal;        
    }

    public function getMoreData($ing_id , $blog_last_id , $avatar_upload_path){
        $blog_list = $this->db->select('tbl_blog_ingredient.* , tbl_account.acc_image , tbl_account.user_id')
            ->from('tbl_blog_ingredient')
            ->join('tbl_account' , 'tbl_account.acc_id = tbl_blog_ingredient.b_acc_id' , 'left')
            ->where('b_ing_id' , $ing_id)
            ->where('b_comment_parent_id' , 0)
            ->where('b_id > ' , $blog_last_id)
            ->order_by('b_id' , 'ASC')
            ->limit(LOADDATAPERPAGE)
            ->get()
            ->result_array();
        foreach ($blog_list as $key => $blog) {
            $blog_list[$key]['commentHtml'] = '';
            $blog_comments = $this->db->select('tbl_blog_ingredient.* , tbl_account.acc_image , tbl_account.user_id')
                ->from('tbl_blog_ingredient')
                ->join('tbl_account' , 'tbl_account.acc_id = tbl_blog_ingredient.b_acc_id' , 'left')
                ->where('b_ing_id' , $blog['b_ing_id'])
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

    public function loadBlogMoreData($ing_id , $blog_last_id , $login_status , $avatar_upload_path) {
        $blog_list = $this->getMoreData($ing_id , $blog_last_id , $avatar_upload_path);
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

}