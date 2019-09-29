<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {    
	public function __construct() {
        parent::__construct();
        
    }

    public function get_current_datetime(){
        $datetime = new DateTime();
        return $datetime->format('Y-m-d h:m:i');
    }

    public function get_current_date(){
        $datetime = new DateTime();
        return $datetime->format('Y-m-d');
    }

    public function array_msort($array, $cols) {
        $colarr = array();
        foreach ($cols as $col => $order) {
            $colarr[$col] = array();
            foreach ($array as $k => $row) { $colarr[$col]['_'.$k] = strtolower($row[$col]); }
        }
        $eval = 'array_multisort(';
        foreach ($cols as $col => $order) {
            $eval .= '$colarr[\''.$col.'\'],'.$order.',';
        }
        $eval = substr($eval,0,-1).');';
        eval($eval);
        $ret = array();
        foreach ($colarr as $col => $arr) {
            foreach ($arr as $k => $v) {
                $k = substr($k,1);
                if (!isset($ret[$k])) $ret[$k] = $array[$k];
                $ret[$k][$col] = $array[$k][$col];
            }
        }
        return $ret;
    }

    public function get_singletbdata($tb_name , $criteria = array() , $col = '*' , $order = '') {
        $query =$this->db->select($col)
            ->from($tb_name)
            ->where($criteria);
        if ($order != '') {
            $query = $query->order_by($order);
        }
        $query = $query->get()->result_array();
        return $query;
    }

    public function tb_data_count($tb_name , $criteria = array()){
        return $this->db->from($tb_name)->where($criteria)->count_all_results();
    }

    public function tb_insertdata($tb_name , $insert_data) {
        $retVal = array();
        $retVal['success'] = $this->db->insert($tb_name , $insert_data);
        if ($retVal['success']) {
            $retVal['insert_id'] = $this->db->insert_id();
        }
        else {
            $retVal['insert_id'] = -1;
        }
        return $retVal;
    }

    public function tb_updatedata($tb_name , $criteria , $update_data) {
        return $this->db->where($criteria)->update($tb_name , $update_data);
    }

    public function tb_deletedata($tb_name , $criteria) {
        return $this->db->where($criteria)->delete($tb_name);
    }

	public function file_upload($path, $file_tag_name , $new_file_name = '' , $special_filetype = ''){
        $config['upload_path']          = $path;
        if ($new_file_name != '') {
            $config['file_name']        = $new_file_name;
        }
        if ($special_filetype != '') {
            $config['allowed_types']        = $special_filetype ;
        }
        else {
            $config['allowed_types']        = '*';
        }
        $config['max_size']             = 1000000000;
        $config['overwrite']            = FALSE;

		$this->load->library('upload', $config);
		$this->upload->initialize($config);
        $retVal = array();
        $retVal['success'] = $this->upload->do_upload($file_tag_name);
        if ($retVal['success']) {
            $retVal['file_name'] = $this->upload->data('file_name');
            $retVal['file_type'] = $this->upload->data('file_type');
        }
        else {
            $retVal['file_name'] = NULL;
        }
        return $retVal;
    }
    
    public function file_exist($filepathname) {
        return file_exists($filepathname);
    }

    public function delete_file($filepathname) {
        if ($this->file_exist($filepathname)) {
            return unlink($filepathname);
        }
        return FALSE;
    }

    public function rename_file($old_pathname , $new_pathname) {
        if ($this->file_exist($old_pathname)) {
            return rename($old_pathname , $new_pathname);
        }
        return FALSE;
    }
    
    public function getLoggedUserData(){
		return $this->session->userdata('LOGGEDIN_BEVOL_USER_DATA');
    }

    public function deleteBlog($b_id , $uploadpath_blog_image) {
        $criteria = array(
            'b_id'  => $b_id , 
            'b_comment_parent_id'   => $b_id
        );
        $blog_list = $this->db->from('tbl_blog')->or_where($criteria)->get()->result_array();
        foreach ($blog_list as $key => $record) {
            if (!empty($record['b_image'])) {
                $this->delete_file($uploadpath_blog_image . $record['b_image']);
            }
        }
        return $this->db->or_where($criteria)->delete('tbl_blog');
    }

    public function deleteBlogingredient($b_id , $uploadpath_blog_image) {
        $criteria = array(
            'b_id'  => $b_id , 
            'b_comment_parent_id'   => $b_id
        );
        $blog_list = $this->db->from('tbl_blog_ingredient')->or_where($criteria)->get()->result_array();
        foreach ($blog_list as $key => $record) {
            if (!empty($record['b_image'])) {
                $this->delete_file($uploadpath_blog_image . $record['b_image']);
            }
        }
        return $this->db->or_where($criteria)->delete('tbl_blog_ingredient');
    }

    public function get_product_newcategory_sorted(){
        $retCategory = array();
        $criteria = array(
            'cat_new_parent_id' => 0 , 
            'is_delete'         => 0
        );
        $parentcategory = $this->get_singletbdata('tbl_category_new' , $criteria);
        foreach ($parentcategory as $key => $record) {
            $retCategory[] = $record;
            $criteria['cat_new_parent_id'] = $record['cat_new_id'];
            $sub_category = $this->get_singletbdata('tbl_category_new' , $criteria);
            foreach ($sub_category as $key => $sub_item) {
                $retCategory[] = $sub_item;
            }
        }
        $retCategory[] = array(
            'cat_new_id'    => -1 , 
            'cat_new_name'  => '其他' , 
            'cat_new_parent_id' => 0 , 
            'is_delete' => 0 , 
        );
        return $retCategory;
    }
}