<?php

require_once('EasyDeposit.php');

class RetrieveServiceDocument extends EasyDeposit
{

    /**
     * Retrieve a service document from a repository using a pre-configured
     * set of credentials from the easydeposit.php configuration file
     */
    function RetrieveServiceDocument()
    {
        // Initalise the parent
        parent::EasyDeposit();
    }

    /**
     * Retrieve the service document using credentials from the easydeposit.php
     * config file
     */
    function index()
    {
        // Load a service document
        $_POST['username'] = $this->config->item('easydeposit_retrieveservicedocument_username');
        $_POST['password'] = $this->config->item('easydeposit_retrieveservicedocument_password');
        $_POST['obo'] = $this->config->item('easydeposit_retrieveservicedocument_obo');
        $_POST['url'] = $this->config->item('easydeposit_retrieveservicedocument_url');
        $this->_getservicedocument('');
        
        // Go to the next step
        $this->_gotonextstep();
    }

    /**
     * No data to verify
     */
    public static function _verify($data)
    {
        // Nothing to do
        return $data;
    }

    /**
     * Nothing to add to the package
     */
    public static function _package($package)
    {
        // Nothing to do
    }

    /**
     * Nothing to add to the email
     */
    public static function _email($message)
    {
        // Nothing to do
        return $message;
    }
}

?>