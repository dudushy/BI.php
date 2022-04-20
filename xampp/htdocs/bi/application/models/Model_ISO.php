<?php

class Model_ISO extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function readISO_groups() { // NOT READY
		$query = $this->db->query("SELECT * FROM tb_iso_groups");
		return $query->result();
	}

	public function createISO_groups(){ // NOT READY
		$url = json_decode(file_get_contents("ignore/help.json"), true);
		$url = $url['api_url']['iso_groups'];

		$token = json_decode(file_get_contents("ignore/help.json"), true);
		$token = $token['profile']['token'];

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Authorization: Bearer ' . $token
		));
		
		$result = json_decode(curl_exec($ch));
		curl_close($ch);
		
		foreach($result->data->companies as $iso){
			$arrayData = array(
				'com_id' => $iso->value,
				'com_name' => $iso->title,
				'com_cnpj' => $iso->cnpj
			);
			
			$this->db->insert('tb_iso', $arrayData);
		}
	}

	public function getToken($username, $password) {
		/* API URL */
		$url = json_decode(file_get_contents("ignore/help.json"), true);
		$url = $url['api_url']['auth'];

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
		$url = json_decode(file_get_contents("ignore/help.json"), true);
		$url = $url['api_url']['login'];

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

	public function getISO_one($ano, $mes) {
		$url = json_decode(file_get_contents("ignore/help.json"), true);
		$url = $url['api_url']['iso_graph'];

		$token = json_decode(file_get_contents("ignore/help.json"), true);
		$token = $token['profile']['token'];

		$ch = curl_init();

		$getUrl = $url . "?cadastro_id=" . 10649 . "&ano=" . $ano . "&mes=" . $mes;
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $getUrl);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Authorization: Bearer ' . $token
		));
		
		$result = curl_exec($ch);
		curl_close($ch);
		
		return $result;
	}

	public function getISO_two($ano, $mes, $grupo_id) {
		$url = json_decode(file_get_contents("ignore/help.json"), true);
		$url = $url['api_url']['iso_companies'];

		$token = json_decode(file_get_contents("ignore/help.json"), true);
		$token = $token['profile']['token'];

		$ch = curl_init();

		$getUrl = $url . "?cadastro_id=" . 10649 . "&ano=" . $ano . "&mes=" . $mes . "&grupo_id=" . $grupo_id;
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $getUrl);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Authorization: Bearer ' . $token
		));
		
		$result = curl_exec($ch);
		curl_close($ch);
		
		return $result;
	}

	public function getISO_three($ano, $mes, $grupo_id, $empresa_id) {
		$url = json_decode(file_get_contents("ignore/help.json"), true);
		$url = $url['api_url']['iso_process'];

		$token = json_decode(file_get_contents("ignore/help.json"), true);
		$token = $token['profile']['token'];

		$ch = curl_init();

		$getUrl = $url . "?cadastro_id=" . 10649 . "&ano=" . $ano . "&mes=" . $mes . "&grupo_id=" . $grupo_id . "&empresa_id=" . $empresa_id;
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $getUrl);
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
