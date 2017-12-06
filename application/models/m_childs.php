<?php

class m_childs extends CI_Model {
        

    public function by_trans($get) {
        
        $this->db->select('COUNT(f_emp_no) AS f_childs')
                ->from('t_member_temp_client')
                ->where('f_member_relation > 2')
                ->group_by('f_emp_no');
        
        if (@$get['f_emp_no'] != '') {
            $this->db->where('f_emp_no', $get['f_emp_no']);
        } 
        
        return $this->db->get();
    }
    
    
    
}