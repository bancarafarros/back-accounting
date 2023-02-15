<?php

class Globalfunction {

    function log_user($ip_address = null, $id_user = null, $jenis_user = null, $activity = null) {
        $CI = & get_instance();
        $CI->db->query("INSERT INTO log_user (id_user, jenis_user, ip_adress, activity, activity_time) VALUES (?,?,?,?,NOW())", array($id_user, $jenis_user, $ip_address, $activity));
    }

    function jenis_user($id_group = null) {
        $jenis = ['User', 'Administrator', 'Rektor', 'Wakil Rektor II', 'Kabag Keuangan', 'Admin Keuangan','Unit/Prodi/Fakultas'];
        if($id_group != "" || $id_group != null){
            return $id_group . "_" . $jenis[(int)$id_group];
        }else{
            return "_".$jenis[0];
        }
    }
}
