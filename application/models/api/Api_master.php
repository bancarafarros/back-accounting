<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class api_master extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function provinces_data() {
        $return['success'] = false;
        $return['message'] = '';
        $return['data']    = null;
        $get = $this->db->query("
            SELECT id, name 
            FROM ref_provinces 
            ORDER BY name ASC
        ");
        if ($get->num_rows() > 0) {
            $result = null;
            foreach ($get->result() as $key => $r) {
                $result[$key]['kode_provinsi'] = $r->id;
                $result[$key]['nama_provinsi'] = $r->name;
            }
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

    function regencies_data($province_id = null) {
        $return['success'] = false;
        $return['message'] = '';
        $return['data']    = null;

        if ($province_id == null) {
            $get = $this->db->query("
                SELECT 
                id, province_id, name 
                FROM ref_regencies 
                ORDER BY province_id ASC, name ASC
            ");
        } else {
            $get = $this->db->query("
                SELECT 
                id, province_id, name 
                FROM ref_regencies 
                WHERE province_id = ? 
                ORDER BY name ASC
            ", array($province_id));
        }

        if ($get->num_rows() > 0) {
            $result = null;
            foreach ($get->result() as $key => $r) {
                $result[$key]['kode_kabupaten_kota'] = $r->id;
                $result[$key]['kode_provinsi'] = $r->province_id;
                $result[$key]['nama_kabupaten_kota'] = $r->name;
            }
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

    function districts_data($regency_id = null) {
        $return['success'] = false;
        $return['message'] = '';
        $return['data']    = null;
        if ($regency_id == null) {
            $get = $this->db->query("
                SELECT 
                id, regency_id, name 
                FROM ref_districts 
                ORDER BY regency_id ASC, name ASC
            ");
        } else {
            $get = $this->db->query("
                SELECT 
                id, regency_id, name 
                FROM ref_districts 
                WHERE regency_id = ? 
                ORDER BY name ASC
            ", array($regency_id));
        }

        if ($get->num_rows() > 0) {
            $result = null;
            foreach ($get->result() as $key => $r) {
                $result[$key]['kode_kecamatan'] = $r->id;
                $result[$key]['kode_kebupaten_kota'] = $r->regency_id;
                $result[$key]['nama_kecamatan'] = $r->name;
            }

            $return['success'] = true;
            $return['message'] = 'Data ditemukan.';
            $return['data']    = $result;
        }else{
            $return['success'] = false;
            $return['message'] = 'Data ditemukan.';
            $return['data']    = null;
        }

        return $return;
    }

}
