<?php

class m_total_premi extends CI_Model {
    
    public function to_calc($post) {
        
        $ongkir = $this->_get_ongkir(@$post['f_emp_post_code']);
        
        if(@$post['f_member_relation'][0]){
            $premi1 = 0;
            foreach (@$post['f_benefit_id_1'] as $key => $value) {
                $premi1 = $premi1 + (int)$this->_get_premi(@$post['f_plan_id_1'][$key],@$post['f_benefit_id_1'][$key],@$post['f_member_relation'][0],'premi');
            }
        }
        if(@$post['f_member_relation'][1]){
            $premi2 = 0;
            foreach (@$post['f_benefit_id_2'] as $key => $value) {
                $premi2 = $premi2 + (int)$this->_get_premi(@$post['f_plan_id_2'][$key],@$post['f_benefit_id_2'][$key],@$post['f_member_relation'][1],'premi');
            }
        }
        if(@$post['f_member_relation'][2]){
            $premi3 = 0;
            foreach (@$post['f_benefit_id_3'] as $key => $value) {
                $premi3 = $premi3 + (int)$this->_get_premi(@$post['f_plan_id_3'][$key],@$post['f_benefit_id_3'][$key],@$post['f_member_relation'][2],'premi');
            }
        }
        
        $premi = @$premi1 + @$premi2 + @$premi3 + (int)$ongkir;
        
        return array(
                    'premi_karyawan' => @$premi1,
                    'premi_pasangan' => @$premi2,
                    'premi_anak' => @$premi3,
                    'ongkir' => (int)$ongkir,
                    'total_premi' => $premi
                );
        
    }
    
    private function _get_premi($planid,$benid,$relid,$in){
        $this->db->select('f_premi')
                ->from('dbios.t_pol_plan_ben_premi')
                ->where('f_plan_id',$planid)
                ->where('f_benefit_id',$benid)
                ->where('f_member_relation',$relid);
        if($in == 'premi'){
            return $this->db->get()->row()->f_premi;
        }
        
    }
    
    private function _get_ongkir($start){
        $this->db->select('f_post_fee')
                ->from('t_post_fee')
                ->where('f_post_code_end',trim($start));
            
        return $this->db->get()->row()->f_post_fee;
    }
    
    
}