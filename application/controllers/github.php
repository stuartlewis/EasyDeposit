<?php

// Name: GitHub
// Description: Download then deposit a github repository
// Notes: None

require_once('easydeposit.php');

class GitHub extends EasyDeposit
{

    function __construct()
    {
        // Initalise the parent
        parent::__construct();
    }

    function index()
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

        // Validate the form
        $this->form_validation->set_rules('githuburl', 'GitHub URL', 'callback__clean|required|callback__getgithubrepo');
        if ($this->form_validation->run() == FALSE)
		{
            // Set the page data
            $data['page_title'] = 'Select GitHub Repository';
            if ((isset($_SESSION['external-referrer'])) && ((strpos($_SESSION['external-referrer'], 'https://github.com/') == 0))) {
                $data['githuburl'] = $_SESSION['external-referrer'];
            }

            // Display the header, page, and footer
            $this->load->view('header', $data);
            $this->load->view('github', $data);
            $this->load->view('footer');
		}
		else
		{
			// Go to the next page
            $this->_gotonextstep();
		}
    }

    public function _getgithubrepo($url)
    {
        if ($url == '')
        {
            return FALSE;
        }
        if (strpos($url, 'https://github.com/') === FALSE)
        {
            $this->form_validation->set_message('_getgithubrepo', 'Bad GitHub Repository name.  ' .
                                                'Must be in the form of https://github.com/{username}/{repository}');
            return FALSE;
        }
        $urlorig = $url;
        $url = $url . '/zip/master';
        $url = str_replace('https://', 'https://codeload.', $url);

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
        $_SESSION['uploadfiles_filecounter'] = 1;
        $_SESSION['uploadfiles_filename' . $_SESSION['uploadfiles_filecounter']] = 'master.zip';
        $target = $savepath . '/' . $_SESSION['uploadfiles_filename' . $_SESSION['uploadfiles_filecounter']];
        $ok = file_put_contents($target, file_get_contents($url));
        if (!$ok) $failed = true;
        $_SESSION['uploadfiles_mime' . $_SESSION['uploadfiles_filecounter']] = 'application/zip';
        $_SESSION['uploadfiles_filesize' . $_SESSION['uploadfiles_filecounter']] = filesize($target) / 1024;

        // Set some basic metadata
        $parts = explode('/', $urlorig);
        $_SESSION['metadata-title'] = $parts[4];
        $_SESSION['metadata-author'] = $parts[3];
        $_SESSION['metadata-link'] = $urlorig;

        // Download the latest commit ID
        $htmllocation = $urlorig . '/commit/master';
        $html = file_get_contents($htmllocation);
        $doc = new DOMDocument();
        @$doc->loadHTML($html);
        $nodes = $doc->getElementsByTagName('title');
        $title = $nodes->item(0)->nodeValue;
        $bits = explode('·', $title);
        $_SESSION['metadata-abstract'] = 'Commit: ' . $bits[0] . ' (' . $bits[1] . ')';

        return TRUE;
    }

    public static function _verify($data)
    {
        $data[] = array('Title', $_SESSION['metadata-title'], 'metadata', 'true');
        $data[] = array('Creator', $_SESSION['metadata-author'], 'metadata', 'true');
        $data[] = array('Abstract', $_SESSION['metadata-abstract'], 'metadata', 'true');
        $data[] = array('Link', $_SESSION['metadata-link'], 'metadata', 'true');

        // List each of the files
        for ($i = 1; $i <= $_SESSION['uploadfiles_filecounter']; $i++)
        {
            $data[] = array('File', $_SESSION['uploadfiles_filename' . $i], 'uploadfiles', 'true');
        }
        return $data;
    }

    public static function _package($package)
    {
        // Use the metadata in making the package
        $package->setTitle($_SESSION['metadata-title']);
        $package->addCreator($_SESSION['metadata-author']);
        $package->setAbstract($_SESSION['metadata-abstract']);
        $package->setIdentifier($_SESSION['metadata-link']);

        // Add each of the files to the package
        for ($i = 1; $i <= $_SESSION['uploadfiles_filecounter']; $i++)
        {
            $package->addFile($_SESSION['uploadfiles_filename' . $i],
                $_SESSION['uploadfiles_mime' . $i]);
        }
    }

    public static function _packagemultipart($package)
    {
        // Add each of the files to the package
        for ($i = 1; $i <= $_SESSION['uploadfiles_filecounter']; $i++)
        {
            $package->addFile($_SESSION['uploadfiles_filename' . $i]);
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