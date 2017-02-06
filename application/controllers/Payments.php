<?php

/**
 * Created by PhpStorm.
 * User: Nika
 * Date: 9/25/2015
 * Time: 4:09 PM
 */
class Payments extends CI_Controller{

    private $pubKey = '-----BEGIN CERTIFICATE-----
MIIEDDCCAvSgAwIBAgIJAIsfWLbDSHfWMA0GCSqGSIb3DQEBBQUAMGExCzAJBgNV
BAYTAkdFMQswCQYDVQQIEwJkZjELMAkGA1UEBxMCZGYxCzAJBgNVBAoTAmRmMQsw
CQYDVQQLEwJkZjELMAkGA1UEAxMCZGYxETAPBgkqhkiG9w0BCQEWAmRmMB4XDTEx
MTAwNjEzMzgyNloXDTExMTEwNTEzMzgyNlowYTELMAkGA1UEBhMCR0UxCzAJBgNV
BAgTAmRmMQswCQYDVQQHEwJkZjELMAkGA1UEChMCZGYxCzAJBgNVBAsTAmRmMQsw
CQYDVQQDEwJkZjERMA8GCSqGSIb3DQEJARYCZGYwggEiMA0GCSqGSIb3DQEBAQUA
A4IBDwAwggEKAoIBAQDVuRwazjuILizu5VQl2UkPTiwVWL2UhLWbXPpzTsK9Q0Cs
smzBaGso4DXWU76vRsSktd1aYl28Y6i8K4ILggWiD9XV+5ozWjq9odO56Tlz/MuL
QJpi9OXryeLj2EonctdNokYQ0VTbTcbUhIjiZZBhqvnt1dQfHAM8a5fZ8Rljb+ap
SZj7hBzHmxE5g8P80Pum4veKRSGcB1raSDl3uQaE+7OfEARArWoJm4nmDJ0b26Ev
f3U7YlyUYIhkOipASHplcSYIg5VqVxrC1JximqYsHvt3Bd2/qHG8ERWOEk7pABR/
cHlsNj2hPtrnpFRuufH6/fbmcho+f/+olvHLrtFbAgMBAAGjgcYwgcMwHQYDVR0O
BBYEFE0nQgEfME40llCVav2VfiQv9IGRMIGTBgNVHSMEgYswgYiAFE0nQgEfME40
llCVav2VfiQv9IGRoWWkYzBhMQswCQYDVQQGEwJHRTELMAkGA1UECBMCZGYxCzAJ
BgNVBAcTAmRmMQswCQYDVQQKEwJkZjELMAkGA1UECxMCZGYxCzAJBgNVBAMTAmRm
MREwDwYJKoZIhvcNAQkBFgJkZoIJAIsfWLbDSHfWMAwGA1UdEwQFMAMBAf8wDQYJ
KoZIhvcNAQEFBQADggEBAGRx0DPIyGrQWg34m3zysHLA+NE+XCRegIphzvbkWMS2
5JLl6pUMRtfZOep0U/+ZqvcbcZuAMBbOPLnKaf2p9mg2JBuK9beKcrXr3K7eA5q+
VGhb+9vHuQZ932V1h/Cpzl46VwoBRyOc10evGV+kT0wP7H6ZGk5GP1SKqOKO6IJ4
nd4N3RaAlR+6M6rPRAmDOb8Uw6x/Rmxir7AynfmGqtDgHXyUs3Fj+2iR3+KCVzcN
T+PtS6vjKH3NbmOeTV/hoqYNHysOAcJx5YFC2+Yp5ATBhiEpPfR4NlrVBOcHIQW+
iTEWppR/b9T1IfqfwMZhUhhcGNC4sWSRt17oUUztDpI=
-----END CERTIFICATE-----';

    /**
     * @var Auction
     */
    public $auction;

    /**
     * @var Payment
     */
    public $payment;

    /**
     * @var User
     */
    public $user;

    private $MerchantId = '';
    private $MerchantPassword = '';

    public function __construct(){
        parent::__construct();
    }

    private function checkLogin(){
        if( !$this->session->userdata('loggedIn') ){
            redirect('/');
            die();
        }
    }

    public function cancel(){
        redirect('/');
    }

    public function error(){
        redirect('/');
    }

    public function success(){
        redirect('/');
    }

    public function payCallback(){

        $transCode = '';
        if( isset($_GET['transactioncode']) )
            $transCode = $_GET['transactioncode'];
        $amount = (int) $_GET['amount'];
        $currency = $_GET['currency'];
        $orderCode = $_GET['ordercode'];
        $payMethod = $_GET['paymethod'];
        $payedAmount = '';
        if( isset($_GET['payedamount']) )
            $payedAmount = $_GET['payedamount'];
        $customData = '';
        if( isset($_GET['customdata'] ) )
            $customData = $_GET['customdata'];
        $check = $_GET['check'];
        $status = $_GET['status'];
        $testMode = '';
        if( isset($_GET['testmode']) )
            $testMode = $_GET['testmode'];

        $check2 = hash('sha256',
            $status.$transCode.$amount.$currency.$orderCode.$payMethod.$payedAmount.
            $customData.$testMode.$this->MerchantPassword
        );

        if( $check != $check2 ){
            $this->xmlRsp(-3,'invalid check',$transCode);
            return;
        }

        $this->load->model('payment');
        $this->load->model('auction');
        $this->load->model('user');

        $tran = $this->payment->getTransaction($orderCode);
        if( $tran == null ){
            $this->xmlRsp(-2,'not found',$transCode);
            return;
        }

        if( $tran->confirmed == 1 ){
            $this->xmlRsp(1,'dublicate',$transCode);
            return;
        }

        if( $tran->amount != $amount ){
            $this->xmlRsp(-3,'invalid data',$transCode);
            return;
        }

        if( $tran->auction_id != 0 ){
            $this->auction->markAsPayed($tran->auction_id);
        }else{
            $this->load->config('packages');
            $packages = $this->config->item('packages');
            $bids = $packages[ $tran->package_id -1 ]['bids'];
            $this->user->depositBids($tran->user_id,$bids);
        }

        $this->payment->updateTransaction($tran->id,$transCode,1);
    }

    public function callback(){
        $req = $_POST['ConfirmRequest'];
        $sig = $_POST['Signature'];
        $sig = urldecode($sig);
        $sig = base64_decode($sig);

        $ok = openssl_verify('ConfirmRequest='.$req, $sig, $this->pubKey, OPENSSL_ALGO_SHA1);
        if( $ok != 1 ){
            $this->xmlRsp( 0,0, false );
            return;
        }

        $req = new SimpleXMLElement($req);

        $this->load->model('payment');

        $tran = $this->payment->getTransaction( $req->TransactionId );
        if( $tran == null ){
            $this->xmlRsp( $req->TransactionId, $req->PaymentId, false );
            return;
        }

        $tran->amount = number_format($tran->amount, 2, '.', '');
        if( $tran->amount != $req->Amount ){
            $this->xmlRsp( $req->TransactionId, $req->PaymentId, false );
            return;
        }

        if( $req->Status == 'C' ){
            $this->payment->updateTransaction($tran->id, $req->PaymentId, $req->PaymentDate, $req->CardType, $req->Reason );
            $this->xmlRsp( $req->TransactionId, $req->PaymentId, true );
        }else if( $req->Status == 'Y' ){
            $this->payment->confirmTransaction($tran->id);
            if( $tran->auction_id != 0 ){
                $this->auction->markAsPayed($tran->auction_id);
            }else{
                $this->load->config('packages');
                $packages = $this->config->item('packages');
                $bids = $packages[ $tran->package_id -1 ]['bids'];
                $this->user->depositBids($tran->user_id,$bids);
            }
        }else{
            error_log('transaction canceled');
        }


    }

    private function xmlRsp( $transId, $paymentId, $status ){
        $status = $status ? 'ACCEPTED' : 'DECLINED';
        $xml = "<ConfirmResponse>
                    <TransactionId>$transId</TransactionId>
                    <PaymentId>$paymentId</PaymentId>
                    <Status >$status</Status >
                </ConfirmResponse>
        ";

        echo $xml;
    }

    public function payItem( $auctionId ){
        $this->checkLogin();
        $auctionId = (int) $auctionId;
        $this->load->model('auction');
        $auc = $this->auction->getAuctionById($auctionId);
        if( $auc == null ){
            echo 'auction not found';
            die();
        }
        if( $auc->last_bidder_id != $this->session->userdata('userId') ){
            echo 'not your auction';
            die();
        }

        $this->load->model('payment');

        $price = number_format($auc->price, 2, '.', '');
        if( strlen($auc->product_name) > 100 ){
            $auc->product_name = substr($auc->product_name,0,100);
        }
        $st = $this->payment->addTransaction($price,$this->session->userdata('userId'),$auctionId);
        $transId = $st['insertId'];

        $this->load->view('payment/payment',[
            'orderCode' => $transId,
            'amount' => $price,
        ]);
    }

    public function payPackage( $packageId ){
        $this->checkLogin();
        $packageId = (int)$packageId;
        $this->load->config('packages');
        $packages = $this->config->item('packages');

        if( count($packages) < $packageId || $packageId < 1 ){
            echo 'invalid package';
            return;
        }

        $price = $packages[ $packageId-1 ]['price'];
        $price = number_format($price, 2, '.', '');

        $st = $this->payment->addTransaction( $price ,$this->session->userdata('userId'),0,$packageId);
        $transId = $st['insertId'];

        $this->load->view('payment/payment',[
            'orderCode' => $transId,
            'amount' => $price,
        ]);
    }

}