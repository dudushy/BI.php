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
				'com_id' => $com_id,
				'year' => $kpi->year,
				'month' => $kpi->month,
				'tus' => (isset($kpi->tus)) ? $kpi->tus : 'NULL',
				'm3_water' => (isset($kpi->m3_water)) ? $kpi->m3_water : 'NULL',
				'm3_well' => (isset($kpi->m3_well)) ? $kpi->m3_well : 'NULL',
				'm3_cistern' => (isset($kpi->m3_cistern)) ? $kpi->m3_cistern : 'NULL',
				'm3_water_total' => (isset($kpi->m3_water_total)) ? $kpi->m3_water_total : 'NULL',
				'm3_water_tus' => (isset($kpi->m3_water_tus)) ? $kpi->m3_water_tus : 'NULL',
				'm3_well_tus' => (isset($kpi->m3_well_tus)) ? $kpi->m3_well_tus : 'NULL',
				'm3_cistern_tus' => (isset($kpi->m3_cistern_tus)) ? $kpi->m3_cistern_tus : 'NULL',
				'm3_water_total_tus' => (isset($kpi->m3_water_total_tus)) ? $kpi->m3_water_total_tus : 'NULL',
				'value_water' => (isset($kpi->value_water)) ? $kpi->value_water : 'NULL',
				'kwh_energy' => (isset($kpi->kwh_energy)) ? $kpi->kwh_energy : 'NULL',
				'kwh_energy_tus' => (isset($kpi->kwh_energy_tus)) ? $kpi->kwh_energy_tus : 'NULL',
				'value_energy' => (isset($kpi->value_energy)) ? $kpi->value_energy : 'NULL',
				'total_recyclable' => (isset($kpi->total_recyclable)) ? $kpi->total_recyclable : 'NULL',
				'total_contaminated' => (isset($kpi->total_contaminated)) ? $kpi->total_contaminated : 'NULL',
				'total_recyclable_tus' => (isset($kpi->total_recyclable_tus)) ? $kpi->total_recyclable_tus : 'NULL',
				'total_contaminated_tus' => (isset($kpi->total_contaminated_tus)) ? $kpi->total_contaminated_tus : 'NULL',
				'badgoal_m3_water_total' => (isset($kpi->badgoal_m3_water_total)) ? $kpi->badgoal_m3_water_total : 'NULL',
				'badgoal_m3_water_total_tus' => (isset($kpi->badgoal_m3_water_total_tus)) ? $kpi->badgoal_m3_water_total_tus : 'NULL',
				'badgoal_kwh_energy' => (isset($kpi->badgoal_kwh_energy)) ? $kpi->badgoal_kwh_energy : 'NULL',
				'badgoal_kwh_energy_tus' => (isset($kpi->badgoal_kwh_energy_tus)) ? $kpi->badgoal_kwh_energy_tus : 'NULL',
				'badgoal_recyclable_tus' => (isset($kpi->badgoal_recyclable_tus)) ? $kpi->badgoal_recyclable_tus : 'NULL',
				'badgoal_total_contaminated_tus' => (isset($kpi->badgoal_total_contaminated_tus)) ? $kpi->badgoal_total_contaminated_tus : 'NULL',
				'delayed_m3_water' => (isset($kpi->delayed_m3_water)) ? $kpi->delayed_m3_water : 'NULL',
				'delayed_m3_well' => (isset($kpi->delayed_m3_well)) ? $kpi->delayed_m3_well : 'NULL',
				'delayed_m3_cistern' => (isset($kpi->delayed_m3_cistern)) ? $kpi->delayed_m3_cistern : 'NULL',
				'delayed_value_water' => (isset($kpi->delayed_value_water)) ? $kpi->delayed_value_water : 'NULL',
				'delayed_kwh_energy' => (isset($kpi->delayed_kwh_energy)) ? $kpi->delayed_kwh_energy : 'NULL',
				'delayed_value_energy' => (isset($kpi->delayed_value_energy)) ? $kpi->delayed_value_energy : 'NULL',
				'delayed_total_recyclable' => (isset($kpi->delayed_total_recyclable)) ? $kpi->delayed_total_recyclable : 'NULL',
				'delayed_total_contaminated' => (isset($kpi->delayed_total_contaminated)) ? $kpi->delayed_total_contaminated : 'NULL',
				'unlocked' => (isset($kpi->unlocked)) ? $kpi->unlocked : 'NULL',
				'obs' => (isset($kpi->obs)) ? $kpi->obs : 'NULL',
				'iso14001' => (isset($kpi->iso14001)) ? $kpi->iso14001 : 'NULL',
				'iso14001_validate_date' => (isset($kpi->iso14001_validate_date)) ? $kpi->iso14001_validate_date : 'NULL',
				'iso14001_file' => (isset($kpi->iso14001_file)) ? $kpi->iso14001_file : 'NULL',
				'iso14001_file_path' => (isset($kpi->iso14001_file_path)) ? $kpi->iso14001_file_path : 'NULL',
				'inserted' => (isset($kpi->inserted)) ? $kpi->inserted : 'NULL',
				'water_file' => (isset($kpi->water_file)) ? $kpi->water_file : 'NULL',
				'water_file_path' => (isset($kpi->water_file_path)) ? $kpi->water_file_path : 'NULL',
				'energy_file' => (isset($kpi->energy_file)) ? $kpi->energy_file : 'NULL',
				'energy_file_path' => (isset($kpi->energy_file_path)) ? $kpi->energy_file_path : 'NULL',
				'me_goal_water' => (isset($kpi->me_goal_water)) ? $kpi->me_goal_water : 'NULL',
				'me_goal_energy' => (isset($kpi->me_goal_energy)) ? $kpi->me_goal_energy : 'NULL',
				'current' => (isset($kpi->current)) ? $kpi->current : 'NULL',
				'permission' => (isset($kpi->permission)) ? $kpi->permission : 'NULL'
			);

			$this->db->insert('tb_kpi', $arrayData);
		}
	}
}
