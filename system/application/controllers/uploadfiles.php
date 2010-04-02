<?php

require_once('EasyDeposit.php');

class UploadFiles extends EasyDeposit
{

    function UploadFiles()
    {
        // Initalise the parent
        parent::EasyDeposit();
    }

    function index()
    {
        // Get the number of files to allow to be uploaded
        $data['count'] = $this->config->item('easydeposit_uploadfiles_number');

        // Set the page title
        $data['page_title'] = 'Upload files';
        if ((empty($data['count'])) || ($data['count'] == 1))
        {
            $data['page_title'] = 'Upload file';                                       
        }       

        // Has a file been uploaded?
        if (!empty($_FILES))
        {
            // Find the path to this script
            $path = str_replace('index.php', '', $_SERVER["SCRIPT_FILENAME"]);

            // Make the directory to save the files in
            $id = $this->userid;
            $savepath = $path . $this->config->item('easydeposit_uploadfiles_savedir') . $id;
            if (file_exists($savepath))
            {
                $this->_rmdir_R($savepath);
            }
            mkdir($savepath);
            
            // Save the uploaded files
            $hasfile = false;
            $failed = false;
            $_SESSION['uploadfiles_filecounter'] = 0;
            for ($i = 1; $i <= $data['count']; $i++)
            {
                if ((isset($_FILES['file' . $i])) && (!empty($_FILES['file' . $i]['name'])))
                {
                    $hasfile = true;
                    $_SESSION['uploadfiles_filecounter']++;
                    $_SESSION['uploadfiles_filename' . $_SESSION['uploadfiles_filecounter']] = $_FILES['file' . $i]['name'];
                    $target = $savepath . '/' . $_SESSION['uploadfiles_filename' . $_SESSION['uploadfiles_filecounter']];
                    $ok = move_uploaded_file($_FILES['file' . $i]['tmp_name'], $target);
                    if (!$ok) $failed = true;
                    $_SESSION['uploadfiles_mime' . $_SESSION['uploadfiles_filecounter']] = $_FILES['file' . $i]['type'];
                    $_SESSION['uploadfiles_filesize' . $_SESSION['uploadfiles_filecounter']] = $_FILES['file' . $i]['size'] / 1024;
                }
            }

            if ($failed)
            {
                // Failed to upload for some reason
                $data['error'] = 'Please upload at least one file!';
                $this->load->view('header', $data);
                $this->load->view('uploadfiles', $data);
                $this->load->view('footer');
            }
            if (!$hasfile)
            {
                // Failed to upload for some reason
                $data['error'] = 'One of more of your files failed to upload successfully. Please try again.';
                $this->load->view('header', $data);
                $this->load->view('uploadfiles', $data);
                $this->load->view('footer');
            }
            else
            {
                // Everything OK, go to the next step
                $this->_gotonextstep();
            }
        }
        else
        {
            // Has the max upload size been hit? (100 is irrelevant - this won't change your max upload size)
            if ((array_key_exists('CONTENT_LENGTH', $_SERVER)) && ($_SERVER['CONTENT_LENGTH'] > 100))
            {
                $support = $this->config->item('easydeposit_supportemail');
                $data['error'] = 'The files that you uploaded were too large. Please contact ' . $support . ' for assistance.';
            }


            // Display the header, page, and footer
            $this->load->view('header', $data);
            $this->load->view('uploadfiles', $data);
            $this->load->view('footer');
        }
    }

    public static function _verify($data)
    {
        // List each of the files
        for ($i = 1; $i <= $_SESSION['uploadfiles_filecounter']; $i++)
        {
            $data[] = array('File', $_SESSION['uploadfiles_filename' . $i], 'uploadfiles', 'true');
        }
        return $data;
    }

    public static function _package($package)
    {
        // Add each of the files to the package
        for ($i = 1; $i <= $_SESSION['uploadfiles_filecounter']; $i++)
        {
            $package->addFile($_SESSION['uploadfiles_filename' . $i],
                              $_SESSION['uploadfiles_mime' . $i]);
        }
    }

    public static function _email($message)
    {
        // Add information about the files
        $message .= 'You have uploaded ' . $_SESSION['uploadfiles_filecounter'] . ' file';
        if ($_SESSION['uploadfiles_filecounter'] != '1')
        {
            $message .= 's';
        }
        $message .= ":\r\n";
        for ($i = 1; $i <= $_SESSION['uploadfiles_filecounter']; $i++)
        {
            $message .= " - " . $_SESSION['uploadfiles_filename' . $i] . "\n";
        }
        $message .= "\n";
        return $message;
    }

    function _rmdir_R($path)
    {
        // Delete any previously uploaded files
        $path = rtrim($path, '/') . '/';
        $handle = opendir($path);
        for (;FALSE !== ($file = readdir($handle));) {
                if ($file != "." and $file != "..") {
                        $fullpath = $path . $file;
                        if (is_dir($fullpath)) {
                                $this->_rmdir_R($fullpath);
                        } else {
                                unlink($fullpath);
                        }
                }
        }
        closedir($handle);
        return rmdir($path);
    }
}

?>