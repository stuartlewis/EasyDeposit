<?php

// Name:
// Description:
// Notes: 

require_once('easydeposit.php');

class Template extends EasyDeposit
{

    function __construct()
    {
        // Initalise the parent
        parent::__construct();
    }

    function index()
    {
        // Set the page title
        $data['page_title'] = 'Template';

        // Display the header, page, and footer
        $this->load->view('header', $data);
        $this->load->view('template');
        $this->load->view('footer');
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

    public static function _packagemultipart($package)
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