<?php

require_once('EasyDeposit.php');

class Admin extends EasyDeposit
{
    function Admin()
    {
        // State that this is an authentication class
        EasyDeposit::_adminInterface();

        // Initalise the parent
        parent::EasyDeposit();
    }

    function index()
    {
        // Set the page title
        $data['page_title'] = 'Administrative Interface';

        // Display the header, page, and footer
        $this->load->view('header', $data);
        $this->load->view('admin', $data);
        $this->load->view('footer');
    }

    function logout()
    {
        // Unset the admin session variable
        unset($_SESSION['easydeposit-admin-isadmin']);

        // Go to the home page
        redirect('/');
    }

}

?>