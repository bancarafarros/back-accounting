<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Api_kasbank extends CI_Model
{

    protected $table = 'hkasbank';
    protected $table2 = 'dkasbank';
    protected $primary_key = 'n_kasbank';
    protected $order_by = 'tanggal';
    protected $order_by_type = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    public function kasbankData()
    {
        $this->db->select([
            "n_kasbank", "tanggal", "reff", "keterangan", "jumlah", "statusA", "n_bank", "n_jurnal", "created_by", "created_at", "updated_by", "updated_at",
        ]);
        $this->db->where(['created_by' => '1']);
        $data = $this->db->get($this->table)->result_array();
        return $data;
    }
    public function dkasbankByAkun($akun)
    {
        $data = $this->getData($this->table2, ['*'], ['akun' => $akun]);
        return $data;
    }

    public function dkasbanByBank($n_kasbank)
    {
        $cek = $this->db->get_where($this->table, array('n_kasbank' => $n_kasbank))->num_rows();
        if ($cek > 0) {
            $this->db->select('hkasbank.n_kasbank, hkasbank.tanggal, hkasbank.reff, hkasbank.keterangan, hkasbank.jumlah, hkasbank.statusA as jenis_transaksi, hkasbank.n_bank, hkasbank.n_jurnal, hkasbank.created_by, hkasbank.created_at, hkasbank.updated_by, hkasbank.updated_at, dkasbank.akun as no_akun, coa.nama as nama_akun, dkasbank.debet, dkasbank.kredit, bank.akun as akun_bank, bank.nama as nama_bank');
            $this->db->from('perusahaan');
            $this->db->join('dkasbank', 'dkasbank.n_kasbank = hkasbank.n_kasbank');
            $this->db->join('coa', 'coa.akun = dkasbank.akun');
            $this->db->join('bank', 'bank.n_bank = hkasbank.n_bank', 'left');
            $this->db->where('hkasbank.n_kasbank', $n_kasbank);

            $raw = $this->db->get($this->table)->result_array();
            $data = [];
            $akun = [];
            foreach ($raw as $val) {
                $akun[] = [
                    'no_akun' => $val['no_akun'],
                    'debet' => $val['debet'],
                    'kredit' => $val['kredit'],
                ];
            }
            $data[] = [
                'n_kasbank' => $raw[0]['n_kasbank'],
                'tanggal' => $raw[0]['tanggal'],
                'reff' => $raw[0]['reff'],
                'keterangan' => $raw[0]['keterangan'],
                'jumlah' => $raw[0]['jumlah'],
                'akun' => $akun,
                'n_bank' => $raw[0]['n_bank'],
                'n_jurnal' => $raw[0]['n_jurnal'],
                'created_by' => $raw[0]['created_by'],
                'created_at' => $raw[0]['created_at'],
                'updated_by' => $raw[0]['updated_by'],
                'updated_at' => $raw[0]['updated_at'],
            ];

            return $data;
        }
    }

    public function kasbankBytanggal($tanggal)
    {
        $data = $this->getData($this->table, ['*'], ['tanggal' => $tanggal]);
        return $data;
    }
    // public function kasbanByBank($n_kasbank)
    // {
    //     $data = $this->getData($this->table, ['*'], ['n_kasbank' => $n_kasbank], 1);
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
    public function insertKasBank($param, $n_jurnal)
    {
        // var_dump($param);
        // die;
        $return['status'] = null;
        $return['message'] = null;
        $this->db->trans_start();
        $conv_date = strtotime($param['tgl_transaksi']);
        $tanggal = date('Y-m-d', $conv_date);
        //hjurnal
        $objectHjurn = [
            "n_jurnal" => $n_jurnal,
            "tanggal" => $tanggal,
            "reff" => $param['reff'],
            "keterangan" => $param['keterangan'],
            "jumlah" => $param['sum_bayar'],
            "statusA" => substr($param['n_transaksi'], 0, 2),
            // "created_by"    => getSession('userId'),
        ];
        $this->db->insert("hjurnal", $objectHjurn);
        //hkasbank
        $object1 = [
            "n_kasbank" => $param['n_transaksi'],
            "tanggal" => $tanggal,
            "reff" => $param['reff'],
            "keterangan" => $param['keterangan'],
            "jumlah" => $param['sum_bayar'],
            "statusA" => $param['jenis'],
            "n_bank" => $param['no_bank'],
            "n_jurnal" => $n_jurnal,
            // "created_by"    => getSession('userId'),
        ];
        $this->db->insert($this->table, $object1);

        //djurnal kasBank
        if ($param['jenis'] == "M") {
            $objectDjurnKB = [
                "n_jurnal" => $n_jurnal,
                "tanggal" => $tanggal,
                "akun" => $param['bayar'],
                "debet" => $param['sum_bayar'],
                "kredit" => 0,
                "status_valid" => "a",
                // "created_by"    => getSession('userId'),
            ];
        }
        if ($param['jenis'] == "K") {
            $objectDjurnKB = [
                "n_jurnal" => $n_jurnal,
                "tanggal" => $tanggal,
                "akun" => $param['bayar'],
                "debet" => 0,
                "kredit" => $param['sum_bayar'],
                "status_valid" => "a",
                // "created_by"    => getSession('userId'),
            ];
        }
        $this->db->insert("djurnal", $objectDjurnKB);


        //djurnal secondary
        for ($br = 0; $br < $param['jml_baris']; $br++) {
            if ($param['akun' . $br]) {
                if ($param['jenis'] == "M") {
                    $objectDjurnSec = [
                        "n_jurnal" => $n_jurnal,
                        "tanggal" => $tanggal,
                        "akun" => $param['akun' . $br],
                        "debet" => 0,
                        "kredit" => $param['jumlah' . $br],
                        "status_valid" => "a",
                        // "created_by"    => getSession('userId'),
                    ];
                }
                if ($param['jenis'] == "K") {
                    $objectDjurnSec = [
                        "n_jurnal" => $n_jurnal,
                        "tanggal" => $tanggal,
                        "akun" => $param['akun' . $br],
                        "debet" => $param['jumlah' . $br],
                        "kredit" => 0,
                        "status_valid" => "a",
                        // "created_by"    => getSession('userId'),
                    ];
                }
                $this->db->insert("djurnal", $objectDjurnSec);
            }
        }

        //dkasbank secondary
        for ($dk = 0; $dk < $param['jml_baris']; $dk++) {
            if (@$param['akun' . $dk]) {
                if ($param['jenis'] == "M") {
                    $objectDkasBank = [
                        "n_kasbank" => $param['n_transaksi'],
                        "akun" => $param['akun' . $dk],
                        "debet" => 0,
                        "kredit" => $param['jumlah' . $dk],
                        // "created_by"    => getSession('userId'),
                    ];
                }
                if ($param['jenis'] == "K") {
                    $objectDkasBank = [
                        "n_kasbank" => $param['n_transaksi'],
                        "akun" => $param['akun' . $dk],
                        "debet" => $param['jumlah' . $dk],
                        "kredit" => 0,
                        // "created_by"    => getSession('userId'),
                    ];
                }
                $this->db->insert("dkasbank", $objectDkasBank);
            }
        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            $return['status'] = true;
            $return['message'] = 'Transaksi kas & bank berhasil';
        } else {
            $this->db->trans_rollback();
            $return['status'] = false;
            $return['message'] = 'Transaksi kas & bank gagal';
        }
        return $return;
    }

    public function hapusData($param)
    {
        $data = $this->db->get_where($this->table, array('n_kasbank' => $param))->num_rows();
        if ($data > 0) {
            $this->db->where('n_kasbank', $param);
            return $this->db->delete($this->table);
        }
    }

    public function editKasBank($param)
    {
        $object = [
            "n_kasbank"     => $param['n_kasbank'],
            "akun"          => $param['akun'],
            "debet"         => $param['debet'],
            "kredit"        => $param['kredit'],
            "created_by"    => '1',
            "updated_by"    => '1'
            // "updated_by"    => getSession('userId'),
        ];
        $data = $this->db->get_where($this->table, array('n_kasbank' => $param['n_kasbank']))->num_rows();
        if ($data > 0) {
            $this->db->where("n_kasbank", $param['n_kasbank']);

            return $this->db->update($this->table, $object);
        }
    }
}
