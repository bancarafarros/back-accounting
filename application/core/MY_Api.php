<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/Format.php';

use Restserver\Libraries\REST_Controller;

class Apicontroller extends REST_Controller
{

    protected $ok = REST_Controller::HTTP_OK;
    protected $bad_req = REST_Controller::HTTP_BAD_REQUEST;
    protected $bad_gateway = REST_Controller::HTTP_BAD_GATEWAY;
    protected $unauthorized = REST_Controller::HTTP_UNAUTHORIZED;
    protected $notfound = REST_Controller::HTTP_NOT_FOUND;
    protected $error = REST_Controller::HTTP_INTERNAL_SERVER_ERROR;
    protected $not_allowed = REST_Controller::HTTP_METHOD_NOT_ALLOWED;
    protected $return = ['code' => null, 'message' => null, 'error' => null, 'data' => null];

    private $noAuth = ['auth'];

    function __construct()
    {
        parent::__construct();
        $this->methods['data_post']['limit'] = 100; // 100 requests per hour per data/key
        // need authorization or not
        if (!in_array($this->uri->segment(2), $this->noAuth)) {
            $this->authorization();
        }
    }

    private function authorization()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('authorization', $headers) && !empty($headers['authorization'])) {
            $token = $headers['authorization'];
            $decoded_token = AUTHORIZATION::validateToken($token);
            if ($decoded_token != false && property_exists($decoded_token, 'id_user') && property_exists($decoded_token, 'id_group')) {
                return;
            } else {
                header("Content-Type: application/json");
                http_response_code($this->unauthorized);
                echo json_encode([
                    'code'     => $this->unauthorized,
                    'message'    => 'Unathorized/Invalid Token',
                    'data'       => null,
                ]);
                die;
            }
        } else {
            header("Content-Type: application/json");
            http_response_code($this->bad_req);
            echo json_encode([
                'code'     => $this->bad_req,
                'message'    => 'Token tidak ditemukan.',
                'data'       => null,
            ]);
            die;
        }
    }

    protected function methodNotAllowed()
    {
        $this->return['code'] = $this->not_allowed;
        $format = [
            'message' => 'Method not allowed',
            'error' => 'Method not allowed',
        ];
        $response = $this->setFormat($this->not_allowed, $format);
        return $this->response($response, $this->not_allowed);
    }

    protected function setFormat($code, $data)
    {
        $this->return['code'] = $code;
        if (empty($data['message'])) {
            $data['message'] = 'Internal server error';
        }
        $this->return['message'] = $data['message'];
        if (empty($data['error'])) {
            $data['error'] = null;
        }
        $this->return['error'] = $data['error'];
        if (empty($data['data'])) {
            $data['data'] = null;
        }
        $this->return['data'] = $data['data'];
        return $this->return;
    }
}
