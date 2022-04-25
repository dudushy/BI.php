<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class KPI extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Model_KPI');
	}

	public function index() {
		$data['content'] = 'charts/index';

		$this->load->view('charts/kpi', $data);
	}

	public function get($com_id, $ano) {
		$response = $this->Model_KPI->get($com_id, $ano);
		echo $response;
	}

	public function create($ano, $mes){
		$this->Model_KPI->create($ano, $mes);
	}
}
