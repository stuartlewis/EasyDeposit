<?php

require_once('EasyDeposit.php');

class LDAPLogin extends EasyDeposit
{
    /**
     * Create the LDAPLogin class
     *
     * This is a login class which allows users to authenticate against an
     * LDAP server. The user id is set to be the netid with a random number
     * appended to allow multiple deposits by the same user.
     */
    function LDAPLogin()
    {
        // State that this is an authentication class
        EasyDeposit::_authN();

        // Initalise the parent
        parent::EasyDeposit();
    }

    /**
     * The index page. If a netid and password are given they are used to
     * attempt a login. The ldap login is performed as a Codeigniter validation
     * rule 'callback__ldaplogin' which uses the _ldaplogin function.
     *
     * If authentication is succesful, the next step is shown.
     */
    function index()
    {
        // Validate the form
        $netidname = $this->config->item('easydeposit_ldaplogin_netidname');
        $this->form_validation->set_rules('netid', $netidname, 'xss_clean|_clean|callback__ldaplogin|required');
        $data['netidname'] = $netidname;
        if ($this->form_validation->run() == FALSE)
        {
            // Set the page title
            $data['page_title'] = 'Login';

            // Display the header, page, and footer
            $this->load->view('header', $data);
            $this->load->view('ldaplogin', $data);
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
        $data[] = array('Author', $_SESSION['user-firstname'] . ' ' . $_SESSION['user-surname'], 'ldaplogin', 'false');
        return $data;
    }

    public static function _package($package)
    {
        // Set the author name
        $package->setCustodian($_SESSION['user-surname'] . ', ' . $_SESSION['user-firstname']);
        $package->addCreator($_SESSION['user-surname'] . ', ' . $_SESSION['user-firstname']);
    }

    /**
     * Greet the user in any emails by their name from LDAP.
     */
    public static function _email($message)
    {
        // Add the greeting
        $message .= 'Dear ' . $_SESSION['user-firstname'] . "\n\n";
        return $message;
    }

    /**
     * Perform the LDAP login
     */
    function _ldaplogin($netid)
    {
        try {
            // Bind to the DAP server using the user's credentials
            $password = $_POST['password'];
            $ldaphost = $this->config->item('easydeposit_ldaplogin_server');
            $ldapcontext = $this->config->item('easydeposit_ldaplogin_context');
            $ldap = ldap_connect($ldaphost);
            ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
            $bind = @ldap_bind($ldap, "cn=$netid,$ldapcontext", $password);

            // Search for the user by their netid
            $searchresult = @ldap_search($ldap, $ldapcontext, "cn=$netid");
            $items = @ldap_get_entries($ldap, $searchresult);

            // If no items are returned, the login must have been bad
            if ($items['count'] == 0)
            {
                $this->form_validation->set_message('_ldaplogin', 'Bad ' .
                                                    $this->config->item('easydeposit_ldaplogin_netidname') .
                                                    ' or password');
                return FALSE;
            }
            else
            {
                // Store the user data in the session
                $firstname = $items[0]["givenname"][0];
                $surname = $items[0]["sn"][0];
                $email = $items[0]["mail"][0];
                $_SESSION['user-firstname'] = $firstname;
                $_SESSION['user-surname'] = $surname;
                $_SESSION['user-email'] = $email;

                // Constuct a username made up of the netid and a random number
                // (this allows them to make multiple deposits without overwriting
                //  their old deposit files)
                $_SESSION['username'] = $netid . mt_rand();
                return TRUE;
            }
        }
        catch (Exception $exception)
        {
            // Something went wrong with connecting to LDAP
            $this->form_validation->set_message('_ldaplogin', 'Unable to connect to login server');
            return FALSE;
        }
    }
}

?>