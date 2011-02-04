<?php

require_once('EasyDeposit.php');

class Admin extends EasyDeposit
{
    function Admin()
    {
        // State that this is an authentication class
        EasyDeposit::_adminInterface();

        // Initalise the parent
        parent::__construct();
    }

    function index()
    {
        // Set the page title
        $data['page_title'] = 'Menu';

        // Warn the user if they are using the default password
        if ($this->config->item('easydeposit_adminpassword') == '6da12e83ef06d1d59884a5ca724cbc75')
        {
            $data['defaultpasswordwarning'] = true;
        }

        // Display the header, page, and footer
        $this->load->view('admin/header', $data);
        $this->load->view('admin/admin', $data);
        $this->load->view('admin/footer');
    }

    function logout()
    {
        // Unset the admin session variable
        unset($_SESSION['easydeposit-admin-isadmin-' . base_url()]);

        // Go to the home page
        redirect('/');
    }

    function steps()
    {
        // Set the page title
        $data['page_title'] = 'Configure deposit steps';

        // Set the steps for display
        $steps = $this->config->item('easydeposit_steps');
        $stepcounter = 0;
        foreach ($steps as $step)
        {
            // Get the details of the step
            $data['currentsteps'][$stepcounter++] = $step;
        }

        // Look up details of each step
        if ($controllers = opendir('application/controllers'))
        {
            while (($controller = readdir($controllers)) !== FALSE)
            {
                if (strstr($controller, '.php') == '.php')
                {
                    $stepcode = fopen('application/controllers/' . $controller, 'r');
                    $classname = str_replace('.php', '', $controller);
                    while (!feof($stepcode))
                    {
                        $line = trim(fgets($stepcode, 4096));
                        if (strpos($line, '// Name: ') === 0)
                        {
                            $data['allsteps'][$classname]['name'] = substr($line, 9);
                        }
                        else if (strpos($line, '// Description: ') === 0)
                        {
                            $data['allsteps'][$classname]['description'] = substr($line, 15);
                        }
                        else if (strpos($line, '// Notes: ') === 0)
                        {
                            $data['allsteps'][$classname]['notes'] = substr($line, 10);
                        }
                    }
                    fclose($stepcode);
                }
            }
            closedir($controllers);
        }

        // Display the header, page, and footer
        $this->load->view('admin/header', $data);
        $this->load->view('admin/steps', $data);
        $this->load->view('admin/footer');
    }

    function arrangesteps()
    {
        // What is the function we want to perform, and on which step?
        $mode = $this->uri->segment(3);
        $step = $this->uri->segment(4);

        // Add a new step
        if ($mode == 'add')
        {
            $steps = $this->config->item('easydeposit_steps');
            array_push($steps, strtolower($step));
            $updates['array_easydeposit_steps'] = $steps;
            $this->_updateconfigkeys($updates);

        }

        // Delete a step
        else if ($mode == 'delete')
        {
            $steps = $this->config->item('easydeposit_steps');
            unset($steps[$this->uri->segment(5)]);
            $updates['array_easydeposit_steps'] = $steps;
            $this->_updateconfigkeys($updates);
        }

        // Move a step up
        else if ($mode == 'up')
        {
            $steps = $this->config->item('easydeposit_steps');
            $temp = $steps[$this->uri->segment(5)];
            $steps[$this->uri->segment(5)] = $steps[($this->uri->segment(5) - 1)];
            $steps[($this->uri->segment(5) - 1)] = $temp;
            $updates['array_easydeposit_steps'] = $steps;
            $this->_updateconfigkeys($updates);
        }

        // Move a step down
        else if ($mode == 'down')
        {
            $steps = $this->config->item('easydeposit_steps');
            $temp = $steps[$this->uri->segment(5)];
            $steps[$this->uri->segment(5)] = $steps[($this->uri->segment(5) + 1)];
            $steps[($this->uri->segment(5) + 1)] = $temp;
            $updates['array_easydeposit_steps'] = $steps;
            $this->_updateconfigkeys($updates);
        }

        // Go back to the steps screen
        redirect('/admin/steps');
    }

    function editstepsettings()
    {
        // Did the user click 'cancel'?
        if (isset($_POST['cancel']))
        {
            redirect('/admin/arrangesteps');
        }

        // The step we're dealing with
        $step = $this->uri->segment(3);

        // Did the user click update?
        if (isset($_POST['submit']))
        {
            // Any updates - we'll record them as we go along, but only
            // commit them if all the validation passes OK
            $updates = array();

            // Look for each field we need to validate
            foreach ($_POST as $field => $value)
            {
                // Field definitions begin with define-
                if (strpos($field, 'define-') === 0)
                {
                    // Get the actual field name
                    $fieldname = substr($field, 7);

                    // What type is it?
                    if ($value == 'string')
                    {
                        // A nice easy String!

                        // Is it 'required'?
                        if (!empty($_POST['required-' . $fieldname]))
                        {
                            // Is it a directory?
                            if (!empty($_POST['directory-' . $fieldname]))
                            {
                                $this->form_validation->set_rules($fieldname, $_POST['description-' . $fieldname], '_clean|required|callback__isdirectory');
                            }
                            else
                            {
                                $this->form_validation->set_rules($fieldname, $_POST['description-' . $fieldname], '_clean|required');
                            }
                        }
                        else
                        {
                            // Is it a directory?
                            if (!empty($_POST['directory-' . $fieldname]))
                            {
                                $this->form_validation->set_rules($fieldname, $_POST['description-' . $fieldname], '_clean|callback__isdirectory');
                            }
                            else
                            {
                                $this->form_validation->set_rules($fieldname, $_POST['description-' . $fieldname], '_clean');
                            }
                        }

                        // Record the update
                        $updates['string_easydeposit_' . $step . '_' . $fieldname] = str_replace(array("\n","\r","\r\n"), '\\n', $_POST[$fieldname]);
                    }
                    else if ($value == 'array')
                    {
                        // An array of Strings
                        $this->form_validation->set_rules($fieldname, $_POST['description-' . $fieldname], '_clean');
                        $updates['array_easydeposit_' . $step . '_' . $fieldname] = explode("\n", $_POST[$fieldname]);
                    }
                    else if ($value == 'assocarray')
                    {
                        // An associative array of Strings
                        $assoc = array();
                        foreach (explode("\n", $_POST[$fieldname]) as $line)
                        {
                            if (trim($line) != '')
                            {
                                $assockey = trim(substr($line, 0, strpos($line, ' ')));
                                $assocvalue = trim(substr($line, strpos($line, ' ') + 1));
                                $assoc[$assockey] = $assocvalue;
                            }
                        }
                        $this->form_validation->set_rules($fieldname, $_POST['description-' . $fieldname], '_clean');
                        $updates['assoc_easydeposit_' . $step . '_' . $fieldname] = $assoc;
                    }
                }
            }
            if ($this->form_validation->run() != FALSE)
            {
                // Update any updated config keys
                $this->_updateconfigkeys($updates);

                // Go to the steps config page
                redirect('/admin/steps');
            }
        }

        // Load any config options for this step
        $data['stepname'] = $step;
        $configoptions = array();
        foreach ($this->config->config as $key => $value)
        {
            if (strpos($key, 'easydeposit_' . $step . '_') === 0)
            {
                $configoptions[str_replace('easydeposit_' . $step . '_', '', $key)] = $value;
            }
        }
        $data['configoptions'] = $configoptions;

        // Set the page title
        $data['page_title'] = 'Edit step settings (' . $step . ')';

        // Display the header, page, and footer
        $this->load->view('admin/header', $data);
        $this->load->view('config/' . $step, $data);
        $this->load->view('admin/footer');
    }

    function editwelcome()
    {
        // Edit the welcome message
        $this->_edit('editwelcome',
                     'application/views/welcome_message.php',
                     'application/views/defaults/welcome_message.php',
                     'Welcome screen',
                     true,
                     $this->config->item('easydeposit_welcome_title'));
    }

    function editheader()
    {
        // Edit the header
        $this->_edit('editheader',
                     'application/views/header.php',
                     'application/views/defaults/header.php',
                     'header',
                     false);
    }

    function editfooter()
    {
        // Edit the footer
        $this->_edit('editfooter',
                     'application/views/footer.php',
                     'application/views/defaults/footer.php',
                     'footer',
                      false);
    }

    function editcss()
    {
        // Edit the CSS file
        $this->_edit('editcss',
                     'css/style.css',
                     'application/views/defaults/style.css',
                     'CSS',
                      false);
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

        $this->form_validation->set_rules('username', 'Username', '_clean|required');
        $this->form_validation->set_rules('oldpassword', 'Old password', '_clean|callback__checkoldpassword|required');
        $this->form_validation->set_rules('newpassword', 'New password', '_clean|required');
        if ($this->form_validation->run() == FALSE)
        {
            // Set the page title
            $data['page_title'] = 'Change the administrator username or password';

            // Display the header, page, and footer
            $this->load->view('admin/header', $data);
            $this->load->view('admin/credentials', $data);
            $this->load->view('admin/footer');
        }
        else
        {
            // Update the username and password
            $updates['string_easydeposit_adminusername'] = set_value('username');
            $updates['string_easydeposit_adminpassword'] = md5(set_value('newpassword'));
            $this->_updateconfigkeys($updates);

            // Go to the admin home page
            redirect('/admin');
        }
    }

    function coresettings()
    {
        // Set the page title
        $data['page_title'] = 'Edit the core settings';

        // Set the current setting values
        $data['supportemail'] = $this->config->item('easydeposit_supportemail');
        $data['librarylocation'] = $this->config->item('easydeposit_librarylocation');                

        // Display the header, page, and footer
        $this->load->view('admin/header', $data);
        $this->load->view('admin/coresettings', $data);
        $this->load->view('admin/footer');
    }

    function supportemail()
    {
        // Did the user click 'cancel'?
        if (isset($_POST['cancel']))
        {
            redirect('/admin/coresettings');
        }

        // Set the current username
        $data['supportemail'] = $this->config->item('easydeposit_supportemail');

        $this->form_validation->set_rules('supportemail', 'Support Email', '_clean|required');
        if ($this->form_validation->run() == FALSE)
        {
            // Set the page title
            $data['page_title'] = 'Change the support email address';

            // Display the header, page, and footer
            $this->load->view('admin/header', $data);
            $this->load->view('admin/supportemail', $data);
            $this->load->view('admin/footer');
        }
        else
        {
            // Update the support email
            $updates['string_easydeposit_supportemail'] = set_value('supportemail');
            $this->_updateconfigkeys($updates);

            // Go to the core settings page
            redirect('/admin/coresettings');
        }
    }

    function librarylocation()
    {
        // Did the user click 'cancel'?
        if (isset($_POST['cancel']))
        {
            redirect('/admin/coresettings');
        }

        // Set the current username
        $data['librarylocation'] = $this->config->item('easydeposit_librarylocation');

        $this->form_validation->set_rules('librarylocation', 'SWORDAPP PHP Library Location', '_clean|callback__checkswordappapi|required');
        if ($this->form_validation->run() == FALSE)
        {
            // Set the page title
            $data['page_title'] = 'Change the location of the SWORDAPP PHP Library';

            // Display the header, page, and footer
            $this->load->view('admin/header', $data);
            $this->load->view('admin/librarylocation', $data);
            $this->load->view('admin/footer');
        }
        else
        {
            // Update the support email
            $updates['string_easydeposit_librarylocation'] = set_value('librarylocation');
            $this->_updateconfigkeys($updates);

            // Go to the core settings page
            redirect('/admin/coresettings');
        }
    }

    function systemcheck()
    {
        // Set the page title
        $data['page_title'] = 'System check';

        // See if we can write to the easydeposit.php config file
        $data['configwritewarning'] = false;
        if (!is_writable('application/config/easydeposit.php'))
        {
            $data['configwritewarning'] = true;
        }

        // See if we can write to the file upload directory
        $path = str_replace('index.php', '', $_SERVER["SCRIPT_FILENAME"]);
        $savepath = $path . $this->config->item('easydeposit_uploadfiles_savedir');
        $data['uploadlocation'] = $savepath;
        $data['uploadwritewarning'] = false;
        if (!is_writable($savepath))
        {
            $data['uploadwritewarning'] = true;
        }

        // See if we can write to the package upload directory
        $path = str_replace('index.php', '', $_SERVER["SCRIPT_FILENAME"]);
        $savepath = $path . $this->config->item('easydeposit_deposit_packages');
        $data['packagelocation'] = $savepath;
        $data['packagewritewarning'] = false;
        if (!is_writable($savepath))
        {
            $data['packagewritewarning'] = true;
        }

        // Warn the user if they are using the default password
        $data['defaultpasswordwarning'] = false;
        if ($this->config->item('easydeposit_adminpassword') == '6da12e83ef06d1d59884a5ca724cbc75')
        {
            $data['defaultpasswordwarning'] = true;
        }

        // Is the curl function available
        $data['curlfunctionwarning'] = false;
        if (!function_exists('curl_exec'))
        {
            $data['curlfunctionwarning'] = true;
        }

        // Is the curl function available
        $data['sxmlfunctionwarning'] = false;
        if (!function_exists('simplexml_load_string'))
        {
            $data['sxmlfunctionwarning'] = true;
        }

        // Is the zip function available
        $data['zipfunctionwarning'] = false;
        if (!function_exists('zip_open'))
        {
            $data['zipfunctionwarning'] = true;
        }

        // Is the ldap function available
        $data['ldapfunctionwarning'] = false;
        if (!function_exists('ldap_connect'))
        {
            $data['ldapfunctionwarning'] = true;
        }

        // Display the header, page, and footer
        $this->load->view('admin/header', $data);
        $this->load->view('admin/systemcheck', $data);
        $this->load->view('admin/footer');
    }

    function _edit($method, $filename, $default, $description, $html, $title = "")
    {
        // Did the user click 'cancel'?
        if (isset($_POST['cancel']))
        {
            redirect('/admin');
        }

        $this->form_validation->set_rules('content', $description, 'required');
        if (($this->form_validation->run() == FALSE) || (isset($_POST['revert'])))
        {
            // Set the page title
            $data['page_title'] = 'Edit the ' . $description . ' content';
            
            // Decide if the page requires a title to be set
            $data['title'] = $title;

            // Load javascript
            if ($html)
            {
                $data['javascript'] = array('tiny_mce/tiny_mce.js');
                $data['tinymce'] = true;
            }

            // Load the current code  or revert to original?
            if (isset($_POST['revert']))
            {
                $data['html'] = file_get_contents($default);
            }
            else
            {
                $data['html'] = file_get_contents($filename);
            }

            // Check we can write to the file
            if (is_writable($filename))
            {
                $data['canwrite'] = true;
            }
            else
            {
                $data['filename'] = $filename;
            }

            // Allow the view to redirect back to the right form
            $data['method'] = $method;

            // Display the header, page, and footer
            $this->load->view('admin/header', $data);
            $this->load->view('admin/edit', $data);
            $this->load->view('admin/footer');
        }
        else
        {
            // Update the content
            $content = html_entity_decode(set_value('content'));
            $content = str_replace('&#39;', "'", $content);
            file_put_contents($filename, $content);

            // Does the title need setting?
            if (!empty($_POST['title']))
            {
                $updates['string_easydeposit_welcome_title'] = $_POST['title'];;
                $this->_updateconfigkeys($updates);   
            }

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

    function _checkswordappapi($apipath)
    {
        // Check the file exists
        if (!file_exists($apipath . '/swordappclient.php')) {
            $this->form_validation->set_message('_checkswordappapi', 'SWORDAPP API Library not found at <em>' . $apipath . '</em>');
            return FALSE;
        }

        // Must be OK
        return TRUE;
    }

    function _isdirectory($dir)
    {
        // Does it contain a trailing slash?
        if ((substr_compare($dir, '/', strlen($dir) - 1) !== 0) &&
            (substr_compare($dir, '\\', strlen($dir) - 1) !== 0))
        {
            $this->form_validation->set_message('_isdirectory', 'Path does not end with a slash');
            return FALSE;
        }

        // Is it a directory?
        if (!is_dir($dir))
        {
            $this->form_validation->set_message('_isdirectory', $dir . ' is not a directory');
            return FALSE;
        }

        // Is it writeable?
        if (!is_writeable($dir))
        {
            $this->form_validation->set_message('_isdirectory', $dir . ' is not writeable by the web server');
            return FALSE;
        }

        return TRUE;
    }
    
    function _updateconfigkeys($updates)
    {
        // As a small bit of protection, make sure the user is an admin
        if (empty($_SESSION['easydeposit-admin-isadmin-' . base_url()])) {
            return;
        }

        // Open the config file to read
        $configin = fopen('application/config/easydeposit.php', 'r');
        $save = '';
        while (!feof($configin))
        {
            $line = trim(fgets($configin, 4096));
            foreach($updates as $key => $value)
            {
                // Work out the type
                $type = 'string';
                if (strpos($key, 'array_') === 0)
                {
                    $type = 'array';
                    $key = substr($key, 6);
                }
                else if (strpos($key, 'assoc_') === 0)
                {
                    $type = 'assoc';
                    $key = substr($key, 6);
                }
                else
                {
                    $key = substr($key, 7);    
                }

                if ((strpos($line, '$config[' . "'" . $key . "'" . ']') === 0) ||
                    (strpos($line, '$config["' . $key . '"]') === 0))
                {
                    if ($type == 'assoc') {
                        $output = 'array(';
                        $counter = 0;
                        foreach ($value as $bit => $bitvalue)
                        {
                            if ((trim($bit) != '') && (trim($bitvalue) != '')) {
                                $output .= "'" . $bit . "' => '" . $bitvalue . "'";
                                $counter++;
                                if ($counter < count($value))
                                {
                                    $output .= ', ';
                                }
                            }
                        }
                        $output .= ');';
                        $line = '$config[' . "'" . $key . "'" . '] = ' . $output;
                    }
                    else if ($type == 'array')
                    {
                        $output = 'array(';
                        $counter = 0;
                        foreach ($value as $bit)
                        {
                            if (trim($bit) != '') {
                                $output .= "'" . $bit . "'";
                                $counter++;
                                if ($counter < count($value))
                                {
                                    $output .= ', ';
                                }
                            }
                        }
                        $output .= ');';
                        $line = '$config[' . "'" . $key . "'" . '] = ' . $output;
                    }
                    else
                    {
                        $value = str_replace('"', '\"', $value);
                        $value = str_replace('&quot;', '\"', $value);
                        $line = '$config[' . "'" . $key . "'" . '] = "' . $value . '";';
                    }
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
        file_put_contents('application/config/easydeposit.php', $save);
    }
}

?>
