<?php
require APPPATH.'/libraries/REST_Controller.php';

class pol_benefit extends \Restserver\Libraries\REST_Controller {

    function __construct($config = 'rest') {
        
        parent::__construct($config);
        
        $this->load->model('m_api');
        
        $this->load->model('m_pol_benefit');
        
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
            
            $pol_benefit = $this->m_pol_benefit->by_trans(array_merge($get,$trans));

            if($pol_benefit->num_rows() > 0){

                if(@$get){
                    $data['mapi_pol_benefit']['query'] = $get;
                }
                
                $data['mapi_pol_benefit']['status'] = array('code' => 200,'description' => 'OK');
                
                if($pol_benefit->num_rows() == 1){
                    
                    foreach ($pol_benefit->result() as $row) {
                        $benefit['f_benefit_id'] = $row->f_benefit_id;
                        $benefit['f_benefit_name'] = $row->f_benefit_name;
                    }
                    
                    $data['mapi_pol_benefit']['results'] = $benefit;
                    
                }else if($pol_benefit->num_rows() > 1){
                    
                    $data['mapi_pol_benefit']['results'] = $pol_benefit->result();
                }
                
                $this->response($data, 200);
            }
            else {
                if(@$get){
                    $data['mapi_pol_benefit']['query'] = $get;
                }
                $data['mapi_pol_benefit']['status'] = array('code' => 200,'description' => 'Data Not Found');
                $this->response($data, 200);
            }
            
        }
        else{
            
            $data['mapi_pol_benefit']['status'] = array('code' => 400,'description' => 'Invalid Key.');
            $this->response($data, 400);
            
        }
        
    }


}