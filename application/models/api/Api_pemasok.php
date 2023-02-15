<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Api_pemasok extends CI_Model
{
    protected $table = 'pemasok';
    protected $primary_key = 'n_pemasok';

    function __construct()
    {
        parent::__construct();
    }

    function pemasokData()
    {
        $this->db->select('*');
        $this->db->where(['statusA' => '1']);
        $data = $this->db->get($this->table)->result_array();
        return $data;
    }

    public function pemasokByNomor($param)
    {
        $data = $this->getData($this->table, ['*'], ['n_pemasok' => $param], 1);
        return $data;
    }

    public function pemasokByAkun($param)
    {
        $data = $this->getData($this->table, ['*'], ['akun' => $param], 1);
        return $data;
    }

    public function pemasokByTanggal($param)
    {
        $data = $this->getData($this->table, ['*'], ['tanggal' => $param]);
        return $data;
    }

    public function getData($table, $select = ['*'], $where = null, $limit = null, $order = null)
    {
        $this->db->select($select);

        if($where != null){
            $this->db->where($where);
        }

        if($limit != null){
            $this->db->limit($limit);
        }

        if($order != null){
            $this->db->order($order);
        }

        $query = $this->db->get($table);

        if($limit == 1){
            return $query->row_array();
        }

        return $query->result_array();
    }

    public function insertPemasok($param)
    {
        $tanggal = date('Y-m-d');

        $result = null;

        $object = array(
            "n_pemasok" => generateNomorPerson(PREFIX_PEMASOK, 'n_pemasok', 'pemasok'),
            "tanggal"   => $tanggal,
            "akun"      => $param['akun'],
            "nama"      => $param['nama'],
            "created_by" => "1"
        );

        if(!empty($param['alamat'])){
            $object['alamat'] = $param['alamat'];
        }
        if(!empty($param['telepon'])){
            $object['telepon'] = $param['telepon'];
        }
        if(!empty($param['email'])){
            $object['email'] = $param['email'];
        }
        if(!empty($param['batas'])){
            $object['batas'] = $param['batas'];
        }

        $query_cek = $this->db->get_where('coa', array('akun' => $param['akun']))->num_rows();

        if($query_cek > 0){
            $this->db->insert($this->table, $object);

            $id = $object['n_pemasok'];
            $result = $this->db->get_where($this->table, array($this->primary_key => $id))->row();
        }

        return $result;
    }

    public function updatePemasok($param)
    {

        $object = array(
            "akun"      => $param['akun'],
            "updated_by"=> '1'
        );
        
        if(!empty($param['nama'])){
            $object['nama'] = $param['nama'];
        }
        if(!empty($param['alamat'])){
            $object['alamat'] = $param['alamat'];
        }
        if(!empty($param['telepon'])){
            $object['telepon'] = $param['telepon'];
        }
        if(!empty($param['email'])){
            $object['email'] = $param['email'];
        }
        if(!empty($param['batas'])){
            $object['batas'] = $param['batas'];
        }
        $cek = $this->db->get_where($this->table, array($this->primary_key => $param['nomor_pemasok']))->num_rows();

        $cek_akun = $this->db->get_where('coa', array('akun' => $param['akun']))->num_rows();

        if($cek > 0 && $cek_akun > 0){
            $this->db->update($this->table, $object, array($this->primary_key => $param['nomor_pemasok']));
            $result = $this->db->get_where($this->table, array($this->primary_key => $param['nomor_pemasok']))->row();
        }else if($cek == 0){
            $result = "invalid_nomor";
        }else if($cek_akun == 0){
            $result = "invalid_akun";
        }
        return $result;
    }

    public function deletePemasok($param)
    {
        $cek = $this->db->get_where($this->table, array($this->primary_key => $param))->num_rows();

        $result = false;

        if($cek > 0){
            $result = $this->db->delete($this->table, array($this->primary_key => $param));
        }

        return $result;
    }
}