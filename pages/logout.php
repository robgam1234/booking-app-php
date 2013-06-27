<?php
defined('INDEX_CALL') or die('You cannot access this page directly.');
$td->Account_logout();
header('Location: '.$td->getHomeUrl());
?>