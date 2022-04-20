<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Model_Company');
	}

	public function index() {
		$data['content'] = 'index';
		$data['companies'] = $this->Model_Company->readCompany();

		$this->load->view('model', $data);
		//$this->Model_Company->createCompany();
	}

	public function create(){
		$this->Model_Company->createCompany();
	}

	public function read(){
		var_dump($this->Model_Company->readCompany());
	}
}
