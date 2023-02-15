<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mataanggaran extends BaseController
{
    protected $template = "app";
    public $loginBehavior = true;

    protected $bread = [];

    public function __construct()
    {
        parent::__construct();
        $this->bread[] = ['title' => 'Mata Anggaran', 'url' => site_url('mataanggaran')];
    }

    public function index()
    {
        $title = 'Mata Anggaran';
        $this->data['judul_title'] = $title;

        $crud = new Grid();
        $crud->setSubject('Mata Anggaran');
        $crud->setTable('mata_anggaran');
        $crud->defaultOrdering('id', 'asc');
        $columns = ['kode', 'mata_anggaran', 'keterangan', 'total', 'jumlah'];
        $column_displays = [
            'kode'          => 'Kode',
            'mata_anggaran' => 'Mata Anggaran',
            'keterangan'    => 'Keterangan',
            'total'         => 'Total',
            'jumlah'        => 'Jumlah',
        ];
        $addFields = ['kode', 'mata_anggaran', 'keterangan', 'total', 'jumlah'];
        $editFields = ['kode', 'mata_anggaran', 'keterangan', 'total', 'jumlah'];
        $crud->columns($columns);
        $crud->displayAs($column_displays);
        $crud->addFields($addFields);
        $crud->editFields($editFields);
        $crud->callbackBeforeUpdate([$this, '_callBeforeUpdate']);

        // $crud->callbackColumn('nama_lengkap', ([$this, '_callNIK']));

        $crud->unsetAdd();
        $crud->unsetEdit();
        $crud->unsetDelete();
        $crud->unsetJquery();

        $output = $crud->render();
        $this->setOutput($output, 'index');
        $this->render('index');
    }
}
