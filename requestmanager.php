<?php

/* Include the requested page */
switch ($page) {
    case 'home':
        include 'pages/home.php';
        break;
    case 'aboutus':
        include 'pages/aboutus.php';
        break;
    case 'iphoneapp':
        include 'pages/iphoneapp.php';
        break;
    case 'booking':
        include 'pages/home.php';
        break;
    case 'account':
        include 'pages/account.php';
        break;
    case 'reset-password':
        include 'pages/reset-password.php';
        break;
    case 'change-password':
        include 'pages/change-password.php';
        break;
    case 'bookings':
        include 'pages/bookings.php';
        break;
    case 'logout':
        include 'pages/logout.php';
        break;
    case 'tracking':
        include 'pages/tracking.php';
        break;
    case 'receipt':
        include 'pages/receipt.php';
        break;
    default:
        include 'pages/home.php';
}
?>