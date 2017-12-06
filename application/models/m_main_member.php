<?php

class m_main_member extends CI_Model {
    
    public function to_insert($post) {
        $from = strtotime($post['f_pol_from']);
        $to = strtotime($post['f_pol_to']);
        $pol_from = ($post['f_pol_from']) ? date('Y-m-d',$from) : '';
        $pol_to = ($post['f_pol_to']) ? date('Y-m-d',$to) : '';
        
        $input_members = array(
            'f_emp_no' => @$post['f_emp_no'],
            'f_member_name' => @$post['f_member_name_main'],
            'f_member_dob' => @$post['f_member_dob_main'],
            'f_member_gender' => @$post['f_member_gender_main'],
            'f_member_relation' => 1,
            'f_emp_name' => @$post['f_emp_name'],
            'f_emp_bank_name' => @$post['f_emp_bank_name'],
            'f_emp_bank_accno' => @$post['f_emp_acc_no'],
            'f_emp_bank_accname' => @$post['f_emp_acc_name'],
            'f_emp_mail' => @$post['f_emp_mail'],
            'f_emp_address' => @$post['f_emp_address'],
            'f_emp_city' => @$post['f_emp_city'],
            'f_emp_province' => @$post['f_emp_province'],
            'f_emp_post_code' => @$post['f_emp_post_code'],
            'f_emp_phone' => @$post['f_emp_phone'],
            'f_pol_month_from' => substr($pol_from,5,2),
            'f_pol_year_from' => substr($pol_from,0,4),
            'f_pol_month_to' => substr($pol_to,5,2),
            'f_pol_year_to' => substr($pol_to,0,4),
            'f_pol_from' => $pol_from,
            'f_pol_to' => $pol_to
        );
        
        $this->db->insert('t_member_temp_client',$input_members);
        
        $member_id = $this->db->insert_id();
        
        $total_premi = 0;
        foreach (@$post['f_benefit_id_main'] as $key => $value) {
            $premi = $this->_get_premi(@$post['f_plan_id_main'][$key],@$post['f_benefit_id_main'][$key],1,'premi');
            $curr = $this->_get_premi(@$post['f_plan_id_main'][$key],@$post['f_benefit_id_main'][$key],1,'curr');
            
            $total_premi = $total_premi + $premi;
            
            $input_flexis = array(
                'f_member_id' => $member_id,
                'f_benefit_id' => @$post['f_benefit_id_main'][$key],
                'f_plan_current' => @$post['f_plan_id_main'][$key],
                'f_plan_choice' => @$post['f_plan_id_main'][$key],
                'f_curr_choice' => @$curr,
                'f_premi_choice' => @$premi,
            );
        
            $this->db->insert('t_member_client_flexi',$input_flexis);
        }
        
        $update_client = array(
                'f_emp_id' => $member_id,
                'f_pol_premi' => $total_premi,
                'f_add_cost' => $this->_get_ongkir($post['f_emp_post_code']),
            );
        
        $this->db->where('f_member_id',$member_id)
                ->update('t_member_temp_client',$update_client);
        
        return $member_id;
    }
    
    private function _get_premi($planid,$benid,$relid,$in){
        $this->db->select('f_curr, f_premi')
                ->from('dbios.t_pol_plan_ben_premi')
                ->where('f_plan_id',$planid)
                ->where('f_benefit_id',$benid)
                ->where('f_member_relation',$relid);
        if($in == 'premi'){
            return $this->db->get()->row()->f_premi;
        }else{
            return $this->db->get()->row()->f_curr;
        }
    }
    
    private function _get_ongkir($start){
        $this->db->select('f_post_fee')
                ->from('t_post_fee')
                ->where('f_post_code_end',trim($start));
            
        return $this->db->get()->row()->f_post_fee;
    }
    
    
}