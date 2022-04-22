<?php

class Model_ISO extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function readGroups() {
		$query = $this->db->query("SELECT * FROM tb_iso_groups");
		return $query->result();
	}

	public function createGroups($ano, $mes){
		$token = json_decode(file_get_contents("ignore/help.json"), true)['profile']['token'];

		$url = json_decode(file_get_contents("ignore/help.json"), true)['api_url']['iso_groups'];
		$cadastro_id = json_decode(file_get_contents("ignore/help.json"), true)['profile']['id'];

		$finalUrl = $url . "?cadastro_id=" . $cadastro_id . "&ano=" . $ano . "&mes=" . $mes;

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $finalUrl);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Authorization: Bearer ' . $token
		));
		
		$result = json_decode(curl_exec($ch));
		curl_close($ch);
		
		foreach($result->data as $iso_groups){
			$arrayData = array(
				'grp_id' => $iso_groups->id_grupo,
				'grp_name' => $iso_groups->nome_grupo,
				'total_companies' => $iso_groups->total_empresas,
				'value' => $iso_groups->valor,
				'year' => $ano,
				'month' => $mes
			);
			
			$this->db->insert('tb_iso_groups', $arrayData);
		}
	}

	public function readCompanies() {
		$query = $this->db->query("SELECT * FROM tb_iso_companies");
		return $query->result();
	}

	public function createCompanies($ano, $mes, $grupo_id){
		$token = json_decode(file_get_contents("ignore/help.json"), true)['profile']['token'];

		$url = json_decode(file_get_contents("ignore/help.json"), true)['api_url']['iso_companies'];
		$cadastro_id = json_decode(file_get_contents("ignore/help.json"), true)['profile']['id'];

		$finalUrl = $url . "?cadastro_id=" . $cadastro_id . "&ano=" . $ano . "&mes=" . $mes . "&grupo_id=" . $grupo_id;

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $finalUrl);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Authorization: Bearer ' . $token
		));
		
		$result = json_decode(curl_exec($ch));
		curl_close($ch);
		
		foreach($result->data as $iso_companies){
			$arrayData = array(
				'com_id' => $iso_companies->empresa_id,
				'com_name' => $iso_companies->razao_social,
				'value' => $iso_companies->valor,
				'grp_id' => $grupo_id,
				'year' => $ano,
				'month' => $mes
			);
			
			$this->db->insert('tb_iso_companies', $arrayData);
		}
	}

	public function readProcess() {
		$query = $this->db->query("SELECT * FROM tb_iso_process");
		return $query->result();
	}

	public function createProcess($ano, $mes, $grupo_id, $empresa_id){
		$token = json_decode(file_get_contents("ignore/help.json"), true)['profile']['token'];

		$url = json_decode(file_get_contents("ignore/help.json"), true)['api_url']['iso_process'];
		$cadastro_id = json_decode(file_get_contents("ignore/help.json"), true)['profile']['id'];

		$finalUrl = $url . "?cadastro_id=" . $cadastro_id . "&ano=" . $ano . "&mes=" . $mes . "&grupo_id=" . $grupo_id . "&empresa_id=" . $empresa_id;

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $finalUrl);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Authorization: Bearer ' . $token
		));
		
		$result = json_decode(curl_exec($ch));
		curl_close($ch);
		
		foreach($result->data as $iso_process){
			$arrayData = array(
				'prc_id' => $iso_process->id,
				'prc_name' => $iso_process->nome,
				'prc_order' => $iso_process->ordem,
				'value' => $iso_process->valor,
				'grp_id' => $grupo_id,
				'com_id' => $empresa_id,
				'year' => $ano,
				'month' => $mes
			);
			
			$this->db->insert('tb_iso_process', $arrayData);
		}
	}

	public function getToken($username, $password) {
		/* API URL */
		$url = json_decode(file_get_contents("ignore/help.json"), true)['api_url']['auth'];

		/* Init cURL resource */
		$ch = curl_init($url);

		/* Array Parameter Data */
		$data = array(
			'username' => $username,
			'password' => $password
		);
		$data = json_encode($data);

		/* pass encoded JSON string to the POST fields */
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

		/* set the content type json */
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json'
		));

		/* set return type json */
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$result = json_decode(curl_exec($ch), true);
		curl_close($ch);

		return $result;
	}

	public function login($username, $password, $token) {
		/* API URL */
		$url = json_decode(file_get_contents("ignore/help.json"), true)['api_url']['login'];

		/* Init cURL resource */
		$ch = curl_init($url);

		/* Array Parameter Data */
		$data = array(
			'username' => $username,
			'password' => $password
		);
		$data = json_encode($data);

		/* pass encoded JSON string to the POST fields */
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

		/* set the content type json */
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Authorization: Bearer ' . $token
		));

		/* set return type json */
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$result = json_decode(curl_exec($ch), true);
		curl_close($ch);

		return $result;
	}

	public function getGroups($ano, $mes) {
		$token = json_decode(file_get_contents("ignore/help.json"), true)['profile']['token'];

		$url = json_decode(file_get_contents("ignore/help.json"), true)['api_url']['iso_groups'];
		$cadastro_id = json_decode(file_get_contents("ignore/help.json"), true)['profile']['id'];

		$finalUrl = $url . "?cadastro_id=" . $cadastro_id . "&ano=" . $ano . "&mes=" . $mes;

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $finalUrl);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Authorization: Bearer ' . $token
		));
		
		$result = curl_exec($ch);
		curl_close($ch);
		
		return $result;
	}

	public function getCompanies($ano, $mes, $grupo_id) {
		$token = json_decode(file_get_contents("ignore/help.json"), true)['profile']['token'];

		$url = json_decode(file_get_contents("ignore/help.json"), true)['api_url']['iso_companies'];
		$cadastro_id = json_decode(file_get_contents("ignore/help.json"), true)['profile']['id'];

		$finalUrl = $url . "?cadastro_id=" . $cadastro_id . "&ano=" . $ano . "&mes=" . $mes . "&grupo_id=" . $grupo_id;

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $finalUrl);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Authorization: Bearer ' . $token
		));
		
		$result = curl_exec($ch);
		curl_close($ch);
		
		return $result;
	}

	public function getProcess($ano, $mes, $grupo_id, $empresa_id) {
		$token = json_decode(file_get_contents("ignore/help.json"), true)['profile']['token'];

		$url = json_decode(file_get_contents("ignore/help.json"), true)['api_url']['iso_process'];
		$cadastro_id = json_decode(file_get_contents("ignore/help.json"), true)['profile']['id'];

		$finalUrl = $url . "?cadastro_id=" . $cadastro_id . "&ano=" . $ano . "&mes=" . $mes . "&grupo_id=" . $grupo_id . "&empresa_id=" . $empresa_id;

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $finalUrl);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Authorization: Bearer ' . $token
		));
		
		$result = curl_exec($ch);
		curl_close($ch);
		
		return $result;
	}
}
