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

    <title><?= $this->app['app_title_short'];?> - <?= $title;?></title>
    
    <link rel="icon" href="<?= site_url('assets/images/'.$this->app['app_logo']);?>">

    <!-- Bootstrap -->
    <link href="<?= site_url();?>assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?= site_url();?>assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?= site_url();?>assets/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Datatables -->
    <link href="<?= site_url();?>assets/vendors/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="<?= site_url();?>assets/vendors/datatables/css/buttons.dataTables.min.css" rel="stylesheet">
    <link href="<?= site_url();?>assets/vendors/datatables/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="<?= site_url();?>assets/vendors/easyautocomplete/easy-autocomplete.min.css" rel="stylesheet" >
    <!-- Additional CSS Themes file - not required-->
    <link href="<?= site_url();?>assets/vendors/easyautocomplete/easy-autocomplete.themes.min.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="<?= site_url();?>assets/css/custom.min.css" rel="stylesheet">
    <style type="text/css">
        /* Important part */
        .modal-dialog{
            overflow-y: initial !important;
        }
        .modal-body{
            height: 400px;
            overflow-y: auto;
        }
    </style>
  </head>