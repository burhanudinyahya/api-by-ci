<?php
require APPPATH.'/libraries/REST_Controller.php';

class childs extends \Restserver\Libraries\REST_Controller {

    function __construct($config = 'rest') {
        
        parent::__construct($config);
        
        $this->load->model('m_api');
        
        $this->load->model('m_childs');
        
    }

    // read data pol_plan
    function index_get() {
        
        $valid_api = $this->m_api->by_api();
        
        if($valid_api){
            
            $get = $this->get();
            
            $childs = $this->m_childs->by_trans($get);

            if($childs->num_rows() > 0){

                if(@$get){
                    $data['mapi_childs']['query'] = $get;
                }
                
                $data['mapi_childs']['status'] = array('code' => 200,'description' => 'OK');
                
                if($childs->num_rows() == 1){

                    foreach ($childs->result() as $row) {
                        $spou['f_childs'] = $row->f_childs;
                    }
                    
                    $data['mapi_childs']['results'] = $spou;
                    
                }else if($childs->num_rows() > 1){
                    
                    $data['mapi_childs']['results'] = $childs->result();
                }
                
                $this->response($data, 200);
            }
            else {
                if(@$get){
                    $data['mapi_childs']['query'] = $get;
                }
                $data['mapi_childs']['status'] = array('code' => 200,'description' => 'Data Not Found');
                $this->response($data, 200);
            }
            
        }
        else{
            
            $data['mapi_childs']['status'] = array('code' => 400,'description' => 'Invalid Key.');
            $this->response($data, 400);
            
        }
        
    }


}