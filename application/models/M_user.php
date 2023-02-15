<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_user extends MY_Model
{
    protected $table = 'user';
    protected $primary_key = 'id_user';

    function getDataUser()
    {
        $this->db->select('user.*, user_group.nama_group');
        $this->db->join('user_group', 'user.id_group = user_group.id_group');
        $this->db->where('id_user !=', 1);
        $this->db->order_by('id_group', 'ASC');
        $query = $this->db->get($this->table);
        if ($query->num_rows() == 0) {
            return FALSE;
        } else {
            return $query->result();
        }
    }

    function getUserGroup()
    {
        $query = $this->db->get('user_group');
        if ($query->num_rows() == 0) {
            return FALSE;
        } else {
            return $query->result();
        }
    }

    function addDataUser($param)
    {
        $object = [
            'username' => $param['username'],
            'email' => $param['email'],
            'real_name' => $param['real_name'],
            'id_group' => $param['id_group'],
            'password' => hash("sha256", $param['password'])
        ];

        return $this->db->insert($this->table, $object);
    }

    function getUser($id_user, $username = null)
    {
        $this->db->select('user.*, user_group.nama_group');
        $this->db->join('user_group', 'user.id_group = user_group.id_group');
        $this->db->where($this->primary_key, $id_user);
        if (!empty($username)) {
            $this->db->where('username', $username);
        }
        $data = $this->db->get($this->table);
        return $data->row();
    }

    public function reset_password($params)
    {
        $return['success'] = false;
        $return['message'] = '';
        $user['password'] = hash('sha256', $params['password']);
        $user['updated_by'] = getSession('userId');
        if ($params['email_awal'] != $params['email_baru']) {
            $user['email'] = $params['email_baru'];
        }
        if ($params['password'] == $params['ulangi_password']) {
            $ubah = $this->editDataUser($params['id_user'], $user);
            if ($ubah) {
                $return['success'] = true;
                $return['message'] = 'Reset password berhasil';
            } else {
                $return['success'] = false;
                $return['message'] = 'Password password gagal';
            }
        } else {
            $return['success'] = false;
            $return['message'] = 'Password dan konfirmasi password tidak sesuai';
        }

        return $return;
    }

    function editDataUser($id_user, $param)
    {
        $this->db->where($this->primary_key, $id_user);
        return $this->db->update($this->table, $param);
    }

    function editPassUser($param, $id_user)
    {
        $object = [
            "password" => hash("sha256", $param['password']),
        ];
        $this->db->where($this->primary_key, $id_user);
        return $this->db->update($this->table, $object);
    }

    function hapusDataUser($idUser)
    {
        $this->db->where($this->primary_key, $idUser);
        return $this->db->delete($this->table);
    }

    function passUser($field1, $field2)
    {
        $this->db->select('*');
        $this->db->where($field1);
        $this->db->where($field2);
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        if ($query->num_rows() == 0) {
            return FALSE;
        } else {
            return $query->result();
        }
    }

    function checkDb()
    {
        if (!$this->db->field_exists('n_sales', 'hpenjualan')) {
            $this->db->query("ALTER TABLE hpenjualan ADD n_sales VARCHAR(12)");
        }
    }

    public function ubah($id_user, $data)
    {
        $return['status'] = null;
        $return['message'] = null;
        $user = $this->getUser($id_user);
        $lanjut = true;
        if ($data['email'] != $user->email) {
            $cek = $this->isUsed('email', $data['email']);
            if ($cek) {
                $lanjut = false;
                $return['status'] = false;
                $return['message'] = 'Email telah digunakan, silahkan masukkan email yang lain';
            }
        }
        if ($lanjut) {
            $this->db->where([$this->primary_key => $id_user]);
            $proses =  $this->db->update($this->table, $data);
            if ($proses) {
                $return['status'] = true;
                $return['message'] = 'Ubah profil berhasil';
            } else {
                $return['status'] = false;
                $return['message'] = 'Ubah profil gagal';
            }
        }

        return $return;
    }

    public function isUsed($column, $value)
    {
        $this->db->where([$column => $value]);
        $data = $this->db->get($this->table);
        if ($data->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
