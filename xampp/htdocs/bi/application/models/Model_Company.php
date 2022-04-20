<?php

class Model_Company extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function readCompany() {
		$query = $this->db->query("SELECT * FROM tb_company");
		return $query->result();
	}

	public function createCompany(){
		$url = json_decode(file_get_contents("ignore/help.json"), true);
		$url = $url['api_url']['companies'];

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
		
		foreach($result->data->companies as $company){
			$arrayData = array(
				'com_id' => $company->value,
				'com_name' => $company->title,
				'com_cnpj' => $company->cnpj
			);
			
			$this->db->insert('tb_company', $arrayData);
		}
	}
}
