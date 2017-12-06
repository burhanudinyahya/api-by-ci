<?php

class m_endorse_relation extends CI_Model {
    
    public function to_insert($post) {
        $pol_from_endorse = date('Y-m-d');
        
        $from = strtotime($post['f_pol_from']);
        $pol_from = ($post['f_pol_from']) ? date('Y-m-d',$from) : ''; 
        $pol_to = $this->_get_period(@$post['f_emp_no']);
        
        $trans_id = $this->_get_trans_id(@$post['f_emp_no']);
        $fol_year = $this->_get_fol_year(@$trans_id);
        
        foreach ($fol_year as $row){
            $folio = $row->f_pol_folio;
            $year = $row->f_pol_year;
        }
        
        // Endorse Spouse
        if(@$post['f_member_name_spouse']){
            $input_members = array(
                'f_emp_no' => @$post['f_emp_no'],
                'f_member_name' => @$post['f_member_name_spouse'],
                'f_member_dob' => @$post['f_member_dob_spouse'],
                'f_member_gender' => @$post['f_member_gender_spouse'],
                'f_member_relation' => 2,
                'f_emp_name' => @$post['f_emp_name'],
                'f_emp_id' => @$post['f_emp_id'],
                'f_emp_bank_name' => @$post['f_emp_bank_name'],
                'f_emp_bank_accno' => @$post['f_emp_acc_no'],
                'f_emp_bank_accname' => @$post['f_emp_acc_name'],
                'f_emp_mail' => @$post['f_emp_mail'],
                'f_emp_address' => @$post['f_emp_address'],
                'f_emp_city' => @$post['f_emp_city'],
                'f_emp_province' => @$post['f_emp_province'],
                'f_emp_post_code' => @$post['f_emp_post_code'],
                'f_emp_phone' => @$post['f_emp_phone'],
                'f_endt_status' => 1,
                'f_pol_folio' => $folio,
                'f_pol_year' => $year,
                'f_pol_month_from' => substr($pol_from_endorse,5,2),
                'f_pol_year_from' => substr($pol_from_endorse,0,4),
                'f_pol_month_to' => substr($pol_to,5,2),
                'f_pol_year_to' => substr($pol_to,0,4),
                'f_pol_from' => $pol_from_endorse,
                'f_pol_to' => $pol_to
            );

            $this->db->insert('t_member_temp_client',$input_members);

            $member_id = $this->db->insert_id();

            $total_premi = 0;

            foreach (@$post['f_benefit_id_spouse'] as $key => $value) {
                $premi_awal = $this->_get_premi(@$post['f_plan_id_spouse'][$key],@$post['f_benefit_id_spouse'][$key],2,'premi');
                $curr = $this->_get_premi(@$post['f_plan_id_spouse'][$key],@$post['f_benefit_id_spouse'][$key],2,'curr');

                $from = substr($pol_to,5,2);
                $from_endorse = substr($pol_from_endorse,5,2) ;
                $num_bulan = (int)$from - (int)$from_endorse + 1;
                $premi = (((int)$num_bulan * $premi_awal) / 12);

                $total_premi = $total_premi + $premi;

                $input_flexis = array(
                    'f_member_id' => $member_id,
                    'f_benefit_id' => @$post['f_benefit_id_spouse'][$key],
                    'f_plan_current' => @$post['f_plan_id_spouse'][$key],
                    'f_plan_choice' => @$post['f_plan_id_spouse'][$key],
                    'f_curr_choice' => @$curr,
                    'f_premi_choice' => @$premi,
                );

                $this->db->insert('t_member_client_flexi',$input_flexis);
            }

            $update_client = array(
                    'f_pol_premi' => $total_premi,
                );

            $this->db->where('f_member_id',$member_id)
                    ->update('t_member_temp_client',$update_client);
        }
        
        // Endorse Childs
        if(@$post['f_member_name_childs']){
            $input_members = array(
                'f_emp_no' => @$post['f_emp_no'],
                'f_member_name' => @$post['f_member_name_childs'],
                'f_member_dob' => @$post['f_member_dob_childs'],
                'f_member_gender' => @$post['f_member_gender_childs'],
                'f_member_relation' => 3,
                'f_emp_name' => @$post['f_emp_name'],
                'f_emp_id' => @$post['f_emp_id'],
                'f_emp_bank_name' => @$post['f_emp_bank_name'],
                'f_emp_bank_accno' => @$post['f_emp_acc_no'],
                'f_emp_bank_accname' => @$post['f_emp_acc_name'],
                'f_emp_mail' => @$post['f_emp_mail'],
                'f_emp_address' => @$post['f_emp_address'],
                'f_emp_city' => @$post['f_emp_city'],
                'f_emp_province' => @$post['f_emp_province'],
                'f_emp_post_code' => @$post['f_emp_post_code'],
                'f_emp_phone' => @$post['f_emp_phone'],
                'f_endt_status' => 1,
                'f_pol_folio' => $folio,
                'f_pol_year' => $year,
                'f_pol_month_from' => substr($pol_from_endorse,5,2),
                'f_pol_year_from' => substr($pol_from_endorse,0,4),
                'f_pol_month_to' => substr($pol_to,5,2),
                'f_pol_year_to' => substr($pol_to,0,4),
                'f_pol_from' => $pol_from_endorse,
                'f_pol_to' => $pol_to
            );

            $this->db->insert('t_member_temp_client',$input_members);

            $member_id = $this->db->insert_id();

            $total_premi = 0;

            foreach (@$post['f_benefit_id_childs'] as $key => $value) {
                $premi_awal = $this->_get_premi(@$post['f_plan_id_childs'][$key],@$post['f_benefit_id_childs'][$key],3,'premi');
                $curr = $this->_get_premi(@$post['f_plan_id_childs'][$key],@$post['f_benefit_id_childs'][$key],3,'curr');

                $from = substr($pol_to,5,2);
                $from_endorse = substr($pol_from_endorse,5,2) ;
                $num_bulan = (int)$from - (int)$from_endorse + 1;
                $premi = (((int)$num_bulan * $premi_awal) / 12);

                $total_premi = $total_premi + $premi;

                $input_flexis = array(
                    'f_member_id' => $member_id,
                    'f_benefit_id' => @$post['f_benefit_id_childs'][$key],
                    'f_plan_current' => @$post['f_plan_id_childs'][$key],
                    'f_plan_choice' => @$post['f_plan_id_childs'][$key],
                    'f_curr_choice' => @$curr,
                    'f_premi_choice' => @$premi,
                );

                $this->db->insert('t_member_client_flexi',$input_flexis);
            }

            $update_client = array(
                    'f_pol_premi' => $total_premi,
                );

            $this->db->where('f_member_id',$member_id)
                    ->update('t_member_temp_client',$update_client);
        }
        
        return true;

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
    
    private function _get_trans_id($emp_no){
        $this->db->select('MAX(f_pol_trans_id) AS f_pol_trans_id')
                ->from('t_member_temp_client')
                ->where('f_emp_no',$emp_no)
                ->group_by('f_emp_no');
        
        $row = $this->db->get()->row();
        
        if($row){
            return $row->f_pol_trans_id;
        }
    }
    
    private function _get_fol_year($trans_id){
        $this->db->select('f_pol_folio, f_pol_year')
                ->from('dbios.t_pol_trans')
                ->where('f_pol_trans_id',$trans_id);
        
        return $this->db->get()->result();
    }
    
    private function _get_period($empno){
        $this->db->select('f_pol_to')
                ->from('t_member_temp_client')
                ->where('f_emp_no',$empno)
                ->where('f_member_relation',1);
        
        return $this->db->get()->row()->f_pol_to;
        
    }
    
}

