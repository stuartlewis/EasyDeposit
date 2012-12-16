<?php

// Name: SelectRepository
// Description: Select a repository from a pre-defined list, or by entering a new URL
// Notes: Edit settings to set the list of Service Documents

require_once('easydeposit.php');

class SelectRepository extends EasyDeposit
{

    function SelectRepository()
    {
        // Initalise the parent
        parent::__construct();
    }

    function index()
    {
        // Validate the form
        $this->form_validation->set_rules('url', 'URL', '_clean|required|is_natural');
        $this->form_validation->set_rules('username', 'Username', 'callback__clean|required');
        $this->form_validation->set_rules('password', 'Password', 'callback__clean|required|callback__getservicedocument');
        if ($this->form_validation->run() == FALSE)
		{
            // Set the page data
            $data['page_title'] = 'Connect to a repository';
		
            // Display the header, page, and footer
            $this->load->view('header', $data);
            $this->load->view('selectrepository', $data);
            $this->load->view('footer');
		}
		else
		{
			// Go to the next page
            $this->_gotonextstep();
		}
    }

    public static function _verify($data)
    {
        // Nothing to do
        return $data;
    }

    public static function _package($package)
    {
        // Nothing to do
    }

    public static function _email($message)
    {
        // Nothing to do
        return $message;
    }
}

?>