<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Isp_m extends CI_Model
{
	public function get_isp()
	{
		return $this->db->get('tb_isp')->result_array();
	}
	
	public function get_isp_by_id($id = NULL)
	{
		$this->db->where('md5(isp_id)', decrypt($id));
		return $this->db->get('tb_isp')->row_array();
	}

	public function add_isp($post = array())
	{
		$isp = array(
			'slug' => strtolower(str_replace(' ', '-', $post['isp_name'])),
			'isp_name' => $post['isp_name'],
			'sla_standard' => $post['sla_standard']
		);

		$insert = $this->db->insert('tb_isp', $isp) ? true : false;

		if($insert)
		{
			$config = array(
				'log_type' => 'service',
				'item' => 'ISP '.$post['isp_name'],
				'pic' => $this->user['user_name'],
				'action' => 'added'
			);
			$this->load->library('logging');
			$this->logging->initialize($config);
			$this->logging->add_log();

			return true;
		}
	}

	public function edit_isp($post = array())
	{
		$isp = array(
			'slug' => strtolower(str_replace(' ', '-', $post['isp_name'])),
			'isp_name' => $post['isp_name'],
			'sla_standard' => $post['sla_standard']
		);

		$this->db->where('md5(isp_id)', decrypt($post['isp_id']));
		$update = $this->db->update('tb_isp', $isp) ? true : false;

		if($update)
		{
			$config = array(
				'log_type' => 'service',
				'item' => 'ISP '.$post['isp_name'],
				'pic' => $this->user['user_name'],
				'action' => 'edited'
			);
			$this->load->library('logging');
			$this->logging->initialize($config);
			$this->logging->add_log();

			return true;
		}
	}

	public function delete_isp($id = NULL)
	{
		$isp = $this->get_isp_by_id($id);

		$this->db->where('md5(isp_id)', decrypt($id));
		$delete = $this->db->delete('tb_isp');

		if($delete)
		{
			$config = array(
				'log_type' => 'service',
				'item' => 'ISP '.$isp['isp_name'],
				'pic' => $this->user['user_name'],
				'action' => 'deleted'
			);
			$this->load->library('logging');
			$this->logging->initialize($config);
			$this->logging->add_log();

			return true;
		}
	}
}

/* End of file isp_m.php */
/* Location: ./application/models/isp_m.php */