<?php
defined('BASEPATH') OR die('No Direct Script Access Allowed');?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?= $this->app['app_title_short'];?> - <?= get_title_by_uri();?></title>
        
        <link rel="icon" href="<?= site_url('assets/images/'.$this->app['app_logo']);?>">

        <!-- Bootstrap -->
        <link href="<?= site_url();?>assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="<?= site_url();?>assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <!-- NProgress -->
        <link href="<?= site_url();?>assets/vendors/nprogress/nprogress.css" rel="stylesheet">

        <!-- CSS file -->
        <link href="<?= site_url();?>assets/vendors/easyautocomplete/easy-autocomplete.min.css" rel="stylesheet">
        <!-- Additional CSS Themes file - not required-->
        <link href="<?= site_url();?>assets/vendors/easyautocomplete/easy-autocomplete.themes.min.css" rel="stylesheet">
        <!-- Custom Theme Style -->
        <link href="<?= site_url();?>assets/css/custom.min.css" rel="stylesheet">
        <!-- Custom Form Style -->
        <style type="text/css" media="screen">
        .error{
            font-size: 12px;
            color: #FF0000;
        }
        .file {
            visibility: hidden;
            position: absolute;
        }
        </style>
    </head>