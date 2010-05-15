<?php

// Name: Deposit
// Description: Perform the SWORD package and deposit
// Notes: This step creates the submission package, and then deposits it using SWORD

require_once('EasyDeposit.php');

class Deposit extends EasyDeposit
{

    function Deposit()
    {
        // Initalise the parent
        parent::EasyDeposit();
    }

    function index()
    {
        // A variable to hold an error message
        $error = '';

        try
        {
            // Allow each step to contribute to the package
            require_once($this->config->item('easydeposit_librarylocation') . '/packager_mets_swap.php');
            $package = new PackagerMetsSwap($this->config->item('easydeposit_uploadfiles_savedir'),
                                            $this->userid,
                                            $this->config->item('easydeposit_deposit_packages'),
                                            $this->userid . '.zip');
            foreach ($this->easydeposit_steps as $stepname)
            {
                if ($stepname == 'deposit')
                {
                    break;
                }
                include_once(APPPATH . 'controllers/' . $stepname . '.php');
                $stepclass = ucfirst($stepname);
                call_user_func(array($stepclass, '_package'), $package);
            }
            $package->create();

            // Deposit the package
            require_once($this->config->item('easydeposit_librarylocation') . '/swordappclient.php');
            $sac = new SWORDAPPClient();
            $contenttype = "application/zip";
            $format = "http://purl.org/net/sword-types/METSDSpaceSIP";
            $response = $sac->deposit($_SESSION['depositurl'],
                                      $_SESSION['sword-username'],
                                      $_SESSION['sword-password'],
                                      $_SESSION['sword-obo'],
                                      $this->config->item('easydeposit_deposit_packages') .
                                              $this->userid . '.zip',
                                      $format,
                                      $contenttype);

            if (($response->sac_status == 200) || ($response->sac_status == 201))
            {
                $_SESSION['deposited-response'] = $response->sac_xml;
                $_SESSION['deposited-url'] = (string)$response->sac_id;
            }
            else
            {
                $error = 'Server returned status code: ' . $response->sac_status . "\n\n";
                $error .= 'Server provided response: ' . $response->sac_xml;
            }
        }
        catch (Exception $e)
        {
            // Catch the exception for reporting
            $error = 'Error: ' . $e->getMessage() . "\n\n";
            $error .= 'Deposit URL: ' . $_SESSION['depositurl'] . "\n";
            $error .= 'Deposit username: ' . $_SESSION['sword-username'] . "\n";
            $error .= 'Package file: ' . $this->config->item('easydeposit_deposit_packages') . $this->userid . '.zip' . "\n";                                                         

            if (!empty($response->sac_xml))
            {
                $error .= "\n\nResponse:" . $response->sac_xml;
            }
        }

        // If there was an error, send it to the administrator
        if (!empty($error))
        {
            $to = $this->config->item('easydeposit_supportemail');
            $subject = 'Error with EasyDeposit system';
            $headers = 'From: ' . $to . ' <' . $to . ">\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/plain; charset=utf-8\r\n";
            $headers .= "Content-Transfer-Encoding: quoted-printable\r\n";
            mail($to, $subject, $error, $headers);
        }

        // Go to the next stage
        $this->_gotonextstep();
    }

    public static function _email($message)
    {
        // Add the URL
        $message .= 'The URL of your item is ' . $_SESSION['deposited-url'] . "\n\n";
        return $message;
    }
}

?>