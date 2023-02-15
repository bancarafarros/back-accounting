<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Api_jurnal extends CI_Model
{

    protected $hjurnal = 'hjurnal';
    protected $djurnal = 'djurnal';

    function __construct()
    {
        parent::__construct();
    }

    // Get
    function hJurnal()
    {
        $this->db->select(["*"]);
        $data = $this->db->get($this->hjurnal)->result_array();
        return $data;
    }

    public function hJurnalByTanggal($tanggal)
    {
        $data = $this->getData($this->hjurnal, ["*"], ["tanggal" => $tanggal]);
        return $data;
    }

    public function dJurnalByN_jurnal($n_jurnal)
    {
        $data = $this->getData($this->djurnal, ["*"], ["n_jurnal" => $n_jurnal]);
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
    public function insertJurnal($params)
    {
        $data = $this->db->get_where($this->hjurnal, array('n_jurnal' => $params['n_jurnal']))->num_rows();
        if ($data == 0) {
            $return['status'] = false;
            $return['message'] = null;
            $error = null;
            $this->db->trans_start();
            $conv_date = strtotime($params['tanggal']);
            $tanggal = date('Y-m-d', $conv_date);

            //hjurnal
            $objectHjurn = [
                "n_jurnal"         => $params['n_jurnal'],
                "tanggal"         => $tanggal,
                "reff"             => $params['reff'],
                "keterangan"    => $params['keterangan'],
                "jumlah"         => $params['jumlah'],
                "statusA"         => "GL",
                "created_by"    => getSession('userId'),
            ];
            $this->insertHjurnal($objectHjurn);
            if ($this->db->error()["code"] != 0) {
                $error[] = [
                    'error' => $this->db->error(),
                    'query' => $this->db->last_query()
                ];
            }

            //djurnal
            for ($br = 0; $br < $params['jml_baris']; $br++) {
                if (@$params['akun' . $br]) {
                    $objectDjurn = [
                        "n_jurnal"         => $params['n_jurnal'],
                        "tanggal"         => $tanggal,
                        "akun"             => $params['akun' . $br],
                        "debet"         => $params['adddebet' . $br],
                        "kredit"         => $params['addkredit' . $br],
                        "status_valid"    => "a",
                        "created_by"    => getSession('userId'),
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
    }

    public function insertHjurnal($params)
    {
        if (empty($params['tanggal'])) {
            $params['tanggal'] = date('Y-m-d');
        }
        if (empty($params['created_by'])) {
            $params['created_by'] = '1';
        }
        if (empty($params['reff'])) {
            $params['reff'] = '-';
        }
        return $this->db->insert($this->hjurnal, $params);
    }

    public function insertDjurnal($params)
    {
        if (empty($params['tanggal'])) {
            $params['tanggal'] = date('Y-m-d');
        }
        if (empty($params['created_by'])) {
            $params['created_by'] = '1';
        }
        return $this->db->insert($this->djurnal, $params);
    }

    // Update
    public function updateJurnal($params)
    {
        $data = $this->db->get_where($this->hjurnal, array('n_jurnal' => $params['n_jurnal']))->num_rows();
        if ($data > 0) {
            $conv_date = strtotime($params['tanggal']);
            $tanggal = date('Y-m-d', $conv_date);
            $return['status'] = false;
            $return['message'] = null;
            $error = null;

            $this->db->trans_start();

            //hjurnal
            $objectHjurn = [
                "keterangan" => '(KOREKSI) ' . $params['keterangan'],
                "jumlah" => $params['jumlah'],
                "updated_by" => getSession('userId'),
            ];
            if (empty($params['updated_by'])) {
                $objectHjurn['updated_by'] = '1';
            }
            $this->db->where("n_jurnal", $params['n_jurnal']);
            $this->db->update($this->hjurnal, $objectHjurn);
            if ($this->db->error()["code"] != 0) {
                $error[] = [
                    'error' => $this->db->error(),
                    'query' => $this->db->last_query()
                ];
            }

            //djurnal
            for ($br = 0; $br < $params['jml_baris']; $br++) {
                if ($params['akun' . $br]) {
                    $objectDjurn = [
                        "tanggal"         => $tanggal,
                        "debet"         => $params['adddebet' . $br],
                        "kredit"         => $params['addkredit' . $br],
                        "updated_by"    => getSession('userId'),
                    ];
                    if (empty($params['updated_by'])) {
                        $objectDjurn['updated_by'] = '1';
                    }
                    $this->db->where(['n_jurnal' => $params['n_jurnal'], 'akun' => $params['akun' . $br]]);
                    $this->db->update($this->djurnal, $objectDjurn);
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
    }

    // Cek statusA
    public function cekStatusA($n_jurnal)
    {
        $data = $this->db->get_where($this->hjurnal, array('n_jurnal' => $n_jurnal))->row_array();
        if ($data['statusA'] == 'GL') {
            return true;
        } else {
            return false;
        }
    }
}
