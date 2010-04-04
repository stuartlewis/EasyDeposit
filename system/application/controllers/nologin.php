<?php

// Name: NoLogin
// Description: Do not require the user to log in and authenticate
// Notes: A random number is used for the user ID

require_once('EasyDeposit.php');

class Nologin extends EasyDeposit
{
    /**
     * Create the NoLogin class
     *
     * This is a login class which is invisible to the user and sets a random
     * userid (a random number generated with mt_rand). If you don't want
     * users to have to login to use the system, make use of this login class.
     */
    function Nologin()
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
        // Set a random identifier and store it in the session
        $_SESSION['username'] = mt_rand();

        // Go to the next page
        $this->_gotonextstep();
    }

    /**
     * If the username' session variable is set, we assume that the
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