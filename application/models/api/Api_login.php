<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Api_login extends CI_Model
{

    private $allowed_user_group = [99];

    function __construct()
    {
        parent::__construct();
    }

    function login($username, $password)
    {
        //cek username
        $get = $this->getUserUsername($username);
        if (empty($get)) {
            return [
                "status"    => false,
                "message"   => "Login gagal. User tidak ditemukan."
            ];
        }

        //cek password
        $get = $this->authentication($username, $password);
        if (empty($get)) {
            return [
                "status"    => false,
                "message"   => "Login gagal. Password tidak sesuai."
            ];
        }

        //cek status
        if ($get['is_active'] == '0') {
            return [
                "status"    => false,
                "message"   => "Login gagal. User telah dinonaktifkan."
            ];
        }
        // else if (!(in_array($get['id_group'], $this->allowed_user_group))) {
        //     return ["status" => false, "message" => "Login gagal. User role tidak diperbolehkan."];
        // } 
        else if ($get['id_group'] == null || $get['id_group'] == '0') {
            return [
                "status"    => false,
                "message"   => "Login gagal. User group tidak ditemukan."
            ];
        }

        $id_user = $get['id_user'];
        $id_group = $get['id_group'];
        return [
            "status"    => true,
            "data"      => [
                'id_user' => $id_user,
                'id_group' => $id_group
            ]
        ];
    }

    function check_user($username)
    {
        //cek username
        $get = $this->getUserUsername($username);
        if (empty($get)) {
            return [
                "status"    => false,
                "message" => "Refresh token gagal. User tidak ditemukan."
            ];
        }

        if ($get['is_active'] == '0') {
            return [
                "status"    => false,
                "message" => "Refresh token gagal. User telah dinonaktifkan."
            ];
        }
        // else if (!(in_array($get['id_group'], $this->allowed_user_group))) {
        //     return ["status" => false, "message" => "Login gagal. User role tidak diperbolehkan."];
        // } 
        else if ($get['id_group'] == null || $get['id_group'] == '0') {
            return ["status" => false, "message" => "Login gagal. User role tidak ditemukan."];
        }

        $id_user = $get['id_user'];
        $id_group = $get['id_group'];
        return [
            "status"    => true,
            "data"      => [
                'id_user'   => $id_user,
                'id_group'  => $id_group
            ]
        ];
    }

    function getUserUsername($username)
    {
        $this->db->where(['lower(username)' => $username]);
        $this->db->or_where(['lower(email)' => $username]);
        $data = $this->db->get('user')->row_array();
        return $data;
        // $this->db->where("((username IS NOT NULL AND LOWER(username) = ?) OR (email IS NOT NULL AND LOWER(email) = ?))");
        // $this->db->query('SELECT id_user, id_group FROM user WHERE ((username IS NOT NULL AND LOWER(username) = ?) OR (email IS NOT NULL AND LOWER(email) = ?))", array($username, $username)');
    }

    function authentication($username, $password)
    {
        $this->db->where(['lower(username)' => $username]);
        $this->db->where(['password' => hash('SHA256', $password)]);
        $data = $this->db->get('user')->row_array();
        return $data;
        // $this->db->query("SELECT id_user, id_group FROM user WHERE ((username IS NOT NULL AND LOWER(username) = ?) OR (email IS NOT NULL AND LOWER(email) = ?)) AND password = SHA2(?,256)", array($username, $username, $password));
    }
}
