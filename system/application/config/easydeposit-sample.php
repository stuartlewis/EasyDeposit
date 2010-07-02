<?php

// Configuration file for the EasyDeposit application
// This file can be edited using the administrative interface at:
// http://example.com/easydeposit/admin
// !!! No config line is allowed to span multiple lines. !!!

// Admin username and password
// (The password is stored encrypted. 6da12e83ef06d1d59884a5ca724cbc75 is 'easydepositadmin'
// The password can be changed in the admin interface
$config['easydeposit_adminusername'] = 'easydepositadmin';
$config['easydeposit_adminpassword'] = '6da12e83ef06d1d59884a5ca724cbc75';

// Location of the SWORD PHP library (this normally doesn't need to be changed)
$config['easydeposit_librarylocation'] = 'system/application/libraries/swordapp-php-library';

// The name of the application (as shown on the welcome page)
$config['easydeposit_welcome_title'] = "EasyDeposit Client";

// The steps that a submission should take
// The first of these should be a login step that has public static methods _loggedin and _id
$config['easydeposit_steps'] = array('nologin', 'selectrepository', 'servicedocument', 'metadata', 'uploadfiles', 'verify', 'deposit', 'thankyou');

// Email address for support enquiries for users of the client
$config['easydeposit_supportemail'] = 'support@example.com';

// LDAP login settings
$config['easydeposit_ldaplogin_netidname'] = 'NetID';
$config['easydeposit_ldaplogin_server'] = 'ldaps://ldap.example.com';
$config['easydeposit_ldaplogin_context'] = 'OU=users,DC=example,DC=com';

// ServiceDocument Login settings
$config['easydeposit_servicedocumentlogin_url'] = 'http://example.com/sword/servicedocument';

// A list of service documents to provide in the selectrepository step
$config['easydeposit_selectrepository_list'] = array('http://localhost:8080/sword/servicedocument', 'http://client.swordapp.org/client/servicedocument', 'http://dspace.swordapp.org/sword/servicedocument', 'http://sword.eprints.org/sword-app/servicedocument', 'http://sword.intralibrary.com/IntraLibrary-Deposit/', 'http://fedora.swordapp.org/sword-fedora/servicedocument');

// Credentials with which to retrieve a service document automatically
$config['easydeposit_retrieveservicedocument_url'] = 'http://example.com/sword/servicedocument';
$config['easydeposit_retrieveservicedocument_username'] = 'email@example.com';
$config['easydeposit_retrieveservicedocument_password'] = 'password';
$config['easydeposit_retrieveservicedocument_obo'] = '';

// Item types
$config['easydeposit_metadata_itemtypes'] = array('http://purl.org/eprint/type/JournalArticle' => 'Journal article', 'http://purl.org/eprint/type/ConferencePaper' => 'Conference paper', 'http://purl.org/eprint/type/ConferencePoster' => 'Conference poster', 'http://purl.org/eprint/type/Thesis' => 'Thesis or dissertation', 'http://purl.org/eprint/type/Book' => 'Book', 'http://purl.org/eprint/type/BookItem' => 'Book chapter', 'http://purl.org/eprint/type/BookReview' => 'Book review', 'http://purl.org/eprint/type/Report' => 'Report', 'http://purl.org/eprint/type/WorkingPapaer' => 'Working paper', 'http://purl.org/eprint/type/NewsItem' => 'News item', 'http://purl.org/eprint/type/Patent' => 'Patent', 'http://purl.org/eprint/type/Report' => 'Report');

// Peer review status
$config['easydeposit_metadata_peerreviewstatus'] = array('http://purl.org/eprint/status/PeerReviewed' => 'Yes', 'http://purl.org/eprint/status/NonPeerReviewed' => 'No');

// The number of files to allow a user to upload
$config['easydeposit_uploadfiles_number'] = 5;

// Where to save files (remember trailing slash!)
$config['easydeposit_uploadfiles_savedir'] = 'private/uploadfiles/';

// Where to store packages (make sure these directories exist and the web server can write to them)
$config['easydeposit_deposit_packages'] = 'private/uploadfiles/';
$config['easydeposit_multipledeposit_packages'] = "private/uploadfiles/";

// Hard code depositurl, login and password if using the depositcredentials step
$config['easydeposit_depositcredentials_depositurl'] = 'http://localhost/sword/deposit/123456789/2';
$config['easydeposit_depositcredentials_username'] = 'email@example.com';
$config['easydeposit_depositcredentials_password'] = 'password';
$config['easydeposit_depositcredentials_obo'] = '';

// Hard code depositurls, logins and passwords if using the multipledepositcredentials step
$config['easydeposit_multipledepositcredentials_depositurl'] = array('http://localhost/sword/deposit/123456789/2', 'http://localhost/sword/deposit/123456789/2');
$config['easydeposit_multipledepositcredentials_username'] = array('email@example.com', 'email@another.com');
$config['easydeposit_multipledepositcredentials_password'] = array('password1', 'password2');
$config['easydeposit_multipledepositcredentials_obo'] = array('', '');

// Email settings
$config['easydeposit_email_from'] = 'example@email.com';
$config['easydeposit_email_fromname'] = 'Example sender name';
$config['easydeposit_email_cc'] = '';
$config['easydeposit_email_subject'] = 'Thank you for your deposit';
$config['easydeposit_email_end'] = "Best wishes,\n\nThe repository team\nsupport@example.com";

// CrossRef API DOI lookup configuration
// Register for a key at http://www.crossref.org/requestaccount/
// Your API KEY is the email address that you used to register
$config['easydeposit_crossrefdoilookup_apikey'] = 'API_KEY';
$config['easydeposit_crossrefdoilookup_itemtypes'] = array('http://purl.org/eprint/type/JournalArticle' => 'Journal article', 'http://purl.org/eprint/type/ConferencePaper' => 'Conference paper', 'http://purl.org/eprint/type/ConferencePoster' => 'Conference poster', 'http://purl.org/eprint/type/Thesis' => 'Thesis or dissertation', 'http://purl.org/eprint/type/Book' => 'Book', 'http://purl.org/eprint/type/BookItem' => 'Book chapter', 'http://purl.org/eprint/type/BookReview' => 'Book review', 'http://purl.org/eprint/type/Report' => 'Report', 'http://purl.org/eprint/type/WorkingPapaer' => 'Working paper', 'http://purl.org/eprint/type/NewsItem' => 'News item', 'http://purl.org/eprint/type/Patent' => 'Patent', 'http://purl.org/eprint/type/Report' => 'Report');
$config['easydeposit_crossrefdoilookup_peerreviewstatus'] = array('http://purl.org/eprint/status/PeerReviewed' => 'Yes', 'http://purl.org/eprint/status/NonPeerReviewed' => 'No');

?>
