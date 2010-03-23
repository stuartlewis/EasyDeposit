<?php

require_once('EasyDeposit.php');

class AdminLogin extends EasyDeposit
{
    function AdminLogin()
    {
        // State that this is an authentication class
        EasyDeposit::_noChecks();

        // Initalise the parent
        parent::EasyDeposit();
    }

    function index()
    {
        // Validate the form
        $this->form_validation->set_rules('username', 'Username', 'xss_clean|_clean|required');
        $this->form_validation->set_rules('password', 'Password', 'xss_clean|_clean|callback__adminlogin|required');
        if ($this->form_validation->run() == FALSE)
        {
            // Set the page title
            $data['page_title'] = 'Login to the Administrative Interface';

            // Display the header, page, and footer
            $this->load->view('header', $data);
            $this->load->view('adminlogin', $data);
            $this->load->view('footer');
        }
        else
        {
            // Record the fact they are logged in
            $_SESSION['easydeposit-admin-isadmin'] = true;

            // Go to the admin home page
            redirect('/admin');
        }
    }

    function _adminlogin($password)
    {
        // Get the username
        $username = $_POST['username'];

        // Check the username and password are correct
        if (($username != $this->config->item('easydeposit_adminusername')) ||
            (md5($password) != $this->config->item('easydeposit_adminpassword')))
        {
            $this->form_validation->set_message('_adminlogin', 'Bad username or password');
            return FALSE;
        }

        // Must be OK
        return TRUE;
    }
}

?>