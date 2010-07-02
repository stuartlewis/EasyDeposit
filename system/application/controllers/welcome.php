<?php

class Welcome extends Controller {

    function Welcome()
    {
        parent::Controller();	
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
