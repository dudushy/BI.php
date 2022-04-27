<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DK extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Model_DK');
	}

	public function index() {
		$data['content'] = 'charts/index';

		$this->load->view('charts/dk', $data);
	}

	public function getCompanyGroups($area_id) {
		$response = $this->Model_DK->getCompanyGroups($area_id);
		echo $response;
	}

	public function createCompanyGroups($area_id){
		$this->Model_DK->createCompanyGroups($area_id);
	}

	public function getCompany($period, $parent_item_id, $area_id) {
		$response = $this->Model_DK->getCompany($period, $parent_item_id, $area_id);
		echo $response;
	}

	public function createCompany($period, $parent_item_id, $area_id){
		$this->Model_DK->createCompany($period, $parent_item_id, $area_id);
	}

	public function getChapter($period, $parent_item_id, $area_id) {
		$response = $this->Model_DK->getChapter($period, $parent_item_id, $area_id);
		echo $response;
	}

	public function createChapter($period, $parent_item_id, $area_id){
		$this->Model_DK->createChapter($period, $parent_item_id, $area_id);
	}
}
