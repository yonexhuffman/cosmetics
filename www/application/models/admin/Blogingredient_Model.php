<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Blogingredient_Model extends MY_Model {
	
    public function __construct() {
		parent::__construct();
		
    }

    public function get_ingredient_data($ing_id){
        return $this->db->select('*')
            ->from('tbl_ingredient')
            ->where('tbl_ingredient.ing_id' , $ing_id)
            ->get()
            ->row_array();
    }

    public function get_blogs($criteria = array() , $order = array() , $limit = array()){
        $blog_count_tb = "SELECT b_id , b_ing_id , COUNT(b_ing_id) AS blog_count
            FROM tbl_blog_ingredient AS blog
            GROUP BY blog.b_ing_id";     
        
    	$query = $this->db->select('ing.ing_id , ing.ing_name , ing.ing_csano , blog_count_tb.blog_count')
    		->from('tbl_ingredient AS ing')
            ->join('(' . $blog_count_tb . ') AS blog_count_tb' , 'blog_count_tb.b_ing_id = ing.ing_id' , 'left')
    		->where($criteria)
    		->order_by($order['field'] , $order['direction']);
        if (isset($limit['length']) && $limit > 0) {
            $query = $query->limit($limit['length'] , $limit['start']);
        }        
        $query = $query->get()->result_array();

        return $query;
    }

    public function getMoreData($ing_id , $blog_last_id , $avatar_upload_path , $uploadpath_blog_image){
        $blog_list = $this->db->select('*')
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
                ->get()
                ->result_array();
            if (!empty($blog['b_image']) && file_exists($uploadpath_blog_image . $blog['b_image'])) {
                $blog_list[$key]['b_content'] = '<p><img src="' . base_url($uploadpath_blog_image . $blog['b_image']) . '" class="pull-left" />' . $blog['b_content'] . '<div class="clearfix"></p></div>';
            }
            $comment_array = array();
            foreach ($blog_comments as $commentkey => $comment) {
                $avatar_image = base_url(DEFAULT_AVATAR_IMGURL);
                if (!empty($comment['acc_image']) && file_exists($avatar_upload_path . $comment['acc_image'])) {
                    $avatar_image = base_url($avatar_upload_path . $comment['acc_image']);
                }
                if (!empty($comment['b_image']) && file_exists($uploadpath_blog_image . $comment['b_image'])) {
                    $comment['b_content'] = '<p><img src="' . base_url($uploadpath_blog_image . $comment['b_image']) . '" class="pull-left" />' . $comment['b_content'] . '<div class="clearfix"></p></div>';
                }
                $comment_array[] = '
                    <div class="blog-comment">
                        <div class="blog-content" blog-id="' . $comment['b_id'] . '">
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
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <button class="btn btn-success btn_update">更新</button>
                                    <button class="btn btn-danger btn_delete">删除</button>
                                </div>
                            </div>
                        </div>
                    </div>
                ';
            }
            $commentHtml = implode(' ', $comment_array);
            $blog_list[$key]['commentHtml'] = $commentHtml;
        }
        return $blog_list;
    }

    public function loadMoreData($ing_id , $blog_last_id , $avatar_upload_path , $uploadpath_blog_image) {
        $blog_list = $this->getMoreData($ing_id , $blog_last_id , $avatar_upload_path , $uploadpath_blog_image);
        $retHtml = '';
        foreach ($blog_list as $key => $blog) {
            $avatar_image = base_url(DEFAULT_AVATAR_IMGURL);
            if (!empty($blog['acc_image']) && file_exists($avatar_upload_path . $blog['acc_image'])) {
                $avatar_image = base_url($avatar_upload_path . $blog['acc_image']);
            }
            $retHtml .= '
                <div class="xxs-info-box line" blog-id="' . $blog['b_id'] . '">
                    <div class="xxs-info-title">
                        <div class="xxs-info-title-img">
                            <img src="' . $avatar_image . '" class="img-circle">
                        </div>
                        <div class="xxs-info-title-main">
                            <p class="p1">' . $blog['b_title'] . 'asdsdfsdfs</p>
                            <div class="p2">' . $blog['b_tags'] . '</div>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="xxs-info-content">' . $blog['b_content'] . '</div>
                    <input type="range" value="'. $blog['b_user_rate'] .'" step="0.25" id="backing_' . $blog['b_id'] . '">
                    <div class="rateit" data-rateit-readonly="false" data-rateit-backingfld="#backing_' . $blog['b_id'] . '" data-rateit-resetable="false"  data-rateit-ispreset="true" data-rateit-min="0" data-rateit-max="5"></div>
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button class="btn btn-success btn_update">更新</button>
                            <button class="btn btn-danger btn_delete">删除</button>
                        </div>
                    </div>
                    ' . $blog['commentHtml'] . '
                </div>';
        }

        if (count($blog_list) == 0) {
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