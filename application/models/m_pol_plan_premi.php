<?php

class m_pol_plan_premi extends CI_Model {
        

    public function by_trans($get,$plan) {
        
        $this->db->select('f_plan_id, f_benefit_id, f_member_relation, f_member_gender, f_curr, f_premi')
                ->from('dbios.t_pol_plan_ben_premi');
        
        if (@$plan != '') {
            $this->db->where_in('f_plan_id', explode(',', $plan));
        } 
        if (@$get['plan_id'] != '') {
            $this->db->where('f_plan_id', $get['plan_id']);
        } 
        if (@$get['benefit_id'] != '') {
            $this->db->where('f_benefit_id', $get['benefit_id']);
        } 
        if (@$get['member_relation'] != '') {
            $this->db->where('member_relation', $get['f_member_relation']);
        } 
        if (@$get['member_gender'] != '') {
            $this->db->where('member_gender', $get['f_member_gender']);
        } 
        if (@$get['curr'] != '') {
            $this->db->where('curr', $get['f_curr']);
        } 
//        if (@$get['premi'] != '') {
//            $this->db->where('premi', $get['f_premi']);
//        } 
        
        return $this->db->get();
    }
    
    
    
}