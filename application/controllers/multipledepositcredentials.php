<?php

// Name: MultipleDepositCredentials
// Description: Set some hardcoded deposit credentials (once per server to deposit to)
// Notes: Edit settings to set the deposit URLs / usernames / passwords / on-behalf-of

require_once('EasyDeposit.php');

class MultipleDepositCredentials extends EasyDeposit
{
     function MultipleDepositCredentials()
    {
        // Initalise the parent
        parent::__construct();
    }

    function index()
    {
        // Set the deposit credentials
        $_SESSION['depositurls'] = $this->config->item('easydeposit_multipledepositcredentials_depositurl');
        $_SESSION['sword-usernames'] = $this->config->item('easydeposit_multipledepositcredentials_username');
        $_SESSION['sword-passwords'] = $this->config->item('easydeposit_multipledepositcredentials_password');
        $_SESSION['sword-obos'] = $this->config->item('easydeposit_multipledepositcredentials_obo');

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
