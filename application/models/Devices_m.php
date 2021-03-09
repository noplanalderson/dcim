<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Devices_m extends CI_Model
{
	public function get_groups()
	{
		$this->db->select('group_label');
		return $this->db->get('tb_dev_group')->result_array();
	}

	public function get_devices($group = NULL)
	{
		$this->db->select('a.device_id, a.device_code, a.group_code, a.processor_type, a.cores, 
							a.memory_model, a.memory_cap, a.hdd_model, a.hdd_cap,
							b.hostname, b.serial_number, b.procurement, b.device_location, 
							b.rack_number, b.device_status, b.device_owner,
							c.dev_manufacture, d.dev_model');
		$this->db->join('tb_dev_identity b', 'a.device_code = b.device_code', 'left');
		$this->db->join('tb_dev_manufacture c', 'a.dev_manufacture_id = c.dev_manufacture_id', 'left');
		$this->db->join('tb_dev_model d', 'a.dev_model_id = d.dev_model_id', 'left');
		$this->db->join('tb_dev_group e', 'a.group_code = e.group_code', 'left');
		if(!is_null($group) && !empty($group)){
			$this->db->where('e.group_label', $group);
		}
		$this->db->order_by('a.device_code', 'asc');
		$this->db->order_by('b.rack_number', 'asc');
		return $this->db->get('tb_devices a')->result_array();
	}
	
	public function get_device_by_id($id = NULL)
	{
		$id = decrypt($id);

		$this->db->select('a.device_id, a.device_code, a.group_code, a.dev_manufacture_id, 
							a.dev_model_id, a.processor_type, a.cores, 
							a.memory_model, a.memory_cap, a.hdd_model, 
							a.hdd_cap, a.eth_port, a.console_port, a.usb_port, 
							b.serial_number, b.hostname, b.operating_system, b.os_architecture,
							b.procurement, b.device_location, b.rack_number, b.device_owner, 
							b.device_status, b.device_picture, c.group_label, d.dev_manufacture, e.dev_model');
		$this->db->join('tb_dev_identity b', 'a.device_code = b.device_code', 'inner');
		$this->db->join('tb_dev_group c', 'a.group_code = c.group_code', 'left');
		$this->db->join('tb_dev_manufacture d', 'a.dev_manufacture_id = d.dev_manufacture_id', 'left');
		$this->db->join('tb_dev_model e', 'a.dev_model_id = e.dev_model_id', 'left');
		$this->db->where('md5(a.device_id)', $id);
		$this->db->or_where('md5(a.device_code)', $id);
		return $this->db->get('tb_devices a')->row_array();
	}

	public function get_timeline($id = NULL)
	{
		$id = decrypt($id);

		$this->db->select('a.installation_date, a.installation_location, a.status, 
							c.hostname, b.group_code, b.device_code, d.group_label');
		$this->db->join('tb_devices b', 'a.device_code = b.device_code', 'left');
		$this->db->join('tb_dev_identity c', 'b.device_code = c.device_code', 'left');
		$this->db->join('tb_dev_group d', 'b.group_code = d.group_code', 'left');
		$this->db->where('md5(b.device_id)', $id);
		$this->db->order_by('a.installation_date', 'asc');
		return $this->db->get('tb_timeline a')->result_array();
	}

	public function check_device($device_group, $device_number, $device_id)
	{
		$this->db->select('device_id');
		$this->db->where('group_code', $device_group);
		$this->db->where('SPLIT_STRING(device_code, ".", 1) = ', $device_number);
		$this->db->where('md5(device_id) != ', decrypt($device_id));
		return $this->db->get('tb_devices')->num_rows();
	}

	public function edit_device($device = array(), $identity = array(), $id)
	{
		$this->db->where('md5(device_id)', decrypt($id));
		$update_device = $this->db->update('tb_devices', $device) ? true : false;
		if($update_device == true)
		{
			$this->db->where('device_code', $identity['device_code']);
			$update_identity = $this->db->update('tb_dev_identity', $identity) ? true : false;
			if($update_identity == TRUE)
			{
				$config = array(
					'log_type' => 'device',
					'item' => $device['device_code'],
					'pic' => $this->user['user_name'],
					'action' => 'edited',
					'obj_link' => base_url('devices/detail/'.$id)
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

	public function get_image($id = NULL)
	{
		$this->db->select('device_code, device_picture');
		$this->db->where('md5(device_code)', decrypt($id));
		return $this->db->get('tb_dev_identity')->row();
	}

	public function delete_device($id = NULL)
	{
		$this->db->where('md5(device_code)', decrypt($id));
		return $this->db->delete('tb_devices') ? true : false;
	}

	public function get_devices_by_rack($rack = NULL)
	{
		$this->db->select('a.device_id, a.device_code, a.group_code, a.processor_type, a.cores, 
							a.memory_model, a.memory_cap, a.hdd_model, a.hdd_cap,
							b.hostname, b.serial_number, b.procurement, b.device_location, 
							b.device_status, b.device_owner,
							c.dev_manufacture, d.dev_model');
		$this->db->join('tb_dev_identity b', 'a.device_code = b.device_code', 'left');
		$this->db->join('tb_dev_manufacture c', 'a.dev_manufacture_id = c.dev_manufacture_id', 'left');
		$this->db->join('tb_dev_model d', 'a.dev_model_id = d.dev_model_id', 'left');
		$this->db->join('tb_dev_group e', 'a.group_code = e.group_code', 'left');
		if(!is_null($rack)){
			$this->db->where('b.rack_number', $rack);
		}
		$this->db->order_by('a.device_code', 'asc');
		$this->db->order_by('b.rack_number', 'asc');
		return $this->db->get('tb_devices a')->result_array();
	}

	public function get_racks()
	{
		$this->db->select('rack_number');
		$this->db->group_by('rack_number');
		$this->db->where('rack_number != ', 0);
		$this->db->order_by('rack_number', 'asc');
		return $this->db->get('tb_dev_identity')->result_array();
	}

	public function get_devices_by_year($year = NULL)
	{
		$this->db->select('a.device_id, a.device_code, a.group_code, a.processor_type, a.cores, 
							a.memory_model, a.memory_cap, a.hdd_model, a.hdd_cap,
							b.hostname, b.serial_number, b.procurement, b.device_location, 
							b.rack_number, b.device_status, b.device_owner,
							c.dev_manufacture, d.dev_model');
		$this->db->join('tb_dev_identity b', 'a.device_code = b.device_code', 'left');
		$this->db->join('tb_dev_manufacture c', 'a.dev_manufacture_id = c.dev_manufacture_id', 'left');
		$this->db->join('tb_dev_model d', 'a.dev_model_id = d.dev_model_id', 'left');
		$this->db->join('tb_dev_group e', 'a.group_code = e.group_code', 'left');
		if(!is_null($year)){
			$this->db->where('b.procurement', $year);
		}
		$this->db->order_by('a.device_code', 'asc');
		$this->db->order_by('b.rack_number', 'asc');
		return $this->db->get('tb_devices a')->result_array();
	}

	public function get_years()
	{
		$this->db->select('procurement');
		$this->db->group_by('procurement');
		$this->db->order_by('procurement', 'asc');
		return $this->db->get('tb_dev_identity')->result_array();
	}
}

/* End of file devices_m.php */
/* Location: ./application/models/devices_m.php */