<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Model_Company');
	}

	public function index() {
		$data['content'] = 'index';
		$data['companies'] = $this->Model_Company->read();

		$this->load->view('model', $data);
	}

	public function createAll() {
		$this->Model_Company->createAll();
	}

	public function create($grupo_id){
		$this->Model_Company->create($grupo_id);
		echo "companies created.";
	}

	public function read(){
		var_dump($this->Model_Company->read());
	}

	public function get() {
		$response = $this->Model_Company->readByName();
		echo json_encode($response);
	}

	public function getByGrpId($grupo_id) {
		$response = $this->Model_Company->readByGrpId($grupo_id);
		echo json_encode($response);
	}
}
