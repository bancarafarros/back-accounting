<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'core/MY_Api.php';

class Auth extends ApiController
{

    function __construct()
    {
        parent::__construct();

        $this->methods['data_post']['limit'] = 100; // 100 requests per hour per data/key
        $this->load->model('api/Api_login', 'login');
    }

    // get /master always disabled
    public function index_get()
    {
        $this->methodNotAllowed();
    }

    public function index_put()
    {
        $this->methodNotAllowed();
    }

    public function index_delete()
    {
        $this->methodNotAllowed();
    }

    public function index_patch()
    {
        $this->methodNotAllowed();
    }

    public function index_post()
    {
        // check on posted data
        $data = json_decode(trim(file_get_contents('php://input')), true);

        // init result
        $result = null;
        // check wether is login, or refresh token
        if ($data != null && array_key_exists('refresh_token', $data)) {
            $refresh = $data['refresh_token'];

            $check_token = AUTHORIZATION::validateToken($refresh);
            if ($check_token == false) {
                $format = [
                    'message'   => 'Internal Server Error',
                    'error'     => null,
                    'data'      => null
                ];
                $response = $this->setFormat($this->error, $format);
                return $this->response($response, $this->error);
            }

            // get username based on token
            $username = $check_token->username;

            $result = $this->login->check_user($username);
        } else if ($data != null && array_key_exists('username', $data) && array_key_exists('password', $data)) { // general login
            $username = $data['username'];
            $password = $data['password'];

            $result = $this->login->login($username, $password);
        } else {
            $format = [
                'message'   => 'Bad request',
            ];
            $response = $this->setFormat($this->bad_req, $format);
            return $this->response($response, $this->bad_req);
        }

        if (is_array($result) && $result != null) {
            if ($result['status'] == true) {
                // create jwt token
                $token = $this->_create_token($result['data'], $username);
                $format = [
                    'message' => 'Sukses',
                    'data' => $token
                ];

                $response = $this->setFormat($this->ok, $format);
                return $this->response($response, $this->ok);
            } else {
                $format = [
                    'message' => $result['message'],
                    'data' => null
                ];
                $response = $this->setFormat($this->unauthorized, $format);
                return $this->response($response, $this->unauthorized);
            }
        } else {
            $format = [
                'message' => 'Internal Server Error',
                'data' => null
            ];
            $response = $this->setFormat($this->error, $format);
            return $this->response($response, $this->error);
        }
    }

    private function _create_token($data, $username)
    {
        $token = array();
        $token['id_user'] = $data['id_user'];
        $token['id_group'] = $data['id_group'];

        $refresh_token = array();
        $refresh_token['username'] = $username;

        try {
            $jwt = AUTHORIZATION::generateToken($token);
            $refresh = AUTHORIZATION::generateToken($refresh_token);
        } catch (Exception $error) {
            $jwt = null;
            $refresh = null;
        }

        $CI = &get_instance();
        $result = array();
        $result['api_key'] = $jwt;
        $result['expired'] = ($CI->config->item('token_timeout') > 0) ? ($CI->config->item('token_timeout') * 60) : 'never';
        $result['refresh_token'] = $refresh;

        return $result;
    }
}
