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

class Config {

	private static $fleetApiKey	= null;
	private static $apiClientId	= null;
	private static $apiSecret		= null;

	private static $homeUrl			= 'http://localhost/';	 // URL of your website this scripts are hosted on, i.e. https://yourwebsite.com/



	// ************* NO NEED TO TOUCH ANY CODE BELOW THIS LINE **************************/

	private static $apiBaseUrl 	= 'https://api.tdispatch.com/';
	private static $resetPasswordCallbackPage = 'reset-password';
	private static $debug = true;

	public static function validateConfig() {
		if( self::$fleetApiKey === null ) {
			die("Configuration Error: No fleetApiKey provided");
		}
		if( self::$apiClientId === null ) {
			die("Configuration Error: No fleetApiKey provided");
		}
		if( self::$apiSecret === null ) {
			die("Configuration Error: No apiSecret provided");
		}
	}

	public static function getFleetApiKey() {
		return self::fleetApiKey;
	}
	public static function getApiClientId() {
		return self::apiClientId;
	}
	public static function getApiSecret() {
		return self::apiSecret;
	}
	public static function getHomeUrl() {
		return self::homeUrl;
	}
	public static function getApiBaseUrl() {
		return self::apiBaseUrl;
	}
	public static function getResetPasswordCallbackPage() {
		return self::getResetPasswordCallbackPage;
	}
	public static function isDebug() {
		return self::debug;
	}

}





/* global $apiConfig;
$apiConfig = array(
    'baseURL'=>'https://api.tdispatch.com/', // http://api.t-dispatch.co for develop and tests, https://api.tdispatch.com for production
    'apiPassengerVersion' => 'v1', //Version of Passenger-API
    'api_key'=>'', //API Key supplied by the Fleet
    'api_cliente_id'=>'xxxxxxxxxx@tdispatch.com', //cliend_id@tdispatch.com - must always have @tdispatch.com
    'api_secret'=>'', //the Client Secret given by TDispatch support
    'getHomeUrl'=>'http://yourwebsite.com/', //Your website url
    'resetPasswordCallbackPage'=>'reset-password', //Callback page for reset-password reset-password.php
    'debug'=>true //(bool) true or false, if you want errors in error_log
);
 */