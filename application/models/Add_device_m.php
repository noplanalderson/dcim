<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add_device_m extends CI_Model
{
	public function get_dev_groups()
	{
		$this->db->select('group_code, group_id, group_label');
		$this->db->order_by('group_label', 'asc');
		return $this->db->get('tb_dev_group')->result_array();
	}
	
	public function get_manufactures($group_id = NULL)
	{
		if(!is_null($group_id)):
			$this->db->where('group_id', $group_id);
		endif;

		$this->db->order_by('dev_manufacture', 'asc');
		return $this->db->get('tb_dev_manufacture')->result_array();
	}

	public function get_dev_models($dev_manufacture_id)
	{
		$this->db->select('dev_model_id, dev_model');
		$this->db->where('dev_manufacture_id', $dev_manufacture_id);
		$this->db->order_by('dev_model', 'asc');
		return $this->db->get('tb_dev_model')->result_array();
	}

	public function check_device($device_group, $device_number)
	{
		$this->db->select('device_id');
		$this->db->where('group_code', $device_group);
		$this->db->where('SPLIT_STRING(device_code, ".", 1) = ', $device_number);
		return $this->db->get('tb_devices')->num_rows();
	}

	public function add_device($device = array(), $identity = array())
	{
		if($this->db->insert('tb_devices', $device) == TRUE)
		{
			if($this->db->insert('tb_dev_identity', $identity) == TRUE)
			{
				$config = array(
					'log_type' => 'device',
					'item' => $device['device_code'],
					'pic' => $this->user['user_name'],
					'action' => 'added',
					'obj_link' => base_url('devices/detail/'.encrypt($device['device_code']))
				);
				$this->load->library('logging');
				$this->logging->initialize($config);
				$this->logging->add_log();

				$timeline = [
					'device_code' => $identity['device_code'],
					'installation_date' => date('Y-m-d'),
					'installation_location' => $identity['device_location'],
					'status' => $identity['device_status']
				];
				timeline($timeline);

				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
}

/* End of file add_device_m.php */
/* Location: ./application/models/add_device_m.php */