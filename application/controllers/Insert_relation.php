<?php
require APPPATH.'/libraries/REST_Controller.php';

class insert_relation extends \Restserver\Libraries\REST_Controller {

    function __construct($config = 'rest') {
        
        parent::__construct($config);
        
        $this->load->model('m_api');
        
        $this->load->model('m_relation');
        
    }

    // insert data main_member
    function index_post() {
        
        $valid_api = $this->m_api->by_api();
        
        if($valid_api){
            
            $id_member = $this->m_relation->to_insert($this->post());

            if($id_member){

                $data['mapi_insert_relation']['status'] = array('code' => 201,'description' => 'Success');
                
                $this->response($data, 201);
            }
            else {

                $data['mapi_insert_relation']['status'] = array('code' => 502,'description' => 'Failure');
                
                $this->response($data, 502);
            }
            
        }
        else{
            
            $data['mapi_insert_relation']['status'] = array('code' => 400,'description' => 'Invalid Key.');
            $this->response($data, 400);
            
        }
        
    }


}