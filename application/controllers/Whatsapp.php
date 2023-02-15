<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Whatsapp extends BaseController
{

    public $loginBehavior = true;
    public $template = "app";
    protected $module = "whatsapp";
    protected $bread = [];

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $title = 'Pengaturan Whatsapp';
        $this->data['judul_title'] = $title;
        $this->bread[] = ['title' => $title, 'url' => site_url('setting')];
        $this->data['modul'] = $this->M_app->modulSistem();
        $this->data['qrcode'] = $this->getqr();
        $this->render('index');
    }

    public function push()
    {
        $send = dswa_request(getSystemSetting('ds_url_send'), ['phone' => '6285103473402', 'api_key' => dswa_GetToken(), 'text' => 'oke oke']);
        // $kir = dswa_kirim('6282244100442', "Selamat it's work");
    }

    public function getqr()
    {
        $data = dswa_request('https://api.dripsender.id/get-qr', ['api_key' => 'e7c2dcfd-4961-491a-bc8f-ffe009ab413e']);
        return $data;
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
