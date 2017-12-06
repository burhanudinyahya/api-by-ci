<?php

class m_provider_lab extends CI_Model {
        

    public function by_trans($get) {
        
        $this->db->select('f_province_name, f_city_name, f_provider_name, f_provider_address, f_contact_name, f_contact_div, f_contact_no, f_contact_fax')
                ->from('dbios.t_provider')
                ->where('f_status_lab',1)
                ->where('f_status_active',1);
        
        if (@$get['province_name'] != '') {
            $this->db->like('f_province_name', $get['province_name']);
        } 
        
        if (@$get['city_name'] != '') {
            $this->db->like('f_city_name', $get['city_name']);
        }
        
        if (@$get['provider_name'] != '') {
            $this->db->like('f_provider_name', $get['provider_name']);
        } 
        
        return $this->db->get();
    }
    
    
    
}