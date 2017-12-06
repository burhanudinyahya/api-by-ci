<?php
require APPPATH.'/libraries/REST_Controller.php';

class flexi_role extends \Restserver\Libraries\REST_Controller {

    function __construct($config = 'rest') {
        
        parent::__construct($config);
        
        $this->load->model('m_api');
        
        $this->load->model('m_flexi_role');
        
    }

    // read data pol_benefit
    function index_get() {
        
        $valid_api = $this->m_api->by_api();
        
        if($valid_api){
            
            foreach ($valid_api->result() as $row) {
                $trans['folio'] = $row->f_pol_folio;
                $trans['year'] = $row->f_pol_year;
            }
            
            $get = $this->get();
            
            $flexi_role = $this->m_flexi_role->by_trans(array_merge($get,$trans));

            if($flexi_role->num_rows() > 0){

                if(@$get){
                    $data['mapi_flexi_role']['query'] = $get;
                }
                
                $data['mapi_flexi_role']['status'] = array('code' => 200,'description' => 'OK');
                
                if($flexi_role->num_rows() == 1){
                    
                    foreach ($flexi_role->result() as $row) {
                        $benefit['f_benefit_id'] = $row->f_benefit_id;
                        $benefit['f_inherit_ben'] = $row->f_inherit_ben;
                        $benefit['f_not_plan'] = $row->f_not_plan;
                        $benefit['f_emp_only'] = $row->f_emp_only;
                        $benefit['f_female_only'] = $row->f_female_only;
                        $benefit['f_max_age'] = $row->f_max_age;
                        $benefit['f_max_child_mt'] = $row->f_max_child_mt;
                    }
                    
                    $data['mapi_flexi_role']['results'] = $benefit;
                    
                }else if($flexi_role->num_rows() > 1){
                    
                    $data['mapi_flexi_role']['results'] = $flexi_role->result();
                }
                
                $this->response($data, 200);
            }
            else {
                if(@$get){
                    $data['mapi_flexi_role']['query'] = $get;
                }
                $data['mapi_flexi_role']['status'] = array('code' => 200,'description' => 'Data Not Found');
                $this->response($data, 200);
            }
            
        }
        else{
            
            $data['mapi_flexi_role']['status'] = array('code' => 400,'description' => 'Invalid Key.');
            $this->response($data, 400);
            
        }
        
    }


}