<?php

class m_flexi_role extends CI_Model {
        

    public function by_trans($get) {
        
        $this->db->select('f_benefit_id, f_inherit_ben, f_not_plan, f_emp_only, f_female_only, f_max_age, f_max_child_mt')
                ->from('dbios.t_pol_plan_ben_flexi');
        
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