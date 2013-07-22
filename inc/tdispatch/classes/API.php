<?php
/**
 * Returns basic information about the current API session. Can be called anonymously
 *
 * @author Punchline
 */
class API {
    
    public function API_getInfo($td) {
        $data = array(
            "access_token" => $td->getToken()
        );
        //TD url
        $url = $td->getFullApiUrl() . 'api-info?' . http_build_query($data);
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
        //Return json string
        return json_decode($result, true);
    }
}
?>