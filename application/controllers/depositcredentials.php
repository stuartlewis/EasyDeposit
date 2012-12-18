<?php

// Name: DepositCredentials
// Description: Set some hardcoded deposit credentials
// Notes: Edit settings to set the deposit URL / username / password / on-behalf-of

require_once('easydeposit.php');

class DepositCredentials extends EasyDeposit
{
     function DepositCredentials()
    {
        // Initalise the parent
        parent::__construct();
    }

    function index()
    {
        // Set the deposit credentials
        $_SESSION['depositurl'] = $this->config->item('easydeposit_depositcredentials_depositurl');
        $_SESSION['sword-username'] = $this->config->item('easydeposit_depositcredentials_username');
        $_SESSION['sword-password'] = $this->config->item('easydeposit_depositcredentials_password');
        $_SESSION['sword-obo'] = $this->config->item('easydeposit_depositcredentials_obo');

        // Go to the next page
        $this->_gotonextstep();
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
