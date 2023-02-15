<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Api_coa extends CI_Model
{

    protected $table = 'coa';
    protected $primary_key = 'akun';

    function __construct()
    {
        parent::__construct();
    }

    function coaData()
    {
        $this->db->select([
            "akun", "nama", "grup", "subgrup", "detail", "debet", "kredit", "saldo", "link", "debet_link", "kredit_link", "saldo_link", "is_active",
        ]);
        $this->db->where(['is_active' => '1']);
        $data = $this->db->get($this->table)->result_array();
        return $data;
    }

    public function coaByAkun($akun)
    {
        $data = $this->getData($this->table, ['*'], ['akun' => $akun], 1);
        return $data;
    }

    public function coaByGrup($grup)
    {
        $data = $this->getData($this->table, ['*'], ['grup' => $grup]);
        return $data;
    }

    public function grup($grup = null)
    {
        $data = null;
        $this->db->distinct();
        $this->db->select(['grup']);
        if (!empty($grup)) {
            $this->db->where(['grup' => $grup]);
            $data = $this->db->get($this->table)->row_array();
        } else {
            $data = $this->db->get($this->table)->result_array();
        }
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

    public function insertCoa($param)
    {
        $object = array(
            'akun'      => $param['akun'],
            'nama'      => strtoupper($param['nama']),
            'created_by' => '1'
        );

        if(!empty($param['grup'])){
            $object['grup'] = strtoupper($param['grup']);
        }
        if(!empty($param['subgrup'])){
            $object['subgrup'] = strtoupper($param['subgrup']);
        }
        if(!empty($param['detail'])){
            $object['detail'] = ucwords($param['detail']);
        }
        if(!empty($param['link'])){
            $object['link'] = $param['link'];
        }

        $cek = $this->db->get_where($this->table, array($this->primary_key => $param['akun']))->num_rows();

        if($cek == 0){
            $this->db->insert($this->table, $object);
            $result = $this->db->get_where($this->table, array($this->primary_key => $param['akun']))->row();
        }else{
            $result = null;
        }

        return $result;
    }

    public function updateCoa($param)
    {
        $object = array();

        if(!empty($param['nama'])){
            $object['nama'] = strtoupper($param['nama']);
        }
        if(!empty($param['grup'])){
            $object['grup'] = strtoupper($param['grup']);
        }
        if(!empty($param['subgrup'])){
            $object['subgrup'] = strtoupper($param['subgrup']);
        }
        if(!empty($param['detail'])){
            $object['detail'] = ucwords($param['detail']);
        }
        if(!empty($param['link'])){
            $object['link'] = $param['link'];
        }

        $cek = $this->db->get_where($this->table, array($this->primary_key => $param['akun']))->num_rows();
        $result = null;

        if($cek > 0 ){
            $this->db->update($this->table, $object, array($this->primary_key => $param['akun']));
            $result = $this->db->get_where($this->table, array($this->primary_key => $param['akun']))->row();
        }

        return $result;
    }

    public function deleteCoa($param)
    {
        $result = $this->db->delete($this->table, array($this->primary_key => $param));
        return $result;
    }

    public function cekData($param)
    {
        $cek = $this->db->get_where($this->table, array($this->primary_key => $param))->num_rows();

        if($cek > 0){
            $result = true;
        }else{
            $result = false;
        }

        return $result;
    }
}
