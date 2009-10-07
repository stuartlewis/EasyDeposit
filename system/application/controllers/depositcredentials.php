<?php

require_once('EasyDeposit.php');

class DepositCredentials extends EasyDeposit
{
     function DepositCredentials()
    {
        // Initalise the parent
        parent::EasyDeposit();
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

    public static function _email($message)
    {
        // Nothing to do
        return $message;
    }
}

?>
