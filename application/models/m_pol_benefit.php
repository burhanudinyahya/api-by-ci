<?php

class m_pol_benefit extends CI_Model {
        

    public function by_trans($get) {
        
        $this->db->select('f_benefit_id, f_benefit_name')
                ->from('dbios.t_pol_benefit');
        
        if (@$get['folio'] != ''){
            $this->db->where('f_pol_folio', $get['folio']);
        } 
        
        if (@$get['year'] != ''){
            $this->db->where('f_pol_year', $get['year']);
        }
        
        if (@$get['id'] != '') {
            $this->db->where('f_benefit_id', $get['id']);
        } 
        
        return $this->db->get();
    }
    
    
    
}