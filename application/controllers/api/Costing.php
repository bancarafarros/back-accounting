<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'core/MY_Api.php';

class Costing extends Apicontroller
{
	protected $template = "app";
	protected $module = 'costing';
	public $loginBehavior = true;
	protected $bread = [];

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_jurnal');
		$this->load->model('M_pemasok');
		$this->load->model('M_barang');
		$this->load->model('M_costing');
		$this->load->model('M_bank');
		$this->load->model('api/Api_costing', 'api_costing');
	}

	public function index_get()
    {
		$this->methodNotAllowed();
    }

	public function index_post()
    {
        $this->methodNotAllowed();
    }

    public function index_put()
    {
        $this->methodNotAllowed();
    }

    public function index_patch()
    {
        $this->methodNotAllowed();
    }

    public function index_delete()
    {
        $this->methodNotAllowed();
    }

	public function create_post()
	{
		$param = json_decode(trim(file_get_contents('php://input')), true);
		// print_r($param);

		// get no.transaksi
		$param['n_transaksi'] = generateNomorForAccounting('CT', 'hcosting', 'n_costing');

		// Generate no. jurnal
		$n_jurnal = generateNomorForAccounting('GL', 'hjurnal', 'n_jurnal');

		$brg = 0;

		//pengolahan data barang
		for ($sm = 0; $sm <= $param['sum_barang']; $sm++) {
			if (@$param['n_barang' . $sm]) {
				$n_barang[$sm] = $this->M_barang->getDetailBarang($param['n_barang' . $sm]);
				$barang_a[] = [$n_barang[$sm]->akun_persediaan => $param['total' . $sm]];
				$s_barang[] = $this->M_barang->getDetailBarang($param['n_barang' . $sm]);
				if ($param['satuan_barang' . $sm] == $s_barang[$brg]->konversi_unit) {
					$param['satuan_barang' . $sm] = $s_barang[$brg]->b_unit;
				} else {
					$param['satuan_barang' . $sm] = $s_barang[$brg]->n_unit;
				}
				$stock_barang[] = $s_barang[$brg]->n_barang . "," . $s_barang[$brg]->stock_gudang . "," . $s_barang[$brg]->harga_pokok . "," . $s_barang[$brg]->stock_etalase;
				$brg++;
			}
		}
		foreach ($barang_a as $k => $subArray) {
			foreach ($subArray as $id => $value) {
				@$barang_a[$id] += $value;
			}
		}
		for ($br = 0; $br <= $param['sum_barang']; $br++) {
			if (@$param['n_barang' . $br]) {
				$hasil[] = $param['perkiraan' . $br] . "," . @$barang_a[$param['perkiraan' . $br]];
			}
		}

		$djurnal = array_unique($hasil);
		//generate jurnal
		$jurnal = ['nomor' => $n_jurnal];


		// echo '<br>';
		// print_r($param);
		// echo '<br>';
		// // print_r($barang_a);
		// echo '<br>';
		// print_r($djurnal);
		// echo '<br>';
		// print_r($stock_barang);

		$post = null;
        if ($param != null) {
            $post = $this->api_costing->insertCosting($param, $jurnal, $djurnal, $stock_barang);

        } else {
            $format = [
                'message'   => 'Data tidak berhasil ditambahkan',
                'data'      => null,
            ];
            $response = $this->setFormat($this->bad_req, $format);
            return $this->response($response, $this->bad_req);
        }

        if (!empty($post)) {
            $format = [
                'message'   => 'Data berhasil ditambahkan',
                'data'      => $param,
            ];
            $response = $this->setFormat($this->ok, $format);
            return $this->response($response, $this->ok);
        
        } else {
            $format = [
                'message'   => 'Data tidak berhasil ditambahkan',
                'data'      => null,
            ];
            $response = $this->setFormat($this->bad_req, $format);
            return $this->response($response, $this->bad_req);
        }
    }

	public function create_get()
    {
        $this->methodNotAllowed();
    }

    public function create_put()
    {
        $this->methodNotAllowed();
    }

    public function create_patch()
    {
        $this->methodNotAllowed();
    }

    public function create_delete()
    {
        $this->methodNotAllowed();
    }
}