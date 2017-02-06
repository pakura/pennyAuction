<?php

/**
 * Created by PhpStorm.
 * User: Nika
 * Date: 9/14/2015
 * Time: 4:26 PM
 */
class Profile extends CI_Controller {

    /**
     * @var User
     */
    public $user;

    /**
     * @var Auction
     */
    public $auction;

    public function __construct(){
        parent::__construct();

        if( !$this->session->userdata('loggedIn') ){
            redirect('/');
            die();
        }

        $this->lang->load('header','georgian');
        $this->lang->load('content','georgian');
        $this->lang->load('profile','georgian');

    }

    public function info(){
        $this->load->model('user');

        $regSuccess = '';
        if( $this->session->userdata('regSuccess') != null ){
            $this->session->set_userdata('regSuccess',null);
            $regSuccess = $this->load->view('main/register_success',[],true);
        }

        $profileContent = $this->load->view('profile/profile_info', [
            'userdata' => $this->user->getUserInfo( $this->session->userdata('userId') ),
            'regSuccess' => $regSuccess
        ], true );

        $menu = $this->load->view('profile/profile_menu',[
            'isActive' => $this->getMenuCssClasses('info')
        ],true);

        $this->loadLayout('profile/profile_content','პროფილი',[
            'menu' => $menu,
            'content' => $profileContent
        ]);
    }

    public function update(){
        $this->config->set_item('language', 'georgian');
        $this->lang->load('register','georgian');
        $this->load->model('user');
        $this->load->helper('form');
        $this->load->library('form_validation');

        $validUpdate = false;
        $passwordStatus = null;

        $this->form_validation->set_rules('oldpassword','Password','trim|required|min_length[6]|max_length[36]');
        $this->form_validation->set_rules('password','Password','trim|min_length[6]|max_length[36]');
        $this->form_validation->set_rules('password2','Password','trim|matches[password]');
        $this->form_validation->set_rules('phone','phone','trim|required|numeric|min_length[9]|max_length[9]');
        $this->form_validation->set_rules('email','email','trim|required|valid_email');
        $this->form_validation->set_rules('address','address','trim|required|max_length[255]');
        $this->form_validation->set_rules('city','city','trim|required|max_length[50]');
        $this->form_validation->set_rules('avatar','avatar','trim|required|integer');

        if( $this->form_validation->run() == false ){

        }else{
            $oldPwd = $this->input->post('oldpassword');
            $pwd1 = $this->input->post('password');
            $pwd2 = $this->input->post('password2');
            if( !empty($oldPwd) && !empty($pwd1) && !empty($pwd2) ){
                $passwordStatus = $this->user->changePassword($this->session->userdata('userId'),$oldPwd,$pwd1);
            }
            $res = $this->user->updateInfo(
                $this->input->post('oldpassword'),
                $this->session->userdata('userId'),
                $this->input->post('phone'),
                $this->input->post('email'),
                $this->input->post('address'),
                $this->input->post('city'),
                $this->input->post('avatar')
            );
            $validUpdate = true;
            if( $passwordStatus == null || $passwordStatus['affectedRows'] > 0 ){
                redirect('/profile/info');
                die();
            }
        }

        $this->load->config('cities');
        $profileContent = $this->load->view('profile/profile_update', [
            'userdata' => $this->user->getUserInfo( $this->session->userdata('userId') ),
            'validUpdate' => $validUpdate,
            'cities' => $this->config->item('cities'),
            'avatarCount' => $this->user->getAvatarCount(),
            'invalidPassword' => $passwordStatus != null && $passwordStatus['affectedRows'] == 0 ? true : false
        ], true );

        $menu = $this->load->view('profile/profile_menu',[
            'isActive' => $this->getMenuCssClasses('info')
        ],true);

        $this->loadLayout('profile/profile_content','პროფილის რედაქტირება',[
            'menu' => $menu,
            'content' => $profileContent
        ]);
    }

    public function buy(){
        $profileContent = $this->load->view('profile/buy_bids',[],true);
        $menu = $this->load->view('profile/profile_menu',[
            'isActive' => $this->getMenuCssClasses('buy')
        ],true);
        $this->loadLayout('profile/profile_content','იყიდე ბიდები',[
            'menu' => $menu,
            'content' => $profileContent
        ]);
    }

    public function win(){
        $this->load->model('auction');
        $profileContent = $this->load->view('profile/auction_list',[
            'auctions' => $this->auction->getAuctionsWon($this->session->userdata('userId'),0)
        ],true);
        $menu = $this->load->view('profile/profile_menu',[
            'isActive' => $this->getMenuCssClasses('win')
        ],true);
        $this->loadLayout('profile/profile_content','მოგებული აუქციონები',[
            'menu' => $menu,
            'content' => $profileContent
        ]);
    }

    public function purchase(){
        $this->load->model('auction');
        $profileContent = $this->load->view('profile/auction_list',[
            'auctions' => $this->auction->getAuctionsWon($this->session->userdata('userId'),1)
        ],true);
        $menu = $this->load->view('profile/profile_menu',[
            'isActive' => $this->getMenuCssClasses('purchase')
        ],true);
        $this->loadLayout('profile/profile_content','შესყიდვების ისტორია',[
            'menu' => $menu,
            'content' => $profileContent
        ]);
    }

    public function ongoing(){
        $this->load->model('auction');
        $profileContent = $this->load->view('profile/auction_list',[
            'auctions' => $this->auction->getUserAuctions($this->session->userdata('userId'),true)
        ], true);
        $menu = $this->load->view('profile/profile_menu',[
            'isActive' => $this->getMenuCssClasses('ongoing')
        ],true);
        $this->loadLayout('profile/profile_content','მიმდინარე აუქციონები',[
            'menu' => $menu,
            'content' => $profileContent
        ]);
    }

    public function history(){
        $this->load->model('auction');
        $profileContent = $this->load->view('profile/auction_list',[
            'auctions' => $this->auction->getUserAuctions($this->session->userdata('userId'))
        ], true);
        $menu = $this->load->view('profile/profile_menu',[
            'isActive' => $this->getMenuCssClasses('history')
        ],true);
        $this->loadLayout('profile/profile_content','აუქციონების ისტორია',[
            'menu' => $menu,
            'content' => $profileContent
        ]);
    }

    public function help(){
        $this->lang->load('faq','georgian');
        $profileContent = $this->load->view('profile/help',[],true);
        $menu = $this->load->view('profile/profile_menu',[
            'isActive' => $this->getMenuCssClasses('help')
        ],true);
        $this->loadLayout('profile/profile_content','დახმარება',[
            'menu' => $menu,
            'content' => $profileContent
        ]);
    }

    private function getMenuCssClasses( $page ){
        $cl = [
            'info' => '',
            'buy' => '',
            'win' => '',
            'purchase' => '',
            'ongoing' => '',
            'help' => '',
            'history' => ''
        ];
        $cl[$page] = 'active';
        return $cl;
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

}