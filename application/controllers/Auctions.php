<?php

/**
 * Created by PhpStorm.
 * User: Nika
 * Date: 9/8/2015
 * Time: 2:58 PM
 */
class Auctions extends CI_Controller {

    /**
     * @var Auction
     */
    public $auction;

    public function __construct(){
        parent::__construct();
        $this->lang->load('header','georgian');
        $this->lang->load('content','georgian');
        $this->load->helper('form');
    }

    public function index(){
    }

    public function item( $itemTitle ){
        $itemTitle = urldecode( $itemTitle );
        $this->load->model('product');
        $this->load->model('auction');
        $auctionData = $this->auction->getAuctionWithImages($itemTitle,$this->product);
        $bidders = $this->auction->getBidders($auctionData->id);
        $auctionData->buyItNowPrice = $auctionData->original_price;

        if( $this->session->userdata('loggedIn') ) {

            $auctionData->buyItNowPrice =
                $this->auction->calcBuyNowPrice($this->session->userdata('userId'), $auctionData->id, $auctionData );

            $autoBidder = $this->auction->getAutoBidder($auctionData->id, $this->session->userdata('userId') );
        }else{
            $autoBidder = null;
        }

        $this->loadLayout( 'content/auction_details', $auctionData->product_name , [
            'auctionData' => $auctionData,
            'bidders' => $bidders,
            'autoBidder' => $autoBidder
        ]);

    }

    public function buyNowPrice( $auctionId ){
        if( !$this->session->userdata('loggedIn') ) return;
        $auctionId = (int) $auctionId;
        $this->load->model('auction');
        echo $this->auction->calcBuyNowPrice( $this->session->userdata('userId'), $auctionId );
    }

    private function loadLayout( $view, $title = '', $data = [] ){

        $html = $this->load->view($view,$data,true);
        $header = $this->load->view('main/header',[],true);
        $footer = $this->load->view('main/footer',[],true);

        $this->load->view('layout/main_layout',[
            'title'=> $title,
            'header' => $header,
            'content'=> $html,
            'footer' => $footer
        ]);
    }



}