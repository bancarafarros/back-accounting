<?php

function active_page($page)
{
    $_this =& get_instance();
    if ($page == $_this->uri->segment(1)) {
        return 'active';
    }
}

function randomPassword()
    {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $input_length = strlen($permitted_chars);
        $random_string = '';
        for($i = 0; $i < 8; $i++) {
            $random_character = $permitted_chars[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }

    return $random_string;
    }

    function getProvinsi()
    {
        $ci  = &get_instance();

        $prov = $ci->db->query("SELECT * FROM ref_provinsi order by name asc");

        if ($prov->num_rows()!=0) {
            return $prov->result_array();
        }else {
            return null;
        }
    }

    function getKotaByProv($id)
    {
        $ci =&get_instance();

        $get = $ci->db->query("SELECT * FROM ref_kabkota where province_id=? order by name asc", array($id));

        if ($get->num_rows()!=0) {
            return $get->result_array();
        }else {
            return null;
        }
    }

    function getKecamatanByKota($id)
    {
        $ci =&get_instance();

        $get = $ci->db->query("SELECT * FROM ref_kecamatan where regency_id=? order by name asc", array($id));

        if ($get->num_rows()!=0) {
            return $get->result_array();
        }else {
            return null;
        }
    }

    function sendWA($params)
    {
        $userkey = '527387d90162';
        $passkey = '68958fc2f7023c4a97267915';
        $telepon = $params['nomor_hp'];
        $message = $params['pesan'];
        $url = 'https://console.zenziva.net/wareguler/api/sendWA/';
        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, $url);
        curl_setopt($curlHandle, CURLOPT_HEADER, 0);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curlHandle, CURLOPT_TIMEOUT,30);
        curl_setopt($curlHandle, CURLOPT_POST, 1);
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, array(
            'userkey' => $userkey,
            'passkey' => $passkey,
            'to' => $telepon,
            'message' => $message
        ));
        $results = json_decode(curl_exec($curlHandle), true);
        curl_close($curlHandle);
        return $results;
    }

    function cekData($tabel, $params, $kondisi, $id='', $primary_key='')
    {
        $ci =& get_instance();
        $ci->db->select("*");
        $ci->db->from($tabel);
        if ($kondisi=='insert') {
            $ci->db->where($params);
        }else if($kondisi=='update'){
            $ci->db->where($params);
            $ci->db->where($primary_key.'!=',$id);
        }
        return $ci->db->count_all_results();
    }

    function uploadFile($nama_file, $path_folder, $prefix)
    {
        $ci =&get_instance();

        $response['success'] = false;
        $response['file_name'] ='';
        $nama_foto = "";
        if (isset($_FILES[$nama_file]['name'])) {
            list($width, $height) = getimagesize($_FILES[$nama_file]['tmp_name']);
            $config['upload_path']='public/uploads/'.$path_folder; //path folder file upload
            $config['allowed_types']='gif|jpg|jpeg|png|jpeg|bmp'; //type file yang boleh di upload
            $config['max_size'] = '2000';
            $config['file_name'] = $prefix.'_'.date('ymdhis'); //enkripsi file name upload
            $ci->load->library('upload');
            $ci->upload->initialize($config);

            if ($ci->upload->do_upload($nama_file)) {
                $file_foto = $ci->upload->data();
                $config['image_library']='gd2';
                $config['source_image']='./public/uploads/'.$path_folder.$file_foto['file_name'];
                $config['create_thumb']= FALSE;
                $config['maintain_ratio']= TRUE;
                $config['quality']= '50%';
                $config['width']= round($width/5);
                $config['height']= round($height/5);
                $config['new_image']= './public/uploads/'.$path_folder.$file_foto['file_name'];
                $ci->load->library('image_lib');
                $ci->image_lib->initialize($config);
                $ci->image_lib->resize();
                $nama_foto='/public/uploads/'.$path_folder.'/'.$file_foto['file_name'];
                $response['success'] = true;
                $response['file_name'] =$nama_foto;
            }
        }

        return $response;
    }

