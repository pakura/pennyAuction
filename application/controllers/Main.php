<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: Nika
 * Date: 8/20/2015
 * Time: 4:45 PM
 */

class Main extends CI_Controller{

    /**
     * @var CI_Form_validation
     */
    public $form_validation;
    /**
     * @var User
     */
    public $user;
    /**
     * @var Auction
     */
    public $auction;

    /**
     * @var Email
     */
    public $email;

    const AUCTIONS_ON_HOMEPAGE = 15;

    public function __construct(){
        parent::__construct();
        $this->lang->load('header','georgian');
        $this->lang->load('content','georgian');
        $this->load->helper('form');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->load->model('auction');
        $aucs = $this->auction->getAuctions( Main::AUCTIONS_ON_HOMEPAGE );
        $items = $this->load->view('content/items',[
            'auctions' => $aucs
        ],true);

        $soldAucs = $this->auction->getSoldAuctions(5);
        $soldItems = $this->load->view('content/items',[
            'auctions' => $soldAucs
        ],true);

        $slide = $this->load->view('main/slide',[],true);
        $contentfilter = $this->load->view('content/contentfilter',[],true);
        $this->loadLayout('main/home','ინტერნეტ აუქციონი',[
            'slide' => $slide,
            'contentfilter' => $contentfilter,
            'items' => $items,
            'soldItems' => $soldItems
        ]);

    }

    public function login(){
        $this->lang->load('register','georgian');

        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username','Username','trim|required|min_length[3]|max_length[20]');
        $this->form_validation->set_rules('password','Password','trim|required|min_length[6]|max_length[36]');
        if( $this->form_validation->run() == false ){
            if( $this->session->userdata('fb') != null ){
                $st = $this->user->loginWithFb();
                if( isset($st['userId']) ) {
                    $this->session->set_userdata('fb',null);
                    redirect('/');
                }else{
                    redirect('/register');
                }
            }

            $this->loadLayout('main/register','შესვლა',[
                'defaults' => []
            ]);
        }else{
            $st = $this->user->login(
                $this->input->post('username'),
                $this->input->post('password')
            );

            if( isset( $st['userId'] ) ){
                redirect('/');
            }else{
                $this->loadLayout('main/register','შესვლა',[
                    'defaults' => []
                ]);
            }
        }
    }

    public function logout(){
        $this->session->set_userdata([
            'userId' => null,
            'username' => null,
            'loggedIn' => false
        ]);
        redirect('/');
    }


    private function checkCaptcha(){
        $g_recaptcha_response = $_POST['g-recaptcha-response'];
        $secret = '6Ldu3w0TAAAAAEPQHjfph3w74Kxma1giL6jkJJam';
        $remoteip = $_SERVER['REMOTE_ADDR'];
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$g_recaptcha_response&remoteip=$remoteip";

        $response = file_get_contents($url);
        $response = json_decode($response);
        return $response->success;
    }

    public function activate( $key ){
        $res = $this->user->activateAccount($key);
        $this->loadLayout('main/activation','აქტივაცია',$res);
    }


    public function register(){
        $this->config->set_item('language', 'georgian');
        $this->lang->load('register','georgian');

        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('username','Username','trim|required|min_length[3]|max_length[20]');
        $this->form_validation->set_rules('password','Password','trim|required|min_length[6]|max_length[36]');
        $this->form_validation->set_rules('password2','Password','trim|required|matches[password]');
        $this->form_validation->set_rules('firstname','First Name','trim|required|max_length[100]');
        $this->form_validation->set_rules('lastname','Last Name','trim|required|max_length[100]');
        $this->form_validation->set_rules('gender','Gender','trim|required|in_list[0,1]');
        $this->form_validation->set_rules('date_of_birth','date of birth','trim|required');
        $this->form_validation->set_rules('id_number','id_number','trim|required|numeric|min_length[11]|max_length[11]');
        $this->form_validation->set_rules('phone','phone','trim|required|numeric|min_length[9]|max_length[9]');
        $this->form_validation->set_rules('email','email','trim|required|valid_email');
        $this->form_validation->set_rules('address','address','trim|required|max_length[255]');
        $this->form_validation->set_rules('city','city','trim|required|max_length[50]');

        if( $this->form_validation->run() == false ){
            $this->load->config('cities');
            $params = [
                'cities' => $this->config->item('cities'),
                'defaults' => []
            ];
            if( $this->session->userdata('fb') != null ){
                $params['defaults'] = $this->session->userdata('fb');
                if( strpos($params['defaults']['email'],'@') === false ){
                    $params['defaults']['phone'] = $params['defaults']['email'];
                    unset($params['defaults']['email']);
                }
            }
            $this->loadLayout('main/register','რეგისტრაცია',$params);
        }else{
            $from = new DateTime( $this->input->post('date_of_birth') );
            $to   = new DateTime('today');
            $age = $from->diff($to)->y;
            if( $age < 18 ){
                $res = [ 'duplicate' => 'age' ];
            }

            if ( !$this->checkCaptcha()){
                $res = [
                    'duplicate' => 'captcha'
                ];
            }

            if( !isset($res) ){
                $this->load->model('user');
                $res = $this->user->register(
                    $this->input->post('username'),
                    $this->input->post('password'),
                    $this->input->post('firstname'),
                    $this->input->post('lastname'),
                    $this->input->post('gender'),
                    $this->input->post('date_of_birth'),
                    $this->input->post('id_number'),
                    $this->input->post('phone'),
                    $this->input->post('email'),
                    $this->input->post('address'),
                    $this->input->post('city'),
                    $this->session->userdata('fb') != null ? $this->session->userdata('fb')['id'] : 0
                );
            }

            if( isset($res['duplicate']) ){
                $this->load->config('cities');
                $params = [
                    'cities' => $this->config->item('cities'),
                    'defaults' => [],
                    'duplicate' => $res['duplicate']
                ];
                $this->loadLayout('main/register','რეგისტრაცია',$params);
            }

            $this->load->model('email');
            //$this->email->send($this->input->post('email'),'register','please activate your account at https://bids.ge/main/activate/'.$res['activationKey'],'info@bids.ge');

            $this->session->set_userdata('regSuccess',true);
            redirect('/profile/info');
            return;
        }

    }


    private function loadLayout( $view, $title = '', $data = [] ){

        $html = $this->load->view($view,$data,true);
        $header = $this->load->view('main/header',[],true);
        $footer = $this->load->view('main/footer',[],true);

        $this->load->view('layout/main_layout',[
            'title'=> 'bids.ge - '.$title,
            'header' => $header,
            'content'=> $html,
            'footer' => $footer
        ]);
    }


    public function allAuctions($offset = 0){
        $offset = (int)$offset;
        $this->load->model('auction');
        $aucs = $this->auction->getAuctions(16, $offset);
        $contentfilter = $this->load->view('content/contentfilter', [], true);

        $allAuction = $this->load->view('content/items',[
            'auctions' => $aucs
        ],true);

        $this->loadLayout('content/auction','აუქციონი',[
            'contentfilter' => $contentfilter,
            'items' => $allAuction,
            'offset' => $offset
        ]);
    }

    public function search( $term, $offset = 0){
        $offset = (int)$offset;
        if( !isset($term) ){
            $term = '';
        }
        $term = urldecode($term);
        $this->load->model('auction');
        $aucs = $this->auction->searchAuctions($term,16,$offset);
        $contentfilter = $this->load->view('content/contentfilter', [
            'searchTerm' => $term
        ], true);

        $allAuction = $this->load->view('content/items',[
            'auctions' => $aucs
        ],true);

        $this->loadLayout('content/auction','აუქციონი',[
            'contentfilter' => $contentfilter,
            'items' => $allAuction,
            'offset' => $offset
        ]);
    }

    public function faq(){
        $this->lang->load('faq','georgian');
        $this->loadLayout('content/faq','F.A.Q.',[
        ]);
    }

    public function terms(){
        $this->lang->load('faq','georgian');
        $this->loadLayout('content/terms','F.A.Q.',[
        ]);
    }

    public function contact(){
        $this->config->set_item('language', 'georgian');
        $this->lang->load('register','georgian');

        $this->load->helper('form');
        $this->load->library('form_validation');

        $params = [
            'sent' => false
        ];
        if( $this->session->userdata('loggedIn') ){
            $params['userdata'] = $this->user->getUserInfo( $this->session->userdata('userId') );
        }

        $this->form_validation->set_rules('name','Name','trim|required|max_length[100]');
        $this->form_validation->set_rules('email','email','trim|required|valid_email');
        $this->form_validation->set_rules('subject','subject','trim|required|min_length[5]|max_length[30]');
        $this->form_validation->set_rules('message','message','trim|required|min_length[30]|max_length[1000]');

        if( $this->form_validation->run() == false ){
            $this->loadLayout('content/contact','კონტაქტი',$params);
        }else{
            if ($this->checkCaptcha()){
                $params['captcha'] = true;
                $params['sent'] = true;
            } else {
                $params['captcha'] = false;
            }
            $this->loadLayout('content/contact','კონტაქტი',$params);
        }

    }

}