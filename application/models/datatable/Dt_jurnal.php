<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once(APPPATH . 'core/MY_Datatable.php');

class Dt_jurnal extends MY_Datatable
{

    var $table = 'hjurnal';
    var $column_order = array('hj.n_jurnal', 'hj.tanggal', 'hj.reff', 'hj.keterangan', 'hj.statusA');
    var $column_search = array('hj.n_jurnal', 'hj.tanggal', 'hj.reff', 'hj.keterangan');
    var $order = array('hj.id' => 'desc');

    function _select_query()
    {
        if (empty($_POST['tahunbulan'])) {
            $_POST['tahunbulan'] = date('Y-m');
        }
        $this->db->where("MID(hj.tanggal, 1,7) = '" . $_POST['tahunbulan'] . "'");
        $this->db->select([
            'hj.id',
            'hj.n_jurnal',
            'hj.tanggal',
            'hj.reff',
            'hj.keterangan',
            'hj.statusA',
        ]);
        $this->db->from($this->table . " hj");
        $this->db->order_by('hj.tanggal', 'DESC');
    }

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
}
