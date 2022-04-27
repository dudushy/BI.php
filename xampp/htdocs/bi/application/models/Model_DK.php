<?php

class Model_DK extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function getCompanyGroups($area_id) {
		$token = json_decode(file_get_contents("ignore/help.json"), true)['profile']['token'];

		$url = json_decode(file_get_contents("ignore/help.json"), true)['api_url']['dk'];
		$user_id = json_decode(file_get_contents("ignore/help.json"), true)['profile']['id2'];

		$finalUrl = $url . "?user_id=" . $user_id . "&level=company-groups&area_id=" . $area_id;

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

	public function createCompanyGroups($area_id){
		$token = json_decode(file_get_contents("ignore/help.json"), true)['profile']['token'];

		$url = json_decode(file_get_contents("ignore/help.json"), true)['api_url']['dk'];
		$user_id = json_decode(file_get_contents("ignore/help.json"), true)['profile']['id2'];

		$finalUrl = $url . "?user_id=" . $user_id . "&level=company-groups" . "&area_id=" . $area_id;

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
		
		foreach($result->data as $dk){
			$arrayData = array(
				'area_id' => $area_id,
				'TEXT' => $dk->TEXT,
				'TEXT' => $dk->TEXT
			);

			$this->db->insert('tb_dk', $arrayData);
		}
	}

	public function getCompany($period, $parent_item_id, $area_id) {
		$token = json_decode(file_get_contents("ignore/help.json"), true)['profile']['token'];

		$url = json_decode(file_get_contents("ignore/help.json"), true)['api_url']['dk'];
		$user_id = json_decode(file_get_contents("ignore/help.json"), true)['profile']['id2'];

		$finalUrl = $url . "?user_id=" . $user_id . "&level=company&period=" . $period . "&parent_item_id=" . $parent_item_id . "&area_id=" . $area_id;

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

	public function createCompany($period, $parent_item_id, $area_id){
		$token = json_decode(file_get_contents("ignore/help.json"), true)['profile']['token'];

		$url = json_decode(file_get_contents("ignore/help.json"), true)['api_url']['dk'];
		$user_id = json_decode(file_get_contents("ignore/help.json"), true)['profile']['id2'];

		$finalUrl = $url . "?user_id=" . $user_id . "&level=company&period=" . $period . "&parent_item_id=" . $parent_item_id . "&area_id=" . $area_id;

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
		
		foreach($result->data as $dk){
			$arrayData = array(
				'area_id' => $area_id,
				'TEXT' => $dk->TEXT,
				'TEXT' => $dk->TEXT
			);

			$this->db->insert('tb_dk', $arrayData);
		}
	}

	public function getChapter($period, $parent_item_id, $area_id) {
		$token = json_decode(file_get_contents("ignore/help.json"), true)['profile']['token'];

		$url = json_decode(file_get_contents("ignore/help.json"), true)['api_url']['dk'];
		$user_id = json_decode(file_get_contents("ignore/help.json"), true)['profile']['id2'];

		$finalUrl = $url . "?user_id=" . $user_id . "&level=chapter&period=" . $period . "&parent_item_id=" . $parent_item_id . "&area_id=" . $area_id;

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

	public function createChapter($period, $parent_item_id, $area_id){
		$token = json_decode(file_get_contents("ignore/help.json"), true)['profile']['token'];

		$url = json_decode(file_get_contents("ignore/help.json"), true)['api_url']['dk'];
		$user_id = json_decode(file_get_contents("ignore/help.json"), true)['profile']['id2'];

		$finalUrl = $url . "?user_id=" . $user_id . "&level=chapter&period=" . $period . "&parent_item_id=" . $parent_item_id . "&area_id=" . $area_id;

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
		
		foreach($result->data as $dk){
			$arrayData = array(
				'area_id' => $area_id,
				'TEXT' => $dk->TEXT,
				'TEXT' => $dk->TEXT
			);

			$this->db->insert('tb_dk', $arrayData);
		}
	}
}
