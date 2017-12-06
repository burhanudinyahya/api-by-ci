<?php
require APPPATH.'/libraries/REST_Controller.php';

class insert_childs_member extends \Restserver\Libraries\REST_Controller {

    function __construct($config = 'rest') {
        
        parent::__construct($config);
        
        $this->load->model('m_api');
        
        $this->load->model('m_insert_childs_member');
        
    }

    // insert data childs_member
    function index_post() {
        
        $valid_api = $this->m_api->by_api();
        
        if($valid_api){
            
            $id_member = $this->m_insert_childs_member->to_insert($this->post());

            if($id_member){
                $data = array();
                $data['mapi_insert_childs_member']['status'] = array('code' => 201,'description' => 'Success');
                //$data['mapi_insert_childs_member']['results'] = array('f_emp_id' => $id_member);
                
                $this->response($data, 201);
            }
            else {

                $data['mapi_insert_childs_member']['status'] = array('code' => 502,'description' => 'Failure');
                
                $this->response($data, 502);
            }
            
        }
        else{
            
            $data['mapi_insert_childs_member']['status'] = array('code' => 400,'description' => 'Invalid Key.');
            $this->response($data, 400);
            
        }
        
    }


}