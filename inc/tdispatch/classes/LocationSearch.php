<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LocationSearch
 *
 * @author Punchline
 */
class LocationSearch {

    //put your code here

    public function search(TDispatch $td, $q = "", $limit = 10, $type = "") {
        $data = array(
            "access_token" => $td->getToken(),
            "q" => $q, //	string	Query string to search locations. Required
            "limit" => $limit, //	int	Limit number of locations. Optional
            "type" => $type //	string	Should be 'pickup' if location is going to be used for a pickup. Optional.
        );
        //TD url
        $url = $td->getFullApiUrl() . 'locations/search?' . http_build_query($data);
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
        return $res;
    }

}

?>
