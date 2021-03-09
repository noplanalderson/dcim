<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account_m extends CI_Model
{
	public function get_user_data()
	{
		$this->db->select('user_name, sec_question_id, user_email, sec_answer, user_picture');
		$this->db->where('user_id', $this->session->userdata('uid'));
		return $this->db->get('tb_user')->row_array();
	}
	
	public function get_questions()
	{
		$this->db->order_by('sec_question', 'asc');
		return $this->db->get('tb_sec_question')->result_array();
	}

	public function check_username($username)
	{
		$this->db->select('user_name');
		$this->db->where('user_name', $username);
		$this->db->where('user_id != ', $this->session->userdata('uid'));
		return $this->db->get('tb_user')->num_rows();
	}

	public function account_setting($post = array(), $picture = NULL)
	{
		$account = array(
			'sec_question_id' => $post['question'],
			'user_name' => strtolower($post['username']), 
			'user_password' => password_hash($post['password'], PASSWORD_ARGON2ID),
			'user_email' => strtolower($post['email']),
			'sec_answer' => $post['answer'],
			'user_picture' => $picture
		);

		$this->db->where('user_id', $this->session->userdata('uid'));
		return $this->db->update('tb_user', $account) ? true : false;
	}
}

/* End of file account_m.php */
/* Location: ./application/models/account_m.php */