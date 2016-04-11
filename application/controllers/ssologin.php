<?php

// Name: SSOLogin
// Description: Authenticates users against an external Single-Sign-On (SSO) system
// Notes: Configure the HTTP headers to examine

require_once('easydeposit.php');

class SSOLogin extends EasyDeposit
{
    /**
     * Create the SSOLogin class
     *
     * This is a login class that authenticates using the REMOTE_USER header.
     * The user id is set to be the REMOTE_USER with a random number
     * appended to allow multiple deposits by the same user.
     */
    function __construct()
    {
        // State that this is an authentication class
        EasyDeposit::_authN();

        // Initalise the parent
        parent::__construct();
    }

    /**
     * The index page. Check the user details are there - if not, show
     * an error page - this is a non-recoverable error.
     *
     * If authentication is successful, the next step is shown.
     */
    function index()
    {
        // Hopefully we have a user
        if (isset($_SERVER[$this->config->item('easydeposit_ssologin_username')]))
        {
            $_SESSION['username'] = $_SERVER[$this->config->item('easydeposit_ssologin_username')] . '-' . mt_rand();
        }
        if (isset($_SERVER[$this->config->item('easydeposit_ssologin_firstname')]))
        {
            $_SESSION['user-firstname'] = $_SERVER[$this->config->item('easydeposit_ssologin_firstname')];
        }
        if (isset($_SERVER[$this->config->item('easydeposit_ssologin_surname')]))
        {
            $_SESSION['user-surname'] = $_SERVER[$this->config->item('easydeposit_ssologin_surname')];
        }
        if (isset($_SERVER[$this->config->item('easydeposit_ssologin_email')]))
        {
            $_SESSION['user-email'] = $_SERVER[$this->config->item('easydeposit_ssologin_email')];
        }
            
        if ((empty($_SESSION['username'])) ||
            (empty($_SESSION['user-firstname'])) ||
            (empty($_SESSION['user-surname'])) ||
            (empty($_SESSION['user-email'])))
        {
            // Set the page title
            $data['page_title'] = 'An error has occurred';
            $data['supportemail'] = $this->config->item('easydeposit_supportemail');

            // Display the header, page, and footer
            $this->load->view('header', $data);
            $this->load->view('ssologin');
            $this->load->view('footer');
        }
        else
        {
            // Go to the next page
            $this->_gotonextstep();
        }
    }

    /**
     * If the 'username' session variable is set, we assume that the
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
     * Return the user's username. This is the netid with the
     * random number appended.
     */
    public static function _id()
    {
        return $_SESSION['username'];
    }

    /**
     * Show the username in the verify screen, but because it is provided by
     * LDAP we don't allow it to be edited.
     */
    public static function _verify($data)
    {
        // Confirm username, but don't allow it to be edited
        $data[] = array('Author', $_SESSION['user-firstname'] . ' ' . $_SESSION['user-surname'], 'ssologin', 'false');
        return $data;
    }

    public static function _package($package)
    {
        // Set the author name
        $package->setCustodian($_SESSION['user-surname'] . ', ' . $_SESSION['user-firstname']);
        $package->addCreator($_SESSION['user-surname'] . ', ' . $_SESSION['user-firstname']);
    }

    public static function _packagemultipart($package)
    {
        // Do nothing
    }

    /**
     * Greet the user in any emails by their name from SSO.
     */
    public static function _email($message)
    {
        // Add the greeting
        $message .= 'Dear ' . $_SESSION['user-firstname'] . "\n\n";
        return $message;
    }

}

?>