<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function _callOpsi($member)
{
	$ci = &get_instance();
	$btnstatus = null;
	$btnhapus = null;
	$edit = null;
	if ($ci->session->userdata('bgskin_idGroup') == '1') {
		$edit = '<button class="btn btn-warning btn-xs btn-icon text-light mb-1" onclick="edit(' . "'" . $member['id_member'] . "'" . ')"><i class="fa fa-edit"></i> Ubah</button>';
		if ($member['is_hapus'] == '0') {
			$btnhapus = '<button type="button" class="btn btn-danger btn-icon btn-xs text-light mb-1" onclick="hapus(' . "'" . $member['id_member'] . "'" . "," . "1" . ')" data-toggle="tooltip" data-placement="top" title="Hapus Event"><i class="fa fa-trash"></i> Hapus</button>';
			if ($member['is_active'] == '0') {
				$btnstatus = '<button type="button" class="btn btn-success btn-icon btn-xs text-light mb-1" onclick="setstatus(' . "'" . $member['id_member'] . "'" . "," . "1" . ')"><i class="fa fa-check"></i> Aktifkan</button>';
			} else {
				$btnstatus = '<button type="button" class="btn btn-warning btn-icon btn-xs text-light mb-1" onclick="setstatus(' . "'" . $member['id_member'] . "'" . "," . "0" . ')"><i class="fa fa-times"></i> Non Aktifkan</button>';
			}
		}
	}
	$return = '<div class="btn-group"><a href="' . site_url('detail_member/detail/') . $member['id_member'] . '" class="btn btn-primary btn-xs btn-icon mb-1"><i class="fa fa-search"></i> Detail</a>' . $edit . $btnstatus . $btnhapus . '</div>';
	return $return;
}

function uploadImage($nama_file, $path_folder, $prefix)
{
	$ci = &get_instance();

	$response['success'] = false;
	$response['file_name'] = '';
	$nama_foto = "";
	if (!empty($_FILES[$nama_file]['name'])) {
		list($width, $height) = getimagesize($_FILES[$nama_file]['tmp_name']);
		$config['upload_path'] = 'public/uploads/' . $path_folder; //path folder file upload
		$config['allowed_types'] = 'gif|jpg|jpeg|png|bmp'; //type file yang boleh di upload
		$config['max_size'] = '3000';
		$config['file_name'] = $prefix . '_' . date('ymdhis'); //enkripsi file name upload
		$ci->load->library('upload');
		$ci->upload->initialize($config);
		if ($ci->upload->do_upload($nama_file)) {
			$file_foto = $ci->upload->data();
			// $con['image_library']='gd2';
			// $con['source_image']= './public/uploads/'.$path_folder.'/'.$file_foto['file_name'];
			// $con['create_thumb']= FALSE;
			// $con['maintain_ratio']= TRUE;
			// $con['quality']= '100%';
			// $con['width']= round($width/5);
			// $con['height']= round($height/5);
			// $con['new_image']= './public/uploads/'.$path_folder.'/'.$file_foto['file_name'];
			// $ci->load->library('image_lib');
			// $ci->image_lib->initialize($con);
			$nama_foto = '/public/uploads/' . $path_folder . '/' . $file_foto['file_name'];
			$response['success'] = true;
			$response['file_name'] = $nama_foto;
		}
	}
	return $response;
}

function uploadBerkas($nama_file, $path_folder, $prefix)
{
	$ci = &get_instance();

	$response['success'] = false;
	$response['file_name'] = '';
	$nama_berkas = "";
	if (!empty($_FILES[$nama_file]['name'])) {
		list($width, $height) = getimagesize($_FILES[$nama_file]['tmp_name']);
		$file_type = explode("/", $_FILES[$nama_file]['type'])[0];
		$config['upload_path'] = 'public/uploads/' . $path_folder; //path folder file upload
		$config['allowed_types'] = 'pdf|gif|jpg|jpeg|png|bmp|webp'; //type file yang boleh di upload
		$config['max_size'] = '2000';
		$config['file_name'] = $prefix . '_' . date('ymdhis'); //enkripsi file name upload
		$ci->load->library('upload');
		$ci->upload->initialize($config);
		if ($ci->upload->do_upload($nama_file)) {
			$file_foto = $ci->upload->data();
			// if($file_type == 'image'){
			//   $config['image_library']='gd2';
			//   $config['source_image']='./public/uploads/'.$path_folder.'/'.$file_foto['file_name'];
			//   $config['create_thumb']= FALSE;
			//   $config['maintain_ratio']= TRUE;
			//   $config['quality']= '100%';
			//   $config['width']= round($width/5);
			//   $config['height']= round($height/5);
			//   $config['new_image']= './public/uploads/'.$path_folder.'/'.$file_foto['file_name'];
			//   $ci->load->library('image_lib');
			//   $ci->image_lib->initialize($config);
			//   $ci->image_lib->resize();
			//   $response['file_type'] = 'image';
			// }
			$nama_berkas = '/public/uploads/' . $path_folder . '/' . $file_foto['file_name'];
			$response['success'] = true;
			$response['file_name'] = $nama_berkas;
		}
	}
	return $response;
}

function getProvinsi()
{
	$ci  = &get_instance();

	$prov = $ci->db->query("SELECT * FROM ref_provinces order by name asc");

	if ($prov->num_rows() != 0) {
		return $prov->result_array();
	} else {
		return null;
	}
}

function getKotaByProv($id)
{
	$ci = &get_instance();

	$get = $ci->db->query("SELECT * FROM ref_regencies where province_id=? order by name asc", array($id));

	if ($get->num_rows() != 0) {
		return $get->result_array();
	} else {
		return null;
	}
}

function getKecamatanByKota($id)
{
	$ci = &get_instance();

	$get = $ci->db->query("SELECT * FROM ref_districts where regency_id=? order by name asc", array($id));

	if ($get->num_rows() != 0) {
		return $get->result_array();
	} else {
		return null;
	}
}

function formatTeks($tag = null, $class = null, $value = null)
{
	$return = '<p>' . $value . '</p>';
	if (!empty($tag)) {
		$return = '<' . $tag . '>' . $value . '</' . $tag . '>';
		if (!empty($class)) {
			$return = '<' . $tag . ' class="' . $class . '">' . $value . '</' . $tag . '>';
		}
	} else {
		$return = '<p>' . $value . '</p>';
		if (!empty($class)) {
			$return = '<p class="' . $class . '">' . $value . '</p>';
		}
	}
	return $return;
}

function listMemberType($tipe_member = null)
{
	$member_type = [
		'Distributor'   => 'Distributor',
		'Agen'          => 'Agen',
		'AgenStarter'   => 'Agen Starter',
		'Reseller'      => 'Reseller',
		'Member'        => 'Member',
	];
	if (!empty($tipe_member)) {
		return $member_type[$tipe_member];
	} else {
		return $member_type;
	}
}

function listGroupUser()
{
	$group = [
		'2' => 'Distributor',
		'3' => 'Agen',
		'4' => 'Agen Starter',
		'5' => 'Reseller',
		'6' => 'Member',
	];

	return $group;
}
function listKeaktifanMember()
{
	$is_active = [
		'1' => 'Aktif',
		'0' => 'Non Aktif',
	];

	return $is_active;
}
// for add member
function arrangelistMember($tipe_member, $member_type = null)
{
	$ci = &get_instance();
	$data = null;
	$return = null;
	$ci->db->select('members.*, ref_regencies.name as kabupaten');
	$ci->db->join('ref_regencies', 'ref_regencies.id = members.kode_kabupaten', 'left');
	$ci->db->where(['is_active' => '1', 'status' => '1', 'is_hapus' => '0']);

	if (!empty($member_type)) {
		$ci->db->where(['member_type' => $member_type]);
	}
	$ci->db->order_by('member_type', 'ASC');

	$grant = grantMemberType($tipe_member);
	$data = $ci->db->get('members');

	if ($data->num_rows() > 0) {
		$result = $data->result_array();
		$return[0] = 'Tidak Ada/Tidak Punya Upline';
		foreach ($result as $d) {
			if (in_array($d['member_type'], $grant)) {
				$return[$d['id_member']] = $d['nama'] . ' [' . $d['member_type'] . '] (' . $d['member_id'] . ') | ' . $d['kabupaten'];
			}
		}
	}

	return $return;
}

function memberTypeByNumber($tipe_member = null)
{
	$data = [2 => 'Distributor', 'Agen', 'AgenStarter', 'Reseller', 'Member'];
	if (!empty($tipe_member)) {
		return $data[$tipe_member];
	}
	return $data;
}

// for add member
function grantMemberType($member_type)
{
	$data = [2 => 'Distributor', 'Agen', 'AgenStarter', 'Reseller', 'Member'];
	$grant = [];
	$key = $member_type;
	for ($i = 2; $i <= $member_type; $i++) {
		$grant[] = $data[$key--];
	}

	return $grant;
}

function listMemberAll($member_type = null)
{
	$ci  = &get_instance();
	if (!empty($member_type)) {
		$ci->db->where(['member_type' => $member_type]);
	}
	$result = null;
	$data = $ci->db->get('members');
	if ($data->num_rows() > 0) {
		$result = $data->result_array();
		foreach ($result as $d) {
			$return[$d['id_member']] = $d['nama'] . ' [' . $d['member_type'] . '] (' . $d['member_id'] . ') | ' . $d['kabupaten'];
		}
	}
}

//for edit member
function arrangelistMemberEdit($tipe_member = null, $member_type = null)
{
	$ci = &get_instance();
	$data = null;
	$return = null;
	$ci->db->select('members.*, ref_regencies.name as kabupaten');
	$ci->db->join('ref_regencies', 'ref_regencies.id = members.kode_kabupaten', 'left');
	$ci->db->where(['is_active' => '1', 'status' => '1', 'is_hapus' => '0']);

	if (!empty($member_type)) {
		$ci->db->where(['member_type' => $member_type]);
	}
	$ci->db->order_by('member_type', 'ASC');

	$data = $ci->db->get('members');
	if ($data->num_rows() > 0) {
		$result = $data->result_array();
		$return[0] = 'Tidak Ada/Tidak Punya Upline';
		foreach ($result as $d) {
			$return[$d['id_member']] = $d['nama'] . ' [' . $d['member_type'] . '] (' . $d['member_id'] . ') | ' . $d['kabupaten'];
		}
	}

	return $return;
}

function listBank()
{
	$bank = ['MANDIRI', 'BCA', 'BRI', 'BNI', 'BSI', 'BANK JATIM', 'PANIN BANK'];
	return $bank;
}

function sum_counter()
{
	$ci = &get_instance();
	//$proses = $ci->db->insert('counter')
}

if (!function_exists('auto_code')) {
	function auto_code($prefix, $delim = "", $tipe = "set", $position = "append")
	{
		$ci  = &get_instance();
		$ci->db->query("INSERT INTO counter (prefix, sequence) VALUES (?, 1) ON DUPLICATE KEY UPDATE sequence  =  sequence + 1", [$prefix]);
		if ($tipe != "set") {
			$ci->db->query("UPDATE counter set sequence = sequence - 1");
		}
		$result = $ci->db->query("SELECT sequence FROM counter WHERE prefix = ?", [$prefix]);
		$row  =  $result->row();
		if ($position == "append") {
			$result  =  strtoupper(substr($prefix, 0, -2)) . $delim . str_pad($row->sequence, 4, '0', STR_PAD_LEFT);
		} else {
			$result  =  str_pad($row->sequence, 4, '0', STR_PAD_LEFT) . $delim . strtoupper(substr($prefix, 0, -2));
		}
		return $result;
	}
}

function footer_undangan()
{
	$return = '&mdash; BG Skin &mdash;';
	return $return;
}

function master_menu_dinamis($member)
{
	$menu = '';
	if (strtolower($member['member_type']) == 'distributor') {
		$menu = 'm2-1';
	} elseif (strtolower($member['member_type']) == 'agen') {
		$menu = 'm2-2';
	} elseif (strtolower($member['member_type']) == 'agenstarter') {
		$menu = 'm2-3';
	} elseif (strtolower($member['member_type']) == 'reseller') {
		$menu = 'm2-4';
	} elseif (strtolower($member['member_type']) == 'member') {
		$menu = 'm2-5';
	}
	return $menu;
}

function custom_group()
{
	$ci = &get_instance();
	$custom = $ci->session->userdata('bgskin_groupName');

	if (!empty($ci->session->userdata('bgskin_customMember'))) {
		if ($ci->session->userdata('bgskin_groupName') != $ci->session->userdata('bgskin_customMember')) {
			$custom = $ci->session->userdata('bgskin_customMember');
		}
	}

	return $custom;
}

function getRefPersyaratan($member_type, $param)
{
	$ci = &get_instance();
	$ref = $ci->db->where(['member_type' => $member_type, 'nama_syarat' => $param])->get('ref_persyaratan');
	if ($ref->num_rows() != 0) {
		return $ref->result()[0];
	} else {
		return null;
	}
}

function getIdGroup($member_type)
{
	$id_group = "";
	if ($member_type == 'Distributor') {
		$id_group = 2;
	} elseif ($member_type == 'Agen') {
		$id_group = 3;
	} elseif ($member_type == 'AgenStarter') {
		$id_group = 4;
	} elseif ($member_type == 'Reseller') {
		$id_group = 5;
	} elseif ($member_type == 'Member') {
		$id_group = 6;
	}
	return $id_group;
}

function isPDF($param)
{
	$file = 'gambar';
	$panjang =  strlen($param);
	if (strpos($param, '.pdf')) {
		$file = 'pdf';
	}
	return $file;
}

function tampil_sebagian($param, $panjang)
{
	//$panjang = strlen($param);
	$tampil = substr($param, 0, $panjang);
	return $tampil;
}

function getStatusPO($param)
{
	$status = '';
	if ($param == '0') {
		$status = 'Belum disetujui';
	} elseif ($param == '1') {
		$status = 'Disetujui';
	} elseif ($param == '2') {
		$status = 'Dikirim';
	} elseif ($param == '3') {
		$status = 'Diterima';
	}
	return $status;
}

function getStatusTerimaPO($param, $pesan)
{
	$status = '-';
	if ($param != null) {
		if ($param == '1') {
			$status = '<span class="text-success">Sesuai</span>';
		} elseif ($param == '0') {
			$status = '<span class="text-danger">Tidak sesuai, karena ' . $pesan . '</span>';
		}
	}
	return $status;
}

function getStatusPOFormat($param, $waktu = null)
{
	$status = '';
	if ($param == '0') {
		$status = "<span class='text-light badge badge-danger'>Belum disetujui</span>" . "<br><small>" . $waktu . "</small>";
	} elseif ($param == '1') {
		$status = "<span class='text-light badge badge-success'>Disetujui</span>" . "<br><small>" . $waktu . "</small>";
	} elseif ($param == '2') {
		$status = "<span class='text-light badge badge-success'>Dikirim</span>" . "<br><small>" . $waktu . "</small>";
	} elseif ($param == '3') {
		$status = "<span class='text-light badge badge-success'>Diterima</span>" . "<br><small>" . $waktu . "</small>";
	}
	return $status;
}


function getStatusJual($param)
{
	$state = '';
	if ($param == '0') {
		$state = 'Belum dicek';
	} else if ($param == '1') {
		$state = 'Sudah dicek';
	}
	return $state;
}

function getStatusJualFormat($param)
{
	$state = '<small class="text-light badge badge-danger">Belum dicek</small>';
	if ($param == '1') {
		$state = '<small class="text-light badge badge-success">Sudah dicek</small>';
	}
	return $state;
}

function getStatusItemPO($batch_kode, $time = null)
{
	$return = '<small class="text-light badge badge-success">Dikirim</small><br><small>' . $time . '</small>';
	if (empty($batch_kode)) {
		$return = '<small class="text-light badge badge-warning">Belum dikirim</small>';
	}

	return $return;
}

/**
 * _session
 *
 * @param  string $key session
 * @return void
 */
function getSession($param)
{
	$ci = &get_instance();
	$return = $ci->session->userdata(PREFIX_SESS . '_' . $param);
	return $return;
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

function lastNomorForAccounting($prefix, $table, $column)
{
	$_this = &get_instance();

	$_this->db->select("SUBSTRING(" . $column . ", 3) as " . $column);
	$_this->db->order_by('tanggal', 'desc');
	$_this->db->order_by($column, 'desc');
	$query =  $_this->db->get($table);
	$result = $query->row_array();

	$last = 0;
	if ($result != null) {
		$last = intval(substr($result[$column], -4));
	}
	return $last;
}

function generateNomorForAccounting($prefix = null, $table = null, $column = null)
{
	// PR202206020001
	if ($prefix == null) {
		$prefix = 'GL';
	}
	$pad = 4;
	$curr_year = date('Y');
	$curr_month = date('m');
	$curr_date = date('d');

	$last_nomor = lastNomorForAccounting($prefix, $table, $column);
	$last_code = intval($last_nomor);
	if ($last_code >= 9999) {
		$last_code = 0;
	}

	$new_code = str_pad(($last_code + 1), $pad, "0", STR_PAD_LEFT);

	return $prefix . $curr_year . $curr_month . $curr_date . $new_code;
}

function is_all_set($var, $keys, $is_base_level = false)
{
	$pointer = $var;
	foreach ($keys as $key) {
		if (!isset($pointer[$key])) {
			return false;
		}
		if (!$is_base_level)
			$pointer = $pointer[$key];
	}
	return true;
}

function is_all_set_and_return($var, $keys)
{
	if (is_all_set($var, $keys)) {
		foreach ($keys as $key) {
			$var = $var[$key];
		}
		return $var;
	}
	return false;
}

function convert_json_to_datatable_query($json)
{
	// Just for IDE
	$length = 'length';
	$start = 'start';
	$filename = 'filename';
	$json['length'] = isset($json['length']) ? $json[$length] : 10;
	$query = [
		"columns" => [],
		"search" => [],
		"length" => isset($json['length']) ? $json[$length] : 10,
		"start" => isset($json['start']) ? $json[$start] : 0,
		"order" => isset($json['order']) ? json_decode($json['order'], true) : [],
		"filename" => isset($json['filename']) ? $json[$filename] : null,
	];
	$orderables = isset($json['ordbls']) ? json_decode($json['ordbls']) : [];
	$searchables = isset($json['sbls']) ? json_decode($json['sbls']) : [];

	if (isset($json['columns'])) {
		$json['columns'] = json_decode($json['columns']);
		foreach ($json['columns'] as $index => $value) {
			$query['columns'][$index] = [
				'searchable' => in_array($index, $searchables),
				'orderable' => in_array($index, $orderables),
				'search' => [
					'value' => $value,
					'regex' => false,
				]
			];
		}
	}

	return $query;
}

function activeYear()
{
	$ci = &get_instance();
	$get = $ci->db->query("SELECT * FROM ref_tahun where is_current='1'");
	$return = ($get->num_rows() != 0) ? $get->row_array()['tahun'] : null;
	return $return;
}

function getDayName($day_of_week)
{
	$reff = [
		0 => 'Minggu',
		1 => 'Senin',
		2 => 'Selasa',
		3 => 'Rabu',
		4 => 'Kamis',
		5 => 'Jumat',
		6 => 'Sabtu',
	];
	$ref_key = array_keys($reff);
	$result = $reff[1];
	if (in_array($day_of_week, $ref_key)) {
		$result = $reff[$day_of_week];
	}

	return $result;
}

function getMonthName($month = null)
{
	$reff = [
		'01' => 'Januari',
		'02' => 'Februari',
		'03' => 'Maret',
		'04' => 'April',
		'05' => 'Mei',
		'06' => 'Juni',
		'07' => 'Juli',
		'08' => 'Agustus',
		'09' => 'September',
		'10' => 'Oktober',
		'11' => 'November',
		'12' => 'Desember',
	];
	$result = $reff;
	$ref_key = array_keys($reff);
	if (!empty($month)) {
		if (in_array($month, $ref_key)) {
			$result = $reff[$month];
		} else {
			$result = $reff[1];
		}
	}
	return $result;
}

function parseTanggal($date)
{
	date_default_timezone_set('Asia/Jakarta');
	$day_name = getDayName(date('w', strtotime($date)));
	$day = date('d', strtotime($date));
	$month = getMonthName(date('m', strtotime($date)));
	$year = date('Y', strtotime($date));
	return "$day_name, $day $month $year";
}

function getJenisTransaksiAccounting($jenis = 'GL')
{
	$ref_jenis = [
		'GL' => 'Jurnal Memorial',
		'CT' => 'Costing',
		'PN' => 'Hutang',
		'KM' => 'Kas Masuk',
		'KK' => 'Kas Keluar',
		'BM' => 'Bank Masuk',
		'BK' => 'Bank Keluar',
		'PY' => 'Bayar Hutang',
		'RY' => 'Bayar Piutang',
		'RN' => 'Piutang',
		'PT' => 'Pembelian',
		'ST' => 'Penjualan',
	];

	$ref_key = array_keys($ref_jenis);
	$return = null;
	if (in_array($jenis, $ref_key)) {
		$return = $ref_jenis[$jenis];
	}

	return $return;
}

function optionMonth($bln = null)
{
	if (empty($bln)) {
		$bln = date('m');
	}
	$month = getMonthName();
	$return = null;
	foreach ($month as $key => $value) {
		$select = ($key == $bln) ? 'selected' : null;
		$return .= '<option value="' . $key . '" ' . $select . '>' . $value . '</option>';
	}
	return $return;
}

/**
 * optionYear
 *
 * @param  string tahun -> 2022
 * @return void
 */
function optionYear($thn = null)
{
	$datesek = null;
	if (!empty($thn)) {
		$datesek = $thn;
	} else {
		$datesek = date('Y');
	}
	$return = null;
	for ($th = 0; $th < 15; $th++) {
		if ($th == 12) {
			$selected = "selected";
		} else {
			$selected = "";
		}
		$return .= '<option value=' . intval($datesek + $th - 12) . ' ' . $selected . '>' . intval($datesek + $th - 12) . '</option>';
	}

	return $return;
}

/**
 * getPengubung for accounting
 *
 * @param  mixed $param
 * @return void
 */
function getPenghubung($n_penghubung = null)
{
	$ci = &get_instance();
	if (!empty($n_penghubung)) {
		$ci->db->where(['n_penghubung' => $n_penghubung]);
	}
	$data = $ci->db->get('coa_penghubung');
	$return = null;
	if ($data->num_rows() > 0) {
		$return = $data->row_array();
	}

	return $return;
}

function getIsActive($is_active = null)
{
	$list = ['1' => 'Aktif', '0' => 'Tidak aktif'];
	$return = $list;
	if (!empty($is_active)) {
		$return = $list[$is_active];
	}
	return $return;
}

function getSystemSetting($name, $default = null)
{
	$ci = &get_instance();
	$ci->db->where([
		"name"  => $name
	]);

	$query = $ci->db->get("system_settings", 1);

	if ($query->num_rows() > 0) {
		return $query->row()->value;
	}

	return $default;
}

function setSystemSetting($name, $value)
{
	$ci = &get_instance();
	$ci->db->where([
		"name"  => $name
	]);

	$query = $ci->db->get("system_settings", 1);

	if ($query->num_rows() > 0) {
		$ci->db->update('system_settings', ['value' => $value], ['name' => $name]);
	} else {
		$ci->db->insert('system_settings', [
			'name' => $name,
			'value' => $value
		]);
	}
}
function status_rab($param)
{
	$status = "";
	if ($param == '0') {
		$status = "<span class='text-danger'>Tidak Disetujui</span>";
	} elseif ($param == '1') {
		$status =  "<span class='text-warning'>Revisi</span>";
	} elseif ($param == '2') {
		$status = "<span class='text-success'>Disetujui</span>";
	}
	return $status;
}

function thn_anggaran($today)
{
	$ta = null;
	$awal = '-09-01';
	$akhir = '-08-31';
	$thNow = date('Y');
	$thAfter = $thNow + 1;
	$thBefore = $thNow - 1;

	$awal_now = date('Y-m-d', strtotime($thNow . $awal));
	$akhir_now = date('Y-m-d', strtotime($thAfter . $akhir));

	if ($today >= $awal_now && $today <= $akhir_now) {
		$ta = $thNow . "-" . $thAfter;
	} else {
		$ta = $thBefore . '-' . $thNow;
	}

	return $ta;
}

/**
 * isBrowser
 *
 * @param  string $_SERVER['HTTP_USER_AGENT']
 * @return bool
 */
function isBrowser($userAgent)
{
	$browsers = ['msie', 'trident', 'firefox', 'chrome', 'opera mini', 'safari'];
	$isBrowser = false;
	for ($i = 0; $i < count($browsers); $i++) {
		if (strpos(strtolower($userAgent), $browsers[$i]) !== FALSE) {
			$bro = $browsers[$i];
			if (in_array($bro, $browsers)) {
				$isBrowser = true;
				break;
			}
		}
	}

	return $isBrowser;
}

function randomPassword()
{
	$alphabet = 'abcdefghijklmnopqrstuvwxyz1234567890';
	$pass = array();
	$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	for ($i = 0; $i < 8; $i++) {
		$n = rand(0, $alphaLength);
		$pass[] = $alphabet[$n];
	}
	return implode($pass); //turn the array into a string
}

function randomPassword_number()
{
	$alphabet = '1234567890';
	$pass = array(); //remember to declare $pass as an array
	$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	for ($i = 0; $i < 8; $i++) {
		$n = rand(0, $alphaLength);
		$pass[] = $alphabet[$n];
	}
	return implode($pass); //turn the array into a string
}

function getUUID($versi = 4)
{
	// $ci = &get_instance();
	// $result = $ci->db->query("SELECT UUID()")->row_array()['UUID()'];
	// return $result;
	// $return = $result['uuid'];
	$ci = &get_instance();
	$ci->load->library(["Uuid" => 'uuid']);
	if ($versi == 4) {
		$return = $ci->uuid->v4();
	} else {
		$return = $ci->uuid->v4();
	}
	return $return;
}

function ceknik($nik)
{
	$return['pesan'] = '';
	$return['status'] = false;
	$ci = &get_instance();
	if (strlen($nik) != 16) {
		$return['pesan'] = 'NIK Harus 16 Digit';
		$return['status'] = false;
	} else {
		$return['pesan'] = '';
		$return['status'] = true;
	}
	return $return;
}


function getNoLast($column, $tabel)
{
	$ci = &get_instance();
	$ci->db->select([$column]);
	$ci->db->order_by($column, "DESC");
	$data = $ci->db->get($tabel)->row_array();
	return $data;
}


function generateNomorPerson($prefix, $column, $table)
{
	$last = getNoLast($column, $table);
	$akhir = 0;
	if (!empty($last)) {
		$akhir = intval(str_replace($prefix, "", $last[$column]));
	}
	$pad = 6;
	$new_code = str_pad(($akhir + 1), $pad, "0", STR_PAD_LEFT);
	return $prefix . $new_code;
}

function ambilCoaGrup($grup)
{
	$ci = &get_instance();
	$ci->db->where('subgrup <> "" AND detail <> ""');
	$ci->db->where(["grup" => $grup]);
	$data = $ci->db->get('coa')->result_array();
	return $data;
}

function ambilCoa()
{
	$ci = &get_instance();
	$ci->db->where('subgrup <> "" AND detail <> ""');
	$data = $ci->db->get('coa')->result_array();
	return $data;
}
