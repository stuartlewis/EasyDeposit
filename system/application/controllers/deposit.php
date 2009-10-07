<?php

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
                $_SESSION['deposited-url'] = '' . $response->sac_id; // have to concat '' so it is treated as a str and not a simplexml element
            }
        }
        catch (Exception $e)
        {
            // Nothing to do - later pages will handle this
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