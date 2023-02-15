<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_persetujuan extends MY_Model
{

	protected $table = 'coa_penghubung';
	protected $primary_key = 'n_penghubung';
	protected $order_by = 'n_penghugung';
	protected $order_by_type = 'DESC';

	public function rab_pengajuan()
	{
		$data = $this->db->select('rab.*, coa.akun, nama, user.id_user, real_name')
			->from('rab')
			->join('coa', 'rab.mata_anggaran = coa.akun')
			->join('user', 'rab.id_user = user.id_user')
			->order_by('user.id_user', 'DESC')
			->get();
		return $data;
	}

	public function cek_pengajuan($id_user, $ta)
	{
		$data = $this->db->get_where('rab_pengajuan', ['id_user' => $id_user, 'ta' => $ta]);
		return $data;
	}

	public function insertPengajuan($data)
	{
		return $this->db->insert('rab_pengajuan', $data);
	}

	public function ubahTotal($where, $total)
	{
		return $this->db->where($where)->update('rab_pengajuan', ['total' => $total]);
	}

	public function getRabUser()
	{
		$data = $this->db->get_where('rab', ['id_user' => $this->session->userdata('t_userId')]);
		return $data;
	}


	public function ubahStatusWarek($where, $param)
	{
		return $this->db->where($where)->update('rab_pencairan', ['warek' => $param]);
	}
}
