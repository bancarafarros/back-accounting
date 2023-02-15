<?php
defined('BASEPATH') or exit('No direct script access allowed');

class user extends BaseController
{

	protected $template = "app";
	protected $module = 'user';
	public $loginBehavior = true;

	protected $bread = [];

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_jurnal');
		$this->load->model('M_user');
		$this->bread[] =
			[
				'title' => 'Daftar User',
				'url' => site_url('user')
			];
	}

	public function index()
	{
		$title = 'Daftar User';
		$this->data['judul_title'] = $title;
		$this->data['scripts'] = ['user/js/index.js'];
		$crud = new Grid();
		// $crud->setSkin('bootstrap-v4');
		$crud->setSubject('User');
		$crud->setTable('user');
		$crud->defaultOrdering('id_user', 'asc');
		$crud->setRelation('id_group', 'user_group', 'nama_group');
		$column_wheres = "id_group != 1";
		$columns = ['last_login_time', 'username', 'real_name', 'email', 'id_group', 'is_active'];
		$column_displays = [
			'last_login_time' 	=> 'Password',
			'username'      	=> 'Username',
			'real_name'     	=> 'Nama',
			'email'         	=> 'Email',
			'id_group'      	=> 'Group',
			'is_active'			=> 'Status',
		];
		$addFields = ['username', 'real_name', 'email', 'id_group'];
		$editFields = ['username', 'real_name', 'email', 'id_group'];
		$required_columns = ['username', 'real_name', 'email', 'id_group'];
		$crud->uniqueFields(['username']);

		$crud->requiredFields($required_columns);
		$crud->where($column_wheres);
		$crud->columns($columns);
		$crud->displayAs($column_displays);
		$crud->addFields($addFields);
		$crud->editFields($editFields);
		$crud->fieldType('is_active', 'dropdown_search', getIsActive());

		$crud->callbackColumn('last_login_time', [$this, '_callResetPassword']);
		$crud->callbackBeforeInsert([$this, '_callbackBeforeInsert']);

		$crud->unsetJquery();

		$output = $crud->render();
		$this->setOutput($output, 'index');
	}

	function _callbackBeforeInsert($stateParameters)
	{
		$stateParameters->data['password'] = hash('SHA256', '12345');
		return $stateParameters;
	}

	function _callResetPassword($value, $row)
	{
		return '<button type="button" onclick="resetPassword(' . "'" . $row->id_user . "'" . ')" class="btn btn-success btn-xs"><i class="fa fa-key"></i> Reset Password</button>';
	}

	public function ajaxData()
	{
		$param = $this->input->post();
		$data = (array) $this->M_user->getUser($param['id_user']);
		if (!empty($data)) {
			unset($data['password']);
		}
		echo json_encode($data);
	}

	public function ajaxresetpassword()
	{
		$response['success'] = false;
		$response['message'] = '';
		$params = $this->input->post(null, true);
		$result = $this->M_user->reset_password($params);
		if ($result['success']) {
			$response['success'] = true;
			$response['message'] = $result['message'];
		} else {
			$response['success'] = false;
			$response['message'] = $result['message'];
		}
		echo json_encode($response);
	}

	public function dosave()
	{
		$param = $this->input->post();
		if ($param['act'] == "insert") {
			$this->M_user->addDataUser($param);
			$this->session->set_flashdata('true', 'Data User Berhasil di simpan');
		}
		if ($param['act'] == "editUser") {
			$this->M_user->editDataUser($param);
			$this->session->set_flashdata('true', 'Data User Berhasil di simpan');
		}
		redirect("User");
	}

	public function getUser()
	{
		$id_user = $this->input->get('id_user');
		$username = $this->input->get('username');
		$data = $this->M_user->getUser($id_user, $username);
		echo json_encode($data);
	}

	public function deleteUser($idUser)
	{
		$proses = $this->M_user->hapusDataUser($idUser);
		if ($proses) {
			$this->session->set_flashdata('true', 'Data User Berhasil dihapus');
		}
		redirect("User");
	}

	public function getPassword()
	{
		$pass =  hash("sha256", $this->input->get('pass'));
		$data = $this->M_user->passUser(['id_user' => $this->session->userdata('t_userId')], ['password' => $pass]);
		echo json_encode($data);
	}
}
