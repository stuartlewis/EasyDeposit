<?php

// Name: MultipleDeposit
// Description: Perform the SWORD package and deposit to multiple destinations
// Notes: This step creates the submission package, and then deposits it using SWORD

require_once('EasyDeposit.php');

class MultipleDeposit extends EasyDeposit
{

    function MultipleDeposit()
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
                if ($stepname == 'multipledeposit')
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
            $counter = 0;
            foreach ($_SESSION['depositurls'] as $depositurl)
            {
                $sac = new SWORDAPPClient();
                $contenttype = "application/zip";
                $format = "http://purl.org/net/sword-types/METSDSpaceSIP";
                $response = $sac->deposit($_SESSION['depositurls'][$counter],
                                          $_SESSION['sword-usernames'][$counter],
                                          $_SESSION['sword-passwords'][$counter],
                                          $_SESSION['sword-obos'][$counter],
                                          $this->config->item('easydeposit_deposit_packages') .
                                                  $this->userid . '.zip',
                                          $format,
                                          $contenttype);

                if (($response->sac_status == 200) || ($response->sac_status == 201))
                {
                    $_SESSION['deposited-response'][$counter] = $response->sac_xml;
                    $_SESSION['deposited-url'][$counter] = (string)$response->sac_id;
                }
                else
                {
                    $error .= 'For deposit URL ' . $_SESSION['depositurls'][$counter] . "\n";
                    $error .= 'Server returned status code: ' . $response->sac_status . "\n\n";
                    $error .= 'Server provided response: ' . $response->sac_xml . "\n\n";
                }
                $counter++;
            }
        }
        catch (Exception $e)
        {
            // Catch the exception for reporting
            $error = 'Error: ' . $e->getMessage() . "\n\n";
            $error .= 'Deposit URL: ' . $_SESSION['depositurls'][$counter] . "\n";
            $error .= 'Deposit username: ' . $_SESSION['sword-usernames'][$counter] . "\n";
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
        $message .= 'The URL of your items are:' . "\n";
        foreach ($_SESSION['deposited-url'][$counter] as $url)
        {
            $message .= ' - ' . $url . "\n";
        }
        $message.= "\n";
        return $message;
    }
}

?>