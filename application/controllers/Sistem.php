<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sistem extends BaseController
{

    public $loginBehavior = true;
    public $template = "app";
    protected $module = "sistem";
    protected $bread = [];

    public function __construct()
    {
        parent::__construct();
        array_push($this->bread, ['title' => 'System Setting', 'url' => site_url('sistem')]);
    }

    public function index()
    {
        $title = 'Sistem Setting';
        $this->data['judul_title'] = $title;
        $crud = new Grid();
        // $crud->setSkin('bootstrap-v4');
        $crud->setSubject('Sistem Setting');
        $crud->setTable('system_settings');
        $crud->defaultOrdering('id', 'asc');
        $columns = ['name', 'value', 'type', 'group', 'description'];
        $column_displays = [
            'name'          => 'Nama',
            'type'          => 'Tipe',
            'value'         => 'Value',
            'group'         => 'Group',
            'description'   => 'Deskripsi',
        ];
        $addFields = ['name', 'type', 'value', 'group', 'description'];
        $editFields = ['name', 'type', 'value', 'group', 'description'];
        $groups =  ['GENERAL' => 'GENERAL', 'TOKEN' => 'TOKEN',];
        $types = ['STRING' => 'STRING', 'INT' => 'INT', 'TEXT' => 'TEXT'];
        $crud->fieldType('group', 'dropdown_search', $groups);
        $crud->fieldType('type', 'dropdown_search', $types);
        $crud->columns($columns);
        $crud->displayAs($column_displays);
        $crud->addFields($addFields);
        $crud->editFields($editFields);
        $crud->callbackBeforeUpdate([$this, '_callBeforeUpdate']);

        // $crud->callbackColumn('nama_lengkap', ([$this, '_callNIK']));

        // $crud->unsetAdd();
        // $crud->unsetEdit();
        $crud->unsetDelete();
        $crud->unsetJquery();

        $output = $crud->render();
        $this->setOutput($output, 'index');
    }

    function _callBeforeUpdate($stateParameter)
    {
        $stateParameter->data['updated_by'] = getSession('userId');
        return $stateParameter;
    }

    public function usergroup()
    {
        $title = 'Group User';
        $this->data['judul_title'] = $title;
        array_push($this->bread, ['title' => $title, 'url' => null]);
        $this->data['usergroup'] = $this->M_app->userGroup();
        $this->render('usergroup');
    }

    public function aksesmodul()
    {
        $group =  $this->input->get('group');
        if (empty($group)) {
            redirect('setting/usergroup');
        }
        $title = 'User Akses Modul';
        $this->data['judul_title'] = $title;
        array_push($this->bread, ['title' => $title, 'url' => null]);
        $this->data['akses'] = $this->M_app->aksesGroup($group);
        $this->data['id'] = $group;
        $this->render('aksesusergroup');
    }

    public function detail()
    {
        $this->data['title'] = 'Akses group module';
        $this->data['is_home'] = false;
        $this->data['id'] = $this->input->get('key');
        $this->data['scripts'] = ['group_module/js/detail.js'];
        $this->render('detail');
    }
}
