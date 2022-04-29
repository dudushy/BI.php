<?php

class Model_Company extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function createAll() {
		$query = $this->db->query("SELECT * FROM tb_group");
		foreach ($query->result() as $group) {
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
					'com_cnpj' => $company->cnpj,
					'grp_id' => $group->grp_id
				);
				
				$this->db->insert('tb_company', $arrayData);
			}
		}
	}

	public function read() {
		$query = $this->db->query("SELECT * FROM tb_company");
		return $query->result();
	}

	public function readByName() {
		$query = $this->db->query("SELECT * FROM tb_company ORDER BY com_name ASC");
		return $query->result();
	}

	public function readByGrpId($grupo_id) {
		$query = $this->db->query("SELECT * FROM tb_company WHERE grp_id = " . $grupo_id);
		return $query->result();
	}

	public function create($grupo_id){
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
				'com_cnpj' => $company->cnpj,
				'grp_id' => $grupo_id
			);
			
			$this->db->insert('tb_company', $arrayData);
		}
	}
}
