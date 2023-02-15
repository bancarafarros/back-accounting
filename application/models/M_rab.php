<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_rab extends CI_model
{

	public function listRab()
	{
		$data = $this->db->get('rab');
		return $data;
	}

	public function getMataAnggaran()
	{
		// $this->db->select('*');
		// $this->db->from('coa');
		// $this->db->where('subgrup <> "" AND detail <> ""');
		// $this->db->select('rab.*, rd.detail, rd.jumlah');
		// $this->db->join('rab_detail rd', 'rab.id = rd.id_rab');
		$data = $this->db->get('rab');
		return $data->result();
	}

	public function getDetail($id_rab)
	{
		$this->db->where(['id_rab' => $id_rab]);
		$data = $this->db->get('rab_detail')->row_array();
		return $data;
	}

	public function getRabUser($id_user = null)
	{
		if (empty($id_user)) {
			$id_user = getSession('userId');
		}
		$this->db->select('rab.*, coa.akun, nama');
		$this->db->join('coa', 'rab.mata_anggaran = coa.akun');
		$this->db->where(['id_user' => $id_user]);
		$data = $this->db->get('rab');
		return $data;
	}

	public function detailRabUser($id_rab = null)
	{
		if ($id_rab != null) {
			$data = $this->db->where_in('id_rab', $id_rab)->get('drab');
			if ($data->num_rows() == 0) {
				return FALSE;
			} else {
				return $data->result();
			}
		}
		return FALSE;
	}

	public function getRabUserBy($id_rab)
	{
		$data = $this->db->select('rab.*, coa.akun, nama')
			->from('rab')
			->join('coa', 'rab.mata_anggaran = coa.akun')
			->where(['id' => $id_rab])
			->get()->result();
		return $data;
	}

	public function getDetailRab($table, $id)
	{
		$data = $this->db->select('rab.*, coa.akun, nama, user.id_user, real_name')
			->from('rab')
			->join('coa', 'rab.mata_anggaran = coa.akun')
			->join('user', 'rab.id_user = user.id_user')
			->order_by('user.id_user', 'DESC')
			->get();

		$data = $this->db->get_where($table, ['id' => $id])->result();
		return $data;
	}

	public function insertRab($param)
	{
		$ta = $this->session->userdata("thn_anggaran");
		$error = null;
		$return['status'] = null;
		$return['message'] =  null;
		$this->db->trans_start();
		$rab = [
			'mata_anggaran'	=> $param['akun'],
			'keterangan'	=> $param['keterangan'],
			'ta'			=> thn_anggaran(date('Y-m-d')),
			'id_user'		=> getSession('userId'),
			'total'			=> $param['total'],
			'created_by'	=> getSession('userId'),
		];
		$this->db->insert("rab", $rab);
		if ($this->db->error()["code"] != 0) {
			$error[] = [
				'error' => $this->db->error(),
				'query' => $this->db->last_query()
			];
		}
		$id_rab = $this->db->insert_id();

		if (!empty($param['detail']) && !empty($param['jumlah'])) {
			for ($i = 0; $i < count($param['detail']); $i++) {
				$detailRab = [
					'id_rab' => $id_rab,
					'detail' => $param['detail'][$i],
					'jumlah' => $param['jumlah'][$i],
					'created_by' => getSession('userId')
				];

				$this->db->insert('rab_detail', $detailRab);
				if ($this->db->error()["code"] != 0) {
					$error[] = [
						'error' => $this->db->error(),
						'query' => $this->db->last_query()
					];
				}
			}
		}
		$this->db->trans_complete();
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			$return['status'] =  true;
			$return['message'] = 'Tambah RAB berhasil';
		} else {
			$this->db->trans_rollback();
			$return['status'] =  false;
			$return['error'] = $error;
			$return['message'] = 'Tambah RAB gagal';
		}
		return $return;
	}

	public function editRab($where, $data)
	{
		// $rab = [
		// 	'mata_anggaran'=> $param['mata_anggaran'],
		// 	'keterangan'=> $param['keterangan'],
		// 	'detail'=>$param['detail'],
		// 	'total'=>$param['total']
		// ];

		return $this->db->where($where)->update('rab', $data);
	}

	public function ubahStatus($id_rab, $status)
	{
		return $this->db->where('id', $id_rab)->update('rab', ['status' => $status]);
	}

	public function hapus_rab($id_rab)
	{
		return $this->db->where('id', $id_rab)->delete('rab');
	}

	public function getRabTa($ta)
	{
		$data = $this->db->select('rab.*, coa.akun, coa.nama, user.id_user, user.real_name')
			->from('rab')
			->join('coa', 'rab.mata_anggaran = coa.akun')
			->join('user', 'rab.id_user = user.id_user')
			->where(['ta' => $ta])
			->order_by('user.id_user', 'DESC')
			->get();
		return $data;
	}

	public function getRab($id_rab)
	{
		$this->db->select('mata_anggaran, detail');
		$this->db->from('rab');
		$this->db->where("id", $id_rab);
		$data = $this->db->get();
		return $data->result();
	}

	public function getRabSetuju($id_rab)
	{
		return $this->db->get_where('rab', ['id' => $id_rab]);
	}

	public function ambilRabDG()
	{
		$this->db->select('rab.*, coa.nama')
			->from('rab')
			->join('coa', 'rab.mata_anggaran = coa.akun', 'left')
			->where(['id_user' => $this->session->userdata('t_userId'), 'status' => '2']);
		$data = $this->db->get();
		return $data->result();
	}
}
