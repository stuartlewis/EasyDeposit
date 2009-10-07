<?php

require_once('EasyDeposit.php');

class LDAPLogin extends EasyDeposit
{
    function LDAPLogin()
    {
        // State that this is an authentication class
        EasyDeposit::_authN();

        // Initalise the parent
        parent::EsyDeposit();
    }

    function index()
    {
        // Validate the form
        $netidname = $this->config->item('swordconfig_ldaplogin_netidname');
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

    public static function _email($message)
    {
        // Add the greeting
        $message .= 'Dear ' . $_SESSION['user-firstname'] . "\n\n";
        return $message;
    }

    function _ldaplogin($netid)
    {
        try {
            $password = $_POST['password'];
            $ldaphost = $this->config->item('easydeposit_ldaplogin_server');
            $ldapcontext = $this->config->item('easydeposit_ldaplogin_context');
            $ldap = ldap_connect($ldaphost);
            ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
            $bind = @ldap_bind($ldap, "cn=$netid,$ldapcontext", $password);
            $searchresult = @ldap_search($ldap, $ldapcontext, "cn=$netid");
            $items = @ldap_get_entries($ldap, $searchresult);
            if ($items['count'] == 0)
            {
                $this->form_validation->set_message('_ldaplogin', 'Bad ' .
                                                    $this->config->item('easydeposit_ldaplogin_netidname') .
                                                    ' or password');
                return FALSE;
            }
            else
            {
                $firstname = $items[0]["givenname"][0];
                $surname = $items[0]["sn"][0];
                $email = $items[0]["mail"][0];
                $_SESSION['user-firstname'] = $firstname;
                $_SESSION['user-surname'] = $surname;
                $_SESSION['user-email'] = $email;

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
