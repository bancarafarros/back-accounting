<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Api_barang extends CI_Model
{

    protected $tableBarang = 'barang';
    protected $tableBarangGrup = 'barang_grup';

    function __construct()
    {
        parent::__construct();
    }

    // Get
    function barangData()
    {
        $this->db->select(["*"]);
        $this->db->where(['is_active' => '1']);
        $data = $this->db->get($this->tableBarang)->result_array();
        return $data;
    }

    public function barangByN_Barang($n_barang)
    {
        $data = $this->getData($this->tableBarang, ["*"], ["n_barang" => $n_barang], 1);
        return $data;
    }

    public function barangGrupData()
    {
        $this->db->select(["*"]);
        $this->db->where(['is_active' => '1']);
        $data = $this->db->get($this->tableBarangGrup)->result_array();
        return $data;
    }

    public function barangGrupByN_Grup($n_grup)
    {
        $data = $this->getData($this->tableBarangGrup, ["*"], ["n_grup" => $n_grup], 1);
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

    // Insert
    public function insertBarang($params)
    {
        $data = $this->db->get_where($this->tableBarang, array('n_barang' => $params['n_barang']))->num_rows();
        if ($data == 0) {
            $object = [
                "n_barang"          => $params['n_barang'],
                "akun_hpp"          => $params['akun_hpp'],
                "akun_persediaan"   => $params['akun_persediaan'],
                "akun_pendapatan"   => $params['akun_pendapatan'],
                "nama"              => $params['nama'],
                "harga_pokok"       => $params['harga_pokok'],
                "harga_beli"        => $params['harga_beli'],
                "harga_jual1"       => $params['harga_jual1'],
                "harga_jual2"       => $params['harga_jual2'],
                "harga_jual3"       => $params['harga_jual3'],
                "stock_awal"        => $params['stock_awal'],
                "stock_gudang"      => $params['stock_gudang'],
                "stock_etalase"     => $params['stock_etalase'],
                "stock_min"         => $params['stock_min'],
                "n_unit"            => $params['n_unit'],
                "b_unit"            => $params['b_unit'],
                "konversi_unit"     => $params['konversi_unit'],
                "n_grup"            => $params['n_grup'],
                "diskon"            => $params['diskon'],
            ];
            if (!empty($params['barcode'])) {
                $object["barcode"] = $params["barcode"];
            } else {
                $object["barcode"] = "-";
            }
            if (!empty($params['keterangan1'])) {
                $object["keterangan1"] = $params["keterangan1"];
            } else {
                $object["keterangan1"] = "-";
            }
            if (!empty($params['keterangan2'])) {
                $object["keterangan2"] = $params["keterangan2"];
            } else {
                $object["keterangan2"] = "-";
            }
            if (!empty($params['keterangan3'])) {
                $object["keterangan3"] = $params["keterangan3"];
            } else {
                $object["keterangan3"] = "-";
            }
            if (!empty(getSession('userId'))) {
                $object["created_by"] = getSession('userId');
            } else {
                $object["created_by"] = "1";
            }
            return $this->db->insert($this->tableBarang, $object);
        }
    }

    public function insertBarangGrup($params)
    {
        $data = $this->db->get_where($this->tableBarangGrup, array('n_grup' => $params['n_grup']))->num_rows();
        if ($data == 0) {
            $object = [
                "n_grup"                   => $params['n_grup'],
                "grup"                     => $params['grup'],
                "departement"              => $params['departement'],
                "akun_hpp"                 => $params['akun_hpp'],
                "akun_persediaan"          => $params['akun_persediaan'],
                "akun_pendapatan"          => $params['akun_pendapatan'],
                "margin_grup"              => $params['margin_grup'],
                "margin_departement"       => $params['margin_departement'],
            ];
            if (!empty($params['kode'])) {
                $object["kode"] = $params["kode"];
            } else {
                $object["kode"] = "-";
            }
            if (!empty(getSession('userId'))) {
                $object["created_by"] = getSession('userId');
            } else {
                $object["created_by"] = "1";
            }
            return $this->db->insert($this->tableBarangGrup, $object);
        }
    }

    // Update
    public function updateBarang($params)
    {
        $data = $this->db->get_where($this->tableBarang, array('n_barang' => $params['n_barang']))->num_rows();
        if ($data > 0) {
            $object = [
                "akun_hpp"          => $params['akun_hpp'],
                "akun_persediaan"   => $params['akun_persediaan'],
                "akun_pendapatan"   => $params['akun_pendapatan'],
                "nama"              => $params['nama'],
                "harga_pokok"       => $params['harga_pokok'],
                "harga_beli"        => $params['harga_beli'],
                "harga_jual1"       => $params['harga_jual1'],
                "harga_jual2"       => $params['harga_jual2'],
                "harga_jual3"       => $params['harga_jual3'],
                "stock_awal"        => $params['stock_awal'],
                "stock_gudang"      => $params['stock_gudang'],
                "stock_etalase"     => $params['stock_etalase'],
                "stock_min"         => $params['stock_min'],
                "n_unit"            => $params['n_unit'],
                "b_unit"            => $params['b_unit'],
                "konversi_unit"     => $params['konversi_unit'],
                "n_grup"            => $params['n_grup'],
                "diskon"            => $params['diskon'],
            ];
            if (!empty($params['barcode'])) {
                $object["barcode"] = $params["barcode"];
            } else {
                $object["barcode"] = "-";
            }
            if (!empty($params['keterangan1'])) {
                $object["keterangan1"] = $params["keterangan1"];
            } else {
                $object["keterangan1"] = "-";
            }
            if (!empty($params['keterangan2'])) {
                $object["keterangan2"] = $params["keterangan2"];
            } else {
                $object["keterangan2"] = "-";
            }
            if (!empty($params['keterangan3'])) {
                $object["keterangan3"] = $params["keterangan3"];
            } else {
                $object["keterangan3"] = "-";
            }
            if (!empty(getSession('userId'))) {
                $object["updated_by"] = getSession('userId');
            } else {
                $object["updated_by"] = "1";
            }
            $this->db->where('n_barang', $params['n_barang']);
            return $this->db->update($this->tableBarang, $object);
        }
    }

    public function updateBarangGrup($params)
    {
        $data = $this->db->get_where($this->tableBarangGrup, array('n_grup' => $params['n_grup']))->num_rows();
        if ($data > 0) {
            $object = [
                "grup"                     => $params['grup'],
                "departement"              => $params['departement'],
                "akun_hpp"                 => $params['akun_hpp'],
                "akun_persediaan"          => $params['akun_persediaan'],
                "akun_pendapatan"          => $params['akun_pendapatan'],
                "margin_grup"              => $params['margin_grup'],
                "margin_departement"       => $params['margin_departement'],
            ];
            if (!empty($params['kode'])) {
                $object["kode"] = $params["kode"];
            } else {
                $object["kode"] = "-";
            }
            if (!empty(getSession('userId'))) {
                $object["updated_by"] = getSession('userId');
            } else {
                $object["updated_by"] = "1";
            }
            $this->db->where('n_grup', $params['n_grup']);
            return $this->db->update($this->tableBarangGrup, $object);
        }
    }

    // Delete
    public function deleteBarang($n_barang)
    {
        $data = $this->db->get_where($this->tableBarang, array('n_barang' => $n_barang))->num_rows();
        if ($data > 0) {
            $this->db->where('n_barang', $n_barang);
            return $this->db->delete($this->tableBarang);
        }
    }

    public function deleteBarangGrup($n_grup)
    {
        $data = $this->db->get_where($this->tableBarangGrup, array('n_grup' => $n_grup))->num_rows();
        if ($data > 0) {
            $this->db->where('n_grup', $n_grup);
            return $this->db->delete($this->tableBarangGrup);
        }
    }
}
