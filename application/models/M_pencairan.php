<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_pencairan extends CI_model{

	public function rab_pencairan(){
		$data = $this->db->select('rab_pencairan.*, user.id_user, real_name, rab.mata_anggaran, rab.detail, coa.nama')
		->from('rab_pencairan')
		->join('user', 'rab_pencairan.id_user = user.id_user', 'left')
		->join('rab', 'rab_pencairan.id_rab = rab.id', 'left')
		->join('coa', 'rab.mata_anggaran = coa.akun', 'left')
		->order_by('user.id_user', 'DESC')
		->order_by('rab_pencairan.created_at', 'DESC')
		->get();
		return $data;
	}

	public function getRabPencairan($id){
		$this->db->select('rab_pencairan.*, rab.mata_anggaran, rab.detail')
		->from('rab_pencairan')
		->join('rab', 'rab_pencairan.id_rab =  rab.id', 'left')
		->where(['rab_pencairan.id'=>$id]);
		$data = $this->db->get();
		return $data->result_array();

	}

	public function insertPencairan($data)
	{
		// $pencairan = [
		// 	'id_rab'=>$param['rab'],
		// 	'id_user'=>$this->session->userdata('t_userId'),
		// 	'ta'=>$param['ta'],
		// 	'keterangan'=>$param['keterangan'],
		// 	'total'=> $param['total']
		// ];
		return $this->db->insert('rab_pencairan', $data);
	}

	public function ubahStatusRektor($where, $param){
		return $this->db->where($where)->update('rab_pencairan', ['rektor'=>$param]);
	}

	public function pencairanbyuser($id_user, $ta){
		$data = $this->db->select('rab.*, rab_pencairan.*, coa.nama')
		->from('rab')
		->join('coa', 'rab.mata_anggaran = coa.akun')
		->join('rab_pencairan', 'rab.id = rab_pencairan.id_rab')
		->where(['rab.id_user'=>$id_user, 'rab_pencairan.ta'=>$ta])
		->order_by('rab_pencairan.created_at', 'DESC')
		->get();
		return $data;
	}


	public function insertTransPencairan($param,$n_jurnal)
	{
		$this->db->trans_start();
		$conv_date = strtotime($param['tgl_transaksi']);
		$tanggal = date('Y-m-d');
		//hjurnal
		$objectHjurn = [
			"n_jurnal" => $n_jurnal,
			"tanggal" => $tanggal,
			"reff" => $param['keterangan'],
			"keterangan" => $param['detail'],
			"jumlah" => $param['jumlah'],
			"statusA" => "P"
		];
		$this->db->insert("hjurnal",$objectHjurn);
		
		//pencairan_header
		$object1 = [
			"n_pencairan" => $param['n_transaksi'],
			"tanggal" => $tanggal,
			"reff" => $param['keterangan'],
			"detail" => $param['detail'],
			"jumlah" => $param['jumlah'],
			"statusA" => $param['jenis'],
			"n_rab" => $param['rab'],
			"n_rab_pencairan"=>$param['rab_pencairan'],
			"n_jurnal" => $n_jurnal
		];
		$this->db->insert("pencairan_header",$object1);


		// Detail
		$objectDjurnal1 = [
			"n_jurnal" => $n_jurnal,
			"tanggal" => $tanggal,
			"akun" => $param['mata_anggaran'],
			"debet" => $param['jumlah'],
			"kredit" => 0,
			"status_valid" => "a"
		];
		$this->db->insert("djurnal",$objectDjurnal1);

		$objectDjurnal2 = [
			"n_jurnal" => $n_jurnal,
			"tanggal" => $tanggal,
			"akun" => '01.1101',
			"debet" => 0,
			"kredit" => $param['jumlah'],
			"status_valid" => "a"
		];

		$this->db->insert("djurnal",$objectDjurnal2);
		
		//dkasbank secondary

		$objectPencairanDetail = [
			"n_pencairan" => $param['n_transaksi'],
			"akun" => $param['mata_anggaran'],
			"debet" => 0,
			"kredit" => $param['jumlah'],
		];
		$this->db->insert("pencairan_detail",$objectPencairanDetail);
		$this->db->where(['id'=>$param['rab_pencairan']])->update('rab_pencairan', ['status'=>'1']);
		$this->db->trans_complete();

		return $this->db->affected_rows();
	}
}
?>