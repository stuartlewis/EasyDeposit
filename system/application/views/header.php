<?php $this->load->helper('url'); ?>
<html>
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<base href="<?php echo base_url() ?>">
		<title><?php echo $page_title; ?></title>
		<link rel='stylesheet' type='text/css' media='all' href='css/style.css' />
        <link rel="SHORTCUT ICON" href="favicon.ico">
        <?php if (!empty($javascript)) { foreach ($javascript as $js): ?>
        <script type="text/javascript" src="js/<?php echo $js; ?>"></script>
        <?php endforeach; } ?>
	</head>
	<body>
		<div id="header"><h1><?php echo $page_title; ?></h1></div>