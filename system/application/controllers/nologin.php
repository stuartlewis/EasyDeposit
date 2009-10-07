<?php

require_once('EasyDeposit.php');

class Nologin extends EasyDeposit
{
    function Nologin()
    {
        // State that this is an authentication class
        EasyDeposit::_authN();

        // Initalise the parent
        parent::EasyDeposit();
    }

    function index()
    {
        // Set a random identifier and store it in the session
        $_SESSION['username'] = mt_rand();

        // Go to the next page
        $this->_gotonextstep();
    }

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

    public static function _id()
    {
        return $_SESSION['username'];
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