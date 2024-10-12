<?php

session_start();

require 'includes/function.php';

$path = $_SERVER["REQUEST_URI"];

$path = parse_url($path, PHP_URL_PATH);

switch($path) {
    case '/auth/signup':
        require 'includes/auth/signup.php';
        break;

    case '/auth/login':
        require 'includes/auth/login.php';
        break;

    case '/auth/submit':
        require 'includes/auth/submit.php';
        break;
    
     case '/logout':
        require 'pages/logout.php';
        break;

    case '/user/add':
        require 'includes/user/add.php';
        break;

    case '/user/changepwd':
        require 'includes/user/changepwd.php';
        break;

    case '/user/delete':
        require 'includes/user/delete.php';
        break;

    case '/user/edit':
         require 'includes/user/edit.php';
        break;

    case '/user/comment':
        require 'includes/user/comment.php';
        break;

    case '/user/bookmark':
        require 'includes/user/bookmark.php';
        break;

    case '/admin/add';
        require 'admin/add.php';
        break;

    case '/admin/delete';
        require 'delete/add.php';
        break;

    case '/admin/edit';
        require 'admin/edit.php';
        break;

    case '/submit';
        require 'pages/home.php';
        break;

    case '/login':
        require 'pages/login.php';
        break;


    case '/signup';
        require 'pages/signup.php';
        break;
    
    case '/adminadd';
        require 'pages/adminadd.php';
        break;
    

    case '/desc';
        require 'pages/desc.php';
        break;

    case '/manage-users':
        require 'pages/manage-users.php';
        break;

    case '/manage-users-add':
        require 'pages/manage-users-add.php';
        break;
    case '/manage-users-changepwd' :
        require 'pages/manage-users-changepwd.php';
        break;
    case '/manage-users-edit' :
        require 'pages/manage-users-edit.php';
        break;

    case '/admindelete';
        require 'pages/admindelete.php';
        break;

    case '/adminedit';
        require 'pages/adminedit.php';
        break;

    case '/adminbook';
        require 'pages/adminbook.php';
        break;

    case '/bookmark';
        require 'pages/bookmark.php';
        break;

    default:
        require 'pages/home.php';
        break;
}