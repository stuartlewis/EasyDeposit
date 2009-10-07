<?php

class Welcome extends Controller {

	function Welcome()
	{
		parent::Controller();	
	}
	
	function index()
	{
		$data['page_title'] = 'EasyDeposit client';
		$this->load->view('header', $data);
		$this->load->view('welcome_message');
		$this->load->view('footer');
	}
}

?>