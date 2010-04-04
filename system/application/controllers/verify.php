<?php

// Name: Verify
// Description: Verify all the data entered in previous steps
// Notes: Typically used before the deposit step

require_once('EasyDeposit.php');

class Verify extends EasyDeposit
{

    function Verify()
    {
        // Initalise the parent
        parent::EasyDeposit();
    }

	function index()
    {
        // Set the page title
        $data['page_title'] = 'Verify';
        
        // Does the user want to modify something?
        if (!empty($_POST['modify']))
        {
            $_SESSION['returntostep'] = 'verify';
            $this->_gotostep($_POST['modify']);
        }

        // Go to the next step?
        if (!empty($_POST['ok']))
        {
            $this->_gotonextstep();
        }

        // Get the verification data for each step
        $verify = array();
        foreach ($this->easydeposit_steps as $stepname)
        {
            if ($stepname == 'verify')
            {
                break;
            }
            include_once(APPPATH . 'controllers/' . $stepname . '.php');
            $stepclass = ucfirst($stepname);
            $verify = call_user_func(array($stepclass, '_verify'), $verify);
        }  
        $data['verify'] = $verify;
        $data['id'] = $this->userid;
        $data['supportemail'] = $this->config->item('easydeposit_supportemail');
            
        // Display the header, page, and footer
		$this->load->view('header', $data);
		$this->load->view('verify', $data);
		$this->load->view('footer');
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