<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signin_m extends CI_Model {

	public function get_questions()
	{
		return $this->db->get('tb_sec_question')->result_array();
	}
	
	public function user_info()
	{
		$this->db->select('a.user_name, a.last_login, a.user_picture, b.user_group');
		$this->db->join('tb_user_group b', 'a.user_group_id = b.user_group_id', 'inner');
		$this->db->where('a.user_id', $this->session->userdata('uid'));
		return $this->db->get('tb_user a')->row_array();
	}

	public function check_user(array $data)
	{
		$this->db->select('user_id, user_name, user_group_id, user_password');
		$this->db->where('user_name', $data['username']);
		$this->db->or_where('user_email', $data['username']);
		return $this->db->get('tb_user');
	}

	public function check_data($post = array())
	{
		$this->db->select('user_name');
		$this->db->where('user_email', $post['user_email']);
		$this->db->where('user_name', $post['user_name']);
		$this->db->where('sec_question_id', $post['sec_question']);
		$this->db->where('sec_answer', $post['sec_answer']);
		return $this->db->get('tb_user')->num_rows();
	}

	public function reset_password($post = array())
	{
		// $password = $this->password_generator(8, false, 'luds');

		// $this->load->library('email');
		
		// $from = $this->config->item('smtp_user');

	 //    $this->email->set_newline("\r\n");
	 //    $this->email->from($from);
	 //    $this->email->to($post['user_email']);
	 //    $this->email->subject("PASSWORD RESET REQUEST DATA CENTER INVENTORY MANAGEMENT APPS - KOTA TANGERANG");
	 //    $this->email->message("YOUR ACCOUNT PASSWORD HAS CHANGE\n\n
	 //    					Use this account to login into application :\n
	 //    					Username : ".$post['user_name']."\n
	 //    					Password : ".$password."\n");
	 //    $this->email->send();

	    $this->db->where('user_name', $post['user_name']);

		return $this->db->update(
			'tb_user', 
			['user_password' => password_hash($post['password'], PASSWORD_ARGON2ID)]
		) ? true : false;
	}

	private function password_generator($panjang = 8, $strip = false, $format_pwd = 'luds')
	{
		$format = array();

		if(strpos($format_pwd, 'l') !== false)
			$format[] = 'abcdefghjkmnpqrstuvwxyz';
		if(strpos($format_pwd, 'u') !== false)
			$format[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
		if(strpos($format_pwd, 'd') !== false)
			$format[] = '123456789';
		if(strpos($format_pwd, 's') !== false)
			$format[] = '!@#$%&*?';

		$all = '';
		$password = '';

		foreach($format as $set)
		{
			$password .= $set[array_rand(str_split($set))];
			$all .= $set;
		}

		$all = str_split($all);
		
		for($i = 0; $i < $panjang - count($format); $i++)
			$password .= $all[array_rand($all)];
			$password = str_shuffle($password);
		
		if(!$strip) return $password;
		
		$dash_len = floor(sqrt($panjang));
		$dash_str = '';
		
		while(strlen($password) > $dash_len)
		{
			$dash_str .= substr($password, 0, $dash_len) . '-';
			$password = substr($password, $dash_len);
		}
		
		$dash_str .= $password;
		
		return $dash_str;
	}
}

/* End of file login_m.php */
/* Location: ./application/models/signin_m.php */