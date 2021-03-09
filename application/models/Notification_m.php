<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification_m extends CI_Model
{
	public function get_notifications($limit = NULL)
	{
		$this->db->select('date_format(action_date, "%d %M %Y") AS date_act, 
							date_format(action_date, "%H:%i") AS hour, action');
		$this->db->order_by('log_id', 'desc');
		if($limit !== NULL) {
			$this->db->limit($limit);
		}
		return $this->db->get('tb_logs')->result_array();
	}

	public function count()
	{
		$this->db->select('log_id');
		$this->db->where('status', 'UNREAD');
		return $this->db->get('tb_logs')->num_rows();
	}

	public function fetch($limit = NULL)
	{
		if(!is_null($limit))
		{
			$this->db->order_by('log_id', 'desc');
			$this->db->limit($limit);
		}
		$this->db->update('tb_logs', array('status' => 'READ'));
	}
}

/* End of file notification_m.php */
/* Location: ./application/models/notification_m.php */