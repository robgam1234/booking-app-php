<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Drivers
 *
 * @author Punchline
 */
class Drivers {

    //put your code here

    public function nearby(TDispatch $td, $limit, $location, $radius, $offset) {
        $data = array(
            "access_token" => $td->getToken()
        );
        //TD url
        $url = $td->getFullApiUrl() . 'drivers/nearby?' . http_build_query($data);
        //Open connection

        $ch = curl_init();

        //Set the url, Number of POST vars, POST data
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);


        $dataSend = array(
            'limit' => $limit,
            'location' => $location,
            'radius' => $radius,
            'offset' => $offset
        );

        curl_setopt($ch, CURLOPT_POST, count($dataSend));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dataSend));


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
        return $res['drivers'];
    }

}

?>
