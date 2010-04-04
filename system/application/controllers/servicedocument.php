<?php

// Name: ServiceDocument
// Description: Display a Service Document to a user to allow them to select the deposit collection
// Notes: Typically follows the SelectRepository or RetrieveServiceDocument step

require_once('EasyDeposit.php');

class ServiceDocument extends EasyDeposit
{

    function ServiceDocument()
    {
        // Initalise the parent
        parent::EasyDeposit();
    }

    function index()
    {
        // Validate the form (get a new service document if required)
        if (!empty($_POST['url']))
        {
            $this->form_validation->set_rules('url', 'Url', 'callback__getservicedocument');
            $this->form_validation->run();
        }
        else if (!empty($_POST['depositurl']))
        {
		    // Remember the deposit URL
            $_SESSION['depositurl'] = $_POST['depositurl'];

            // Go to the next page
            $this->_gotonextstep();
        }
        else
        {
            // Load the service document from the session
            $servicedocument = new SWORDAPPServiceDocument($_SESSION['servicedocumenturl'],
                                                           $_SESSION['servicedocumentstatuscode'],
                                                           $_SESSION['servicedocumentxml']);
            $data['servicedocument'] = $servicedocument;
            $data['username'] = $_SESSION['sword-username'];
            $data['password'] = $_SESSION['sword-password'];
            $data['obo'] = $_SESSION['sword-obo'];

            // Load javascripts
            $data['javascript'] = array('mootools1.2.js', 'mootools1.2-more.js', 'toggle-o-matic.js');

            // Set the page title
            $data['page_title'] = 'Select a collection';

            // Display the header, page, and footer
            $this->load->view('header', $data);
            $this->load->view('servicedocument', $data);
            $this->load->view('footer');
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
