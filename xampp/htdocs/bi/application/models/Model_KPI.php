<?php

class Model_KPI extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
	}
}
