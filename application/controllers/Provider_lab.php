<?php
require APPPATH.'/libraries/REST_Controller.php';

class provider_lab extends \Restserver\Libraries\REST_Controller {

    function __construct($config = 'rest') {
        
        parent::__construct($config);
        
        $this->load->model('m_api');
        
        $this->load->model('m_provider_lab');
        
    }

    // read data pol_plan
    function index_get() {
        
        $valid_api = $this->m_api->by_api();
        
        if($valid_api){
            
            $get = $this->get();
            
            $provider_lab = $this->m_provider_lab->by_trans($get);

            if($provider_lab->num_rows() > 0){

                if(@$get){
                    $data['mapi_provider_lab']['query'] = $get;
                }
                
                $data['mapi_provider_lab']['status'] = array('code' => 200,'description' => 'OK');
                
                if($provider_lab->num_rows() == 1){

                    foreach ($provider_lab->result() as $row) {
                        $prov['f_province_name'] = $row->f_province_name;
                        $prov['f_city_name'] = $row->f_city_name;
                        $prov['f_provider_name'] = $row->f_provider_name;
                        $prov['f_provider_address'] = $row->f_provider_address;
                        $prov['f_contact_name'] = $row->f_contact_name;
                        $prov['f_contact_div'] = $row->f_contact_div;
                        $prov['f_contact_no'] = $row->f_contact_no;
                        $prov['f_contact_fax'] = $row->f_contact_fax;
                    }
                    
                    $data['mapi_provider_lab']['results'] = $prov;
                    
                }else if($provider_lab->num_rows() > 1){
                    
                    $data['mapi_provider_lab']['results'] = $provider_lab->result();
                }
                
                $this->response($data, 200);
            }
            else {
                if(@$get){
                    $data['mapi_provider_lab']['query'] = $get;
                }
                $data['mapi_provider_lab']['status'] = array('code' => 200,'description' => 'Data Not Found');
                $this->response($data, 200);
            }
            
        }
        else{
            
            $data['mapi_provider_lab']['status'] = array('code' => 400,'description' => 'Invalid Key.');
            $this->response($data, 400);
            
        }
        
    }


}