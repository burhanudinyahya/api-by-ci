<?php
require APPPATH.'/libraries/REST_Controller.php';

class insert_main_member extends \Restserver\Libraries\REST_Controller {

    function __construct($config = 'rest') {
        
        parent::__construct($config);
        
        $this->load->model('m_api');
        
        $this->load->model('m_main_member');
        
    }

    // insert data main_member
    function index_post() {
        
        $valid_api = $this->m_api->by_api();
        
        if($valid_api){
            
            $id_member = $this->m_main_member->to_insert($this->post());

            if($id_member){

                $data['mapi_insert_main_member']['status'] = array('code' => 201,'description' => 'Success');
                $data['mapi_insert_main_member']['results'] = array('f_emp_id' => $id_member);
                
                $this->response($data, 201);
            }
            else {

                $data['mapi_insert_main_member']['status'] = array('code' => 502,'description' => 'Failure');
                
                $this->response($data, 502);
            }
            
        }
        else{
            
            $data['mapi_insert_main_member']['status'] = array('code' => 400,'description' => 'Invalid Key.');
            $this->response($data, 400);
            
        }
        
    }


}