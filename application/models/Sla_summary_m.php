<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sla_summary_m extends CI_Model
{
	public function get_isp()
	{
		return $this->db->get('tb_isp')->result_array();
	}

	public function get_isp_by_slug($slug = NULL)
	{
		$this->db->where('slug', $slug);
		return $this->db->get('tb_isp')->row_array();
	}

	public function get_isp_data($isp)
	{
		$this->db->select('slug, isp_name, sla_standard');
		$this->db->where('isp_id', $isp);
		return $this->db->get('tb_isp')->row();
	}

	public function get_monthly($isp, $month)
	{
		$month = date('Ym', $month);

		$this->db->select('a.*, b.isp_name, b.sla_standard');
		$this->db->join('tb_isp b', 'a.isp_id = b.isp_id', 'inner');
		$this->db->where('b.slug', $isp);
		$this->db->where('date_format(a.downtime, "%Y%m") = ', $month);
		return $this->db->get('tb_sla a')->result_array();
	}

	public function chart($isp, $month)
	{
		$month = date('Y-m', $month);

		$this->db->select('SUM(a.duration) AS total_down, b.sla_standard');
		$this->db->join('tb_isp b', 'a.isp_id = b.isp_id', 'inner');
		$this->db->where('b.slug', $isp);
		$this->db->where('date_format(a.downtime, "%Y-%m") = ', $month);
		$chart = $this->db->get('tb_sla a')->row();

		$month      = explode("-", $month);
		$cnt_days	= cal_days_in_month(CAL_GREGORIAN, $month[1], $month[0]);
		$mnt_in_mth = $cnt_days	* 24 * 60;
		$up_wajar	= round(($chart->sla_standard * $mnt_in_mth)/100, 2);
		$down_wajar	= $mnt_in_mth - $up_wajar;
		
		$durasi_up 	= $mnt_in_mth - ($chart->total_down + $down_wajar);

		$total_down = is_null($chart->total_down) ? 0 : $chart->total_down;
		return array(
			'uptime' => $durasi_up,
			'downtime' => $total_down,
			'wajar' => $down_wajar
		);
	}

	public function get_sla_by_id($id = NULL)
	{
		$id = decrypt($id);

		$this->db->where('md5(sla_id)', $id);
		return $this->db->get('tb_sla')->row_array();
	}

	public function edit_sla($post = array())
	{
		$start_date = new DateTime($post['downtime']);
		$since_start= $start_date->diff(new DateTime($post['uptime']));
		$duration	= ($since_start->days*24*60)+($since_start->h*60)+$since_start->i;
		$month 		= explode("-", $post['downtime']);
		$cnt_days	= cal_days_in_month(CAL_GREGORIAN, $month[1], $month[0]);
        $mnt_in_mth = $cnt_days*24*60;
        $tolerance 	= $mnt_in_mth - (($this->get_isp_data($post['isp_id'])->sla_standard * $mnt_in_mth)/100);

		$upDuration = $mnt_in_mth - ($duration + $tolerance);
		$percentage	= ($upDuration/$mnt_in_mth)*100 - $this->get_isp_data($post['isp_id'])->sla_standard;
		$percentage = round($percentage, 2);

		$sla = array(
			'isp_id' => $post['isp_id'],
			'downtime' => $post['downtime'],
			'uptime' => $post['uptime'],
			'duration' => $duration,
			'percentage' => $percentage,
			'cause' => $post['cause'],
			'solution' => $post['solution']
		);

		$this->db->where('md5(sla_id)', decrypt($post['sla_id']));
		$update = $this->db->update('tb_sla', $sla) ? true : false;

		$timestamp = explode('-', $post['downtime']);
		
		if($update)
		{
			$config = array(
				'log_type' => 'sla-summary',
				'item' => 'downtime for ISP '.$this->get_isp_data($post['isp_id'])->isp_name,
				'pic' => $this->user['user_name'],
				'action' => 'edited'
			);
			$this->load->library('logging');
			$this->logging->initialize($config);
			$this->logging->add_log();

			$status = true;
		}
		else
		{
			$status  = false;
		}

		return [
			'status' => $status, 
			'period' => strtotime(date($timestamp[0].'-'.$timestamp[1])), 
			'isp' => $this->get_isp_data($post['isp_id'])->slug
		];
	}

	public function delete_sla($id = NULL)
	{
		$this->db->select('b.isp_name, date_format(a.downtime, "%d %M %Y") AS dates');
		$this->db->join('tb_isp b', 'a.isp_id = b.isp_id', 'inner');
		$this->db->where('md5(a.sla_id)', decrypt($id));
		$isp = $this->db->get('tb_sla a')->row();

		$this->db->where('md5(sla_id)', decrypt($id));
		$delete = $this->db->delete('tb_sla');

		if($delete)
		{
			$config = array(
				'log_type' => 'sla-summary',
				'item' => 'downtime at '. $isp->dates .' for ISP '.$isp->isp_name,
				'pic' => $this->user['user_name'],
				'action' => 'deleted'
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

/* End of file Sla_summary_m.php */
/* Location: ./application/models/Sla_summary_m.php */