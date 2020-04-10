<!DOCTYPE HTML>
<html>

<head>
    <title>My Blog</title>
    <meta name="description" content="website description" />
    <meta name="keywords" content="website keywords, website keywords" />
    <meta http-equiv="content-type" content="text/html; charset=windows-1252" />
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Tangerine&amp;v1" />
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz" />
    <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/css/style.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/css/bootstrap-theme.min.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
</head>

<body>
    <div id="main">
        <div id="header">
            <div id="logo">
                <h1><a href="<?=base_url()?>index.php/blog/">My Blog</a></h1>
            </div>
            <div id="menubar">
                <ul id="menu">
                  <!-- put class="current" in the li tag for the selected page - to highlight which page you're on -->
                    <li class="<?=$home_class;?>" ><a href="<?=base_url()?>index.php/blog/">Home</a></li>
                    <?php if($this->session->userdata('user_id'))
                    {?>
                          <li class="<?=$login_class;?>" ><a href="<?=  base_url()?>index.php/users/logout">(<?=$this->session->userdata['username']?>)Logout</a></li>
                    <?php
                    } 
                    else{ ?>
                    <li class="<?= $login_class;?>" ><a href="<?=  base_url()?>index.php/users/login">Login</a></li>                    
                    <li class="<?=$register_class;?>" ><a href="<?=  base_url()?>index.php/users/register/">Register</a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>