<?php

class Model_Group extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function read() {
		$query = $this->db->query("SELECT * FROM tb_group");
		return $query->result();
	}

	public function readByName() {
		$query = $this->db->query("SELECT * FROM tb_company ORDER BY grp_name ASC");
		return $query->result();
	}

	public function create(){
		$url = json_decode(file_get_contents("ignore/help.json"), true);
		$url = $url['api_url']['groups'];

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
		
		foreach($result->data->groups as $group){
			$arrayData = array(
				'grp_id' => $group->value,
				'grp_name' => $group->title
			);
			
			$this->db->insert('tb_group', $arrayData);
		}
	}
}
