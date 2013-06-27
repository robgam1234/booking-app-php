<?php

/*
 * Description of Vehicles
 *
 * @author Punchline
 */
class Vehicles {

    //put your code here
    public function vehicles_list(TDispatch $td,$limit = 4) {
        $data = array(
            "access_token" => $td->getToken()
        );
        //TD url
        $url = $td->getFullApiUrl() . 'vehicletypes?' . http_build_query($data);        
        //Open connection

        $ch = curl_init();

        //Set the url, Number of POST vars, POST data
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);

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
        return array_slice($res['vehicle_types'], 0, $limit);
    }

}

?>
