#### Copyrights

Copyright (C) 2013 T Dispatch Ltd

    T Dispatch Ltd
    35 Paul Street
    London
    UK EC2A 4UQ

For more details visit www.tdispatch.com

#### Trademarks

T Dispatch logo, T Dispatch, the T Dispatch T shaped logo are all trademarks of T Dispatch Ltd.


#### Requirements

 - PHP 5.2.x or higher [http://www.php.net/]
 - PHP Curl extension [http://www.php.net/manual/en/intro.curl.php]
 - PHP JSON extension [http://php.net/manual/en/book.json.php]

#### Setting up

Configuration is stored in `tdispatch_config.php` file:

```php
$apiConfig = array(
    'baseURL'=>'http://api.tdispatch.com/',
    'apiPassengerVersion' => 'v1', //Version of Passenger-API to use
    'api_key'=>'', // Your Fleet API key
    'api_cliente_id'=>'',// Your Client ID given by TDispatch support (Note: Client ID is always something like “LXNgW9FfJP@tdispatch.com” (10 characters + @tdispatch.com))
    'api_secret'=>'', // Your Client Secret
    'getHomeUrl'=>'', // Your website URL (http://yoursite.com/)
    'resetPasswordCallbackPage'=>'reset-password', //Callback page for reset-password (reset-password.php)
    'debug'=>true //(bool) true or false, if you want errors in error_log
);
```


#### License

    Licensed under the GPL License, Version 3.0 (the "License");
    you may not use this file except in compliance with the License.
    You may obtain a copy of the License at

        http://www.gnu.org/licenses/gpl-3.0.html

    Unless required by applicable law or agreed to in writing, software
    distributed under the License is distributed on an "AS IS" BASIS,
    WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
    See the License for the specific language governing permissions and
    limitations under the License.
