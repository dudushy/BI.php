<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ISO extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Model_ISO');
	}

	public function index() {
		$data['content'] = 'charts/index';

		$this->load->view('charts/iso', $data);
	}

	public function create(){
		$this->Model_ISO->createISO(); // NOT READY
	}

	public function read(){
		var_dump($this->Model_ISO->readISO()); // NOT READY
	}

	// public function chart() {
	// 	$data = $this->input->post();

	// 	$this->load->view('charts/iso', $data);
	// }

	public function auth() {
		$data = $this->input->post();
		
		if (isset($data)){
			$username = $data['username'];
			$password = $data['password']; 

			// echo "username: " . $username . "<br>password: " . $password . "<br><hr>";

			$jsonToken = $this->Model_ISO->getToken($username, $password);
			// var_dump($jsonToken);

			if ($jsonToken['success']) {
				// echo "<br><hr>[SUCCESS] got token<br>";
				// var_dump($jsonToken['data']);
				// echo "<br><hr>";

				$data['auth'] = $this->Model_ISO->login($username, $password, $jsonToken['data']['token']);
				$this->load->view('charts/iso', $data);

				// echo "token: " . $jsonToken['data']['token'] . "<br>";
				// var_dump($auth);
			}
		}
	}

	public function getGroups($ano, $mes) {
		$response = $this->Model_ISO->getGroups($ano, $mes);
		echo $response;
		//$this->saveGroup(json_decode($response));
	}

	public function getCompanies($ano, $mes, $grupo_id) {
		$response = $this->Model_ISO->getCompanies($ano, $mes, $grupo_id);
		echo $response;
		//$this->saveCompany(json_decode($response), $grupo_id);
	}

	public function getProcess($ano, $mes, $grupo_id, $empresa_id) {
		$response = $this->Model_ISO->getProcess($ano, $mes, $grupo_id, $empresa_id);
		echo $response;
	}
}
