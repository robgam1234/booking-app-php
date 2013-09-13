<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FareCalculation
 *
 * @author Punchline
 */
class FareCalculation {

//put your code here

    public function fare(TDispatch $td, $pickup_postcode, $dropoff_postcode, $pickup = array(), $dropoff = array(), $waypoints = array()) {
        $data = array(
            "access_token" => $td->getToken()
        );
//TD url
        $url = $td->getFullApiUrl() . 'locations/fare?' . http_build_query($data);

//Open connection
        $ch = curl_init();

        $dataSend = array(
            'pickup_postcode' => $pickup_postcode,
            'dropoff_postcode' => $dropoff_postcode,
            'pickup_location' => $pickup,
            'dropoff_location' => $dropoff,
            'waypoints' => $waypoints
        );

//Set the url, Number of POST vars, POST data
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, count($dataSend));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dataSend));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

//Execute post
        $result = curl_exec($ch);
        $info = curl_getinfo($ch);
//Close connection
        curl_close($ch);
//Return json string
        return json_decode($result, true);
    }

}

?>
