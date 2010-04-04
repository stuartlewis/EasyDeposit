<?php

// Name: CrossRefDOILookup
// Description: Lookup metadata for a DOI using the CrossRef API
// Notes: This step must be followed by the CrossRefDOIMetadata step

require_once('EasyDeposit.php');

class CrossRefDOILookup extends EasyDeposit
{
    function CrossRefDOILookup()
    {
        // Initalise the parent
        parent::EasyDeposit();
    }

    function index()
    {
        // Set the page title
        $data['page_title'] = 'Enter DOI';

        // Validate the form
        $this->form_validation->set_rules('doi', 'DOI', 'xss_clean|_clean|callback__lookupdoi|required');
        if (!empty($_POST['doi'])) $_SESSION['crossref-doi'] = $_POST['doi'];
        if ($this->form_validation->run() == FALSE)
        {
            // Display the header, page, and footer
            $_SESSION['crossrefdoilookup_ok'] = false;
            $this->load->view('header', $data);
            $this->load->view('crossrefdoilookup');
            $this->load->view('footer');
        }
        else
        {
            // Go to the next stage
            $this->_gotonextstep();
        }
    }

    /**
     * Lookup the DOI from the crossref site
     */
    function _lookupdoi($doi)
    {
        // Get the API key from the config file
        $apikey = $this->config->item('easydeposit_crossrefdoilookup_apikey');

        // Check the DOI is in the correct format (strip any http prefix)
        $doi = str_replace('http://dx.doi.org/', '', $doi);
        if (strpos($doi, '10.') !== 0)
        {
            $this->form_validation->set_message('_lookupdoi', 'Bad DOI');
            return FALSE;
        }

        // Get the DOI, throw an error if we can't connect
        if (!$response = file_get_contents('http://www.crossref.org/openurl/?id=doi:' . $doi .
                                          '&noredirect=true&format=unixref&pid=' . $apikey))
        {
            $this->form_validation->set_message('_lookupdoi', 'Error connecting to CrossRef');
            return FALSE;
        }

        // An example of a response, useful if developing or debugging offline
        //$response = '<doi_records xmlns="http://www.crossref.org/xschema/1.1" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.crossref.org/xschema/1.1 http://www.crossref.org/schema/unixref1.1.xsd http://www.crossref.org/xschema/1.0 http://www.crossref.org/schema/unixref1.0.xsd"><doi_record xmlns="http://www.crossref.org/xschema/1.0" owner="10.1108" timestamp="2009-10-10 07:01:10.0"><crossref><journal><journal_metadata language="en"><full_title>Program: electronic library and information systems</full_title><abbrev_title>Program: electronic library and information systems</abbrev_title><issn media_type="print">0033-0337</issn></journal_metadata><journal_issue><publication_date media_type="print"><year>2009</year></publication_date><journal_volume><volume>43</volume></journal_volume><issue>4</issue></journal_issue><journal_article publication_type="full_text"><titles><title>If SWORD is the answer, what is the question?: Use of the Simple Web-service Offering Repository Deposit protocol</title></titles><contributors><person_name sequence="first" contributor_role="author"><given_name>Stuart</given_name><surname>Lewis</surname></person_name><person_name sequence="additional" contributor_role="author"><given_name>Leonie</given_name><surname>Hayes</surname></person_name><person_name sequence="additional" contributor_role="author"><given_name>Vanessa</given_name><surname>Newton-Wade</surname></person_name><person_name sequence="additional" contributor_role="author"><given_name>Antony</given_name><surname>Corfield</surname></person_name><person_name sequence="additional" contributor_role="author"><given_name>Richard</given_name><surname>Davis</surname></person_name><person_name sequence="additional" contributor_role="author"><given_name>Tim</given_name><surname>Donohue</surname></person_name><person_name sequence="additional" contributor_role="author"><given_name>Scott</given_name><surname>Wilson</surname></person_name></contributors><publication_date media_type="print"><year>2009</year></publication_date><pages><first_page>407</first_page><last_page>418</last_page></pages><doi_data><doi>10.1108/00330330910998057</doi><resource>http://www.emeraldinsight.com/10.1108/00330330910998057</resource></doi_data><citation_list/></journal_article></journal></crossref></doi_record></doi_records>';

        // Parse and process the xml
        $xml = new SimpleXMLElement($response);
        $error =  $xml->children()->doi_record->crossref->error;
        if (!empty($error))
        {
            $this->form_validation->set_message('_lookupdoi', $error);
            return FALSE;   
        }
        
        // Looks like we have a match, so process it
        $record =  $xml->children()->doi_record->crossref->journal;
        $_SESSION['crossrefdoi-title'] = $record->journal_article->titles->title . '';
        $contributors = $record->journal_article->contributors;
        $authorcount = 0;
        foreach ($contributors->person_name as $contributor)
        {
            $_SESSION['crossrefdoi-author' . ++$authorcount] = $contributor->surname . ', ' . $contributor->given_name;
        }
        $_SESSION['crossrefdoi-authorcount'] = $authorcount;
        $_SESSION['crossrefdoi-year'] = $record->journal_article->publication_date->year . '';
        $_SESSION['crossrefdoi-journaltitle'] = $record->journal_metadata->full_title . '';
        $pstart = $record->journal_article->pages->first_page;
        $pend = $record->journal_article->pages->last_page;
        $pages = '';
        if (!empty($pstart))
        {
            $pages = $pstart;
            if (!empty($pend))
            {
                $pages .= '-' . $pend;
            }
        }
        $_SESSION['crossrefdoi-volume'] = $record->journal_issue->journal_volume->volume . '';
        $_SESSION['crossrefdoi-issue'] = $record->journal_issue->issue . '';

        return TRUE;

    }

    public static function _verify($data)
    {
        // No metadata to verify - this is done in the crossrefdoimetadata step
        return $data;
    }

    public static function _package($package)
    {
        // No metadata to package - this is done in the crossrefdoimetadata step
    }

    public static function _email($message)
    {
        // No metadata to email - this is done in the crossrefdoimetadata step
        return $message;
    }
}

?>