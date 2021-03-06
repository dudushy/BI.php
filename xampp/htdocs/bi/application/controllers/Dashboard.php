<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Model_Dashboard');
	}

	public function index() {
		//! $this->load->view('dashboard/login');

		$queryGroups = $this->db->query("SELECT * FROM tb_group ORDER BY grp_name ASC");
		$queryCompanies = $this->db->query("SELECT * FROM tb_company ORDER BY com_name ASC");

		$data['auth'] = "pulado";
		$data['groups'] = $queryGroups->result();
		$data['companies'] = $queryCompanies->result();
		$this->load->view('dashboard/dashboard', $data);
	}

	public function auth() {
		$input_data = $this->input->post();
		
		if (isset($input_data)){
			$username = $input_data['username'];
			$password = $input_data['password']; 

			echo "username: " . $username . "<br>password: " . $password . "<br>";

			$jsonToken = $this->Model_Dashboard->getToken($username, $password);
			echo "<hr>jsonToken:<br><br>";
			var_dump($jsonToken);

			if ($jsonToken['success']) {
				echo "<hr>[SUCCESS] token:<br><br>";
				echo $jsonToken['data']['token'];

				echo "<hr>jsonToken[data]:<br><br>";
				var_dump($jsonToken['data']);

				$data['auth'] = $this->Model_Dashboard->login($username, $password, $jsonToken['data']['token']);
			} else {
				$data['auth'] = "fail";
			}

			echo "<hr>data[auth]:<br><br>";
			var_dump($data['auth']);

			$this->load->view('Dashboard/charts', $data);
		}
	}
}
