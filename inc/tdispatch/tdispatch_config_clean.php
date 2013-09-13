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

global $apiConfig;
$apiConfig = array(
    'baseURL'=>'http://api.t-dispatch.co/', // http://api.t-dispatch.co for develop and tests, https://api.tdispatch.com for production
    'apiPassengerVersion' => 'v1', //Version of Passenger-API
    'api_key'=>'', //API Key supplied by the Fleet
    'api_cliente_id'=>'xxxxxxxxxx@tdispatch.com', //cliend_id@tdispatch.com - must always have @tdispatch.com
    'api_secret'=>'', //the Client Secret given by TDispatch support
    'getHomeUrl'=>'http://yoursite.com/', //Your website url
    'resetPasswordCallbackPage'=>'reset-password', //Callback page for reset-password reset-password.php
    'debug'=>false //(bool) true or false, if you want errors in error_log
);