<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ISO extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Model_ISO');
	}

	public function test($ano){
		$this->Model_ISO->createCompaniesByYear($ano);
	}

	public function index() {
		$data['content'] = 'charts/index';

		$this->load->view('charts/iso', $data);
	}

	public function readGroupsByYear($ano){
		var_dump($this->Model_ISO->readGroupsByYear($ano));
	}

	public function readGroupsByYearAndMonth($ano, $mes){
		var_dump($this->Model_ISO->readGroupsByYearAndMonth($ano, $mes));
	}

	public function readAll(){
		var_dump($this->Model_ISO->readGroups());
		echo "<hr>";
		var_dump($this->Model_ISO->readCompanies());
		echo "<hr>";
		var_dump($this->Model_ISO->readProcess());
	}

	public function createGroups($ano, $mes){
		$this->Model_ISO->createGroups($ano, $mes);
	}

	public function readGroups(){
		var_dump($this->Model_ISO->readGroups());
	}

	public function createCompanies($ano, $mes, $grupo_id){
		$this->Model_ISO->createCompanies($ano, $mes, $grupo_id);
	}

	public function readCompanies(){
		var_dump($this->Model_ISO->readCompanies());
	}

	public function createProcess($ano, $mes, $grupo_id, $empresa_id){
		$this->Model_ISO->createProcess($ano, $mes, $grupo_id, $empresa_id);
	}

	public function readProcess(){
		var_dump($this->Model_ISO->readProcess());
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
