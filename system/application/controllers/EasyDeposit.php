<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('system/libraries/Controller.php');

/**
 * EasyDeposit master Application Controller Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Stuart Lewis
 */
class EasyDeposit extends Controller {

    // The order of steps to follow
    var $easydeposit_steps;

    // The username of the current user
    var $userid;

    // Whether this step is an authentication step
    var $authN = false;

    // Whether this step is part of the administrative interface
    var $adminInterface = false;

    // Whether this step is should skip any integrity checks
    var $noChecks = false;

    // The description of this step
    var $description;

    // Notes associated with this step
    var $notes;

    /**
     * Constructor
     *
     */
    function EasyDeposit()
    {
        // Initalise the parent
        parent::Controller();
            
        // Load the SWORD config
        $this->config->load('easydeposit');

        // Get and validate the steps
        $this->easydeposit_steps = $this->config->item('easydeposit_steps');
        if (empty($this->easydeposit_steps))
        {
            show_error('Empty configuration setting: easydeposit_steps');
        }
        foreach ($this->easydeposit_steps as $stepname)
        {
            // Check the step exists as a class
            if (!file_exists('system/application/controllers/' . $stepname . '.php'))
            {
                show_error('Error in configuration setting: invald step name  - ' .
                           $this->_clean($stepname));
            }
            // Using class_exists would have been better, but this seemed to mess
            // with the PHP class loader and cause a LogicException
        }

        // Load some helpers required for user and step validation
        $this->load->helper(array('form', 'url'));            

        // Turn the sessions on
        // Restrict the session to the base url of this instance in case multiple
        // instances are installed on the same domain
        $sessionhost = substr(base_url(), 7, strpos(base_url(), '/', 7) - 7);
        $sessionpath = substr(base_url(), strpos(base_url(), '/', 8));
        session_set_cookie_params(1800, $sessionpath, $sessionhost);
        session_start();

        // Check the user is logged in, else redirect them to the first step
        if ($this->adminInterface)
        {
            // Check the user is logged in as an admin
            if (empty($_SESSION['easydeposit-admin-isadmin-' . base_url()]))
            {
                redirect('/adminlogin');
            }
        }
        else if ($this->noChecks) {
            // Do nothing... let the user right though
            // This is used for thr admin interface login page, and any other
            // pages that you do not wish to be protected by the admin password
            // or the normal checks that ensure the user isn't messing with the
            // order of the steps.
        }
        else if (!$this->authN)
        {
            // Check the user is authenticated
            include_once(APPPATH . 'controllers/' . $this->easydeposit_steps[0] . '.php');
            $loginclass = ucfirst($this->easydeposit_steps[0]);
            if (!call_user_func(array($loginclass, '_loggedin')))
            {
                redirect('/' . $this->easydeposit_steps[0]);
            }
   
            // Check that a user isn't trying to jump to a step that they shouldn't be
            if ((empty($_SESSION['currentstep'])) || (!in_array(strtolower(get_class($this)), $this->easydeposit_steps)))
            {
                // No current step, or invalid step selected,
                // so set the step to be the first page, and send them there
                $_SESSION['currentstep'] = $this->easydeposit_steps[0];
                if (strtolower(get_class($this)) != $this->easydeposit_steps[0])
                {
                    redirect('/' . $this->easydeposit_steps[0]);
                }
            }
            else
            {
                // They are trying to access the wrong step, so send them to the right one
                if (strtolower(get_class($this)) != $_SESSION['currentstep'])
                {
                    redirect('/' . $_SESSION['currentstep']);
                }
            }

            // Everything is OK so set the user id
            include_once(APPPATH . 'controllers/' . $this->easydeposit_steps[0] . '.php');
            $loginclass = ucfirst($this->easydeposit_steps[0]);
            $this->userid = call_user_func(array($loginclass, '_id'));
        }
        else
        {
            // Check the user isn't trying to use an invalid authentication step
            if (strtolower(get_class($this)) != $this->easydeposit_steps[0])
            {
                redirect('/' . $this->easydeposit_steps[0]);
            }        
        }

        // Load some more helpers
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        require_once($this->config->item('easydeposit_librarylocation') . '/swordappclient.php');
    }

    function index()
    {
        // Go to the first step page
        redirect('/' . $this->easydeposit_steps[0] . '/');
    }

    function _gotonextstep()
    {
        if (!empty($_SESSION['returntostep']))
        {
            $goto = $_SESSION['returntostep'];
            unset($_SESSION['returntostep']);
            $_SESSION['currentstep'] = $goto;
            redirect('/' . $goto . '/');
        }
        else
        {
            $counter = 0;
            foreach ($this->easydeposit_steps as $stepname)
            {
                $counter++;
                if (strtolower(get_class($this)) == $stepname)
                {
                    $_SESSION['currentstep'] = $this->easydeposit_steps[$counter];
                    redirect('/' . $this->easydeposit_steps[$counter] . '/');
                }
            }
        }
    }

    function _gotostep($goto)
    {
        $counter = 0;
        foreach ($this->easydeposit_steps as $stepname)
        {
            if ($goto == $stepname)
            {
                $_SESSION['currentstep'] = $this->easydeposit_steps[$counter];
                redirect('/' . $this->easydeposit_steps[$counter] . '/');
            }
            $counter++;        
        }
    }

    function _describeself()
    {
        $self['name'] = get_class($this);
        $self['description'] = description;
        $self['notes'] = notes;
        return $self;                
    }

    function _clean($in)
    {
        // Clean up any input
        $in = strip_tags($in);
        $in = htmlentities($in);
        $in = trim($in);
        return $in;
    }

    function _authN()
    {
        $this->authN = true;
    }

    function _adminInterface()
    {
        $this->adminInterface = true;
    }

    function _noChecks()
    {
        $this->noChecks = true;
    }

    function _getservicedocument($str)
    {
        // Clear out old session data related to the service document
        $_SESSION['servicedocumenturl'] = '';
        $_SESSION['servicedocumentxml'] = '';
        $_SESSION['servicedocumentstatuscode'] = '';

        // Try and get the service document
        // If we succeed, store the xml in the SESSION for future steps
        // If we fail, report so
        try {
            $swordappclient = new SWORDAPPClient();
            $urls = $this->config->item('easydeposit_selectrepository_list');
            $url = $_POST['url'];
            $url = str_replace('/client/client/', '/client/', $url);

            if (is_numeric($_POST['url']))
            {
                $url = $urls[$_POST['url']];
            }
            $servicedocument = $swordappclient->servicedocument($url,
                                                                $_POST['username'],
                                                                $_POST['password'],
                                                                $_POST['obo']);
                
            if ($servicedocument->sac_status == 200)
            {
                // Store the service document in the session
                $_SESSION['servicedocumenturl'] = $url;
                $_SESSION['servicedocumentxml'] = $servicedocument->sac_xml;
                $_SESSION['servicedocumentstatuscode'] = $servicedocument->sac_status;

                // Store the username / password / obo in the session
                $_SESSION['sword-username'] = $_POST['username'];
                $_SESSION['sword-password'] = $_POST['password'];
                $_SESSION['sword-obo'] = $_POST['obo'];

                return TRUE;
            }
            else
            {
                $this->form_validation->set_message('_getservicedocument', $servicedocument->sac_statusmessage);
                return FALSE;
            }
        }
        catch (Exception $e)
        {
            $this->form_validation->set_message('_getservicedocument',
                                                'An error occured when trying to parse the service document: ' . $e);
            return FALSE;
        }
    }

}