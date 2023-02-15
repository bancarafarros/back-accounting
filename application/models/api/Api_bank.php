<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Api_bank extends CI_Model
{

    protected $table = 'bank';
    protected $n_bank = 'n_bank';
    function __construct()
    {
        parent::__construct();
    }

    function bankData()
    {
        $this->db->select([
            "n_bank", "akun", "nama", "norek", "pemilik", "alamat", "telepon", "is_active", "created_by", "created_at", "updated_by", "updated_at",
        ]);
        $this->db->where(['is_active' => '1']);
        $data = $this->db->get($this->table)->result_array();
        return $data;
    }

    public function bankByAkun($akun)
    {
        $data = $this->getData($this->table, ['*'], ['akun' => $akun], 1);
        return $data;
    }
    public function banByBank($n_bank)
    {
        $data = $this->getData($this->table, ['*'], ['n_bank' => $n_bank], 1);
        return $data;
    }

    // public function grup($grup = null)
    // {
    //     $data = null;
    //     $this->db->distinct();
    //     $this->db->select(['grup']);
    //     if (!empty($grup)) {
    //         $this->db->where(['grup' => $grup]);
    //         $data = $this->db->get($this->table)->row_array();
    //     } else {
    //         $data = $this->db->get($this->table)->result_array();
    //     }
    //     return $data;
    // }

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
    public function insertBank($param)
    {
        $object = [
            "akun"             => $param['akun'],
            "nama"             => $param['nama'],
            "norek"         => $param['norek'],
            "pemilik"         => $param['pemilik'],
            "alamat"         => $param['alamat'],
            "telepon"         => $param['telepon'],
            // "created_by"    => getSession('userId'),
        ];
        return $this->db->insert($this->table, $object);
    }

    public function hapusData($param)
    {
        $data = $this->db->get_where($this->table, array('n_bank' => $param))->num_rows();
        if ($data > 0) {
            $this->db->where('n_bank', $param);
            return $this->db->delete($this->table);
        }
    }

    public function editBank($param)
    {
        $object = [
            "n_bank" => $param['n_bank'],
            "akun"             => $param['akun'],
            "nama"             => $param['nama'],
            "norek"         => $param['norek'],
            "pemilik"         => $param['pemilik'],
            "alamat"         => $param['alamat'],
            "telepon"         => $param['telepon'],
            // "updated_by"    => getSession('userId'),
        ];
        $data = $this->db->get_where($this->table, array('n_bank' => $param['n_bank']))->num_rows();
        if ($data > 0) {
            $this->db->where("n_bank", $param['n_bank']);

            return $this->db->update($this->table, $object);
        }
    }
}
