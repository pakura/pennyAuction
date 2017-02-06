<?php

/**
 * Created by PhpStorm.
 * User: Nika
 * Date: 9/3/2015
 * Time: 6:23 PM
 */
class Auction extends CI_Model {

    /**
     * @var Product
     */
    public $product;

    public function getAuctions( $limit, $offset = 0 ){
        $sql = 'SELECT *,auctions.id AS id FROM auctions
                JOIN products ON auctions.product_id = products.id
                WHERE started = 1 AND finished = 0 AND visible = 1
                ORDER BY time_left
                LIMIT ? OFFSET ?';
        $query = $this->db->query($sql, [ $limit, $offset ] );
        return $query->result();
    }

    public function getSoldAuctions($limit, $offset = 0){
        $sql = 'SELECT *,auctions.id AS id FROM auctions
                JOIN products ON auctions.product_id = products.id
                WHERE started = 1 AND finished = 1 AND visible = 1
                ORDER BY end_time DESC
                LIMIT ? OFFSET ?';
        $query = $this->db->query($sql, [ $limit, $offset ] );
        return $query->result();
    }

    public function searchAuctions( $term, $limit, $offset = 0 ){
        $sql = "SELECT *,auctions.id AS id FROM auctions
                JOIN products ON auctions.product_id = products.id
                WHERE started = 1 AND finished = 0 AND visible = 1 AND
                ( product_name LIKE '%".$this->db->escape_like_str($term)."%' OR
                  keywords LIKE '%".$this->db->escape_like_str($term)."%' )
                ORDER BY time_left
                LIMIT ? OFFSET ?";
        $query = $this->db->query($sql, [ $limit, $offset ] );
        return $query->result();
    }

    public function getAuctionById( $id ){
        $sql = 'SELECT *,auctions.id AS id FROM auctions
                JOIN products ON auctions.product_id = products.id
                WHERE visible = 1 AND auctions.id = ?';
        $query = $this->db->query($sql, [ $id ] );
        return $query->row();
    }

    public function getFinishedAuctions($limit, $offset = 0){
        $sql = 'SELECT *,auctions.id AS id FROM auctions
                JOIN products ON auctions.product_id = products.id
                WHERE finished = 1 AND visible = 1
                ORDER BY time_left
                LIMIT ? OFFSET ?';
        $query = $this->db->query($sql, [ $limit, $offset ] );
        return $query->result();
    }

    public function getAuctionsWon( $userId, $payed = 0 ){
        $sql = 'SELECT *,auctions.id AS id FROM auctions
            JOIN products ON auctions.product_id = products.id
            WHERE finished = 1 AND payed = ? AND last_bidder_id = ?
            ORDER BY end_time';
        $query = $this->db->query($sql, [ $payed, $userId ] );
        return $query->result();
    }

    public function getUserAuctions($userId,$ongoingOnly = false){
        $sql = 'SELECT DISTINCT(auction_id) as id from bid_log where user_id = ?';
        $query = $this->db->query($sql, [ $userId ] );
        $res = $query->result();
        $ids = [];
        foreach( $res as $row ){
            $ids[] = $row->id;
        }
        if( empty($ids) ){
            return [];
        }

        $metaSql = '';
        if( $ongoingOnly ){
            $metaSql = ' finished = 0 AND';
        }

        $sql = 'SELECT *,auctions.id AS id FROM auctions
                JOIN products ON auctions.product_id = products.id
                WHERE visible = 1 AND '.$metaSql.' auctions.id IN ?
                ORDER BY start_time';
        $query = $this->db->query($sql, [ $ids ] );
        return $query->result();
    }

    /**
     * @param $urlTitle String
     * @param $productModel Product
     * @return null
     */
    public function getAuctionWithImages( $urlTitle, $productModel ){
        $sql = 'SELECT *,auctions.id AS id FROM auctions
                JOIN products ON auctions.product_id = products.id
                WHERE url_title = ? ';
        $query = $this->db->query( $sql, [$urlTitle] );
        $auc = $query->row();
        if( $auc == null ) return null;

        $sql = 'SELECT * FROM product_images WHERE product_id = ?';
        $query = $this->db->query( $sql, [$auc->product_id] );
        $images = $query->result();
        foreach( $images as $image ){
            $image->thumbnail = $productModel->getThumbnail($image->filename);
        }
        $auc->images = $images;
        return $auc;
    }

    public function markAsPayed( $auctionId ){
        $sql = 'UPDATE auctions SET payed = 1 WHERE id = ?';
        $this->db->query( $sql, [$auctionId] );
        return [
            'error' => $this->db->error()
        ];
    }

    public function add( $productId, $productName, $price, $bidPrice ,$timeLeft, $resetTime,
                         $incPrice, $buyNow, $tags, $deliveryTime, $realPrice ){

        $sql = 'INSERT INTO
                auctions( product_id,price,bid_price,time_left,reset_time,started,start_time,inc_price,
                          buy_now,tags,delivery_time,real_price)
                VALUES(?,?,?,?,?,1,NOW(),?,?,?,?,?)';
        $params = [ $productId, $price, $bidPrice, $timeLeft, $resetTime,
                    $incPrice, $buyNow, $tags, $deliveryTime, $realPrice
        ];

        $this->db->query( $sql, $params );
        $error = $this->db->error();
        if( $error['code'] != 0 ) return [ 'error' => $error ];
        $auc_id  = $this->db->insert_id();
        $urlTitle = url_title($productName);
        if( strlen($urlTitle) > 90 ) $urlTitle = substr($urlTitle,0,90);
        $urlTitle .= '-'.$auc_id;
        $sql = 'UPDATE auctions SET url_title = ? WHERE id = ?';
        $this->db->query( $sql, [ $urlTitle, $auc_id ] );

        return $auc_id;
    }

    public function getBidders( $auctionId, $limit = 20 ){
        $sql = 'SELECT * FROM bid_log WHERE auction_id = ? ORDER BY price DESC LIMIT ?';
        $query = $this->db->query( $sql, [$auctionId, $limit] );
        return $query->result();
    }

    public function getAutoBidder( $auctionId, $userId ){
        $sql = 'SELECT * FROM autobidders WHERE user_id = ? AND auction_id = ? AND active = 1 AND limit_bids > 0';
        $query = $this->db->query( $sql, [$userId,$auctionId] );
        return $query->row();
    }

    public function calcBuyNowPrice( $userId, $auctionId, $auctionData = null ){

        if( $auctionData != null ){
            $auc = $auctionData;
        }else{
            $auc = $this->getAuctionById($auctionId);
        }

        if( $auc == null ) return 0;
        if( $auc->buy_now != 1 ){
            return $auc->original_price;
        }
        $sql = 'SELECT SUM(bid_amount) AS bidsum FROM bid_log WHERE user_id = ? AND auction_id = ?';
        $query = $this->db->query( $sql, [$userId,$auctionId] );
        $buyNowPrice = $auc->original_price - $query->row()->bidsum * 0.08;
        if( $buyNowPrice < 1.00 )
            return 1.00;
        return $buyNowPrice;
    }

    public function getajaxAuctions( $limit, $offset ){
        $sql = 'SELECT *,auctions.id AS id FROM auctions
                JOIN products ON auctions.product_id = products.id
                WHERE started = 1 AND finished = 0 AND visible = 1
                ORDER BY time_left
                LIMIT ? OFFSET ?';
        $query = $this->db->query($sql, [ $limit, $offset ] );
        return $query->result();
    }
}