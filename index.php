<?php
ob_start();
session_start();
define('INDEX_CALL', 1);

if (isset($_POST['JSON'])) {
    include 'requestJSON.php';
    exit;
}
require_once 'inc/tdispatch/TDispatch.php';
$td = new TDispatch();

$page = 'home';
if (isset($_GET['p']) && $_GET['p'] != '') {
    $page = $_GET['p'];
}

ob_start();
include 'pages/header.php';
$header = ob_get_clean();

ob_start();
include 'requestmanager.php';
$content = ob_get_clean();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Taxi Cars</title>
        <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=UTF-8" />
        <meta name="keywords" content=""/>
        <meta name="description" content=""/>
        <meta name="robots" content="index, follow, noarchive"/>
        <meta name="googlebot" content="noarchive"/>
        <base href="<?php echo $td->getHomeUrl(); ?>" />
        <link rel="shortcut icon" href="images/icon.ico" type="image/x-icon" />

        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
            <link rel="stylesheet" href="<?php echo $td->getHomeUrl(); ?>css/style.css" type="text/css" />           
            <link rel="stylesheet" href="<?php echo $td->getHomeUrl(); ?>css/tdispatch-squareball/jquery-ui-1.10.3.custom.css"  type="text/css"/>

            <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
            <script type="text/javascript" src="<?php echo $td->getHomeUrl(); ?>js/jquery.validate.js"  ></script>            
            <script type="text/javascript" src="<?php echo $td->getHomeUrl(); ?>js/jquery-ui-1.10.3.custom.min.js"></script>
            <script type="text/javascript" src="<?php echo $td->getHomeUrl(); ?>js/misc.js" ></script>
    </head>
    <body>
        <div id="overlay"></div>
        <?php #include('pages/header.php'); ?>
        <?php echo $header; ?>
        <?php echo $content; ?>
        <?php include('pages/footer.php'); ?>
    </body>

    <script>
        function initialize() {
            
        }

        function loadScript() {
            var script = document.createElement('script');
            script.type = 'text/javascript';
            script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&callback=initialize';
            document.body.appendChild(script);
        }
        window.onload = loadScript;

    </script>
</html>