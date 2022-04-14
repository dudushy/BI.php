<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Graph extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Model_Graph');
	}

	public function index() {
		$data['content'] = 'graph/index';

		var_dump(json_decode(file_get_contents("ignore/help.json"), true));

		$this->load->view('model', $data);
	}

	public function auth() {
		$data = $this->input->post();
		
		if (isset($data)){
			$username = $data['username'];
			$password = $data['password']; 

			// echo "username: " . $username . "<br>password: " . $password . "<br><hr>";

			$jsonToken = $this->Model_Graph->getToken($username, $password);
			// var_dump($jsonToken);

			if ($jsonToken['success']) {
				// echo "<br><hr>[SUCCESS] got token<br>";
				// var_dump($jsonToken['data']);
				// echo "<br><hr>";

				$data['auth'] = $this->Model_Graph->login($username, $password, $jsonToken['data']['token']);
				$data['content'] = 'graph/charts';
				$this->load->view('model', $data);

				// echo "token: " . $jsonToken['data']['token'] . "<br>";
				// var_dump($auth);
			}
		}
	}

	public function getISO_one($ano, $mes) {
		echo $this->Model_Graph->getISO_one($ano, $mes);
	}

	public function getISO_two($ano, $mes, $grupo_id) {
		echo $this->Model_Graph->getISO_two($ano, $mes, $grupo_id);
	}

	public function getISO_three($ano, $mes, $grupo_id, $empresa_id) {
		echo $this->Model_Graph->getISO_three($ano, $mes, $grupo_id, $empresa_id);
	}

	public function chart() {
		$data = $this->input->post();

		list($ano, $mes) = explode("-", $data['date']);
		echo "ano: " . $ano;
		echo " | mes: " . $mes;
		//$company = $data['company'];

		$data['charts'] = $this->Model_Graph->getISO_one($ano, $mes);

		$this->load->view('graph/charts', $data);
	}
}
