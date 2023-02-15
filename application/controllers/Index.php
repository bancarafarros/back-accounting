<?php defined('BASEPATH') or exit('no access allowed');

class Index extends BaseController
{
	protected $template = "login";

	function __construct()
	{
		parent::__construct();
		$this->load->model('M_hutang');
		$this->load->model('M_piutang');
		$this->load->model('M_barang');
		$this->load->model('M_app');
		$this->load->model('M_penjualan');
		$this->load->model('M_jurnal');
		$this->load->model('M_user');
	}

	public function index()
	{
		if (!empty(getSession('userId'))) {
			redirect('dashboard');
		}
		$this->data['judul_title'] = 'Login';
		$this->render('login');
	}

	public function fetchCaptha()
	{
		$response['data'] = $this->create_captcha();
		echo json_encode($response);
	}

	public function notFound()
	{
		$userAgent = $_SERVER['HTTP_USER_AGENT'];
		$isBrowser = $this->isBrowser($userAgent);
		if ($isBrowser) {
			http_response_code(404);
			$this->template = 'login';
			$this->data['judul_title'] = 'Page Not Found';
			$this->render('notfound');
		} else {
			header("Content-Type: application/json");
			http_response_code(404);
			echo json_encode([
				'code'     	=> 404,
				'message'    => 'Not found',
				'data'       => null,
			]);
			die;
		}
	}

	private function isBrowser($userAgent)
	{
		$isBrowser = false;
		$isBrowser = isBrowser($userAgent);
		// $browsers = ['msie', 'trident', 'firefox', 'chrome', 'opera mini', 'safari'];
		// for ($i = 0; $i < count($browsers); $i++) {
		// 	if (strpos(strtolower($userAgent), $browsers[$i]) !== FALSE) {
		// 		$bro = $browsers[$i];
		// 		if (in_array($bro, $browsers)) {
		// 			$isBrowser = true;
		// 			break;
		// 		}
		// 	}
		// }

		return $isBrowser;
	}
}
