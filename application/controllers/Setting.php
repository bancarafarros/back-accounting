<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Setting extends BaseController
{

    public $loginBehavior = true;
    public $template = "app";
    protected $module = "setting";
    protected $bread = [];

    public function __construct()
    {
        parent::__construct();
        $this->bread[] = ['title' => 'Modul Sistem', 'url' => site_url('setting')];
    }

    public function index()
    {
        $this->data['menu'] = 'm9-2';
        $this->data['instansi'] = $this->M_app->getData('ref_perguruan_tinggi');
        $title = "Data Perushaan";
        $this->data['judul_title'] = $title;
        $this->data['scripts'] = ['setting/js/index.js'];

        $this->render('instansi');
    }

    public function modul()
    {
        $title = 'Modul Sistem';
        $this->data['judul_title'] = $title;
        $crud = new Grid();
        // $crud->setSkin('bootstrap-v4');
        $crud->setSubject('Modul Sistem');
        $crud->setTable('modul_sistem');
        $crud->defaultOrdering('nama_modul', 'asc');
        $columns = ['nama_modul', 'keterangan', 'is_active'];
        $column_displays = [
            'username'      => 'Username',
            'real_name'     => 'Nama',
            'email'         => 'Email',
            'id_group'      => 'Group',
            'is_active'        => 'Status',
        ];
        $addFields = ['nama_modul', 'keterangan', 'is_active'];
        $editFields = ['nama_modul', 'keterangan', 'is_active'];
        $crud->columns($columns);
        $crud->displayAs($column_displays);
        $crud->addFields($addFields);
        $crud->editFields($editFields);
        $crud->callbackBeforeDelete([$this, '_callBeforeDelete']);
        $crud->fieldType('is_active', 'dropdown_search', getIsActive());
        $crud->unsetJquery();

        $output = $crud->render();
        $this->setOutput($output, 'index');
    }

    function _callBeforeDelete($stateParameter)
    {
        $id_modul = $stateParameter->primaryKeyValue;
        $cek = $this->M_app->isExistModul($id_modul);
        if (!empty($cek)) {
            $errorMessage = new \GroceryCrud\Core\Error\ErrorMessage();
            return $errorMessage->setMessage("<div class='alert alert-danger'><b>Mohon Maaf!</b><br>Modul telah digunakan, anda tidak bisa menghapus</div>");
        }

        return $stateParameter;
    }

    public function dosave()
    {
        $param = $this->input->post();
        $proses = $this->M_app->editPerusahaan($param);
        if ($proses) {
            $this->session->set_flashdata('true', 'Edit perusaahn berhasil');
        } else {
            $this->session->set_flashdata('false', 'Edit perusahaan gagal');
        }

        redirect('setting');
    }
}
