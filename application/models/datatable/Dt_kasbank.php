<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once(APPPATH . 'core/MY_Datatable.php');

class Dt_kasbank extends MY_Datatable
{

    var $table = 'hkasbank';
    var $column_order = array(null, 'hj.n_kasbank', 'hj.tanggal', 'hj.reff', 'hj.keterangan', 'hj.jumlah', 'hj.statusA');
    var $column_search = array('hj.n_kasbank', 'hj.tanggal', 'hj.reff', 'hj.keterangan', 'hj.jumlah', 'hj.statusA');
    var $order = array('hj.id' => 'desc');

    function _select_query()
    {
        // if (empty($_POST['tahunbulan'])) {
        //     $_POST['tahunbulan'] = date('Y-m');
        // } else {
        //     $_POST['tahunbulan'] = $_POST['columns'][3]['search']['value'];
        // }
        $_POST['tahunbulan'] = date('Y-m');
        if (!empty($_POST['columns'][3]['search']['value'])) {
            $_POST['tahunbulan'] = $_POST['columns'][3]['search']['value'];
        }

        $this->db->where("MID(hj.tanggal, 1,7) = '" . $_POST['tahunbulan'] . "'");
        $this->db->select([
            'hj.id',
            'hj.n_kasbank',
            'hj.tanggal',
            'hj.reff',
            'hj.keterangan',
            'hj.jumlah',
            'hj.statusA',
        ]);
        $this->db->from($this->table . " hj");
        $this->db->order_by('hj.tanggal', 'DESC');
    }

    public $excelKeys = [
        'id',
        'n_jurnal',
        'tanggal',
        'reff',
        'keterangan',
        'statusA',
    ];

    function _custom_search_query()
    {
        $this->_filterbulantahun();
    }

    protected function _filterbulantahun()
    {
        if (isset($_POST['columns'])) {
            if ($_POST['columns'][0]['search']['value'] != '') {
                $filter = $_POST['columns'][0]['search']['value'];
                // $tahun = date('Y-m', strtotime($filter));
                // $bulan = date('m', strtotime($filter));
                // $this->db->where('MID(hj.tanggal,1,7)', $tahun);
                // $this->db->where('MONTH(hj.tanggal)', $bulan);
            }
        }
    }

    function export_query($where = [])
    {
        $this->db->select([
            'hj.n_kasbank',
            'hj.tanggal',
            'hj.reff',
            'hj.keterangan',
            'hj.statusA'
        ]);

        $this->db->from($this->table . " hj");
    }

    function export_data_map($item, $index, $type)
    {
        return [
            'No'                    => $index + 1,
            'No Transaksi'          => $item->n_kasbank,
            'Tanggal'               => $item->tanggal,
            'Referensi'             => $item->reff,
            'Keterangan'            => $item->keterangan,
            'Status'                => $item->statusA,
        ];
    }

    function export_headers($type)
    {
        return [
            'No',
            'No Transaksi',
            'Tanggal',
            'Referensi',
            'Keterangan',
            'Status',
        ];
    }
}
