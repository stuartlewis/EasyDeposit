<?php

// Name: Metadata
// Description: Select some standard metadata for journal articles
// Notes: Collects title, up to three authors, abstract, type, peer review status, citation and link

require_once('EasyDeposit.php');

class Metadata extends EasyDeposit
{

    function Metadata()
    {
        // Initalise the parent
        parent::__construct();
    }

    function index()
    {
        // Prepoulate some session variables
        $_SESSION['metadata-peerreviewed'] = '';
        $_SESSION['metadata-type'] = '';

        // Validate the form
        $this->form_validation->set_rules('title', 'Title', '_clean|required');
        $this->form_validation->set_rules('author1', 'First author', '_clean|required');
        $this->form_validation->set_rules('author2', 'Second author', '_clean');
        $this->form_validation->set_rules('author3', 'Third author', '_clean');
        $this->form_validation->set_rules('abstract', 'Abstract', '_clean');
        $this->form_validation->set_rules('type', 'Type', '_clean|required');
        $this->form_validation->set_rules('peerreviewed', 'Peer review status', '_clean|required');
        $this->form_validation->set_rules('citation', 'Bibliographic citation', '_clean');
        $this->form_validation->set_rules('link', 'Link', '_clean');
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
            $_SESSION['metadata-title'] = $_POST['title'];
            $_SESSION['metadata-author1'] = $_POST['author1'];
            $_SESSION['metadata-author2'] = $_POST['author2'];
            $_SESSION['metadata-author3'] = $_POST['author3'];
            $_SESSION['metadata-abstract'] = $_POST['abstract'];

            $types = $this->config->item('easydeposit_metadata_itemtypes');
            $_SESSION['metadata-type'] = $types[$_POST['type']];

            $peer = $this->config->item('easydeposit_metadata_peerreviewstatus');
            $_SESSION['metadata-peerreviewed'] = $peer[$_POST['peerreviewed']];
            $_SESSION['metadata-citation'] = $_POST['citation'];
            $_SESSION['metadata-link'] = $_POST['link'];

            // Go to the next page
            $this->_gotonextstep();
        }
    }

    public static function _verify($data)
    {
        // Verify the metadata that has been stored
        $data[] = array('Title', $_SESSION['metadata-title'], 'metadata', 'true');
        $data[] = array('Author 1', $_SESSION['metadata-author1'], 'metadata', 'true');
        if (!empty($_SESSION['metadata-author2']))
        {
            $data[] = array('Author 2', $_SESSION['metadata-author2'], 'metadata', 'true');
        }
        if (!empty($_SESSION['metadata-author3']))
        {
            $data[] = array('Author 3', $_SESSION['metadata-author3'], 'metadata', 'true');
        }
        if (!empty($_SESSION['metadata-abstract']))
        {
            $data[] = array('Abstract', $_SESSION['metadata-abstract'], 'metadata', 'true');
        }
        $data[] = array('Type of item', $_SESSION['metadata-type'], 'metadata', 'true');
        $data[] = array('Has the item been peer reviewed?', $_SESSION['metadata-peerreviewed'], 'metadata', 'true');
        if (!empty($_SESSION['metadata-citation']))
        {
            $data[] = array('Bibliographic citation', $_SESSION['metadata-citation'], 'metadata', 'true');
        }
        if (!empty($_SESSION['metadata-link']))
        {
            $data[] = array('Link', $_SESSION['metadata-link'], 'metadata', 'true');
        }

        return $data;
    }

    public static function _package($package)
    {
        // Use the metadata in making the package
        $package->setTitle($_SESSION['metadata-title']);
        $package->addCreator($_SESSION['metadata-author1']);
        if (!empty($_SESSION['metadata-author2']))
        {
            $package->addCreator($_SESSION['metadata-author2']);
        }
        if (!empty($_SESSION['metadata-author3']))
        {
            $package->addCreator($_SESSION['metadata-author3']);
        }
        if (!empty($_SESSION['metadata-abstract']))
        {
            $package->setAbstract($_SESSION['metadata-abstract']);
        }
        $data[] = array('Type of item', $_SESSION['metadata-type'], 'metadata', 'true');
        $data[] = array('Has the item been peer reviewed?', $_SESSION['metadata-peerreviewed'], 'metadata', 'true');
        if (!empty($_SESSION['metadata-citation']))
        {
            $package->setCitation($_SESSION['metadata-citation']);
        }
        if (!empty($_SESSION['metadata-link']))
        {
            $package->setIdentifier($_SESSION['metadata-link']);
        }
    }

    public static function _email($message)
    {
        // Add the details
        $message .= "Thank you for depositing an electronic copy of your item '" . $_SESSION['metadata-title']. ":\n";
        $message .= ' - Author: ' . $_SESSION['metadata-author1'] . "\n";
        if (!empty($_SESSION['metadata-author2']))
        {
            $message .= ' - Author 2: ' . $_SESSION['metadata-author2'] . "\n";
        }
        if (!empty($_SESSION['metadata-author3']))
        {
            $message .= ' - Author 3: ' . $_SESSION['metadata-author3'] . "\n";
        }
        if (!empty($_SESSION['metadata-abstract']))
        {
            $message .= ' - Abstract: ' . $_SESSION['metadata-abstract'] . "\n";
        }
        if (!empty($_SESSION['metadata-citation']))
        {
            $message .= ' - Citation: ' . $_SESSION['metadata-citation'] . "\n";
        }
        if (!empty($_SESSION['metadata-link']))
        {
            $message .= ' - Link: ' . $_SESSION['metadata-link'] . "\n";
        }
        $message .= "\n";

        return $message;
    }
}

?>