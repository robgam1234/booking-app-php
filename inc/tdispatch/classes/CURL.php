<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CURL
 *
 * @author Punchline
 */
class CURL {

    //put your code here

    var $ch = null;
    var $site = null;

    function __construct($site) {
        if (isset($site)) {
            $this->site = $site;          
            $this->init();
        }
    }

    function init() {
        if (!isset($this->ch)) {            
            $options = array(
                CURLOPT_RETURNTRANSFER => true, // return web page
                CURLOPT_URL => $this->site
            );
            $this->ch = curl_init($this->site);
            curl_setopt_array($this->ch, $options);
        }
    }

    function getSource() {
        if (isset($this->ch)) {
            curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($this->ch, CURLOPT_HEADER, false);
            return curl_exec($this->ch);
        }
    }

    function getHeaders() {
        if (isset($this->ch)) {
            curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, false);
            curl_setopt($this->ch, CURLOPT_HEADER, true);
            return curl_exec($this->ch);
        }
    }

    function getInfo() {
        if (isset($this->ch)) {
            return curl_getinfo($this->ch);
        }
    }

    function close() {
        if (isset($this->ch)) {                   
            curl_close($this->ch);
            unset($this->ch);
        }
    }

    function __destruct() {       
        $this->close();
    }
    
    function setPost($data = array()){
        if(count($data)){            
            curl_setopt($this->ch, CURLOPT_POST, true);
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($data));
        }
    }

}

?>
