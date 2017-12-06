<?php
require APPPATH.'/libraries/REST_Controller.php';

class total_premi extends \Restserver\Libraries\REST_Controller {

    function __construct($config = 'rest') {
        
        parent::__construct($config);
        
        $this->load->model('m_api');
        
        $this->load->model('m_total_premi');
        
    }

    // insert data main_member
    function index_post() {
        
        $valid_api = $this->m_api->by_api();
        
        if($valid_api){
            
            $total_premi = $this->m_total_premi->to_calc($this->post());

            if($total_premi){

                $data['mapi_total_premi']['status'] = array('code' => 201,'description' => 'Success');
                $data['mapi_total_premi']['results'] = $total_premi;
                
                $this->response($data, 201);
            }
            else {

                $data['mapi_total_premi']['status'] = array('code' => 502,'description' => 'Failure');
                
                $this->response($data, 502);
            }
            
        }
        else{
            
            $data['mapi_total_premi']['status'] = array('code' => 400,'description' => 'Invalid Key.');
            $this->response($data, 400);
            
        }
        
    }


}