<?php
/*
 ******************************************************************************
 *
 * Copyright (C) 2013 T Dispatch Ltd
 *
 * Licensed under the GPL License, Version 3.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.gnu.org/licenses/gpl-3.0.html
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 ******************************************************************************
*/


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
        break;
}
