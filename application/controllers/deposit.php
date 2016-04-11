<?php

// Name: Deposit
// Description: Perform the SWORD package and deposit
// Notes: This step creates the submission package, and then deposits it using SWORD

require_once('easydeposit.php');

class Deposit extends EasyDeposit
{

    function __construct()
    {
        // Initalise the parent
        parent::__construct();
    }

    function index()
    {
        // Variables to hold an error message and the XML SWORD deposit response

        $error = '';
        $response = '';

        // Check to see if the packager directory exists, and if not
        // make the directory to save the files in
        $path = str_replace('index.php', '', $_SERVER["SCRIPT_FILENAME"]);
        $id = $this->userid;
        $savepath = $path . $this->config->item('easydeposit_uploadfiles_savedir') . $id;
        if (!file_exists($savepath))
        {
            mkdir($savepath);
        }

        // Load the relevant packager
        $packager = $this->config->item('easydeposit_deposit_packager');
        $swordversion = $this->config->item('easydeposit_swordversion');
        require_once($this->_getswordlibrary() . '/' . $packager . '.php');
        if (($packager == 'packager_mets_swap') && ($swordversion == 1)) {
            $this->_depositmetsswap();
        } else if (($packager == 'packager_mets_swap') && ($swordversion == 2)) {
            $this->_depositmetsswapv2();
        } else if ($packager == 'packager_atom_multipart') {
            $this->_depositatommultipart();
        } else if ($packager == 'packager_atom_multipart_eprints') {
            $this->_depositatommultipart();
        } else if ($packager == 'packager_atom_twostep') {
            $this->_depositatomtwostep();
        }

        // Go to the next stage
        $this->_gotonextstep();
    }

    public static function _email($message)
    {
        // Add the URL if set
        if (!empty($_SESSION['deposited-url'])) {
            $message .= 'The URL of your item is ' . $_SESSION['deposited-url'] . "\n\n";
        }
        return $message;
    }

    private function _depositmetsswap()
    {
        $response = '';
        try
        {
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

            if (($response->sac_status >= 200) && ($response->sac_status < 300))
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

            $_SESSION['deposited-response'] = $error;
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
    }

    private function _depositatommultipart()
    {
        $response = '';
        try
        {
            $package = new PackagerAtomMultipart($this->config->item('easydeposit_uploadfiles_savedir'),
                $this->userid,
                $this->config->item('easydeposit_deposit_packages'),
                $this->userid . '.multipart');
            foreach ($this->easydeposit_steps as $stepname)
            {
                if ($stepname == 'deposit')
                {
                    break;
                }
                include_once(APPPATH . 'controllers/' . $stepname . '.php');
                $stepclass = ucfirst($stepname);
                call_user_func(array($stepclass, '_packagemultipart'), $package);
            }
            $package->create();

            // Deposit the package
            $sac = new SWORDAPPClient();
            $response = $sac->depositMultipart($_SESSION['depositurl'],
                                               $_SESSION['sword-username'],
                                               $_SESSION['sword-password'],
                                               $_SESSION['sword-obo'],
                                               $this->config->item('easydeposit_deposit_packages') . $this->userid . '.multipart',
                                               false);

            if (($response->sac_status >= 200) && ($response->sac_status < 300))
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

            $_SESSION['deposited-response'] = $error;
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
    }

    private function _depositatomtwostep()
    {
        $response = '';
        $editmediairi = '';
        try
        {
            $package = new PackagerAtomTwoStep($this->config->item('easydeposit_uploadfiles_savedir'),
                                               $this->userid,
                                               $this->config->item('easydeposit_deposit_packages'),
                                               $this->userid . '.multipart');

            foreach ($this->easydeposit_steps as $stepname)
            {
                if ($stepname == 'deposit')
                {
                    break;
                }
                include_once(APPPATH . 'controllers/' . $stepname . '.php');
                $stepclass = ucfirst($stepname);
                call_user_func(array($stepclass, '_packagemultipart'), $package);
            }
            $package->create();

            // Deposit the atom entry, leave 'in progress'
            $sac = new SWORDAPPClient();
            $response = $sac->depositAtomEntry($_SESSION['depositurl'],
                                               $_SESSION['sword-username'],
                                               $_SESSION['sword-password'],
                                               $_SESSION['sword-obo'],
                                               $this->config->item('easydeposit_deposit_packages') . $this->userid . '/atom',
                                               true);

            if (($response->sac_status >= 200) && ($response->sac_status < 300))
            {
                $_SESSION['deposited-response'] = $response->sac_xml;
                $_SESSION['deposited-url'] = (string)$response->sac_id;
                $editmediairi = $response->sac_edit_media_iri;
            }
            else
            {
                $error = 'Server returned status code: ' . $response->sac_status . "\n\n";
                $error .= 'Server provided response: ' . $response->sac_xml;
            }
echo '3';
            // Deposit each file
            $counter = 0;
            $inprogress = True;
            foreach ($package->getFiles() as $file) {
                echo $counter;
                $counter++;
                if ($counter == count($package->getFiles())) {
                    $inprogress = False;
                }
                $response = $sac->addExtraFileToMediaResource($editmediairi,
                                                              $_SESSION['sword-username'],
                                                              $_SESSION['sword-password'],
                                                              $_SESSION['sword-obo'],
                                                              $this->config->item('easydeposit_deposit_packages') . $this->userid . '/' . $file,
                                                              $inprogress);
            }

            $response = $sac->completeIncompleteDeposit($editmediairi,
                                                        $_SESSION['sword-username'],
                                                        $_SESSION['sword-password'],
                                                        $_SESSION['sword-obo']);
            echo '5';
            echo $response;
            die();

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

            $_SESSION['deposited-response'] = $error;
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
    }

}

?>