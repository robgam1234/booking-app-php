<?php
/**
 * Description of Account
    Method	Resource path                   Description
    create	POST /accounts                  Creates new passenger's account
    get         GET /accounts/preferences	Returns account preferences
    update	POST /accounts/preferences	Updates account preferences
    get         GET /accounts/fleetdata         Returns account's office data
    post	POST /accounts/reset-password	Allows user to reset his password
    post	POST /accounts/change-password	Method to change password after reseting
 * @author Punchline
 */
class Account {
    /*
     * create() 
     * Creates new passenger's account and does sign in after that 
     * @param (object) TDispatch object
     * @param (array) passenger information  
     * @return (object) json object
     */
    public function create(TDispatch $td, $passenger = array()) {
        $data = array(
            "key" => $td->getApiKey()
        );
        //TD url
        $url = $td->getFullApiUrl() . 'accounts?' . http_build_query($data);
        //Open connection
        $ch = curl_init();
        $passenger = array_merge($passenger, array('client_id' => $td->getClientId()));
        //Set the url, Number of POST vars, POST data
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($passenger));
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($passenger));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        //Execute post
        $result = curl_exec($ch);
        $info = curl_getinfo($ch);
        //Close connection
        curl_close($ch);

        //Decode jsonresponse
        $response = json_decode($result, true);
        if ($info["http_code"] == "200" && $response["status"] === 'OK') {
            //Revoke anonimous first
            if (isset($_SESSION['TDISPATCH']['access']["anonimously"])) {
                $revoke = $td->oauth->revokeAuthorization();
                if ($revoke["status_code"] == "200") {
                    unset($_SESSION['TDISPATCH']['access']["anonimously"]);
                    unset($_SESSION['TDISPATCH']['access']["refresh"]);
                    if (isset($_SESSION['TDISPATCH']['access']) && count($_SESSION['TDISPATCH']['access']) == 0)
                        unset($_SESSION['TDISPATCH']['access']);
                    if (isset($_SESSION['TDISPATCH']) && count($_SESSION['TDISPATCH']) == 0)
                        unset($_SESSION['TDISPATCH']);
                }
            }
            //Auth info
            $_SESSION['TDISPATCH']['passenger']["pk"] = $response["passenger"]["pk"];
            $_SESSION['TDISPATCH']['access']["access_token"] = $response["passenger"]["access_token"];
            return $response;
        }
        $td->setError($response);
        return false;
    }

    /*
     * getPreferences()
     *
     * Returns object with account preferences 
     * @param (object) TDispatch object    
     * @return (object) json object    
     * return example:
     * {
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

    public function getPreferences(TDispatch $td) {


        $data = array(
            "access_token" => $td->getToken()
        );
        //TD url
        $url = $td->getFullApiUrl() . 'accounts/preferences?' . http_build_query($data);
        //Open connection

        $ch = curl_init();

        //Set the url, Number of POST vars, POST data
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        //Execute post
        $result = curl_exec($ch);
        $res = json_decode($result, true);
        $info = curl_getinfo($ch);
        //Close connection
        curl_close($ch);

        if (!isset($res['status']) || $res['status'] !== 'OK') {
            $td->setError($res);
            return false;
        }
        //Decode jsonresponse
        return $res['preferences'];
    }

    /*
     * setPreferences
     *
     * Returns object with account preferences 
     * @param (object) TDispatch object
     * @param (array) preferences
     * example:
     * 
      {
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
      }
     * @return (object) json object    
     * return example:
     * {
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

    public function setPreferences(TDispatch $td, $preferences = array()) {


        $data = array(
            "access_token" => $td->getToken()
        );
        //TD url
        $url = $td->getFullApiUrl() . 'accounts/preferences?' . http_build_query($data);
        //Open connection
        $ch = curl_init();

        //Set the url, Number of POST vars, POST data
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($preferences));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($preferences));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //Execute post
        $result = curl_exec($ch);
        $info = curl_getinfo($ch);
        //Close connection
        curl_close($ch);
        //Decode jsonresponse
        return json_decode($result, true);
    }

    public function getFleetdata(TDispatch $td) {
        $data = array(
            "access_token" => $td->getToken()
        );
        //TD url
        $url = $td->getFullApiUrl() . 'accounts/fleetdata?' . http_build_query($data);
        //Open connection

        $ch = curl_init();

        //Set the url, Number of POST vars, POST data
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        //Execute post
        $result = curl_exec($ch);
        $info = curl_getinfo($ch);
        //Close connection
        curl_close($ch);

        //Decode jsonresponse
        return json_decode($result, true);
    }

    public function resetPassword(TDispatch $td, $email = "") {
        $data = array(
            "key" => $td->getApiKey()
        );
        //TD url
        $url = $td->getFullApiUrl() . 'accounts/reset-password?' . http_build_query($data);
        //Open connection

        $ch = curl_init();

        //Set the url, Number of POST vars, POST data
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $dataSend = array(
            "email" => $email,
            "confirm_url"=>$td->getHomeUrl().$td->resetPasswordCallbackPage.'/?token={token}'
        );
        curl_setopt($ch, CURLOPT_POST, count($dataSend));
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($dataSend));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        if($td->debug){
            error_log(__FILE__.' in line '.__LINE__);
            error_log(__CLASS__.' in method '.__METHOD__);
            error_log("URL: ".$url);
            error_log("DATA BODY: ".http_build_query($dataSend));
        }

        //Execute post
        $result = curl_exec($ch);
        $info = curl_getinfo($ch);
        //Close connection
        curl_close($ch);

        //Decode jsonresponse
        return json_decode($result, true);
    }
    
     public function changePassword(TDispatch $td, $requestBody) {
        $data = array(
            "key" => $td->getApiKey()
        );
        //TD url
        $url = $td->getFullApiUrl() . 'accounts/change-password?' . http_build_query($data);
        //Open connection

        $ch = curl_init();

        //Set the url, Number of POST vars, POST data
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        
        curl_setopt($ch, CURLOPT_POST, count($requestBody));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestBody));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        if($td->debug){
            error_log(__FILE__.' in line '.__LINE__);
            error_log(__CLASS__.' in method '.__METHOD__);
            error_log("URL: ".$url);
            error_log("DATA BODY: ".json_encode($requestBody));
        }

        //Execute post
        $result = curl_exec($ch);
        $res = json_decode($result, true);       
        $info = curl_getinfo($ch);
        //Close connection
        curl_close($ch);

        if (!isset($res['status']) || $res['status'] !== 'OK') {
            $td->setError($res);
            return false;
        }
        //Decode jsonresponse
        return true;
    }

}

?>
