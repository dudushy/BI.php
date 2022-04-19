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
		$response = $this->Model_Graph->getISO_one($ano, $mes);
		echo $response;
		$this->saveGroup(json_decode($response));
	}

	public function getISO_two($ano, $mes, $grupo_id) {
		$response = $this->Model_Graph->getISO_two($ano, $mes, $grupo_id);
		echo $response;
		//$this->saveCompany(json_decode($response), $grupo_id);
	}

	public function getISO_three($ano, $mes, $grupo_id, $empresa_id) {
		$response = $this->Model_Graph->getISO_three($ano, $mes, $grupo_id, $empresa_id);
		echo $response;
	}

	public function saveGroup($response){
		$grp_id = $response['data']['id_grupo'];
		$grp_name = $response['data']['nome_grupo'];
		$grp_total_companies = $response['data']['total_empresas'];
		$this->Model_Graph->createGroup($grp_id, $grp_name, $grp_total_companies);
	}

	public function saveCompany($response, $grp_id){
		$com_id = $response['data']['empresa_id'];
		$com_name = $response['data']['razao_social'];
		$this->Model_Graph->createCompany($com_id, $com_name, $grp_id);
	}

	public function chart() {
		$data = $this->input->post();

		$this->load->view('graph/charts', $data);
	}
}
