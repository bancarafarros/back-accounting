<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Usergroup extends BaseController
{

    public $loginBehavior = true;
    public $template = "app";
    protected $module = "usergroup";
    protected $bread = [];

    public function __construct()
    {
        parent::__construct();
        $this->bread[] = ['title' => 'User Group', 'url' => site_url('usergroup')];
    }

    public function index()
    {
        $title = 'Daftar User';
        $this->data['judul_title'] = $title;
        $crud = new Grid();
        // $crud->setSkin('bootstrap-v4');
        $crud->setSubject('Group User');
        $crud->setTable('user_group');
        $crud->defaultOrdering('id_group', 'asc');
        $columns = ['nama_group', 'keterangan', 'dbusername', 'is_active'];
        $column_displays = [
            'nama_group'    => 'Nama Group',
            'keterangan'    => 'Keterangan',
            'dbusername'    => 'DB Username',
            'is_active'     => 'Aktif',
        ];
        $addFields = ['nama_group', 'keterangan', 'dbusername',];
        $editFields = ['nama_group', 'keterangan', 'dbusername'];
        $crud->columns($columns);
        $crud->displayAs($column_displays);
        $crud->addFields($addFields);
        $crud->editFields($editFields);
        $crud->fieldType('is_active', 'dropdown_search', getIsActive());
        // $crud->callbackColumn('is_active', ([$this, '_callAkses']));
        $crud->setActionButton('Hak Akses', 'fas fa-users-cog', function ($row) {
            return site_url("usergroup/akses?group=$row->id_group");
        }, false);
        $crud->unsetDelete();
        $crud->unsetJquery();

        $output = $crud->render();
        $this->setOutput($output, 'index');
    }

    function _callAkses($value, $row)
    {
        $return = '<a href="' . site_url('usergroup/akses?group=' . $row->id_group) . '" class="btn btn-success btn-sm"><i class="fa fa-key"></i></a>';
        return $return;
    }

    public function akses()
    {
        $group = $this->input->get('group');
        if (empty($group)) {
            $this->session->set_flashdata('false', 'Url salah, data tidak ditemukan');
            redirect('usergroup');
        }
        $title = 'Akses Group Modul';
        $this->data['judul_title'] = $title;
        array_push($this->bread, ['title' => $title, 'url' => site_url('usergroup/akses')]);

        $userGroup = $this->M_app->getUserGroup(intval($group));
        $modul = $this->M_app->modulSistem();
        $this->data['id_group'] = $group;
        $this->data['groupAccess'] = $this->castingAccess($group);
        $this->data['userGroup'] = $userGroup;
        $this->data['modul'] = $modul;
        $this->data['is_home'] = false;
        $this->render('akses');
    }

    private function castingAccess($group)
    {
        $groupAccess = $this->M_app->aksesGroup($group);
        $accesses = [];
        foreach ($groupAccess as $g) {
            array_push($accesses, $g['nama_modul'] . '.' . $g['hak_akses']);
        }
        return $accesses;
    }

    public function setHakAkses($group_id)
    {
        $param = $this->input->post();
        $prose = $this->M_app->updateGroupAccess($group_id, $param['access']);
        $redirect = 'usergroup';
        if ($prose) {
            $this->session->set_flashdata('true', 'Pengaturan hak akses berhasil');
        } else {
            $this->session->set_flashdata('false', 'Pengaturan hak akses gagal');
            $redirect .= '/akses?group=' . $group_id;
        }

        redirect($redirect);
    }
}
