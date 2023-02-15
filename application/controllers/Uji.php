<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Uji extends CI_Controller
{

    public function index()
    {
        $data = generateNomorPerson('PEM', 'n_pemasok', 'pemasok');
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        die;
    }

    public function pembelian()
    {
        $data = generateNomorForAccounting('PT', 'hpembelian', 'n_pembelian');
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        die;
    }

    public function setLolos()
    {
        $file = file_get_contents('./data/lolos_berkas.json');
        $records = json_decode($file, true);

        $lolosBerkas = $this->castingLolos($records['lolos_berkas']);
        $registrasi = $lolosBerkas['id_registrasi'];
        $prodi = $lolosBerkas['prodi'];

        $datas = $this->db->get('registrasi')->result_array();

        $this->db->trans_begin();
        foreach ($datas as $key => $data) {
            $lo = $records['lolos_berkas'];
            for ($i = 0; $i < count($lo); $i++) {
                if ($data['id_registrasi'] == $lo[$i]['id_registrasi']) {
                    if (!empty($lo[$i]['id_prodi_diterima'])) {
                        $dataUpdate = ['is_lolos_administrasi' => '1', 'id_prodi_diterima' => $lo[$i]['id_prodi_diterima']];

                        $this->db->where(['id_registrasi' => $data['id_registrasi']]);
                        $this->db->update('registrasi', $dataUpdate);
                    }
                }
            }
            // if (in_array($data['id_registrasi'], $registrasi)) {
            // } else {
            //     echo 'tidak ketemu<br>';
            // }
        }
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            echo 'sukse';
        } else {
            $this->db->trans_rollback();
            echo 'gagal';
        }
    }

    private function castingLolos($data)
    {
        $lolosBerkas = $data;
        $return = null;
        $id_registrasi = null;
        $prodi = null;
        foreach ($lolosBerkas as $key => $lolos) {
            if (!empty($lolos['id_prodi_diterima'])) {
                $id_registrasi[] = $lolos['id_registrasi'];
                $prodi[] = $lolos['id_prodi_diterima'];
            }
        }
        $return['id_registrasi'] = $id_registrasi;
        $return['prodi'] = $id_registrasi;

        return $return;
    }

    private function castingProdi($data)
    {
        $lolosBerkas = $data;
        $return = null;
        foreach ($lolosBerkas as $key => $lolos) {
            $return[] = $lolos['id_prodi_diterima'];
        }

        return $return;
    }

    public function setProdi()
    {
        $prodis = $this->db->get('ref_prodi')->result_array();
        $sejumlah = 50;
        $this->db->trans_begin();
        foreach ($prodis as $key => $prodi) {
            $this->db->where(['is_lolos_administrasi' => '0']);
            $this->db->order_by('id_registrasi', 'ASC');
            $data = $this->db
                ->limit($sejumlah)
                ->get('registrasi')
                ->result_array();
            foreach ($data as $k => $peserta) {
                $this->db->where(['id_registrasi' => $peserta['id_registrasi']]);
                $this->db->update('registrasi', ['is_lolos_administrasi' => '1', 'id_prodi_diterima' => $prodi['id_prodi']]);
            }
        }

        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            echo 'sukse';
        } else {
            $this->db->trans_rollback();
            echo 'gagal';
        }
    }
}
