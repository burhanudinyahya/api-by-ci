<?php
require APPPATH.'/libraries/REST_Controller.php';

class spouse extends \Restserver\Libraries\REST_Controller {

    function __construct($config = 'rest') {
        
        parent::__construct($config);
        
        $this->load->model('m_api');
        
        $this->load->model('m_spouse');
        
    }

    // read data pol_plan
    function index_get() {
        
        $valid_api = $this->m_api->by_api();
        
        if($valid_api){
            
            $get = $this->get();
            
            $spouse = $this->m_spouse->by_trans($get);

            if($spouse->num_rows() > 0){

                if(@$get){
                    $data['mapi_spouse']['query'] = $get;
                }
                
                $data['mapi_spouse']['status'] = array('code' => 200,'description' => 'OK');
                
                if($spouse->num_rows() == 1){

                    foreach ($spouse->result() as $row) {
                        $spou['f_spouse'] = $row->f_spouse;
                    }
                    
                    $data['mapi_spouse']['results'] = $spou;
                    
                }else if($spouse->num_rows() > 1){
                    
                    $data['mapi_spouse']['results'] = $spouse->result();
                }
                
                $this->response($data, 200);
            }
            else {
                if(@$get){
                    $data['mapi_spouse']['query'] = $get;
                }
                $data['mapi_spouse']['status'] = array('code' => 200,'description' => 'Data Not Found');
                $this->response($data, 200);
            }
            
        }
        else{
            
            $data['mapi_spouse']['status'] = array('code' => 400,'description' => 'Invalid Key.');
            $this->response($data, 400);
            
        }
        
    }


}