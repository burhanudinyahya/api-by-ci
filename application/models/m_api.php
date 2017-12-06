<?php

class m_api extends CI_Model {
    
    public function by_api() {
        $header = getallheaders();
        if(! @$header['X-Api-Key']){
            return false;
        }
        $key = $header['X-Api-Key'];
        
        $this->db->select('f_pol_folio, f_pol_year')
                ->from('t_mstpol_api')
                ->where('f_api_key',trim($key));
        
        $q = $this->db->get();
        
        return ($q->num_rows() > 0) ? $q : false;

    }
    
}