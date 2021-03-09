<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_m extends CI_Model
{
	public function get_settings()
	{
		return $this->db->get('tb_app_setting', 1)->row_array();
	}
}

/* End of file app_m.php */
/* Location: ./application/models/app_m.php */