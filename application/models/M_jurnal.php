<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_jurnal extends MY_Model
{

	protected $table = 'hjurnal';
	protected $primary_key = 'n_jurnal';
	protected $order_by = 'tanggal';
	protected $order_by_type = 'DESC';

	public function getDataHjurnal($now)
	{
		$this->db->where("MID(tanggal,1,7)", $now, true);
		$data = $this->db->get('hjurnal');

		return $this->setReturn($data, true, false);
	}

	public function getNotaJurnal($n_transaksi)
	{
		$this->db->select('hjurnal.*,djurnal.akun akun,djurnal.debet debet, djurnal.kredit kredit, coa.nama n_akun, perusahaan.nama as n_perusahaan, perusahaan.alamat as a_perusahaan, perusahaan.telepon as telp_perusahaan');
		$this->db->from('perusahaan');
		$this->db->join('djurnal', 'djurnal.n_jurnal = hjurnal.n_jurnal');
		$this->db->join('coa', 'coa.akun = djurnal.akun');
		$this->db->where('hjurnal.n_jurnal', $n_transaksi);
		$data = $this->db->get($this->table);

		return $data;
	}

	public function insertJurnal($param)
	{
		$return['status'] = false;
		$return['message'] = null;
		$error = null;
		$this->db->trans_start();
		$conv_date = strtotime($param['tanggal']);
		$tanggal = date('Y-m-d', $conv_date);

		//hjurnal
		$objectHjurn = [
			"n_jurnal" 		=> $param['no_jurnal'],
			"tanggal" 		=> $tanggal,
			"reff" 			=> $param['reff'],
			"keterangan"	=> $param['keterangan'],
			"jumlah" 		=> $param['total'],
			"statusA" 		=> "GL",
			"created_by"	=> getSession('userId'),
		];
		$this->insertHjurnal($objectHjurn);
		if ($this->db->error()["code"] != 0) {
			$error[] = [
				'error' => $this->db->error(),
				'query' => $this->db->last_query()
			];
		}

		//djurnal
		for ($br = 0; $br <= $param['jml_baris']; $br++) { // Mengubah < ke <= di $br < $param['jml_baris'], jika menggunakan <, data yang tidak dienter tidak akan masuk/terhitung ke database.
			if (@$param['akun' . $br]) {
				$objectDjurn = [
					"n_jurnal" 		=> $param['no_jurnal'],
					"tanggal" 		=> $tanggal,
					"akun" 			=> $param['akun' . $br],
					"debet" 		=> $param['adddebet' . $br],
					"kredit" 		=> $param['addkredit' . $br],
					"status_valid"	=> "a",
					"created_by"	=> getSession('userId'),
				];
				$this->insertDjurnal($objectDjurn);
				if ($this->db->error()["code"] != 0) {
					$error[] = [
						'error' => $this->db->error(),
						'query' => $this->db->last_query()
					];
				}
			}
		}
		$this->db->trans_complete();
		if ($this->db->trans_status() === TRUE) {
			$this->db->trans_commit();
			$return['status'] = true;
			$return['message'] = 'Jurnal berhasil disimpan';
		} else {
			$this->db->trans_rollback();
			$return['status'] = false;
			$return['message'] = 'Jurnal gagal disimpan';
		}
		return $return;
	}

	public function insertHjurnal($param)
	{
		if (empty($param['tanggal'])) {
			$param['tanggal'] = date('Y-m-d H:i:s');
		}
		return $this->db->insert($this->table, $param);
	}

	/**
	 * updateHjurnal
	 *
	 * @param  string or array $where
	 * @param  mixed $param
	 * @return void
	 */
	public function updateHjurnal($where, $param)
	{
		$this->db->where($where);
		return $this->db->update($this->table, $param);
	}

	public function insertDjurnal($param)
	{
		if (empty($param['tanggal'])) {
			$param['tanggal'] = date('Y-m-d H:i:s');
		}
		return $this->db->insert('djurnal', $param);
	}

	public function updateDjurnal($where, $param)
	{
		$this->db->where($where);
		return $this->db->update('djurnal', $param);
	}

	public function editJurnal($param)
	{
		$conv_date = strtotime($param['tanggal']);
		$tanggal = date('Y-m-d', $conv_date);
		$return['status'] = false;
		$return['message'] = null;
		$error = null;

		$this->db->trans_start();
		// $this->db->where("n_jurnal", $param['no_jurnal']);
		// $this->db->delete("djurnal");
		// if ($this->db->error()["code"] != 0) {
		// 	$error[] = [
		// 		'error' => $this->db->error(),
		// 		'query' => $this->db->last_query()
		// 	];
		// }

		//hjurnal
		$objectHjurn = [
			"keterangan" => $param['keterangan'],
			"jumlah" => $param['total'],
			"updated_by" => getSession('userId'),
		];
		$this->db->where("n_jurnal", $param['no_jurnal']);
		$this->db->update("hjurnal", $objectHjurn);
		if ($this->db->error()["code"] != 0) {
			$error[] = [
				'error' => $this->db->error(),
				'query' => $this->db->last_query()
			];
		}

		//djurnal
		for ($br = 0; $br <= $param['sum_baris']; $br++) {
			if (@$param['akun' . $br]) {
				$objectDjurn = [
					// "n_jurnal" 		=> $param['no_jurnal'],
					"tanggal" 		=> $tanggal,
					// "akun" 			=> $param['akun' . $br],
					"debet" 		=> $param['debet' . $br],
					"kredit" 		=> $param['kredit' . $br],
					// "status_valid" 	=> "a",
					"updated_by"	=> getSession('userId'),
				];

				// $this->insertDjurnal($objectDjurn);
				$this->db->where(['n_jurnal' => $param['no_jurnal'], 'akun' => $param['akun' . $br]]);
				$this->db->update('djurnal', $objectDjurn);
				if ($this->db->error()["code"] != 0) {
					$error[] = [
						'error' => $this->db->error(),
						'query' => $this->db->last_query()
					];
				}
			}
		}
		$this->db->trans_complete();
		if ($this->db->trans_status() === TRUE) {
			$this->db->trans_commit();
			$return['status'] = true;
			$return['message'] = 'Jurnal berhasil diubah';
		} else {
			$this->db->trans_rollback();
			$return['status'] = false;
			$return['message'] = 'Jurnal gagal diubah';
		}
		return $return;
	}

	public function deleteJurnal($n_jurnal)
	{
		$error = null;
		$return['status'] = false;
		$return['message'] = null;
		$this->db->trans_start();
		$this->db->where("n_jurnal", $n_jurnal);
		$this->db->delete("djurnal");
		if ($this->db->error()["code"] != 0) {
			$error[] = [
				'error' => $this->db->error(),
				'query' => $this->db->last_query()
			];
		}
		$this->db->where('n_jurnal', $n_jurnal);
		$this->db->delete('hjurnal');
		if ($this->db->error()["code"] != 0) {
			$error[] = [
				'error' => $this->db->error(),
				'query' => $this->db->last_query()
			];
		}

		$this->db->trans_complete();
		if ($this->db->trans_status() === TRUE) {
			$this->db->trans_commit();
			$return['status'] = true;
			$return['message'] = 'Hapus jurnal berhasil';
		} else {
			$this->db->trans_rollback();
			$return['status'] = false;
			$return['error'] = $error;
			$return['message'] = 'Hapus jurnal gagal';
		}
		return $return;
	}

	public function getPerkiraan($akun)
	{
		$this->db->select('nama');
		$this->db->where("akun", $akun);
		$this->db->from('coa');
		$data = $this->db->get();

		return $data->result();
	}

	public function ambilCoa()
	{
		$this->db->select('*');
		$this->db->from('coa');
		$this->db->where('subgrup <> "" AND detail <> ""');
		$data = $this->db->get();
		return $data->result();
	}

	public function ambilCoaGrup($grup)
	{
		$this->db->where('subgrup <> "" AND detail <> ""');
		$this->db->where("grup", $grup);
		$data = $this->db->get('coa')->result();
		return $data;
	}

	public function ambilCoaDG()
	{
		$this->db->select('*');
		$this->db->from('coa');
		$this->db->where('subgrup <> "" AND detail <> ""');
		$data = $this->db->get();
		return $data->result();
	}

	public function ambilCoaDG_by($akun)
	{
		$this->db->select('akun, nama');
		$this->db->from('coa');
		$this->db->where('subgrup <> "" AND detail <> ""');
		$this->db->where("akun", $akun);
		$data = $this->db->get();
		return $data->result();
	}

	public function getNoJurnal()
	{
		$this->db->select('n_jurnal');
		$this->db->limit(1);
		$this->db->order_by('n_jurnal', "DESC");
		$data = $this->db->get("hjurnal")->result();
		return $data[0];
	}

	public function getNoLast($order, $tabel)
	{
		$this->db->from($tabel);
		$this->db->select("*");
		$this->db->order_by($order, "DESC");
		$data = $this->db->get()->result();
		return $data[0];
	}

	public function getNoLastTransaksi($order, $tabel, $userId, $kode)
	{
		$this->db->from($tabel);
		$this->db->select("MAX(RIGHT($order,4)) as 'n_last'", false);
		$this->db->where("MID($order,7,1)", $userId, true);
		$this->db->where("MID($order,1,2)", $kode, true);
		$data = $this->db->get()->result();
		return $data[0];
	}

	public function get_detail($n_jurnal)
	{
		$hasil = $this->db->query("SELECT djurnal.akun, coa.nama as nama_akun,djurnal.debet, djurnal.kredit FROM djurnal INNER JOIN coa ON coa.akun = djurnal.akun WHERE n_jurnal='$n_jurnal' ORDER BY djurnal.debet DESC, djurnal.akun ASC");
		return $hasil->result();
	}

	public function getPenghubung($param)
	{
		$this->db->where("n_penghubung", $param);
		$data = $this->db->get("coa_penghubung")->result();
		return $data[0];
	}

	function cekAkunCoa($perk)
	{
		$this->db->select('*');
		$this->db->from('coa');
		$this->db->where('akun', $perk);
		$this->db->limit(1);
		$query = $this->db->get();
		if ($query->num_rows() == 0) {
			return FALSE;
		} else {
			return $query->result();
		}
	}

	function getDataDelete($table, $param)
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($param);
		$query = $this->db->get();
		if ($query->num_rows() == 0) {
			return FALSE;
		} else {
			return $query->result();
		}
	}

	public function createHjurnal($data)
	{
		return $this->db->insert($this->table, $data);
	}

	public function createDjurnal($data)
	{
		return $this->db->insert('djurnal', $data);
	}

	public function dataTableJurnal($params)
	{
		$return = array('total' => 0, 'rows' => array());
		$this->db->start_cache();
		$this->db->from($this->table);
		if (!empty($params['tahunbulan'])) {
			$this->db->where("MID(tanggal,1,7)", $params['tahunbulan']);
		}
		if (!empty($params['sSearch'])) {
			$this->db->group_start();
			$this->db->like(['keterangan' => $params['sSearch']]);
			$this->db->or_like(['reff' => $params['sSearch']]);
			$this->db->or_like(['n_jurnal' => $params['sSearch']]);
			$this->db->group_end();
		}

		$rs = $this->db->count_all_results();

		$return['total'] = $rs;
		if ($return['total'] > 0) {
			$this->db->limit($params['limit'], $params['start']);
			$this->db->order_by('n_jurnal', 'DESC');
			$rs = $this->db->get();

			if ($rs->num_rows()) {
				$return['rows'] = $rs->result_array();
			}
		}
		$this->db->flush_cache();

		return $return;
	}

	public function getDataKasMasuk()
	{
		$this->db->where(['statusA' => 'Km']);
		$data = $this->db->get($this->table);

		return $this->setReturn($data, true, false);
	}

	public function getDataKasKeluar()
	{
		$this->db->where(['statusA' => 'KK']);
		$data = $this->db->get($this->table);

		return $this->setReturn($data, true, false);
	}
}
