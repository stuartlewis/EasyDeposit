<?php

// Name: MultipleThankYou
// Description: Prints a thank you message to the user at the end of the multiple submission process
// Notes: Typically the last step in a submission process. Can also be used to display an error if a deposit failed

require_once('easydeposit.php');

class MultipleThankYou extends EasyDeposit
{
    function MultipleThankYou()
    {
        // Initalise the parent
        parent::__construct();
    }

    function index()
    {
        // Set the page title
        $data['page_title'] = 'Thank you';

        // Set the message to thank the user
        if (isset($_SESSION['deposited-url']))
        {
            $data['ok'] = TRUE;
        }
        else
        {
            $data['ok'] = FALSE;
        }
        $data['id'] = $this->userid;
        $data['supportemail'] = $this->config->item('easydeposit_supportemail');

        // Display the header, page, and footer
        $this->load->view('header', $data);
        $this->load->view('multiplethankyou', $data);
        $this->load->view('footer');

        // Clear the session data so they can submit again
	    session_destroy();
    }

}

?>