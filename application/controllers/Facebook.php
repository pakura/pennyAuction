<?php

/**
 * Created by PhpStorm.
 * User: Nika
 * Date: 9/28/2015
 * Time: 5:30 PM
 */

require_once 'vendor/autoload.php';

class Facebook extends CI_Controller {

    /**
     * @var Facebook\Facebook
     */
    public $fb;

    public function __construct(){
        parent::__construct();
        $this->fb = new Facebook\Facebook([
            'app_id' => '828474430606212',
            'app_secret' => '701f7fab7fed21e1255353644aad111f',
            'default_graph_version' => 'v2.4',
        ]);
    }

    public function login(){
        $helper = $this->fb->getRedirectLoginHelper();
        $permissions = ['email','user_birthday','user_location' ]; // Optional permissions
        $loginUrl = $helper->getLoginUrl('https://bids.ge/facebook/callback/', $permissions);
        redirect($loginUrl);
    }

    public function callback(){
        $helper = $this->fb->getRedirectLoginHelper();
        try {
            $accessToken = $helper->getAccessToken();
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            error_log( 'Graph returned an error: ' . $e->getMessage() );
            redirect('/');
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            error_log( 'Facebook SDK returned an error: ' . $e->getMessage() );
            redirect('/');
            exit;
        }
        if (! isset($accessToken)) {
            if ($helper->getError()) {
                header('HTTP/1.0 401 Unauthorized');
                echo "Error: " . $helper->getError() . "\n";
                echo "Error Code: " . $helper->getErrorCode() . "\n";
                echo "Error Reason: " . $helper->getErrorReason() . "\n";
                echo "Error Description: " . $helper->getErrorDescription() . "\n";
            } else {
                header('HTTP/1.0 400 Bad Request');
                echo 'Bad request';
            }
            exit;
        }

        try {
            //,user_birthday,user_location
            $response = $this->fb->get('/me?fields=id,first_name,last_name,email', $accessToken->getValue());
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        $user = $response->getGraphUser();
        $this->session->set_userdata('fb',$user->all());
        redirect('/main/login');
    }

}