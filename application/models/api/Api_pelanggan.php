<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Api_pelanggan extends CI_Model
{

    protected $table = 'pelanggan';

    function __construct()
    {
        parent::__construct();
    }

    function pelangganData()
    {
        // $this->db->select([
        //     "n_pelanggan", "barcode", "pass", "tanggal", "akun", "nama", "alamat", "telepon", "email", "batas", "statusA", "n_sales", "created_by", "created_at", "updated_by", "updated_at"
        // ]);
        // $this->db->where(['statusA' => '1']);
        $this->db->select('pelanggan.*,coa.nama as n_akun, salesman.nama as nama_sales');
		$this->db->join('salesman', 'salesman.n_sales = pelanggan.n_sales');
		$this->db->join('coa', 'coa.akun = pelanggan.akun');
		$this->db->where(['statusA' => "1"]);
        $data = $this->db->get($this->table)->result_array();
        return $data;
    }

    public function pelangganByN_Pelanggan($n_pelanggan)
    {
        $data = $this->getData($this->table, ['*'], ['n_pelanggan' => $n_pelanggan], 1);
        return $data;
    }

    public function pelangganBytanggal($tanggal)
    {
        $data = $this->getData($this->table, ['*'], ['tanggal' => $tanggal]);
        return $data;
    }

    public function pelangganByAkun($akun)
    {
        $data = $this->getData($this->table, ['*'], ['akun' => $akun]);
        return $data;
    }

    public function pelangganByStatusA($statusA)
    {
        $data = $this->getData($this->table, ['*'], ['statusA' => $statusA]);
        return $data;
    }

    public function pelangganByN_Sales($n_sales)
    {
        $data = $this->getData($this->table, ['*'], ['n_sales' => $n_sales]);
        return $data;
    }

    public function getData($table, $select = ['*'], $where = null, $limit = null, $order = null)
    {
        $this->db->select($select);

        if ($where != null) {
            $this->db->where($where);
        }

        if ($limit != null) {
            $this->db->limit($limit);
        }

        if ($order != null) {
            $this->db->order_by($order);
        }

        $query = $this->db->get($table);

        if ($limit == 1) {
            return $query->row_array();
        }

        return $query->result_array();
    }

    public function insertPelanggan($param)
    {
        $conv_date = strtotime($param['tanggal']);
		$tanggal = date('Y-m-d', $conv_date);
		$object = [
			"n_pelanggan" 	=> generateNomorPerson(PREFIX_PELANGGAN, 'n_pelanggan', 'pelanggan'),
			"barcode" 		=> $param['barcode'],
			"tanggal" 		=> $tanggal,
			"akun" 			=> $param['akun'],
			"nama" 			=> $param['nama'],
			"alamat" 		=> $param['alamat'],
			"telepon" 		=> $param['telepon'],
			"email" 		=> $param['email'],
			"batas" 		=> $param['batas'],
			"n_sales" 		=> $param['n_sales'],
			'created_by'	=> "1"
		];

        $cek_akun = $this->db->get_where('coa', array('akun' => $param['akun']))->num_rows();
        $cek_sales = $this->db->get_where('salesman', array('n_sales' => $param['n_sales']))->num_rows();

        if($cek_akun > 0 && $cek_sales > 0){
            $this->db->insert($this->table, $object);
            return $this->db->get_where($this->table, array('akun' => $param['akun'], 'n_sales' => $param['n_sales']))->row();
        }
    }

    public function editPelanggan($param)
	{
		$conv_date = strtotime($param['tanggal']);
		$tanggal = date('Y-m-d', $conv_date);

		$object = [
			"n_pelanggan" => $param['n_pelanggan'],
			"barcode" => $param['barcode'],
			"tanggal" => $tanggal,
			"akun" => $param['akun'],
			"nama" => $param['nama'],
			"alamat" => $param['alamat'],
			"telepon" => $param['telepon'],
			"email" => $param['email'],
			"batas" => $param['batas'],
			"statusA" => $param['status'],
			"n_sales" => $param['n_sales']
		];

        $data = $this->db->get_where($this->table, array('n_pelanggan' => $param['n_pelanggan']))->num_rows();
        $cek_akun = $this->db->get_where('coa', array('akun' => $param['akun']))->num_rows();
        $cek_sales = $this->db->get_where('salesman', array('n_sales' => $param['n_sales']))->num_rows();

        if ($data > 0 && $cek_akun > 0 && $cek_sales > 0) {
            $this->db->where('n_pelanggan', $param['n_pelanggan']);
            return $this->db->update($this->table, $object);
            return $this->db->get_where($this->table, array('akun' => $param['akun'], 'n_sales' => $param['n_sales']))->row();
        }
	}

    public function hapusData($param)
	{
        $data = $this->db->get_where($this->table, array('n_pelanggan' => $param))->num_rows();

        if ($data > 0) {
            $this->db->where('n_pelanggan', $param);
            return $this->db->delete($this->table);
        }
	}
}