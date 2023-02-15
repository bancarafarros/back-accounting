<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_daftarsaldo extends MY_Model
{

	protected $table = 'coa';

	public function getDataRange($from_date, $to_date, $n_akun)
	{
		$data = $this->db->query("SELECT djurnal.n_jurnal, djurnal.tanggal, djurnal.akun, djurnal.debet, djurnal.kredit, hjurnal.keterangan, hjurnal.ID FROM djurnal INNER JOIN hjurnal ON djurnal.n_jurnal = hjurnal.n_jurnal WHERE djurnal.tanggal BETWEEN '$from_date' AND '$to_date' AND djurnal.akun = '$n_akun' ORDER BY hjurnal.ID, djurnal.tanggal ASC");
		return $data->result();
	}

	public function getSaldobyAkun($from_date, $n_akun)
	{
		$data = $this->db->query("SELECT akun, SUM(debet) as t_debet, SUM(kredit) as t_kredit FROM djurnal WHERE tanggal < '$from_date' AND akun = '$n_akun'");
		return $data->result();
	}

	public function getSaldo($to_date)
	{
		$data = $this->db->query("SELECT coa.akun, coa.nama, IFNULL((SELECT sum(debet) FROM djurnal WHERE djurnal.akun = coa.akun AND MID(djurnal.tanggal,1,7) <= '$to_date'),0) as t_debet, IFNULL((SELECT sum(kredit) FROM djurnal WHERE djurnal.akun = coa.akun AND MID(djurnal.tanggal,1,7) <= '$to_date'),0) as t_kredit FROM coa WHERE coa.detail <> ''");

		// var_dump($data->result()); die();

		return $data->result();
	}
}
