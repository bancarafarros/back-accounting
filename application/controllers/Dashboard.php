<?php defined('BASEPATH') or exit('no access allowed');

class Dashboard extends BaseController
{
    protected $template = "app";
    protected $module = 'index';
    public $loginBehavior = true;
    protected $bread = [];

    function __construct()
    {
        parent::__construct();
        $this->load->model('M_hutang');
        $this->load->model('M_jurnal');
        $this->load->model('M_piutang');
        $this->load->model('M_barang');
        $this->load->model('M_app');
        $this->load->model('M_penjualan');
        $this->load->model('M_user', 'm_user');
    }

    public function index()
    {
        if (!empty(getSession('userId'))) {
            $title = 'Dashboard';
            $this->data['judul_title'] = $title;
            // $this->data['breadcrumb'] = $this->breadcrumb;

            $this->data['menu'] = 'm0';
            //get total data
            $totmasuk = 0;
            $totkeluar = 0;
            $totpiutang = 0;
            $tothutang = 0;
            $totpenj = 0;
            $kaskeluar = $this->M_jurnal->getDataKasKeluar();
            $kasmasuk = $this->M_jurnal->getDataKasMasuk();
            $piutang = $this->M_piutang->getDataPiutang();
            $hutang = $this->M_hutang->getDataHutangNlunas();
            $penj = $this->M_penjualan->getDatapenjNow();

            if(!empty($kasmasuk)){
                foreach($kasmasuk as $row){
                    $totmasuk += $row->jumlah;
                }
            }
            if(!empty($kaskeluar)){
                foreach($kaskeluar as $row){
                    $totkeluar += $row->jumlah;
                }
            }
            if (!empty($piutang)) {
                foreach ($piutang as $row) {
                    $totpiutang  += $row->sisa;
                }
            }
            if (!empty($hutang)) {
                foreach ($hutang as $rows) {
                    $tothutang += $rows->sisa;
                }
            }
            if (!empty($penj)) {
                foreach ($penj as $row1) {
                    $totpenj += $row1->total_penjualan;
                }
            }

            $this->data['tot_piutang'] = $totpiutang;
            $this->data['tot_kaskeluar'] = $totkeluar;
            $this->data['tot_kasmasuk'] = $totmasuk;
            $this->data['tot_hutang'] = $tothutang;
            $this->data['tot_stockMin'] = count($this->M_barang->BarangMinimum());
            $this->data['tot_penj'] = $totpenj;
            $this->data['akunPend'] = ambilCoaGrup('PENDAPATAN');
            $this->render('index_user');
        } else {
            redirect('index');
        }
    }

    public function profil()
    {
        $title = 'Profil';
        $this->data['judul_title'] = $title;
        array_push($this->bread, ['title' => $title, 'url' => site_url('dashboard/profil')]);
        $this->data['profil'] = $this->m_user->getUser(getSession('userId'));
        $this->render('profil');
    }

    public function profilEdit()
    {
        $title = 'Edit Profil';
        $this->data['judul_title'] = $title;
        array_push($this->bread, ['title' => 'Edit Profil', 'url' => site_url('dashboard/profiledit')]);
        $this->data['profil'] = $this->m_user->getUser(getSession('userId'));
        $this->render('profil_edit');
    }

    public function prosesedit()
    {
        $param = $this->input->post();
        $id_user = getSession('userId');
        $userData = $this->m_user->getUser($id_user);
        $data = $param;
        unset($data['username']);
        if (!empty($_FILES['image']['name'])) {
            $siap = uploadBerkas('image', 'user', 'user');
            if ($siap['success']) {
                if (!empty($userData->image)) {
                    if (file_exists('.' . $userData->image)) {
                        unlink('.' . $userData->image);
                    }
                }
                $data['image'] = $siap['file_name'];
            }
        }
        $proses = $this->m_user->ubah($id_user, $data);
        if ($proses) {
            $this->setSession('realName', $data['real_name']);
            $this->setSession('email', $data['email']);
            if (!empty($data['image'])) {
                $this->setSession('image', $data['image']);
            }
            $this->setUserData();
        }
        if ($this->input->is_ajax_request()) {
            echo json_encode($proses);
        } else {
            redirect("dashboard/profil");
        }
    }

    public function ubahPassword()
    {
        $param = $this->input->post();
        if ($param['act'] == "edit") {
            $this->m_user->editPassUser($param, $this->session->userdata('t_userId'));
            $this->unSetUserData();
            redirect('Index');
        }
    }

    public function getPassword()
    {
        $pass =  hash("sha256", $this->input->get('pass'));
        $data = $this->m_user->passUser(['id_user' => $this->session->userdata('t_userId')], ['password' => $pass]);
        echo json_encode($data);
    }

    public function logout()
    {
        $log_user = ['id_user' => getSession('userId'), 'activity' => 'LOG OUT', 'page_url' => site_url('?logout=true')];
        $this->setLog($log_user);
        $this->unSetUserData();
        redirect(site_url() . "?logout=true");
    }


    public function getChating()
    {
        $data = $this->M_app->get_chating();
        echo json_encode($data);
    }

    public function addChat()
    {
        $chat = $this->input->get('i_chat');
        $data = $this->M_app->add_chat($chat);
        echo json_encode($data);
    }

    public function getPenjualan()
    {
        $data = [];
        for ($i = 1; $i < 13; $i++) {
            $bln = str_pad($i, 2, "0", STR_PAD_LEFT);
            $total = $this->M_app->get_penjualan($bln);
            if ($total->total == null) {
                $total->total = 0;
            }
            array_push($data, $total);
        }
        echo json_encode($data);
    }

    public function getStatPerkiraan()
    {
        $data = [];
        $akun = $kode = $this->input->get('akun');;
        for ($i = 1; $i < 13; $i++) {
            $bln = str_pad($i, 2, "0", STR_PAD_LEFT);
            $total = $this->M_app->get_stat_perkiraan($bln, $akun);
            if ($total->total == null) {
                $total->total = 0;
            }
            array_push($data, $total);
        }
        echo json_encode($data);
    }
}
