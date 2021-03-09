<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signout_m extends CI_Model 
{
	public function signout()
	{
		$uid = $this->session->userdata('uid');
		$time = $this->session->userdata('time');

		$this->db->where('user_id', $uid);
		$this->db->update('tb_user', array('last_login' => $time));
	}	

}

/* End of file logout_m.php */
/* Location: ./application/models/logout_m.php */