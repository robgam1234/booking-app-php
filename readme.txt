TDispatch Library for PHP
=====================================

== Description
The TDispatch Library enables you to work with TDISPATCH API on your server.

Requirements:
  PHP 5.2.x or higher [http://www.php.net/]
  PHP Curl extension [http://www.php.net/manual/en/intro.curl.php]
  PHP JSON extension [http://php.net/manual/en/book.json.php]

Project page:
  https://github.com/TDispatch/Passenger-API

Report a defect or feature request here:
  https://github.com/TDispatch/Passenger-API/issues


== What you need to configure?
You only need to configure vars in this file "tdispatch_config.php"

$apiConfig = array(
    'baseURL'=>'http://api.t-dispatch.co/', // http://api.t-dispatch.co for develop and tests, https://api.tdispatch.com for production 
    'apiPassengerVersion' => 'v1', //Version of Passenger-API
    'api_key'=>'', //API Key supplied by the Fleet 
    'api_cliente_id'=>'',//the Client ID given by TDispatch support (Note: Client ID is always something like “LLNgW9FfJP@tdispatch.com” (10 characters + @tdispatch.com))
    'api_secret'=>'', //the Client Secret given by TDispatch support
    'getHomeUrl'=>'', //Your website url (http://yoursite.com/)
    'resetPasswordCallbackPage'=>'reset-password', //Callback page for reset-password (reset-password.php)
    'debug'=>true //(bool) true or false, if you want errors in error_log
);

== Basic Example for usage
  <?php
    require_once 'path/to/src/tdispatch/TDispatch.php';
    $tdispatch = new TDispatch();

== List Methods for $tdispatch you can use, the explain in the bottom (check topic: == Details for each method )
$tdispatch->getToken(); //return token for api use
$tdispatch->getApiKey(); //return api key
$tdispatch->getClientId(); //return cliente id
$tdispatch->getFullApiUrl();// return api url, used for make api calls
$tdispatch->getFullOAuthUrl(); // return oauth api url, used for make oauth api calls
$tdispatch->getHomeUrl(); // return your site base url
$tdispatch->getErrorMessage(); //get last error message
$tdispatch->getErrorCode();// //get last error code
$tdispatch->api_info(); //Returns basic information about the current API session.
$tdispatch->Account_create(); //create a new account
$tdispatch->api_info(); //get api info

$tdispatch->Account_create($passenger); //create new user
$tdispatch->Account_login($user, $password); //do login
$tdispatch->Account_logout(); //do logout
$tdispatch->Account_getPreferences(); //get preferences for user
$tdispatch->Account_setPreferences($preferences); //update preferences for user
$tdispatch->Account_getFleetdata();  //get fleet data
$tdispatch->Account_resetPassword($email);  //reset password request
$tdispatch->Account_changePassword($data);  //change password
$tdispatch->Account_checkLogin(); //check if user is authenticated

$tdispatch->Bookings_list($order_by,$status,$pickup_time,$limit,$offset); //list all bookings
$tdispatch->Bookings_create($customer, $passenger, $pickup_time, $return_pickup_time, $pickup_location, $way_points, $dropoff_location, $vehicle_type, $extra_instructions, $luggage, $passengers, $payment_method, $prepaid, $status, $price_rule,$customs);//create new booking
$tdispatch->Bookings_get($bookingPk); //get booking data
$tdispatch->Bookings_update($customer, $passenger, $pickup_time, $return_pickup_time, $pickup_location, $way_points, $dropoff_location, $vehicle_type, $extra_instructions, $luggage, $passengers, $payment_method, $prepaid, $status, $price_rule,$customs); //update a booking
$tdispatch->Bookings_cancel($bookingPk, $description); //cancel a booking
$tdispatch->Bookings_receipt($bookingPk); //download receipt
$tdispatch->Bookings_tracking($bookings); //track booking
$tdispatch->Bookings_getCustom();//get custom fields

$tdispatch->Vehicles_list($limit); //get vehicle list

$tdispatch->Drivers_nearby($limit, $location, $radius, $offset); //get nearby drivers


== Details for each method

/* API FUNCTIONS */

//Basic methods used inside other methods
$tdispatch->getToken(); //return token for api use
$tdispatch->getApiKey(); //return api key
$tdispatch->getClientId(); //return cliente id
$tdispatch->getFullApiUrl();// return api url, used for make api calls
$tdispatch->getFullOAuthUrl(); // return oauth api url, used for make oauth api calls
$tdispatch->getHomeUrl(); // return your site base url
$tdispatch->getErrorMessage(); //get last error message
$tdispatch->getErrorCode();// //get last error code

//API Info
//$tdispatch->api_info();
//Returns basic information about the current API session.
//@return (object) json object
//Returns an json object like this:
/*
{ "api" : "passenger",
  "application" : {
      "client_id" : "w3bW7HyMjz",
      "email" : "jack@gmail.com",
      "name" : "Passenger App"
    },
  "passenger" : {
      "name" : "Jack Sparrow"
    },
  "session" : {
      "access_token" : "50dfb3d2c6c1215f8500001f",
      "creation" : "2012-12-30 03:24:02",
      "expires_in" : 1189769
    },
  "status" : "OK",
  "status_code" : 200,
  "version" : "1"
}
*/
$tdispatch->api_info();

/* END - API FUNCTIONS */


/* ACCOUNT FUNCTIONS */

/* Account_create()
* Creates new passenger's account and does sign in after that
* @param (array) passenger information
* example:      
    $passenger = array(
        "first_name"=> "James",
        "last_name"=>  "Moriarty",
        "email"=>  "jmoriarty@tdispatch.com",
        "phone"=>  "+380632592471",
        "password"=>  "Sherlock_MustD!e"
    );
* @return (object) json object
    If successful, this method returns a response body with the following structure:
    {
        "passenger": { //(object) Object with newly created passenger
        "pk": "516feb1c2769a156bb5e5008", //Passenger unique id
        "access_token": "51714d8e2769a10688e125ad" //Access token that can be used for further API calls //can obtain in $tdispatch->getToken();
        },
        "status": "OK",//
        "status_code": 200 //
    }     
*/
//example
$tdispatch->Account_create($passenger);



/* 
* Account_login()  
* o login for user
* @param $user email for user
* @param $password password for user
* @return (bool) true or false, if authenticated or not
*/
//example
$tdispatch->Account_login($user, $password);

/* 
* Account_logout()  
* do logout and unset all session vars   
*/
//example
$tdispatch->Account_logout();
    

/*
* Account_getPreferences()
* Returns object with account preferences 
* @return (object) json object    
* return example:
{
    "preferences": {
    "birth_date": "1985-10-21T00:00:00",
    "email": "eugen@tdispatch.com",
    "first_name": "Eugen",
    "last_name": "Ivanov",
    "location": {
    "address": "Lessingstraße 23",
    "location": {
    "lat": 52.12588,
    "lng": 11.6115
    },
    "postcode": "39108"
    },
    "phone": "+380633191140",
    "receive_email_notifications": true,
    "receive_sms_notifications": true,
    "use_account_location_as_pickup": true,
    "username": "eugen-ivanov"
    },
    "status": "OK",
    "status_code": 200
}
*/
//example
$tdispatch->Account_getPreferences();


/*
* Account_setPreferences()
* Returns object with new account preferences 
* @param $preferences (array) with new preferences
example: 
$preferences = array(   
    "birth_date"=> "1985-10-21T00:00:00",
    "email"=> "eugen@tdispatch.com",
    "first_name"=> "Eugen",
    "last_name"=> "Ivanov",
    "location"=> array(
        "address"=> "Lessingstraße 23",
        "location"=> array(
            "lat"=> 52.12588,
            "lng"=> 11.6115
            ),
        "postcode"=> "39108"
    ),
    "phone"=> "+380633191140",
    "receive_email_notifications"=> true,
    "receive_sms_notifications"=> true,
    "use_account_location_as_pickup"=> true
);
* @return (object) json object    
* return example:
{
    "preferences": {
    "birth_date": "1985-10-21T00:00:00",
    "email": "eugen@tdispatch.com",
    "first_name": "Eugen",
    "last_name": "Ivanov",
    "location": {
    "address": "Lessingstraße 23",
    "location": {
    "lat": 52.12588,
    "lng": 11.6115
    },
    "postcode": "39108"
    },
    "phone": "+380633191140",
    "receive_email_notifications": true,
    "receive_sms_notifications": true,
    "use_account_location_as_pickup": true,
    "username": "eugen-ivanov"
    },
    "status": "OK",
    "status_code": 200
}
*/
//example
$tdispatch->Account_setPreferences($preferences);


/*
* Account_getFleetdata()
* Returns account's office data 
* @return (object) json object    
* return example:  
{
    "data": {
        "phone": "+612073811124",
        "name": "Berlin cars",
        "email": "office@cabdomain.co.uk"
    },
    "status": "OK",
    "status_code": 200
}
*/
//example
$tdispatch->Account_getFleetdata(); 


/*
* Account_resetPassword()
* Allow user to reset his password, the user will receive in email a link for change password.
* "http://yoursite.com/reset-password?token={token}"
* @param $email (string) user email
* @return (bool) true or false
*/
//example
$tdispatch->Account_resetPassword($email); 


/*
* Account_changePassword()
* Method to change password after reseting 
* @param $data (array) with token and new password.
example:
$data = array(
    'token'=>"3il-8f837e891b40dbccbe0f", //Reset password token. Can be obtained from confirm_url when user clicks it from the password reset
    'new_password'=> "n1ce_nevv_pa$$word"
);
* @return (bool) true or false    
*/
//example
$tdispatch->Account_changePassword($data); 



/*
* Account_checkLogin()
* Method to check if user is authenticated
* @return (bool) true or false    
*/
//example
$tdispatch->Account_checkLogin(); 

/* END - ACCOUNT FUNCTIONS */


/* LOCATION FUNCTIONS */

/*
* Location_search()
* Searches for locations and returns a list of them. Can be called anonymously
* @param $q Query string to search locations. Required
* @param $limit Limit number of locations. Optional
* @param $type Should be 'pickup' if location is going to be used for a pickup. Optional.
* @return (object) json object
example:
{
    "status": "OK",
    "status_code": 200,
    "locations": [
        {
            "town": "Adelanto",
            "country": "United States",
            "source": "googlemaps",
            "postcode": "92301",
            "address": "Lessing Avenue, Adelanto",
            "type": "location",
            "location": {
                "lat": 34.5845871,
                "lng": -117.5110175
            }
        },
        {
            "town": "Phelan",
            "country": "United States",
            "source": "googlemaps",
            "postcode": "92371",
            "address": "Lessing Road, Phelan",
            "type": "location",
            "location": {
                "lat": 34.5287707,
                "lng": -117.5036127
            }
        }
    ]
}
*/
//example
$tdispatch->Location_search($q,$limit,$type ); 
/* END - LOCATION FUNCTIONS */


/* FareCalculation FUNCTIONS */
/*
* FareCalculation_fare()
* Searches for locations and returns a list of them. Can be called anonymously
* @param $pickup location for pickup. Required
* example: $pickup = array("lat"=> 52.12588,"lng"=> 11.61150);
* @param $dropoff location for dropoff. Required
* example: $dropoff = array("lat"=> 52.5373399193,"lng"=> 13.378729824);
* @param $waypoints location for waypoints. Optional
* example: $waypoints = array(array("lat"=> 52.5373399193,"lng"=> 13.378729824),array("lat"=> 52.5373399193,"lng"=> 13.378729824)...);
* @return (object) json object
example:
{
    "distance": {
        "miles": 98.1,
        "km": 157
    },
    "duration": {
        "raw_duration": 2341,
        "hours": 0,
        "minutes": 39
    },
    "formatted_total_cost": "руб. 349.69",
    "time_to_wait": 600,
    "status": "OK",
    "status_code": 200
}
*/
//example
$tdispatch->FareCalculation_fare($pickup, $dropoff, $waypoints); 
/* END - FareCalculation FUNCTIONS */

/* BOOKINGS FUNCTIONS */
/*
* Bookings_list()
* Returns list with bookings of that passenger, according to given parameters
* @param $order_by Fields to order by, separated by commas. For descending order, put a minus sign before the field name. 
* Possible fields to order by:
    -pickup_time
    -dropoff_time
    -luggage
    -passengers
    -extra_instructions
    -cost
    -total_cost
    -miles
    -minutes
    -creation_date
    -notes
    -return_time
    -keywords
    -minutes_waited
* @param $status
* Possible fields to status: 
    -quoting
    -incoming
    -from_partner
    -dispatched
    -confirmed
    -active
    -completed
    -rejected
    -cancelled
    -draft
    Few statuses possible, if separated by comma
* @param $pickup_time (string (ISO format)) Show only bookings with a specified pickup time 
* @param $limit (int) Limit number of bookings
* @param $offset (int) Use with limit parameter to get paged bookings; get {limit} bookings from {offset}. Default is 0
* @return (object) json object (list of bookings)
example:
{ "bookings" : [ {
    "accessibilities": {},
    "account": {
        "name": "John Doe",
        "pk": "51546e8e2769a15cc0468d85"
    },
    "allocated_hours": null,
    "alternative_route": null,
    "avoid": {
        "highways": false,
        "tolls": false
    },
    "cost": {
        "currency": "GBP",
        "value": 7
    },
    "customer_name": "Andy Warhol",
    "customer_phone": "+49123470416",
    "distance": {
        "km": 2.5,
        "miles": 1.6
    },
    "driver_pk": "50d092c0b6c1211963000067",
    "dropoff_location": {
        "address": "Wöhlertstraße 10 10115",
        "location": {
            "lat": "52.53673",
            "lng": "13.379416"
        },
        "postcode": "10115"
    },
    "duration": {
        "minutes": 15,
        "seconds": 900
    },
    "extra_instructions": "The three guys in blue.",
    "extras": [],
    "flight_number": "",
    "key": "13002r",
    "luggage": 5,
    "office": {
        "slug": "berlin-cars",
        "name": "Berlin Cars Ltd."
    },
    "passengers": 3,
    "payment_method": "cash",
    "payment_status": "",
    "pickup_location": {
        "address": "Grüntaler strasse 11 13357",
        "location": {
            "lat": "52.552037",
            "lng": "13.387291"
        },
        "postcode": "13357",
    },
    "pickup_time": "2013-05-07T12:30:00+00:00",
    "pk": "515470002769a110b26260c0",
    "prepaid": false,
    "price_correction": null,
    "receipt_url": "bookings/14002n/receipt",
    "status": "incoming",
    "total_cost": {
        "currency": "GBP",
        "value": 7.7
    },
    "vehicle_type": {
        "pk": "5093aff36e77c305510003a5", 
        "name": "Coupe"
    },
    "way_points": [ {
        "address": "Voltastraße 100 13355",
        "location": {
            "lat": "52.542381",
            "lng": "13.392463"
        },
        "postcode": "13355"
    } ]
    }, {
    "accessibilities": {},
    "account": {
        "name": "John Doe",
        "pk": "51546e8e2769a15cc0468d85"
    },
    "allocated_hours": null,
    "alternative_route": null,
    "avoid": {
        "highways": false,
        "tolls": false
    },
    "cost": {
        "currency": "GBP",
        "value": 7
    },
    "customer_name": "Andy Warhol",
    "customer_phone": "+49123470416",
    "distance": {
        "km": 2.5,
        "miles": 1.6
    },
    "driver_pk": "50d092c0b6c1211963000067",
    "dropoff_location": {
        "address": "Wöhlertstraße 10 10115",
        "location": {
            "lat": "52.53673",
            "lng": "13.379416"
        },
        "postcode": "10115"
    },
    "duration": {
        "minutes": 15,
        "seconds": 900
    },
    "extra_instructions": "The three guys in blue.",
    "extras": [],
    "flight_number": "",
    "key": "13002r",
    "luggage": 5,
    "office": {
        "slug": "berlin-cars",
        "name": "Berlin Cars Ltd."
    },
    "passengers": 3,
    "payment_method": "cash",
    "payment_status": "",
    "pickup_location": {
        "address": "Grüntaler strasse 11 13357",
        "location": {
            "lat": "52.552037",
            "lng": "13.387291"
        },
        "postcode": "13357",
    },
    "pickup_time": "2013-05-07T12:30:00+00:00",
    "pk": "515470002769a110b26260c0",
    "prepaid": false,
    "price_correction": null,
    "receipt_url": "bookings/15003g/receipt",
    "status": "incoming",
    "total_cost": {
        "currency": "GBP",
        "value": 7.7
    },
    "vehicle_type": {
        "pk": "5093aff36e77c305510003a5", 
        "name": "Coupe"
    },
    "way_points": [ {
        "address": "Voltastraße 100 13355",
        "location": {
            "lat": "52.542381",
            "lng": "13.392463"
        },
        "postcode": "13355"
    } ]
    }],
  "count": 354,
  "status" : "OK",
  "status_code" : 200
}
*/
//example
$tdispatch->Bookings_list($order_by,$status,$pickup_time,$limit,$offset);



/*
* Bookings_create()
* Creates a new Booking in Draft or Incoming status. 
* Returns the created booking, according to given parameters
* @param $customer 
example: $customer= array(
    'name' => 'Vincent vvan Gogh',
    'phone' => '+49234654967'
);
* @param $passenger 
example:  $passenger = array(
    'name' => 'Pablo Picasso',
    'phone' => '+49123470416',
    'email' => 'pablo@tdispatch.com'
);
* @param $pickup_time  Timestamp for pickup time 
* @param $return_pickup_time Optional timestamp for returning booking pickup time
* @param $pickup_location 
example: = $pickup_location = array(
    'address' => 'Grüntaler strasse 11 13357',
    'postcode' => '13357',
    'door_number' => '15',
    'location' => array(        
        'lat' => '52.552037',
        'lng' => '13.387291'
    )
);
* @param $way_points 
example: $way_points = array(
    '0' => array(
        'address' => '',
        'postcode' => '',
        'door_number' => '',
        'location' => array(
            'lat' => '',
            'lng' => ''
        )
    )
);
* @param $dropoff_location 
example $dropoff_location = array(
    'address' => '11 Bramblefield Close DA3 7RT',
    'postcode' => 'DA3 7QA',
    'door_number' => '',
    'location' => array(
        'lat' => '51.3963894991',
        'lng' => '0.3007067293'
    )
); 
* @param $vehicle_type Vehicle's type unique ID
* @param $extra_instructions Passenger's extra instructions
* @param $luggage Amount of luggage going to be in the car
* @param $passengers Amount of persons going to be in the car
* @param $payment_method Payment method. Can be "cash", "account" or "credit-card"
* @param $prepaid = (boolean) Sets the booking was pre paid via account or credit
* @param $status Booking status. For creation, only "draft" and "incoming" are accepted.For update, this field is not updated, because it requires specific method for each status.
* @param $price_rule Price rule PK identifier. If empty, the default one assumes.

* @return (object) json object (booking)
example:
{
    "customer": {"name": "Vincent vvan Gogh", "phone": "+49234654967"},
    "passenger": {"name": "Pablo Picasso", "phone": "+49123470416", "email": "pablo@tdispatch.com"},
    "pickup_time": "2013-05-07T10:30:00-02:00",
    "return_time": "2013-05-09T10:30:00-02:00",
    "pickup_location": {"postcode": "13357", "location": {"lat": 52.552037, "lng": 13.387291}, "address": "Gr\u00fcntaler strasse 11"},
    "way_points": [{"postcode": "13355", "location": {"lat": 52.542381, "lng": 13.392463}, "address": "Voltastra\u00dfe 100"}],
    "dropoff_location": {"postcode": "10115", "location": {"lat": 52.53673, "lng": 13.379416}, "address": "W\u00f6hlertstra\u00dfe 10"},
    "luggage": 5,
    "passengers": 3,
    "extra_instructions": "The three guys in blue.",
    "payment_method": "cash",
    "pre_paid": false,
    "status": "incoming",
    "vehicle_type": "5174f4f02769a13ed9bdbeed"
 }
*/
//example
$tdispatch->Bookings_create($customer, $passenger, $pickup_time, $return_pickup_time, $pickup_location, $way_points, $dropoff_location, $vehicle_type, $extra_instructions, $luggage, $passengers, $payment_method, $prepaid, $status, $price_rule,$customs);

/*
* Bookings_get()
* Return information about a specific booking
* @param $bookingPk 
* @return (object) json object (booking)
example:
{
    "booking": {
        "allocated_hours": null,
        "alternative_route": null,
        "accessibilities": {},
        "account": {
            "pk": "51546e8e2769a15cc0468d85",
            "name": "Benjamin Franklin"
        },
        "avoid": {
            "highways": false,
            "tolls": false
        },
        "cost": {
            "currency": "GBP",
            "value": 25.91
        },
        "customer_name": "Benjamin",
        "customer_phone": "+49123470416",
        "distance": {
            "km": 0.62,
            "miles": 0.4
        },
        "dropoff_location": {
            "address": "11 Bramblefield Close DA3 7RT",
            "location": {
                "lat": "51.3963894991",
                "lng": "0.3007067293"
            },
            "postcode": "DA3 7QA"
        },
        "driver_pk": "50d092c0b6c1211963000067",
        "duration": {
            "seconds": 900,
            "minutes": 15
        },
        "extra_instructions": "The three guys in blue.",
        "extras": [],
        "flight_number": "",
        "key": "140001",
        "luggage": 5,
        "office": {
            "slug": "berlin-cars",
            "name": "Berlin Cars Ltd."
        },
        "passengers": 3,
        "payment_method": "cash",
        "payment_status": "",
        "pickup_location": {
            "postcode": "13357",
            "location": {
                "lat": "52.552037",
                "lng": "13.387291"
            },
            "address": "Grüntaler strasse 11 13357"
        },
        "pickup_time": "2013-05-07T12:30:00+00:00",
        "pk": "515966b72769a158f5d5be62",
        "prepaid": false,
        "price_correction": null,
        "receipt_url": "bookings/14002f/receipt",
        "status": "incoming",
        "total_cost": {
            "currency": "GBP",
            "value": 11.55
        },
        "vehicle_type": {
            "pk": "5093aff36e77c305510003a5", 
            "name": "Coupe"
        },
        "way_points": [
            {
                "postcode": "13355",
                "location": {
                    "lat": "52.542381",
                    "lng": "13.392463"
                },
                "address": "Voltastraße 100 13355"
            }
        ]
    },
    "status": "OK",
    "status_code": 200,
}
*/
//example
$tdispatch->Bookings_get($bookingPk);


/*
* Bookings_update()
* Updates a specific Booking information
* Returns the created booking, according to given parameters
* param are the same as Bookings_create()
* @return (object) json object (booking)
example:
{
    "customer": {"name": "Vincent vvan Gogh", "phone": "+49234654967"},
    "passenger": {"name": "Pablo Picasso", "phone": "+49123470416", "email": "pablo@tdispatch.com"},
    "pickup_time": "2013-05-07T10:30:00-02:00",
    "return_time": "2013-05-09T10:30:00-02:00",
    "pickup_location": {"postcode": "13357", "location": {"lat": 52.552037, "lng": 13.387291}, "address": "Gr\u00fcntaler strasse 11"},
    "way_points": [{"postcode": "13355", "location": {"lat": 52.542381, "lng": 13.392463}, "address": "Voltastra\u00dfe 100"}],
    "dropoff_location": {"postcode": "10115", "location": {"lat": 52.53673, "lng": 13.379416}, "address": "W\u00f6hlertstra\u00dfe 10"},
    "luggage": 5,
    "passengers": 3,
    "extra_instructions": "The three guys in blue.",
    "payment_method": "cash",
    "pre_paid": false,
    "status": "incoming",
    "vehicle_type": "5174f4f02769a13ed9bdbeed"
 }
*/
//example
$tdispatch->Bookings_update($customer, $passenger, $pickup_time, $return_pickup_time, $pickup_location, $way_points, $dropoff_location, $vehicle_type, $extra_instructions, $luggage, $passengers, $payment_method, $prepaid, $status, $price_rule,$customs);


/*
* Bookings_cancel()
* Cancellation of booking
* @param $bookingPk
* @param $description (string) Optional. Cancellation reason
* @return (bool) true or false
*/
//example
$tdispatch->Bookings_cancel($bookingPk, $description);


/*
* Bookings_receipt()
* Get PDF receipt of the booking.
* @param $bookingPk
* @return pdf
*/
//example
$tdispatch->Bookings_receipt($bookingPk);


/*
* Bookings_tracking()
* Tracking of booking
* @param $bookings (array) 
example: array($pk1, $pk2,$pkn);
* @return (object) json object
example:
{
    "bookings": [
        {
            "status": "active",
            "pk": "51891c9e2769a16d86cfaea3",
            "driver": {
                "pk": "4f4f8a6f54b4f35364000000",
                "location": {
                    "lat": 52.537293,
                    "lng": 13.378715
                },
                "name": "Bryony"
            },
            "return_code": 200
        }
    ],
    "status_code": 200,
    "status": "OK"
}
*/
//example
$tdispatch->Bookings_tracking($bookings);


/*
* Bookings_getCustom()
* Get custom fields for bookings in the office. Can be called anonymously
* @return (object) json object
example:
{
    "status": "OK",
    "status_code": 200,
    "custom_fields": [
        {
            "required": true,
            "type": "integer",
            "name": "Monthly income",
            "internal_name": "monthly_income"
        }
    ]
}
*/
//example
$tdispatch->Bookings_getCustom();

/* END - BOOKINGS FUNCTIONS */

/* VEHICLE  FUNCTIONS */
/*
* Vehicles_list()
* Returns list of available office's vehicle types. Can be called anonymously
* @param $limit Limit number of results. Optional (limited to 4)
* @return (object) json object
example:
{
    "status": "OK",
    "vehicle_types": [
        {
            "pk": "5086b3086e77c3590400e935",
            "name": "Coach"
        },
        {
            "pk": "5087c88e6e77c3323f0008db",
            "name": "Compact"
        },
        {
            "pk": "509bf6b56e77c352e10003f7",
            "name": "Convertible"
        },
        {
            "pk": "5093aff36e77c305510003a5",
            "name": "Coupe"
        }
    ],
    "status_code": 200
}
*/
//example
$tdispatch->Vehicles_list($limit);

/* END - VEHICLE  FUNCTIONS */

/* DRIVERS  FUNCTIONS */
/*
* Drivers_nearby()
* Returns list of nearby drivers. Can be called anonymously
* @param $limit (int) Limit number of drivers
* @param $location (array) Current passenger's location object example: array("lat"=> "52.12724","lng"=> "11.60905")
* @param $radius (float) Optional. Search radius in km. Default value is 0.1
* @param $offset (int) Use with limit parameter to get paged drivers; get {limit} drivers from {offset}. Default is 0
* @return (object) json object
example:
{
    "count": 4,
    "drivers": [
        {
            "lat": "52.12724",
            "lng": "11.60905"
        },
        {
            "lat": "52.12588",
            "lng": "11.61150"
        },
        {
            "lat": "52.12145",
            "lng": "11.61194"
        },
        {
            "lat": "52.12961",
            "lng": "11.60787"
        }
    ],
    "status": "OK",
    "status_code": 200
}
*/
//example
$tdispatch->Drivers_nearby($limit, $location, $radius, $offset);

/* END - DRIVERS  FUNCTIONS */