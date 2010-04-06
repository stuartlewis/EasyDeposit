<?php $this->load->helper('url'); ?>
<html>
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<base href="<?php echo base_url() ?>">
		<title>EasyDeposit Admin: <?php echo $page_title; ?></title>
		<link rel='stylesheet' type='text/css' media='all' href='css/adminstyle.css' />
        <link rel="SHORTCUT ICON" href="favicon.ico">
        <?php if (!empty($javascript)) { foreach ($javascript as $js): ?>
        <script type="text/javascript" src="js/<?php echo $js; ?>"></script>
        <?php endforeach; } ?>
        <?php if (!empty($javascript)) { foreach ($javascript as $js):
                if ($js == 'tiny_mce/tiny_mce.js') { ?>
                    <script type="text/javascript">
                        tinyMCE.init({
                           theme : "advanced",
                           mode: "exact",
                           elements : "content",
                           theme_advanced_toolbar_location : "top",
                           theme_advanced_toolbar_align : "left", 
                           theme_advanced_buttons1 : "bold,italic,underline,strikethrough,separator,"
                           + "justifyleft,justifycenter,justifyright,justifyfull,formatselect,"
                           + "bullist,numlist,outdent,indent",
                           theme_advanced_buttons2 : "link,unlink,anchor,image,separator,"
                           +"undo,redo,cleanup,code,separator,sub,sup,charmap",
                           theme_advanced_buttons3 : "",
                           height:"350px",
                           width:"1000px",
                           content_css : "../css/style.css",
                           theme_advanced_statusbar_location : "bottom",
                           file_browser_callback : 'myFileBrowser'
                         });

                        function toggleEditor(id)
                        {
                            if (!tinyMCE.get(id))
                                tinyMCE.execCommand('mceAddControl', false, id);
                            else
                                tinyMCE.execCommand('mceRemoveControl', false, id);
                        }
                    </script>
                    
        <?php } endforeach; } ?>
	</head>
	<body>
		<div id="header"><h1><?php echo $page_title; ?></h1></div>