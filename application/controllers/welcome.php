<?php

class Welcome extends CI_Controller {

    function __construct()
    {
        parent::__construct();	
    }
	
    function index()
    {
        // Load the EasyDeposit config
        $this->config->load('easydeposit');

        // Create the page
        $data['page_title'] = $this->config->item('easydeposit_welcome_title');
        $this->load->view('header', $data);
        $this->load->view('welcome_message');
        $this->load->view('footer');
    }
}

?>
