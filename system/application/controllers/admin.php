<?php

require_once('EasyDeposit.php');

class Admin extends EasyDeposit
{
    function Admin()
    {
        // State that this is an authentication class
        EasyDeposit::_adminInterface();

        // Initalise the parent
        parent::EasyDeposit();
    }

    function index()
    {
        // Set the page title
        $data['page_title'] = 'Administrative Interface';

        // See if we can write to the easydeposit.php config file
        if (!is_writable('system/application/config/easydeposit.php'))
        {
            $data['configwritewarning'] = true;
        }
        
        // Warn the user if they are using the default password
        if ($this->config->item('easydeposit_adminpassword') == '6da12e83ef06d1d59884a5ca724cbc75')
        {
            $data['defaultpasswordwarning'] = true;
        }

        // Display the header, page, and footer
        $this->load->view('header', $data);
        $this->load->view('admin/admin', $data);
        $this->load->view('footer');
    }

    function logout()
    {
        // Unset the admin session variable
        unset($_SESSION['easydeposit-admin-isadmin']);

        // Go to the home page
        redirect('/');
    }

    function credentials()
    {
        // Did the user click 'cancel'?
        if (isset($_POST['cancel']))
        {
            redirect('/admin');
        }

        // Set the current username
        $data['username'] = $this->config->item('easydeposit_adminusername');

        $this->form_validation->set_rules('username', 'Username', 'xss_clean|_clean|required');
        $this->form_validation->set_rules('oldpassword', 'Old password', 'xss_clean|_clean|callback__checkoldpassword|required');
        $this->form_validation->set_rules('newpassword', 'New password', 'xss_clean|_clean|required');
        if ($this->form_validation->run() == FALSE)
        {
            // Set the page title
            $data['page_title'] = 'Change the administrator username or password';

            // Display the header, page, and footer
            $this->load->view('header', $data);
            $this->load->view('admin/credentials', $data);
            $this->load->view('footer');
        }
        else
        {
            // Update the username and password
            $updates['easydeposit_adminusername'] = set_value('username');
            $updates['easydeposit_adminpassword'] = md5(set_value('newpassword'));
            $this->_updateconfigkeys($updates);
            
            // Go to the admin home page
            redirect('/admin');
        }
    }

    function _checkoldpassword($password)
    {
        // Get the username
        $username = $_POST['username'];

        // Check the username and password are correct
        if (md5($password) != $this->config->item('easydeposit_adminpassword'))
        {
            $this->form_validation->set_message('_checkoldpassword', 'Old password is incorrect');
            return FALSE;
        }

        // Must be OK
        return TRUE;
    }

    function _updateconfigkeys($updates)
    {
        // Open the config file to read
        $configin = fopen('system/application/config/easydeposit.php', 'r');
        $save = '';
        while (!feof($configin))
        {
            $line = trim(fgets($configin, 4096));
            foreach($updates as $key => $value)
            {
                if ((strpos($line, '$config[' . "'" . $key . "'" . ']') === 0) ||
                    (strpos($line, '$config["' . $key . '"]') === 0))
                {
                    $value = str_replace('"', '\"', $value);
                    $line = '$config[' . "'" . $key . "'" . '] = "' . $value . '";';
                }
            }
            if ($line == '?' . '>')
            {
                $save .= $line;
                break;
            }
            else
            {
                $save .= $line . "\n";
            }
        }
        @fclose($configin);

        // Save the config file
        file_put_contents('system/application/config/easydeposit.php', $save);
    }
}

?>