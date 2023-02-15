<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Api_pembelian extends CI_Model
{
    function __construct()
    {
        parent::__construct();
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
    public function insertPembelian($params, $jurnal, $djurnal, $stock_barang)
    {
        $jurnalArray = "";
        $jumlahJurnal = 0;
        $barangArray = "";
        $KeluarMasukArray = "";
        $jumlahBarang = 0;
        $pembelianArray = "";
        $jumlahPembelian = 0;
        $hutangArray = "";
        $jumlahHutang = 0;

        // Hjurnal pembelian
        $error = null;
        $return['status'] = null;
        $return['message'] = null;
        $this->db->trans_start();
        $conv_date = strtotime($params['tanggal']);
        $tanggal = date('Y-m-d', $conv_date);
        $nowTime = date("h:i:s");
        $conv_date1 = strtotime($params['jatuh_tempo']);
        $tanggalTempo = date('Y-m-d', $conv_date1);
        $n_pemasok = explode(" | ", $params['n_pemasok']);
        $objectHjurnal = [
            "n_jurnal" => $jurnal['nomor'],
            "tanggal" => $tanggal,
            "reff" => $params['n_transaksi'],
            "keterangan" => $params['keterangan'],
            "jumlah" => $params['total_all'],
            "statusA" => substr($params['n_transaksi'], 0, 2),
            "created_by" => getSession('userId'),
        ];
        if (empty($params['reff'])) {
            $objectHjurn['reff'] = '-';
        }
        if (empty($params['created_by'])) {
            $objectHjurn['created_by'] = '1';
        }
        $this->db->insert("hjurnal", $objectHjurnal);
        if ($this->db->error()["code"] != 0) {
            $error[] = [
                'error' => $this->db->error(),
                'query' => $this->db->last_query()
            ];
        }

        // Djurnal pembelian
        if ($params['jml_bayar'] <> 0) {
            $objectKas = [
                "n_jurnal" => $jurnal['nomor'],
                "tanggal" => $tanggal,
                "akun" => $jurnal['kredit'],
                "debet" => 0,
                "kredit" => $params['jml_bayar'],
                "status_valid" => "b",
                "created_by" => getSession('userId'),
            ];
            if (empty($params['created_by'])) {
                $objectKas['created_by'] = '1';
            }
            $this->db->insert("djurnal", $objectKas);
            if ($this->db->error()["code"] != 0) {
                $error[] = [
                    'error' => $this->db->error(),
                    'query' => $this->db->last_query()
                ];
            }
            $jurnalArray .= $jurnal['nomor'] . ',' . $tanggal . ',' . $params['keterangan'] . ',' . $jurnal['kredit'] . ',0,' . $params['jml_bayar'] . ",b|";
            $jumlahJurnal += 1;
        }
        if ($params['biaya_ppn'] <> 0) {
            $objectPpn = [
                "n_jurnal" => $jurnal['nomor'],
                "tanggal" => $tanggal,
                "akun" => $jurnal['ppn'],
                "debet" => $params['biaya_ppn'],
                "kredit" => 0,
                "status_valid" => "b",
                "created_by" => getSession('userId'),
            ];
            if (empty($params['created_by'])) {
                $objectPpn['created_by'] = '1';
            }
            $this->db->insert("djurnal", $objectPpn);
            if ($this->db->error()["code"] != 0) {
                $error[] = [
                    'error' => $this->db->error(),
                    'query' => $this->db->last_query()
                ];
            }
            $jurnalArray .= $jurnal['nomor'] . ',' . $tanggal . ',' . $params['keterangan'] . ',' . $jurnal['ppn'] . ',' . $params['jml_bayar'] . ',0,b|';
            $jumlahJurnal += 1;
        }
        if ($params['biaya_kirim'] <> 0) {
            $objectBiaya = [
                "n_jurnal" => $jurnal['nomor'],
                "tanggal" => $tanggal,
                "akun" => $jurnal['biaya'],
                "debet" => $params['biaya_kirim'],
                "kredit" => 0,
                "status_valid" => "b",
                "created_by" => getSession('userId'),
            ];
            if (empty($params['created_by'])) {
                $objectBiaya['created_by'] = '1';
            }
            $this->db->insert("djurnal", $objectBiaya);
            if ($this->db->error()["code"] != 0) {
                $error[] = [
                    'error' => $this->db->error(),
                    'query' => $this->db->last_query()
                ];
            }
            $jurnalArray .= $jurnal['nomor'] . ',' . $tanggal . ',' . $params['keterangan'] . ',' . $jurnal['biaya'] . ',' . $params['biaya_kirim'] . ',0,b|';
            $jumlahJurnal += 1;
        }
        if ($params['total_diskon'] <> 0) {
            $objectDiskon = [
                "n_jurnal" => $jurnal['nomor'],
                "tanggal" => $tanggal,
                "akun" => $jurnal['diskon'],
                "debet" => 0,
                "kredit" => $params['total_diskon'],
                "status_valid" => "b",
                "created_by" => getSession('userId'),
            ];
            if (empty($params['created_by'])) {
                $objectDiskon['created_by'] = '1';
            }
            $this->db->insert("djurnal", $objectDiskon);
            if ($this->db->error()["code"] != 0) {
                $error[] = [
                    'error' => $this->db->error(),
                    'query' => $this->db->last_query()
                ];
            }
            // $jurnalArray .= $jurnal['nomor'].','.$tanggal.','.$params['keterangan'].','.$jurnal['biaya'].','.$params['biaya_kirim'].',0,b|';
            // $jumlahJurnal += 1;
        }
        for ($dj = 0; $dj < count($djurnal); $dj++) {
            if (array_key_exists($dj, $djurnal)) {
                $n_kredit = explode(",", $djurnal[$dj]);
                $objectLop = [
                    "n_jurnal" => $jurnal['nomor'],
                    "tanggal" => $tanggal,
                    "akun" => $n_kredit[0],
                    "debet" => $n_kredit[1],
                    "kredit" => 0,
                    "status_valid" => "b",
                    "created_by" => getSession('userId'),
                ];
                if (empty($params['created_by'])) {
                    $objectLop['created_by'] = '1';
                }
                $this->db->insert("djurnal", $objectLop);
                if ($this->db->error()["code"] != 0) {
                    $error[] = [
                        'error' => $this->db->error(),
                        'query' => $this->db->last_query()
                    ];
                }
                $jurnalArray .= $jurnal['nomor'] . ',' . $tanggal . ',' . $params['keterangan'] . ',' . $n_kredit[0] . ',' . $n_kredit[1] . ',0,b|';
                $jumlahJurnal += 1;
            }
        }


        for ($st = 0; $st < count($stock_barang); $st++) {
            if (@$params['n_barang' . $st]) {
                $stock = 0;
                $n_barang = explode(",", $stock_barang[$st]);
                $qtyBeli = intval($params['qty_barang' . $st] * $params['conversiUnit' . $st]);
                $qtyStok = intval($n_barang[1]);
                $stock = $qtyStok + $qtyBeli;
                $hppBrg = ((($qtyStok + $n_barang[3]) * intval($n_barang[2])) + ($qtyBeli * $params['harga_barang' . $st])) / ($stock + $n_barang[3]);
                // print_r($qtyStok);

                $objectBarang = [
                    "stock_gudang" => $stock,
                    "harga_pokok" => round($hppBrg, 2),
                    "harga_beli" =>    $params['harga_barang' . $st],
                    "updated_by" => getSession('userId'),
                ];
                if (empty($params['created_by'])) {
                    $objectBarang['created_by'] = '1';
                }
                $this->db->where("n_barang", $n_barang[0]);
                $this->db->update("barang", $objectBarang);
                if ($this->db->error()["code"] != 0) {
                    $error[] = [
                        'error' => $this->db->error(),
                        'query' => $this->db->last_query()
                    ];
                }

                $objectKeluarMasuk = [
                    "reff" => $params['n_transaksi'],
                    "tanggal" => $tanggal,
                    "waktu" => $nowTime,
                    "n_pelanggan" => $n_pemasok[0],
                    "n_barang" => $params['n_barang' . $st],
                    "masuk" =>  $params['qty_barang' . $st],
                    "keluar" => 0,
                    "sisa" => $stock,
                    "harga" => $params['harga_barang' . $st],
                    "satuan" => $params['satuan_barang' . $st],
                    "created_by" => getSession('userId'),
                ];
                if (empty($params['created_by'])) {
                    $objectKeluarMasuk['created_by'] = '1';
                }
                $this->db->insert("keluar_masuk", $objectKeluarMasuk);
                if ($this->db->error()["code"] != 0) {
                    $error[] = [
                        'error' => $this->db->error(),
                        'query' => $this->db->last_query()
                    ];
                }
                $KeluarMasukArray .= $params['n_transaksi'] . ',' . $tanggal . ',' . $n_pemasok[0] . ',' . $params['n_barang' . $st] . ',' . $params['qty_barang' . $st] . ',0,' . $stock . ',' . $params['harga_barang' . $st] . ',' . $params['satuan_barang' . $st] . '|';
                $barangArray .= $params['n_barang' . $st] . ',' . $hppBrg . ',' . $params['harga_barang' . $st] . ',' . $qtyStok . '|';
                $jumlahBarang += 1;
            }
        }

        $objectHbeli = [
            "n_pembelian" => $params['n_transaksi'],
            "tanggal" => $tanggal,
            "reff" => $params['reff'],
            "n_pemasok" => $n_pemasok[0],
            "keterangan" => $params['keterangan'],
            "total_pembelian" => $params['totalBelibrg'],
            "uang_muka" => $params['uang_muka'],
            "biaya_kirim" => $params['biaya_kirim'],
            "ppn" => $params['biaya_ppn'],
            "hutang" => $params['sisa_bayar'],
            "cara_bayar" => $params['c_bayar'],
            "created_by" => getSession('userId'),
        ];
        if (empty($params['created_by'])) {
            $objectHbeli['created_by'] = '1';
        }
        $this->db->insert('hpembelian', $objectHbeli);
        if ($this->db->error()["code"] != 0) {
            $error[] = [
                'error' => $this->db->error(),
                'query' => $this->db->last_query()
            ];
        }

        for ($dbl = 0; $dbl <= $params['sum_barang']; $dbl++) {
            if (@$params['n_barang' . $dbl]) {
                $b_disc = intval(str_replace('%', "", $params['diskon' . $dbl]));
                $objectDbeli = [
                    "n_pembelian" => $params['n_transaksi'],
                    "n_barang" => $params['n_barang' . $dbl],
                    "jumlah" => $params['qty_barang' . $dbl],
                    "harga_asli" => $params['harga_barang' . $dbl],
                    "disc" => $b_disc,
                    "harga" => $params['harga_diskon' . $dbl],
                    "satuan" => $params['satuan_barang' . $dbl],
                    "created_by" => getSession('userId'),
                ];
                if (empty($params['created_by'])) {
                    $objectDbeli['created_by'] = '1';
                }
                $this->db->insert("dpembelian", $objectDbeli);
                if ($this->db->error()["code"] != 0) {
                    $error[] = [
                        'error' => $this->db->error(),
                        'query' => $this->db->last_query()
                    ];
                }
                $pembelianArray .= $params['n_transaksi'] . ',' . $tanggal . ',' . $params['reff'] . ',' . $n_pemasok[0] . ',' . $params['keterangan'] . ',' . $params['total_all'] . ',' . $params['uang_muka'] . ',' . $params['biaya_kirim'] . ',' . $params['biaya_ppn'] . ',' . $params['sisa_bayar'] . ',' . $params['c_bayar'] . ',' . $params['n_barang' . $dbl] . ',' . $params['qty_barang' . $dbl] . ',' . $b_disc . ',' . $params['satuan_barang' . $dbl] . '|';
                $jumlahPembelian += 1;
            }
        }
        if ($params['sisa_bayar'] <> 0) {
            $objectHutang = [
                "n_pembelian" => $params['n_transaksi'],
                "tanggal" => $tanggal,
                "reff" => $params['reff'],
                "n_pemasok" => $n_pemasok[0],
                "keterangan" => $params['keterangan'],
                "jumlah" => $params['sisa_bayar'],
                "sisa" => $params['sisa_bayar'],
                "tempo" => $tanggalTempo,
                "statusA" => "b",
                "created_by" => getSession('userId'),
            ];
            if (empty($params['created_by'])) {
                $objectHutang['created_by'] = '1';
            }
            $this->db->insert("hutang", $objectHutang);
            if ($this->db->error()["code"] != 0) {
                $error[] = [
                    'error' => $this->db->error(),
                    'query' => $this->db->last_query()
                ];
            }
            $hutangArray .= $params['n_transaksi'] . ',' . $tanggal . ',' . $params['reff'] . ',' . $n_pemasok[0] . ',' . $params['keterangan'] . ',' . $params['sisa_bayar'] . ',0,' . $tanggalTempo . ',b|';
            $jumlahHutang += 1;
            //djurnal hutang
            $objectHdjurnal = [
                "n_jurnal" => $jurnal['nomor'],
                "tanggal" => $tanggal,
                "akun" => $jurnal['a_pemasok'],
                "debet" => 0,
                "kredit" => $params['sisa_bayar'],
                "status_valid" => "a",
                "created_by" => getSession('userId'),
            ];
            if (empty($params['created_by'])) {
                $objectHdjurnal['created_by'] = '1';
            }
            $this->db->insert("djurnal", $objectHdjurnal);
            if ($this->db->error()["code"] != 0) {
                $error[] = [
                    'error' => $this->db->error(),
                    'query' => $this->db->last_query()
                ];
            }
            $jurnalArray .= $jurnal['nomor'] . ',' . $tanggal . ',' . $params['keterangan'] . ',' . $jurnal['a_pemasok'] . ',0,' . $params['sisa_bayar'] . ',b|';
            $jumlahJurnal += 1;
        }

        $this->db->trans_complete();
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            $return['status'] = true;
            $return['message'] = 'Transaksi pembelian berhasil';
        } else {
            $this->db->trans_rollback();
            $return['status'] = false;
            $return['error'] = $error;
            $return['message'] = 'Transaksi pembelian gagal';
        }
        return $return;
    }
}
