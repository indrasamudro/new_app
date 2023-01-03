<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class m_api extends CI_Model {

	function log_model($param){

		$sql = "SELECT mu.user_id, mu.user_name, mu.user_password, mu.user_salt_encrypt, mu.user_status, mu.par_id, mu.employee_id,
		 hre.employee_name , mu.siswa_id, mu.dosen_id,hre.employee_nik,mu.person_name 
		 FROM ms_user  mu LEFT JOIN employee hre ON hre.employee_id = mu.employee_id 
		 WHERE user_name = '".$param['user_name']."' AND user_password = '".$param['user_password']."'";
		$query = $this->db->query($sql); 		
			return $query->result();
		
	}

	function get_item($req){

		$sql = "SELECT item_code,item_name,price_hpp as harga FROM ms_item i
		join ms_classification ms on i.classification_id = ms.classification_id
		WHERE lower(classification_name) like '%".$req['term']."%' 
		";
		$query = $this->db->query($sql); 		
			return $query->result();		
	}


	function order($input){
		//$input=[];
		
		$this->db->trans_begin();			
			$this->db->insert('tb_order', $input);
			$dt=$this->db->insert_id();	
			if ($this->db->trans_status() === FALSE)
				{
					$this->db->trans_rollback();
					return false;
				}else{
					$this->db->trans_commit();
					return $dt;
				}
		
	}
}