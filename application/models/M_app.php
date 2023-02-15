<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_app extends MY_Model
{

	public function getData($data)
	{
		$data = $this->db->get($data);
		$result = null;
		if ($data->num_rows() > 0) {
			$result = $data->row();
		}
		return $result;
	}

	public function editInstansi($param)
	{
		$object = [
			"nama_resmi" => $param['nama_resmi'],
			"nama_pendek" => $param['nama_pendek'],
			"alamat" => $param['alamat'],
			"no_telp" => $param['no_telp'],
			"updated_by" => getSession('userId'),
		];
		$proses = $this->db->where(['id_nama_pt' => 1])->update("ref_perguruan_tinggi", $object);
		return $proses;
	}

	public function get_chating()
	{
		$this->db->select('chating.*,userl.username n_user');
		$this->db->join('userl', 'userl.id = chating.user');
		$this->db->order_by('id', 'DESC');
		$this->db->from('chating');
		$data = $this->db->get();

		return $data->result();
	}

	public function add_chat($chat)
	{
		$userId = getSession('userId');
		$now = date('Y-m-d h:i:s');
		$object = [
			"user" => $userId,
			"chat" => $chat,
			"waktu" => $now,
		];
		$this->db->insert("chating", $object);
		return $this->db->affected_rows();
	}

	public function get_penjualan($bulan)
	{
		$now = date('Y');
		$this->db->select('SUM(total_penjualan) total');
		$this->db->from('hpenjualan');
		$this->db->where("MID(tanggal,1,7)", $now . '-' . $bulan);

		$data = $this->db->get('hpenjualan');

		return $data->row();
	}

	public function get_stat_perkiraan($bulan, $akun)
	{
		$now = date('Y');
		$this->db->select('(SUM(kredit) - SUM(debet))  total');
		$this->db->where("MID(tanggal,1,7)", $now . '-' . $bulan);
		$this->db->where("akun", $akun);


		$data = $this->db->get('djurnal');

		return $data->row();
	}

	public function modulSistem()
	{
		$this->db->where(['is_active' => 1]);
		$data = $this->db->get('modul_sistem');
		$result = null;
		if ($data->num_rows() > 0) {
			$result = $data->result_array();
		}

		return $result;
	}

	public function userGroup()
	{
		$data = $this->db->get('user_group');
		$result = null;
		if ($data->num_rows() > 0) {
			$result = $data->result_array();
		}

		return $result;
	}

	public function aksesGroup($id_group = null)
	{
		if (!empty($id_group)) {
			$this->db->where(['id_group' => $id_group]);
		}
		$data = $this->db->get('akses_group_modul');
		$result = null;
		if ($data->num_rows() > 0) {
			$result = $data->result_array();
		}

		return $result;
	}

	public function isExistModul($id_modul)
	{
		if (!empty($id_modul)) {
			$this->db->where(['id_modul' => $id_modul]);
		}
		$this->db->join('modul_sistem', 'modul_sistem.nama_modul = akses_group_modul.nama_modul');
		$data = $this->db->get('akses_group_modul');
		$result = null;
		if ($data->num_rows() > 0) {
			$result = $data->result_array();
		}

		return $result;
	}

	public function getUserGroup($group_id)
	{
		$this->db->where('id_group', $group_id);
		$data = $this->db->get('user_group');
		return $data->row_array();
	}

	public function updateGroupAccess($group_id, $access)
	{

		$this->db->trans_start();
		$this->removeUserGroupAccess($group_id);

		foreach ($access as $key => $value) {
			$this->setUserGroupAccess($group_id, $value, 'access');
		}

		$this->db->trans_complete();

		if ($this->db->trans_status() === TRUE) {
			$this->db->trans_commit();
			return true;
		} else {
			$this->db->trans_rollback();
			return false;
		}
	}

	public function setUserGroupAccess($group_id, $nama_modul, $hak)
	{
		$data = array(
			'id_group' => $group_id,
			'nama_modul' => $nama_modul,
			'hak_akses' => $hak
		);
		$this->db->insert('akses_group_modul', $data);
	}

	public function removeUserGroupAccess($group_id)
	{
		$this->db->where('id_group', $group_id);
		$this->db->delete('akses_group_modul');
	}

	public function editPerusahaan($data)
	{
		return $this->db->update('ref_perguruan_tinggi', $data);
	}
}
