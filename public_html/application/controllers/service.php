<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Service extends CI_Controller {
	
	function index($process = false) 
	{

		$process = $this->input->get('p');
		if(empty($process)) {
			$this->load->model('service_model','service');
			echo json_encode($this->service->getSliderNews());
		} else {
			header('Content-Type: application/json');
			echo $this->$process();
		}
	}
	
	private function load() {
		$start = $this->input->get('s');
		if(!empty($start)) {
			$this->load->model('service_model','service');
			return json_encode($this->service->loadNews($start));
		}
		return json_encode(array());
	}
	
	private function get() 
	{
		$this->load->model('service_model','service');
		return json_encode($this->service->getNews());
	}
	
	private function detail()
	{
		$id = $this->input->get('id');
		if(!empty($id)) {
			$this->load->model('service_model','service');
			return json_encode($this->service->newsDetail($id));
		}
		return json_encode(array());
	}
	
	private function category() 
	{
		$id = $this->input->get('idc');
		if(!empty($id)) {
			$this->load->model('service_model','service');
			return json_encode($this->service->getCategoryNews($id));
		}
		return json_encode(array());
	}
	
	private function loadCategory() 
	{
		$id 	= $this->input->get('idc');
		$start 	= $this->input->get('s');
		if(!empty($id)) {
			$this->load->model('service_model','service');
			return json_encode($this->service->getCategoryNews($id, $start));
		}
		return json_encode(array());
	}
	
	private function special() 
	{
		$widget	 = $this->input->get('w');
			$this->load->model('service_model','service');
		return json_encode($this->service->getSpecial($widget));
	}
	
	private function loadSpecial() 
	{
		$widget	 = $this->input->get('w');
		$start 	= $this->input->get('s');

		$this->load->model('service_model','service');
		return json_encode($this->service->getSpecial($widget, $start));

	}

}
