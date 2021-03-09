<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Userman_m extends CI_Model
{
	public function get_users()
	{
		$this->db->select('a.user_id, a.user_name, a.user_email, a.last_login, a.user_status, b.user_group');
		$this->db->join('tb_user_group b', 'a.user_group_id = b.user_group_id', 'inner');
		$this->db->where('a.user_id != ', $this->session->userdata('uid'));
		$this->db->order_by('a.user_name', 'asc');
		return $this->db->get('tb_user a')->result_array();
	}
	
	public function get_questions()
	{
		return $this->db->get('tb_sec_question')->result_array();
	}

	public function get_user_groups()
	{
		$this->db->order_by('user_group', 'asc');
		return $this->db->get('tb_user_group')->result_array();
	}

	public function get_user_by_id($id = NULL)
	{
		$this->db->select('user_group_id, user_name, user_email, sec_question_id, sec_answer, user_picture, user_status');
		$this->db->where('md5(user_id)', decrypt($id));
		return $this->db->get('tb_user')->row_array();
	}

	public function check_username($username, $id = NULL)
	{
		$this->db->select('user_name');
		$this->db->where('user_name', $username);
		if(!is_null($id)) $this->db->where('md5(user_id) != ', decrypt($id));
		return $this->db->get('tb_user')->num_rows();
	}

	public function add_user($post = array(), $picture)
	{
		$password = $this->password_generator(8, false, 'luds');

		$this->load->library('email');
		
		$from = $this->config->item('smtp_user');

	    $this->email->set_newline("\r\n");
	    $this->email->from($from);
	    $this->email->to($post['email']);
	    $this->email->subject("DATA CENTER INVENTORY MANAGEMENT APPS - KOTA TANGERANG");
	    $this->email->message("YOUR EMAIL WAS REGISTERED ON DATA CENTER INVENTORY MANAGEMENT APPS - KOTA TANGERANG\n\n
	    					Use this account to login into application :\n
	    					Username : ".$post['username']."\n
	    					Password : ".$password."\n");
	    $this->email->send();

		$user = array(
			'user_group_id' => $post['user_group'],
			'sec_question_id' => $post['question'],
			'user_name' => strtolower($post['username']),
			'user_password' => password_hash($password, PASSWORD_ARGON2ID),
			'user_email' => strtolower($post['email']),
			'sec_answer' => $post['answer'],
			'user_picture' => $picture,
			'last_login' => NULL,
			'user_status' => $post['status']
		);

		return $this->db->insert('tb_user', $user) ? true : false;
	}

	public function edit_user($post = array(), $picture)
	{
		$user = array(
			'user_group_id' => $post['user_group'],
			'sec_question_id' => $post['question'],
			'user_name' => strtolower($post['username']),
			'user_email' => strtolower($post['email']),
			'sec_answer' => $post['answer'],
			'user_picture' => $picture,
			'user_status' => $post['status']
		);

		$this->db->where('md5(user_id)', decrypt($post['user_id']));
		return $this->db->update('tb_user', $user) ? true : false;
	}

	public function delete_user($id = NULL)
	{
		$this->db->select('user_name');
		$this->db->where('md5(user_id)', decrypt($id));
		$user = $this->db->get('tb_user')->row();

		$files = glob('./assets/wp-content/image/user/'.encrypt($user->user_name).'/*');
		foreach($files as $file)
		{
		  if(is_file($file)) unlink($file);
		}

		if(rmdir('./assets/wp-content/image/user/'.encrypt($user->user_name)))
		{
			$this->db->where('md5(user_id)', decrypt($id));
			return $this->db->delete('tb_user') ? true : false;
		}
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

/* End of file userman_m.php */
/* Location: ./application/models/userman_m.php */