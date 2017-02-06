<?php
/**
 * Created by PhpStorm.
 * User: Pakura
 * Date: 12.10.2015
 * Time: 12:23
 */
class Auctionadmin extends CI_Controller{

    /**
     * @var Product
     */
    public $product;

    /**
     * @var Auction
     */
    public $auction;

    /**
     * @var Auctiondata
     */
    //public $auctiondata;

    public function getAuctions(){
        $finished = $_POST['finished'];
        $from = $_POST['from'];
        $to = $_POST['to'];
        $offset = intval($_POST['offset']);
        $this->load->model('admin/auctiondata');
        $result = $this->auctiondata->getAuctions($finished, $from, $to, $offset);
        echo json_encode($result);
    }

    public function getUsers(){
        $offset = intval($_POST['offset']);
        $this->load->model('admin/auctiondata');
        $result = $this->auctiondata->getUsers($offset);
        echo json_encode($result);
    }

    public function getAuctionsMembers(){
        $auctionid = intval($_POST['auctionid']);
        $this->load->model('admin/auctiondata');
        $result = $this->auctiondata->getAuctionsUsers($auctionid);
        $result1 = $this->auctiondata->getAuctionsUserstotal($auctionid);
        echo json_encode($result).'&'.json_encode($result1);
    }

    public function getProfile(){
        $userId = intval($_POST['userid']);
        $this->load->model('admin/auctiondata');
        if ($_POST['sec'] == 'info'){
            $result = $this->auctiondata->getProfileInfo($userId);
        }
        echo json_encode($result);
    }

    public function updateInfo(){
        $userId = intval($_POST['userid']);
        $name = $_POST['name'];
        $sname = $_POST['sname'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $dateofbirth = $_POST['dateofbirth'];
        $personalid = $_POST['personalid'];
        $verified = $_POST['verified'];
        $this->load->model('admin/auctiondata');
        if ($_POST['sec'] == 'update'){
            $result = $this->auctiondata->updateProfileInfo($userId, $name, $sname, $address, $city, $phone, $email, $dateofbirth, $personalid, $verified);
        }
        echo $result;
    }


    public function updatebids(){
        $userId = intval($_POST['userid']);
        $bids = intval($_POST['bids']);
        $this->load->model('admin/auctiondata');
        if ($_POST['sec'] == 'updatebids'){
            $result = $this->auctiondata->updateProfilebids($userId, $bids);
        }
        echo $result;
    }


    public function getProTransaction(){
        $userId = intval($_POST['userid']);
        $this->load->model('admin/auctiondata');
        if ($_POST['sec'] == 'profiletransaction'){
            $result = $this->auctiondata->getProTransactions($userId);
        }
        echo json_encode($result);
    }

}