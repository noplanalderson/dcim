<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add_sla_m extends CI_Model
{
	public function get_isp()
	{
		$this->db->select('isp_id, isp_name');
		return $this->db->get('tb_isp')->result_array();
	}
	
	public function get_isp_data($isp)
	{
		$this->db->select('isp_name, sla_standard');
		$this->db->where('isp_id', $isp);
		return $this->db->get('tb_isp')->row();
	}

	public function add_sla($post = array())
	{
		$start_date = new DateTime($post['downtime']);
		$since_start= $start_date->diff(new DateTime($post['uptime']));
		$duration	= ($since_start->days*24*60)+($since_start->h*60)+$since_start->i;
		$month 		= explode("-", $post['downtime']);
		$cnt_days	= cal_days_in_month(CAL_GREGORIAN, $month[1], $month[0]);
        $mnt_in_mth = $cnt_days*24*60;
        $tolerance 	= $mnt_in_mth - (($this->get_isp_data($post['isp'])->sla_standard * $mnt_in_mth)/100);

		$upDuration = $mnt_in_mth - ($duration + $tolerance);
		$percentage	= ($upDuration/$mnt_in_mth)*100 - $this->get_isp_data($post['isp'])->sla_standard;
		$percentage = round($percentage, 2);

		$sla = array(
			'isp_id' => $post['isp'],
			'downtime' => $post['downtime'],
			'uptime' => $post['uptime'],
			'duration' => $duration,
			'percentage' => $percentage,
			'cause' => $post['reason'],
			'solution' => $post['solution']
		);

		$insert = $this->db->insert('tb_sla', $sla) ? true : false;

		if($insert)
		{
			$config = array(
				'log_type' => 'sla-summary',
				'item' => 'downtime for ISP '.$this->get_isp_data($post['isp'])->isp_name,
				'pic' => $this->user['user_name'],
				'action' => 'added'
			);
			$this->load->library('logging');
			$this->logging->initialize($config);
			$this->logging->add_log();

			return true;
		}
		else
		{
			return false;
		}
	}
}

/* End of file add_sla_m.php */
/* Location: ./application/models/add_sla_m.php */