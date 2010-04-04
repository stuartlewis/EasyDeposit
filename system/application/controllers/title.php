<?php

// Name: Title
// Description: Set a title for the item being deposited
// Notes: Useful if you want to minimise the amount of metadata collected by the user, if the repository manager will complete the rest of the metadata later

require_once('EasyDeposit.php');

class Title extends EasyDeposit
{

    function Title()
    {
        // Initalise the parent
        parent::EasyDeposit();
    }

    function index()
    {
        // Validate the form
        $this->form_validation->set_rules('title', 'Title', 'xss_clean|_clean|required');
        if ($this->form_validation->run() == FALSE)
        {
            // Set the page title
            $data['page_title'] = 'Describe your item';

            // Display the header, page, and footer
            $this->load->view('header', $data);
            $this->load->view('metadata');
            $this->load->view('footer');
        }
        else
        {
            // Store the metadata in the session
            $_SESSION['metadata-title'] = $this->input->xss_clean($_POST['title']);

            // Go to the next page
            $this->_gotonextstep();
        }
    }

    public static function _verify($data)
    {
        $data[] = array('Title', $_SESSION['metadata-title'], 'title', 'true');
        return $data;
    }

    public static function _package($package)
    {
        $package->setTitle($_SESSION['metadata-title']);
    }

    public static function _email($message)
    {
        // Add the URL
        $message .= "Thank you for depositing an electronic copy of your item '" . $_SESSION['metadata-title']. "'.\n\n";
        return $message;
    }
}

?>