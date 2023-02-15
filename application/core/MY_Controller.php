<?php

class BaseController extends CI_Controller
{

    protected $template = "app";
    protected $module = "";
    protected $sub = "";
    protected $data = array();
    protected $bread = [];

    private $whitelistUrl = [
        '',
        'forgot_password',
        'forgot_password_reset',
        'aktifkan_akun',
        'logout',
        'index',
        'index/login',
        'set_dokumen'
    ];

    public $loginBehavior = false;

    public function __construct()
    {
        parent::__construct();
        $this->bread[] = ['title' => 'Dashboard', 'icon' => 'fa fa-home', 'url' => site_url('dashboard')];
        $this->load->model('M_app');
        $this->load->model('M_activity_log');
        $userId = $this->session->userdata(PREFIX_SESS . '_userId');
        $idGroup = $this->session->userdata(PREFIX_SESS . '_idGroup');
        $thn_anggaran = thn_anggaran(date('Y-m-d'));

        if (uri_string() == "" && $this->input->post("btn-login") != null) {
            if (trim($this->input->post('captcha')) != trim($this->session->userdata('captchaword'))) {
                $this->template = "login";
                $this->data['judul_title'] = 'Login';
                $this->data["errorMessage"] = "Gagal login, captcha tidak sesuai.";
                $this->session->set_flashdata('false', 'Gagal login, captcha tidak sesuai.');
                $this->render('login');
            }
            $username = $this->input->post("username");
            $password = $this->input->post("password");

            $this->db->select('u.id_user, u.username, u.id_group, u.email, u.real_name,u.image, ug.nama_group, u.is_active');
            $this->db->where('((u.username IS NOT NULL AND u.username = ' . '"' . $username . '"' . ') OR (u.email IS NOT NULL AND u.email = ' . '"' . $username . '"' . '))');
            $this->db->join('user_group ug', 'ug.id_group = u.id_group');
            $this->db->where(['u.password' => hash('SHA256', $password), 'u.is_active' => '1']);
            $result = $this->db->get('user u');

            if ($result->num_rows() == 0) {
                $this->data["errorMessage"] = "Gagal login, silahkan periksa kembali informasi login Anda!.";
                $this->data['judul_title'] = "Login";
                $this->template = "login";
                $this->render("login");
            } else {
                $row = $result->row();
                $perusahaan = $this->M_app->getData('ref_perguruan_tinggi');

                if (empty($row->image)) {
                    $row->image = 'public/uploads/user/default.png';
                }
                $this->session->set_userdata(PREFIX_SESS . "_userId", $row->id_user);
                $this->session->set_userdata(PREFIX_SESS . "_username", $row->username);
                $this->session->set_userdata(PREFIX_SESS . "_email", $row->email);
                $this->session->set_userdata(PREFIX_SESS . "_isActive", $row->is_active);
                $this->session->set_userdata(PREFIX_SESS . "_image", $row->image);
                $this->session->set_userdata(PREFIX_SESS . "_realName", $row->real_name);
                $this->session->set_userdata(PREFIX_SESS . "_idGroup", $row->id_group);
                $this->session->set_userdata(PREFIX_SESS . "_groupDescription", $row->nama_group);
                $this->session->set_userdata(PREFIX_SESS . "_namaInstansi", $perusahaan->nama_resmi);
                $this->session->set_userdata(PREFIX_SESS . "_aliasInstansi", $perusahaan->nama_pendek);
                $this->session->set_userdata(PREFIX_SESS . "_thnAnggaran", $thn_anggaran);

                $this->setUserData();
                // LOG USER
                $log_user = ['id_user' => $row->id_user, 'activity' => 'LOGIN', 'page_url' => site_url()];
                $this->setLog($log_user);
            }
        } else if (!$userId && uri_string() == "") { // Accessing index page and there is no user session (login form state)
            $this->template = "login";
            if ($this->input->get("access_without_login") == "true") {
                $this->data["errorMessage"] = "<b>Session anda telah berakhir,</b> silahkan login kembali untuk masuk ke dashboard.";
            } else if ($this->input->get("logout") == "true") {
                $this->data["successMessage"] = "Anda telah keluar.";
            } else if ($this->input->get("forgot_password") == "true") {
                $this->data["successMessage"] = "Password anda berhasil diperbarui. Silahkan login dengan password baru.";
            }
            $this->data['judul_title'] = "Login";
            $this->render("login");
        } else if (!$userId && !in_array(uri_string(), $this->whitelistUrl) && $this->loginBehavior) { // Accessing user page and there is no user session
            redirect("?access_without_login=true");
        } else if ($userId != null) { // Accessing user page and there is user session
            $this->setUserData();
        }

        if (is_array($this->input->get())) {
            foreach ($this->input->get() as $key => $value) {
                $this->data[$key] = $value;
            }
        }

        if (is_array($this->input->post())) {
            foreach ($this->input->post() as $key => $value) {
                if ($key == "description" || $key == "email" || $key == "is_active" || $key == "is_soft_delete" || $key == "username" || $key == "real_name") {
                    $this->data[$key . "Input"] = $value;
                } else {
                    $this->data[$key] = $value;
                }
            }
        }

        // trim field from form submit
        if (is_array($_POST)) {
            $_POST = array_map(function ($row) {
                $row = is_string($row) ? trim($row) : $row;
                $row = $row === '' ? NULL : $row;
                return $row;
            }, $this->input->post());
        }
    }

    protected function setUserData()
    {
        $this->data['userId']           = $this->session->userdata(PREFIX_SESS . "_userId");
        $this->data['username']         = $this->session->userdata(PREFIX_SESS . "_username");
        $this->data['email']            = $this->session->userdata(PREFIX_SESS . "_email");
        $this->data['isActive']         = $this->session->userdata(PREFIX_SESS . "_isActive");
        $this->data['image']            = $this->session->userdata(PREFIX_SESS . "_image");
        $this->data['realName']         = $this->session->userdata(PREFIX_SESS . "_realName");
        $this->data['idGroup']          = $this->session->userdata(PREFIX_SESS . "_idGroup");
        $this->data['groupDescription'] = $this->session->userdata(PREFIX_SESS . "_groupDescription");
        $this->data['namaInstansi']     = $this->session->userdata(PREFIX_SESS . "_namaInstansi");
        $this->data['aliasInstansi']    = $this->session->userdata(PREFIX_SESS . "_aliasInstansi");
        $this->data['thnAnggaran']      = $this->session->userdata(PREFIX_SESS . "_thnAnggaran");
        $this->data["dbUsername"]       = $this->session->userdata(PREFIX_SESS . "_dbUsername");
        $this->setDataArgumen();
        $this->db->where(['id_user' => $this->data['userId']])->update('user', ['last_login_time' => date('Y-m-d H:i:s')]);

        $this->db->distinct('nama_modul, hak_akses');
        $this->db->where('id_group', $this->session->userdata(PREFIX_SESS . "_idGroup"));
        $result = $this->db->get('akses_group_modul');

        $this->data["userMenus"] = array();
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
                $this->data["userMenus"][] = $row->nama_modul . "." . $row->hak_akses;
            }
        }
    }

    protected function setDataArgumen()
    {
        $this->data['requiredLabel'] = '<b class="text-danger" data-toggle="tooltip" data-placement="top" data-title="Wajib diisi">*</b>';
        $this->data['fileHint'] = '<small class="text-danger" data-toggle="tooltip" data-placement="top" data-title="Tipe file dan ukuran maksimal">Tipe file: PDF | JPG | JPEG | PNG | Max: 2MB </small>';
    }

    protected function setSession($name, $data)
    {
        $this->session->set_userdata(PREFIX_SESS . '_' . $name, $data);
    }

    protected function unSetUserData()
    {
        $this->session->unset_userdata(PREFIX_SESS . "_userId");
        $this->session->unset_userdata(PREFIX_SESS . "_username");
        $this->session->unset_userdata(PREFIX_SESS . "_email");
        $this->session->unset_userdata(PREFIX_SESS . "_isActive");
        $this->session->unset_userdata(PREFIX_SESS . "_image");
        $this->session->unset_userdata(PREFIX_SESS . "_realName");
        $this->session->unset_userdata(PREFIX_SESS . "_idGroup");
        $this->session->unset_userdata(PREFIX_SESS . "_groupDescription");
        $this->session->unset_userdata(PREFIX_SESS . "_namaInstansi");
        $this->session->unset_userdata(PREFIX_SESS . "_aliasInstansi");
        $this->session->unset_userdata(PREFIX_SESS . "_thnAnggaran");
        $this->session->unset_userdata(PREFIX_SESS . "_dbUsername");
    }

    protected function render($filename = null)
    {
        $this->data['breadcrumb'] = $this->bread;
        $template = $this->load->view("template/" . $this->template, $this->data, true);
        if ($this->sub != null) {
            $content = $this->load->view($this->sub . "/" . strtolower(get_class($this)) . "/" . $filename, $this->data, true);
        } else {
            $content = $this->load->view(strtolower(get_class($this)) . "/" . $filename, $this->data, true);
        }

        if ($this->module != NULL) {
            if (in_array($this->module . ".access", $this->data["userMenus"]) == 0) {
                $message = "Maaf, Anda tidak memiliki akses ke halaman tersebut.";
                $this->session->set_flashdata('false', $message);
                redirect('dashboard');
            }
        }
        exit(str_replace("{CONTENT}", $content, $template));
    }

    /**
     * renderTo untuk load view dengan folder view
     *
     * @param  string path $filename
     * @return void
     */
    protected function renderTo($filename = null)
    {
        $this->data['breadcrumb'] = $this->bread;
        $template = $this->load->view("template/" . $this->template, $this->data, true);
        $content = $this->load->view($filename, $this->data, true);

        if ($this->module != NULL) {
            if (in_array($this->module . ".access", $this->data["userMenus"]) == 0) {
                $message = "Maaf, Anda tidak memiliki akses ke halaman tersebut.";
                $this->session->set_flashdata('false', $message);
                redirect('dashboard');
            }
        }
        exit(str_replace("{CONTENT}", $content, $template));
    }

    protected function setOutput($output = null, $view = 'index')
    {
        $this->data['breadcrumb'] = $this->bread;
        if (isset($output->isJSONResponse) && $output->isJSONResponse) {
            header('Content-Type: application/json; charset=utf-8');
            echo $output->output;
            exit;
        }
        $content = (strtolower(get_class($this)) . "/" . $view);
        $x = array_merge($this->data, ['output' => $output]);
        $this->layout->set_template('template/app');

        $this->layout->CONTENT->view($content, $x);
        if ($this->module != NULL) {
            if (in_array($this->module . ".access", $this->data["userMenus"]) == 0) {
                $this->session->set_flashdata('false', 'Maaf, Anda tidak memiliki akses ke halaman tersebut.');
                redirect();
            }
        }
        $this->layout->publish();
    }

    /**
     * Membuat log user
     *
     * @param  array $data
     * @return void
     */
    protected function setLog($data)
    {
        if (empty($data['id_user'])) {
            $data['id_user'] = $this->session->userdata('id_user');
        }
        if (empty($data['activity'])) {
            $data['activity'] = 'LOGIN';
        }
        if (empty($data['page_url'])) {
            $data['page_url'] = site_url();
        }
        if (empty($data['ip_address'])) {
            $data['ip_address'] = getIp();
        }

        $this->M_activity_log->insert($data);
    }

    /**
     * setResponse
     *
     * @param  boolean $status
     * @param  string $message
     * @return array response
     */
    protected function setResponse($status, $message)
    {
        $response['status'] = null;
        $response['message'] = null;
        if ($status) {
            $response['status'] = true;
            $response['message'] = $message;
        } else {
            $response['status'] = false;
            $response['message'] = $message;
        }
        return $response;
    }

    protected function create_captcha()
    {
        $files = glob('./public/captcha/*.jpg'); // get all file names
        foreach ($files as $file) {
            if (is_file($file))
                unlink($file); // delete file
        }

        $number = ' ' . rand(1000, 5000) . ' ';
        $vals = array(
            'word'          => $number,
            'img_path'      => './public/captcha/',
            'img_url'       => base_url('public/captcha'),
            'font_path'     => FCPATH . 'public/fonts/poppins/Poppins-SemiBold.ttf',
            'img_width'     => 180,
            'img_height'    => 40,
            'expiration'    => 3600,
            'word_length'   => 12,
            'font_size'     => 18,
            'img_id'        => 'imageid',
            'pool'          => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',

            // White background and border, black text and red grid
            'colors'        => array(
                'background' => array(255, 255, 255),
                'border' => array(255, 255, 255),
                'text' => array(0, 0, 0),
                'grid' => array(255, 40, 40)
            )
        );

        $cap = create_captcha($vals);
        $this->session->set_userdata('captchaword', $cap['word']);
        return $cap['image'];
    }
}
