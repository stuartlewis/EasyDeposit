<?php

require_once('EasyDeposit.php');

class ServiceDocumentLogin extends EasyDeposit
{
    /**
     * Create the ServiceDocumentLogin class
     *
     * This is a login class which tries to authenticate a user by requesting
     * a service document. If the service document is retrieved successfully
     * then it is assumed the login against the repository was successful.
     *
     * You can use this login class to delegate authentication to your
     * repository.
     */
    function ServiceDocumentLogin()
    {
        // State that this is an authentication class
        EasyDeposit::_authN();

        // Initalise the parent
        parent::EasyDeposit();
    }

    /**
     * Just set the username as a random number.
     */
    function index()
    {
        // Add the servicedocument URL to the POST array, and add an empty obo
        $_POST['url'] = $this->config->item('easydeposit_servicedocumentlogin_url');
        $_POST['obo'] = '';

        // Try to validate the user
        $this->form_validation->set_rules('username', 'Username', 'xss_clean|callback__clean|required');
        $this->form_validation->set_rules('password', 'Password', 'xss_clean|callback__clean|required|callback__getservicedocument');
        if (((!isset($_POST['username'])) && (!isset($_POST['password']))) || ($this->form_validation->run() == FALSE))
        {
            // Set the page data
            $data['page_title'] = 'Login';

            // Display the header, page, and footer
            $this->load->view('header', $data);
            $this->load->view('servicedocumentlogin', $data);
            $this->load->view('footer');
        }
        else
        {
            // Append a random identifier to the login and store it in the session
            $_SESSION['username'] = $_POST['username'] . mt_rand();

            // Go to the next page
            $this->_gotonextstep();
        }
    }

    /**
     * If the username session variable is set, we assume that the
     * user is logged in.
     */
    public static function _loggedin()
    {
        if (!empty($_SESSION['username']))
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Return the user's random id.
     */
    public static function _id()
    {
        return $_SESSION['username'];
    }

    /**
     * Since the userid is random, nothing to verify about it.
     */
    public static function _verify($data)
    {
        // Nothing to do
        return $data;
    }

    /**
     * Since the userid is random, nothing to do with it.
     */
    public static function _package($package)
    {
        // Nothing to do
    }

    /**
     * Since the userid is random, nothing to email about it. 
     */
    public static function _email($message)
    {
        // Nothing to do
        return $message;
    }
}

?>