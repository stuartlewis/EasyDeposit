<?php $this->load->helper('url'); ?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <base href="<?php echo base_url() . index_page(); if (index_page() !== '') { echo '/'; } ?>">
    <title><?php echo $page_title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap-responsive.min.css">
    <link rel="stylesheet" href="css/main.css">

    <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>

    <?php if (!empty($javascript)) { foreach ($javascript as $js): ?>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/<?php echo $js; ?>"></script>
    <?php endforeach; } ?>

</head>

<body>
<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <ul class="nav">
                <li class="active">
                    <a class="brand" href="./">EasyDeposit</a>
                </li>
                <li><a href="easydeposit/">Deposit an item</a></li>
            </ul>
            <ul class="nav pull-right">
                <li><a href="admin/">Admin</a></li>
            </ul>
        </div>
    </div>
</div>

<div class="container">
    <div class="leaderboard">
        <h1><?php echo $page_title; ?></h1>