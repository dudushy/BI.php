<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DK extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Model_DK');
	}

	public function index() {
		// $data['content'] = 'graph/index';

		// $this->load->view('model', $data);
	}
}
