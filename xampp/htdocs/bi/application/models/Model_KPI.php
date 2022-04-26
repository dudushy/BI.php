<?php

class Model_KPI extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function read() {
		$query = $this->db->query("SELECT * FROM tb_kpi");
		return $query->result();
	}

	public function readByYear($ano) {
		$query = $this->db->query("SELECT * FROM tb_kpi WHERE year = " . $ano);
		return $query->result();
	}

	public function readByYearAndMonth($ano, $mes) {
		$query = $this->db->query("SELECT * FROM tb_kpi WHERE year = " . $ano . " AND month = " . $mes);
		return $query->result();
	}

	public function readCompanies() {
		$query = $this->db->query("SELECT * FROM tb_company");
		return $query->result();
	}

	public function readCompaniesByName() {
		$query = $this->db->query("SELECT * FROM tb_company ORDER BY com_name ASC");
		return $query->result();
	}

	public function getAll($ano) {
		$resultArray = array();
		foreach ($this->readCompanies() as $company) {
			$token = json_decode(file_get_contents("ignore/help.json"), true)['profile']['token'];

			$url = json_decode(file_get_contents("ignore/help.json"), true)['api_url']['kpi'];
			$cadastro_id = json_decode(file_get_contents("ignore/help.json"), true)['profile']['id2'];

			$finalUrl = $url . $cadastro_id . "/" . $company->com_id . "/" . $ano . ".json";

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
			
			array_push($resultArray, $result);
		}
		
		return $resultArray;
	}

	public function get($com_id, $ano) {
		$token = json_decode(file_get_contents("ignore/help.json"), true)['profile']['token'];

		$url = json_decode(file_get_contents("ignore/help.json"), true)['api_url']['kpi'];
		$cadastro_id = json_decode(file_get_contents("ignore/help.json"), true)['profile']['id2'];

		$finalUrl = $url . $cadastro_id . "/" . $com_id . "/" . $ano . ".json";

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

	public function create($com_id, $ano){
		$token = json_decode(file_get_contents("ignore/help.json"), true)['profile']['token'];

		$url = json_decode(file_get_contents("ignore/help.json"), true)['api_url']['kpi'];
		$cadastro_id = json_decode(file_get_contents("ignore/help.json"), true)['profile']['id2'];

		$finalUrl = $url . $cadastro_id . "/" . $com_id . "/" . $ano . ".json";

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
		
		foreach($result->data->years->$ano as $kpi){
			$arrayData = array(
				'com_id' => $kpi->company,
				'year' => $kpi->year,
				'month' => $kpi->month,
				'tus' => $kpi->tus,
				'm3_water' => $kpi->m3_water,
				'm3_well' => $kpi->m3_well,
				'm3_cistern' => $kpi->m3_cistern,
				'm3_water_total' => $kpi->m3_water_total,
				'm3_water_tus' => $kpi->m3_water_tus,
				'm3_well_tus' => $kpi->m3_well_tus,
				'm3_cistern_tus' => $kpi->m3_cistern_tus,
				'm3_water_total_tus' => $kpi->m3_water_total_tus,
				'value_water' => $kpi->value_water,
				'kwh_energy' => $kpi->kwh_energy,
				'kwh_energy_tus' => $kpi->kwh_energy_tus,
				'value_energy' => $kpi->value_energy,
				'total_recyclable' => $kpi->total_recyclable,
				'total_contaminated' => $kpi->total_contaminated,
				'total_recyclable_tus' => $kpi->total_recyclable_tus,
				'total_contaminated_tus' => $kpi->total_contaminated_tus,
				'badgoal_m3_water_total' => $kpi->badgoal_m3_water_total,
				'badgoal_m3_water_total_tus' => $kpi->badgoal_m3_water_total_tus,
				'badgoal_kwh_energy' => $kpi->badgoal_kwh_energy,
				'badgoal_kwh_energy_tus' => $kpi->badgoal_kwh_energy_tus,
				'badgoal_recyclable_tus' => $kpi->badgoal_recyclable_tus,
				'badgoal_total_contaminated_tus' => $kpi->badgoal_total_contaminated_tus,
				'delayed_m3_water' => $kpi->delayed_m3_water,
				'delayed_m3_well' => $kpi->delayed_m3_well,
				'delayed_m3_cistern' => $kpi->delayed_m3_cistern,
				'delayed_value_water' => $kpi->delayed_value_water,
				'delayed_kwh_energy' => $kpi->delayed_kwh_energy,
				'delayed_value_energy' => $kpi->delayed_value_energy,
				'delayed_total_recyclable' => $kpi->delayed_total_recyclable,
				'delayed_total_contaminated' => $kpi->delayed_total_contaminated,
				'unlocked' => $kpi->unlocked,
				'obs' => $kpi->obs,
				'iso14001' => $kpi->iso14001,
				'iso14001_validate_date' => $kpi->iso14001_validate_date,
				'iso14001_file' => $kpi->iso14001_file,
				'iso14001_file_path' => $kpi->iso14001_file_path,
				'inserted' => $kpi->inserted,
				'water_file' => $kpi->water_file,
				'water_file_path' => $kpi->water_file_path,
				'energy_file' => $kpi->energy_file,
				'energy_file_path' => $kpi->energy_file_path,
				'me_goal_water' => $kpi->me_goal_water,
				'me_goal_energy' => $kpi->me_goal_energy,
				'current' => $kpi->current,
				'permission' => $kpi->permission,
				'text' => $kpi->text
			);
			
			$this->db->insert('tb_kpi', $arrayData);
		}
	}
}
