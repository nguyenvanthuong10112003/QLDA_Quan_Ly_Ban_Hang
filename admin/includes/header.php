<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Admin</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="../assets/css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
        <link rel="stylesheet" href="../assets/css/profile.css">  
        <link rel="stylesheet" href="../assets/css/toastr.min.css">
    </head>
    <body class="sb-nav-fixed">
        <?php 
            include('../../helpers/function.php'); 
            $regexResult = checkPrivilege();
        ?>
        <?php include('../includes/navbar_top.php') ?>
			<div id="layoutSidenav">
				<?php include('../includes/sidebar.php') ?>
				<div id="layoutSidenav_content">
                	<main>