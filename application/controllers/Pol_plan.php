<?php
require APPPATH.'/libraries/REST_Controller.php';

class pol_plan extends \Restserver\Libraries\REST_Controller {

    function __construct($config = 'rest') {
        
        parent::__construct($config);
        
        $this->load->model('m_api');
        
        $this->load->model('m_pol_plan');
        
    }

    // read data pol_plan
    function index_get() {
        
        $valid_api = $this->m_api->by_api();
        
        if($valid_api){
            
            foreach ($valid_api->result() as $row) {
                $trans['folio'] = $row->f_pol_folio;
                $trans['year'] = $row->f_pol_year;
            }
            
            $get = $this->get();
            
            $pol_plan = $this->m_pol_plan->by_trans(array_merge($get,$trans));

            if($pol_plan->num_rows() > 0){

                if(@$get){
                    $data['mapi_pol_plan']['query'] = $get;
                }
                
                $data['mapi_pol_plan']['status'] = array('code' => 200,'description' => 'OK');
                
                if($pol_plan->num_rows() == 1){
                    
                    foreach ($pol_plan->result() as $row) {
                        $plan['f_plan_id'] = $row->f_plan_id;
                        $plan['f_plan_name'] = $row->f_plan_name;
                    }
                    
                    $data['mapi_pol_plan']['results'] = $plan;
                    
                }else if($pol_plan->num_rows() > 1){
                    
                    $data['mapi_pol_plan']['results'] = $pol_plan->result();
                }
                
                $this->response($data, 200);
            }
            else {
                if(@$get){
                    $data['mapi_pol_plan']['query'] = $get;
                }
                $data['mapi_pol_plan']['status'] = array('code' => 200,'description' => 'Data Not Found');
                $this->response($data, 200);
            }
            
        }
        else{
            
            $data['mapi_pol_plan']['status'] = array('code' => 400,'description' => 'Invalid Key.');
            $this->response($data, 400);
            
        }
        
    }


}