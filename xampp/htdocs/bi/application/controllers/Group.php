<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Model_Group');
	}

	public function index() {
		$data['content'] = 'index';
		$data['groups'] = $this->Model_Group->read();

		$this->load->view('model', $data);
		//$this->Model_Group->createGroup();
	}

	public function create(){
		$this->Model_Group->createGroup();
	}

	public function read(){
		var_dump($this->Model_Group->readGroup());
	}
}
