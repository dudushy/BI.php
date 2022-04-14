<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Graph extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Model_Graph');
	}

	public function index() {
		$data['content'] = 'graph/index';

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
				$this->load->view('graph/charts', $data);

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

		$this->load->view('graph/charts', $data);
	}
}
