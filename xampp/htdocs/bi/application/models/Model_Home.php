<?php

class Model_Home extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function readGroup() {
		$query = $this->db->query("SELECT * FROM tb_group");
		return $query->result();
	}

	public function getToken($username, $password) {
		$data = json_encode(array(
			'username' => $username,
			'password' => $password
		));

		$url = json_decode(file_get_contents("ignore/help.json"), true)['api_url']['auth'];

		$ch = curl_init($url);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json'
		));
		
		$result = json_decode(curl_exec($ch), true);

		curl_close($ch);

		return $result;
	}

	public function login($username, $password, $token) {
		echo "<hr>username: " . $username . "<br>password: " . $password . "<br>token: " . $token;

		$data = json_encode(array(
			'username' => $username,
			'password' => $password
		));

		echo "<hr>data:<br><br>";
		var_dump($data);

		$url = json_decode(file_get_contents("ignore/help.json"), true)['api_url']['login'];

		$ch = curl_init($url);

		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Authorization: Bearer ' . $token
		));

		$result = json_decode(curl_exec($ch), true);
		echo "<hr>result:<br><br>";
		var_dump($result);

		curl_close($ch);

		return $result;
	}
}
