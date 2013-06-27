<?php 
global $apiConfig;
$apiConfig = array(
    'baseURL'=>'http://api.tdispatch.com/', // http://api.t-dispatch.co for develop and tests, https://api.tdispatch.com for production 
    'apiPassengerVersion' => 'v1', //Version of Passenger-API
    'api_key'=>'', //API Key supplied by the Fleet 
    'api_cliente_id'=>'xxx@tdispatch.com',
    'api_secret'=>'', //the Client Secret given by TDispatch support
    'getHomeUrl'=>'http://yourwebsite.com/', //Your website url
    'resetPasswordCallbackPage'=>'reset-password', //Callback page for reset-password reset-password.php
    'debug'=>true //(bool) true or false, if you want errors in error_log
);
?>
