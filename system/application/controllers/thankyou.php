<?php

// Name: ThankYou
// Description: Proves a thank you message to the user at the end of the submission process
// Notes: Typically the last step in a submission process. Can also be used to display an error if the deposit failed

require_once('EasyDeposit.php');

class ThankYou extends EasyDeposit
{
    function ThankYou()
    {
        // Initalise the parent
        parent::EasyDeposit();
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
        $this->load->view('thankyou', $data);
        $this->load->view('footer');

        // Clear the session data so they can submit again
	    session_destroy();
    }

}

?>