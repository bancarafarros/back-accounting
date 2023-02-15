<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class api_member extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function member_data($member_id = null) {
        $return['success'] = false;
        $return['message'] = '';
        $return['data']    = null;

        $get = $this->db->where(['member_id'=> $member_id])->get('members');
        if ($get->num_rows() > 0) {
            $result = null;
            $hasil = $get->row_array();
            $result['member_id']        = $hasil['member_id']; 
            $result['nama']             = $hasil['nama']; 
            $result['nik']              = $hasil['nik']; 
            $result['no_hp']            = $hasil['no_hp']; 
            $result['tgl_lahir']        = $hasil['tgl_lahir']; 
            $result['kode_provinsi']    = $hasil['kode_provinsi'];
            $result['kode_kabupaten']   = $hasil['kode_kabupaten'];
            $result['kode_kecamatan']   = $hasil['kode_kecamatan'];
            $result['alamat']           = $hasil['alamat'];
            $result['alamat_domisili']  = $hasil['alamat_domisili'];
            $result['email']            = $hasil['email']; 
            $result['member_type']      = $hasil['member_type'];
            $result['custom_member']    = $hasil['custom_member'];
            $result['bank_type']        = $hasil['bank_type'];
            $result['bank_no_rek']      = $hasil['bank_no_rek'];
            $result['bank_atas_nama']   = $hasil['bank_atas_nama'];
            $result['parent_member_id'] = $hasil['parent_member_id'];
            $result['status']           = $hasil['status'];
            $result['foto']             = base_url($this->members_photo($hasil['id_member']));
            $result['medsos']           = $this->members_medsos($hasil['id_member']);
            
            $return['success'] = true;
            $return['message'] = 'Data ditemukan';
            $return['data']    = $result;
        }else{
            $return['success'] = false;
            $return['message'] = 'Data tidak ditemukan.';
            $return['data'] = null;
        }
        return $return;
    }

    function members_photo($id_member){
        $return = null;
        $get = $this->db->where(['id_member'=> $id_member, 'id_syarat'=> '2'])->get('members_syarats_files');
        if($get->num_rows() > 0){
            $return = $get->row_array()['url_syarat'];
        }

        return $return;
    }

    function members_medsos($id_member){
        $return = null;
        $this->db->select('med.*, r.nama');
        $this->db->join('ref_medsos as r', 'med.id_medsos = r.id', 'left');
        $this->db->where(['id_member'=> $id_member]);
        $this->db->order_by('r.nama', 'asc');
        $get = $this->db->get('members_medsos as med');
        if($get->num_rows() > 0){
            $result = $get->result_array();
                foreach ($result as $key => $value) {
                    $return[strtolower($value['nama'])] = $value['url_medsos'];
                }
            }

        return $return;
    }

    function member_find($params) {
        $return['success'] = false;
        $return['message'] = '';
        $return['data']    = null;
        $this->db->select('members.*, p.name as provinsi, k.name as kabupaten, kec.name as kecamatan');
        $this->db->join('ref_provinces p', 'members.kode_provinsi = p.id', 'left');
        $this->db->join('ref_regencies k', 'members.kode_kabupaten = k.id', 'left');
        $this->db->join('ref_districts kec', 'members.kode_kecamatan = kec.id');
        if(!empty($params['member_id'])){
            $this->db->where(['member_id'=> $params['member_id']]);
        }elseif(!empty($params['no_hp'])){
            $this->db->where(['no_hp'=> $params['no_hp']]);
        }elseif(!empty($params['nama'])){
            $this->db->where(['nama'=> $params['nama']]);
        }
        $this->db->where(['status'    => '1']);
        $get = $this->db->get('members');
        if ($get->num_rows() > 0) {
            $result = null;
            $hasil = $get->row_array();
            $result['member_id']        = $hasil['member_id']; 
            $result['nama']             = $hasil['nama']; 
            $result['nik']              = $hasil['nik']; 
            $result['no_hp']            = $hasil['no_hp']; 
            $result['tgl_lahir']        = $hasil['tgl_lahir']; 
            $result['kode_provinsi']    = $hasil['kode_provinsi'];
            $result['provinsi']         = $hasil['provinsi'];
            $result['kode_kabupaten']   = $hasil['kode_kabupaten'];
            $result['kabupaten']        = $hasil['kabupaten'];
            $result['kode_kecamatan']   = $hasil['kode_kecamatan'];
            $result['kecamatan']        = $hasil['kecamatan'];
            $result['alamat']           = $hasil['alamat'];
            $result['alamat_domisili']  = $hasil['alamat_domisili'];
            $result['email']            = $hasil['email']; 
            $result['member_type']      = $hasil['member_type'];
            $result['custom_member']    = $hasil['custom_member'];
            $result['bank_type']        = $hasil['bank_type'];
            $result['bank_no_rek']      = $hasil['bank_no_rek'];
            $result['bank_atas_nama']   = $hasil['bank_atas_nama'];
            $result['parent_member_id'] = $hasil['parent_member_id'];
            $result['status']           = $hasil['status'];
            $result['foto']             = base_url($this->members_photo($hasil['id_member']));
            $result['medsos']           = $this->members_medsos($hasil['id_member']);
            
            $return['success'] = true;
            $return['message'] = 'Data ditemukan';
            $return['data']    = $result;
        }else{
            $return['success'] = false;
            $return['message'] = 'Data tidak ditemukan.';
            $return['data'] = null;
        }
        return $return;
    }
}