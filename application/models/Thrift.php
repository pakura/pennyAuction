<?php

/**
 * Created by PhpStorm.
 * User: Nika
 * Date: 9/16/2015
 * Time: 4:38 PM
 */

//require_once __DIR__. '/../../lib/php/lib/Thrift/ClassLoader/ThriftClassLoader.php';

require_once 'vendor/apache/thrift/lib/php/lib/Thrift/ClassLoader/ThriftClassLoader.php';

use Thrift\ClassLoader\ThriftClassLoader;

$loader = new ThriftClassLoader();
$loader->registerNamespace('Thrift', 'vendor/apache/thrift/lib/php/lib');
$loader->register();

require_once 'application/extra/ge/bids/thrift/auction/Auction.php';
require_once 'application/extra/ge/bids/thrift/auction/Types.php';

use Thrift\Protocol\TCompactProtocol;
use Thrift\Transport\TSocket;
use Thrift\Transport\TFramedTransport;
use Thrift\Exception\TException;

use ge\bids\thrift\auction\AuctionClient;
use ge\bids\thrift\auction\Status;

class Thrift extends CI_Model {

    /**
     * @var AuctionClient;
     */
    private $client = null;

    public function __construct(){
        parent::__construct();
        $socket = new TSocket('192.168.0.125',4452);
        $transport = new TFramedTransport($socket);
        $protocol = new TCompactProtocol($transport);
        $this->client = new AuctionClient($protocol);
        $transport->open();
    }

    /*
     * 	Status makeBid( 1:i32 userId, 2:i32 auctionId )

	Status autoBidOptions( 1:i32 userId, 2:i32 auctionId, 3:double fromPrice, 4:double toPrice, 5:i32 bids )

	Status loadAuction( 1:i32 auctionId )

	list<AuctionInfo> getUpdates( 1:i64 lastUpdate )*/

    public function makeBid( $userId, $auctionId ){
        return $this->client->makeBid($userId,$auctionId);
    }

    public function autoBidOptions( $userId, $auctionId, $startPrice, $endPrice, $bids ){
        return $this->client->autoBidOptions($userId,$auctionId,$startPrice,$endPrice,$bids);
    }

    public function loadAuction( $auctionId ){
        return $this->client->loadAuction($auctionId);
    }

    public function getUpdates( $lastUpdate ){
        return $this->client->getUpdates($lastUpdate);
    }
}