<?php
class M_activity_log extends MY_Model
{
    protected $table = 'activity_log';
    protected $primary_key = 'id_log';
    protected $order_by;
    protected $order_by_type;
    protected $primary_filtered = 'intval';
    protected $type;

    function insertData($data)
    {
        if (empty($data['ip_address'])) {
            $ip = $this->getIp();
            $data['ip_address'] = $ip;
        }

        $status = $this->insert($data);
        return $status;
    }

    function getIp()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED'];
        } elseif (!empty($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_FORWARDED_FOR'];
        } elseif (!empty($_SERVER['HTTP_FORWARDED'])) {
            $ip = $_SERVER['HTTP_FORWARDED'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return $ip;
    }

    function get_data($limit = null, $start = null, $nama = null, $tgl = null)
    {
        if ($nama != null) {
            $where = $this->filter($nama);
        } else {
            $where = "";
        }
        if ($tgl != null) {
            $where .= $this->filter(null, $tgl);
        } else {
            $where .= "";
        }

        if ($limit != null) {
            $result = $this->db->query("SELECT a.*, b.username, b.email FROM activity_log a INNER JOIN user b ON a.id_user = b.id_user WHERE 1 $where ORDER BY a.id_log DESC LIMIT $start, $limit");
        } else {
            $result = $this->db->query("SELECT a.*, b.username, b.email FROM activity_log a INNER JOIN user b ON a.id_user = b.id_user WHERE 1 $where ORDER BY a.id_log DESC");
        }

        return $result;
    }

    function get_nama()
    {
        $result = $this->db->query("SELECT DISTINCT a.id_user, b.username, b.email FROM activity_log a INNER JOIN user b ON a.id_user = b.id_user");

        return $result->result_array();
    }

    function filter($nama = null, $tgl = null)
    {
        if ($nama != null) {
            foreach ($nama as $m) {
                $nama_array[] = $m;
            }

            if (!empty($nama_array)) {
                $nama_array_im = implode("','", $nama_array);
                $nama_where = "a.id_user IN ('$nama_array_im')";
            } else {
                $nama_where = "";
            }

            if ($nama_where != "") {
                $where = " AND " . $nama_where;
            }
        } else if ($tgl != null) {
            $ex = explode(" - ", $tgl);
            $start = $ex[0];
            $finish = $ex[1];

            $ex_s = explode("/", $start);
            $start = $ex_s[2] . "-" . $ex_s[1] . "-" . $ex_s[0] . " 00:00:00";
            $ex_f = explode("/", $finish);
            $finish = $ex_f[2] . "-" . $ex_f[1] . "-" . $ex_f[0] . " 23:59:59";

            $where = " AND DATE(activity_time) BETWEEN '$start' AND '$finish'";
        } else {
            $where = "";
        }

        return $where;
    }
}
