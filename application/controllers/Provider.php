<?php
require APPPATH.'/libraries/REST_Controller.php';

class provider extends \Restserver\Libraries\REST_Controller {

    function __construct($config = 'rest') {
        
        parent::__construct($config);
        
        $this->load->model('m_api');
        
        $this->load->model('m_provider');
        
    }

    // read data pol_plan
    function index_get() {
        
        $valid_api = $this->m_api->by_api();
        
        if($valid_api){
            
            $get = $this->get();
            
            $provider = $this->m_provider->by_trans($get);

            if($provider->num_rows() > 0){

                if(@$get){
                    $data['mapi_provider']['query'] = $get;
                }
                
                $data['mapi_provider']['status'] = array('code' => 200,'description' => 'OK');
                
                if($provider->num_rows() == 1){

                    foreach ($provider->result() as $row) {
                        $prov['f_province_name'] = $row->f_province_name;
                        $prov['f_city_name'] = $row->f_city_name;
                        $prov['f_provider_name'] = $row->f_provider_name;
                        $prov['f_provider_address'] = $row->f_provider_address;
                        $prov['f_contact_name'] = $row->f_contact_name;
                        $prov['f_contact_div'] = $row->f_contact_div;
                        $prov['f_contact_no'] = $row->f_contact_no;
                        $prov['f_contact_fax'] = $row->f_contact_fax;
                        $prov['f_status_ip'] = $row->f_status_ip;
                        $prov['f_status_op'] = $row->f_status_op;
                    }
                    
                    $data['mapi_provider']['results'] = $prov;
                    
                }else if($provider->num_rows() > 1){
                    
                    $data['mapi_provider']['results'] = $provider->result();
                }
                
                $this->response($data, 200);
            }
            else {
                if(@$get){
                    $data['mapi_provider']['query'] = $get;
                }
                $data['mapi_provider']['status'] = array('code' => 200,'description' => 'Data Not Found');
                $this->response($data, 200);
            }
            
        }
        else{
            
            $data['mapi_provider']['status'] = array('code' => 400,'description' => 'Invalid Key.');
            $this->response($data, 400);
            
        }
        
    }


}