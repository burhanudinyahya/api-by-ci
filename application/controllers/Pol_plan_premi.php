<?php
require APPPATH.'/libraries/REST_Controller.php';

class pol_plan_premi extends \Restserver\Libraries\REST_Controller {

    function __construct($config = 'rest') {
        
        parent::__construct($config);
        
        $this->load->model('m_api');
        
        $this->load->model('m_pol_plan');
        
        $this->load->model('m_pol_plan_premi');
        
    }

    // read data pol_plan_premi
    function index_get() {
        
        $valid_api = $this->m_api->by_api();
        
        if($valid_api){
            
            foreach ($valid_api->result() as $row) {
                $trans['folio'] = $row->f_pol_folio;
                $trans['year'] = $row->f_pol_year;
            }
            
            $get = $this->get();
            
            $pol_plan = $this->m_pol_plan->by_trans(array_merge($get,$trans));
            foreach ($pol_plan->result() as $row) {
                $plan[] = $row->f_plan_id;
            }
            $pol_plan_premi = $this->m_pol_plan_premi->by_trans($get,implode(',', $plan));

            if($pol_plan_premi->num_rows() > 0){

                if(@$get){
                    $data['mapi_pol_plan_premi']['query'] = $get;
                }
                
                $data['mapi_pol_plan_premi']['status'] = array('code' => 200,'description' => 'OK');
                
                if($pol_plan_premi->num_rows() == 1){
                    
                    foreach ($pol_plan_premi->result() as $row) {
                        $premi['f_plan_id'] = $row->f_plan_id;
                        $premi['f_benefit_id'] = $row->f_benefit_id;
                        $premi['f_member_relation'] = $row->f_member_relation;
                        $premi['f_member_gender'] = $row->f_member_gender;
                        $premi['f_curr'] = $row->f_curr;
                        $premi['f_premi'] = $row->f_premi;
                    }
                    
                    $data['mapi_pol_plan_premi']['results'] = $premi;
                    
                }else if($pol_plan_premi->num_rows() > 1){
                    
                    $data['mapi_pol_plan_premi']['results'] = $pol_plan_premi->result();
                }
                
                $this->response($data, 200);
            }
            else {
                if(@$get){
                    $data['mapi_pol_plan_premi']['query'] = $get;
                }
                $data['mapi_pol_plan_premi']['status'] = array('code' => 200,'description' => 'Data Not Found');
                $this->response($data, 200);
            }
            
        }
        else{
            
            $data['mapi_pol_plan_premi']['status'] = array('code' => 400,'description' => 'Invalid Key.');
            $this->response($data, 400);
            
        }
        
    }


}