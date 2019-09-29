<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Company_Model extends MY_Model {
	
    public function __construct() {
		parent::__construct();
		
    }

    public function is_reset_rankingnumber(){
        $query = $this->db->select('ranking_decision_date')
            ->from('tbl_companys')
            ->group_by('ranking_decision_date')
            ->order_by('ranking_decision_date' , 'ASC')
            ->get()
            ->first_row();
        if ($query) {
            $recently_update_date = $query->ranking_decision_date;
            $difference = date_diff(date_create($this->get_current_date()) , date_create($recently_update_date));
            if ($difference->m > 0) {
                return TRUE;        
            }
        }
        return FALSE;
    }

    public function decisionrankingnumber(){
        $company_list = $this->get_singletbdata('tbl_companys');
        foreach ($company_list as $key => $record) {
            $criteria = array(
                'pro.pro_company_id'   => $record['com_id'] , 
            );
            $averageRateQuery = $this->db->select('SUM(blog.b_user_rate) / COUNT(blog.b_pro_id) AS average_rate')
                ->from('tbl_product AS pro')
                ->join('tbl_blog AS blog' , 'pro.pro_id = blog.b_pro_id' , 'LEFT')
                ->or_where($criteria)
                ->group_by('blog.b_pro_id')
                ->get()
                ->result_array();
            $average_value = 0;
            $count = 0;
            foreach ($averageRateQuery as $averageKey => $item) {
                if (is_numeric($item['average_rate'])) {
                    $average_value += $item['average_rate'];
                    $count ++;
                }
            }
            if ($count > 0) {
                $company_list[$key]['average_rate'] = $average_value / $count;
            }
            else {
                $company_list[$key]['average_rate'] = 0;
            }
        }
        $sort_result = $this->array_msort($company_list , array('average_rate' => SORT_DESC));
        $i = 1;
        $ranking_decision_date = $this->get_current_date();
        foreach ($sort_result as $key => $record) {
            $update_data = array(
                'ranking_number'    => $i , 
                'ranking_decision_date' => $ranking_decision_date
            );
            $this->tb_updatedata('tbl_companys' , array('com_id' => $record['com_id']) , $update_data);
            $i ++;
        }
        
        return TRUE;
    }

    public function get_companys($criteria = array() , $order = array() , $limit = array()){
    	$query = $this->db->select('*')
    		->from('tbl_companys')
    		->where($criteria);
        if (isset($order['field'])) {
            $query = $query->order_by($order['field'] , $order['direction']);
        }   
        if (isset($limit['length']) && $limit > 0) {
            $query = $query->limit($limit['length'] , $limit['start']);
        }        
        $query = $query->get()->result_array();
        return $query;
    }

    public function insert($input_data , $upload_path){
		$uploaded_filename = '';
        $upload_result = $this->file_upload($upload_path , 'com_image' , $input_data['com_name']);
        if ($upload_result['success']) {
        	$uploaded_filename = $upload_result['file_name'];
			$update_data = array(
				'com_name'	=> $input_data['com_name'] , 
				'com_image'	=> $uploaded_filename , 
                'com_alias'  => $input_data['com_alias'] , 
                'com_country'  => $input_data['com_country'] , 
			);    	    
            $this->load->library('image_lib');
            $config = array();
            $config['source_image'] = $upload_path . $uploaded_filename;
            $config['width']    = DEFAULTIMGWIDTH;
            $config['height']   = DEFAULTIMGHEIGHT;
            $config['maintain_ratio']   = TRUE;
            $config['quality']  = '100%';
            $this->image_lib->initialize($config);
            $this->image_lib->resize();
        }	
        else {
			$update_data = array(
				'com_name'	=> $input_data['com_name'] , 
                'com_alias'  => $input_data['com_alias'] , 
                'com_country'  => $input_data['com_country'] , 
			);    	
        }
    	if ($input_data['com_id'] < 0) {
    		return $this->tb_insertdata('tbl_companys' , $update_data);
    	}
    	else {
    		return array('success' => $this->tb_updatedata('tbl_companys' , array('com_id' => $input_data['com_id']) , $update_data) , 'insert_id' => $input_data['com_id']);
    	}
    }
}