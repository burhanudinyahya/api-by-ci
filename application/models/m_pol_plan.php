<?php

class m_pol_plan extends CI_Model {
        

    public function by_trans($get) {
        
        $this->db->select('f_plan_id, f_plan_name')
                ->from('dbios.t_pol_plan');
        
        if (@$get['folio'] != ''){
            $this->db->where('f_pol_folio', $get['folio']);
        } 
        
        if (@$get['year'] != ''){
            $this->db->where('f_pol_year', $get['year']);
        }
        
        if (@$get['id'] != '') {
            $this->db->where('f_plan_id', $get['id']);
        } 
        
        return $this->db->get();
    }
    
    
    
}