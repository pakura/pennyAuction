<?php

/**
 * Created by PhpStorm.
 * User: Nika
 * Date: 10/1/2015
 * Time: 5:37 PM
 */
class Email extends CI_Model {

    private $API_USERNAME = 'bids.ge';
    private $API_KEY = 'irakli11';

    public function send( $to, $subject, $msg, $from ){
        $params = array(
            'api_user'  => $this->API_USERNAME, //sengridis username
            'api_key'   => $this->API_KEY, //sengridis
            'to'        => $to, //useris email
            'subject'   => $subject,
            'html'      => $msg, // html mailis kodi
            'text'      => $msg, //texturi mailis kodi im shemtxvevashi tu useris maili ver archevs htmls
		    'from'      => $from, // no-replay@bids.ge
	    );
        $request = 'https://api.sendgrid.com/api/mail.send.json';
        $session = curl_init($request);
        curl_setopt ($session, CURLOPT_POST, true);
        curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
        curl_setopt($session, CURLOPT_HEADER, false);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($session);
        //error_log( $response );
        //print_r($response);
        curl_close($session);
    }

}