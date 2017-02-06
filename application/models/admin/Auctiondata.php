<?php
/**
 * Created by PhpStorm.
 * User: Pakura
 * Date: 12.10.2015
 * Time: 3:27
 */
class Auctiondata extends CI_Model{
    public function getAuctions( $finished, $from, $to, $offset){
        $sql = 'SELECT auctions.*, products.*, auctions.id AS id
                FROM auctions
                INNER JOIN products
                ON auctions.product_id=products.id
                WHERE finished = ? AND start_time BETWEEN ? AND ? order by auctions.id DESC LIMIT 1000 offset ?';
        $query = $this->db->query($sql, [ $finished, $from, $to, $offset] );
        return $query->result();
    }

    public function getUsers($offset){
        $sql = 'SELECT * FROM users LIMIT 1000 OFFSET ?';
        $query = $this->db->query($sql, [$offset] );
        return $query->result();
    }

    public function getAuctionsUsers($id){
        $sql = 'SELECT bid_log.*, sum(bid_log.bid_amount) as bids,
                autobidders.limit_bids, autobidders.bids_left, autobidders.from_price, autobidders.to_price
                FROM bid_log left join autobidders ON bid_log.user_id= autobidders.user_id
                AND bid_log.auction_id = autobidders.auction_id AND autobidders.limit_bids > 0 AND autobidders.active = 1
                WHERE bid_log.auction_id = ?
                GROUP BY bid_log.user_id';
        $query = $this->db->query($sql, [$id] );
        return $query->result();
    }

    public function getAuctionsUserstotal($id){
        $sql = 'SELECT sum(bid_amount) as total_bids, count(*) as bids, COUNT( DISTINCT(user_id) ) AS uniq
                FROM bid_log WHERE auction_id = ?';
        $query = $this->db->query($sql, [$id] );
        return $query->result();
    }


    public function getProfileInfo($id){
        $sql = 'SELECT users.*, user_wallet.bids FROM users left join user_wallet ON users.id =  user_wallet.user_id WHERE users.id = ?';
        $query = $this->db->query($sql, [$id] );
        return $query->result();
    }

    public function updateProfileInfo($id, $name, $sname, $address, $city, $phone, $email, $dateofbirth, $personalid, $verified){
        $sql = 'UPDATE users SET firstname = ?,
                lastname = ?,
                address = ?,
                city = ?,
                phone = ?,
                email = ?,
                date_of_birth = ?,
                id_number = ?,
                verified = ? WHERE id = ?';
        $query = $this->db->query($sql, [$name, $sname, $address, $city, $phone, $email, $dateofbirth, $personalid, $verified, $id] );
        if (!$query){
            return $this->db->error();
        } else {
            return 'The data was successfully changed';
        }
    }

    public function updateProfilebids($id, $bids){
        $sql = 'INSERT INTO user_wallet (bids, user_id) VALUES (?,?) ON DUPLICATE KEY UPDATE bids = ?;';
        $query = $this->db->query($sql, [$bids, $id, $bids] );
        if (!$query){
            return $this->db->error();
        } else {
            return 'The bids amount was successfully changed';
        }
    }


    public function getProTransactions($userid){
        $sql = 'SELECT transactions.*, auctions.url_title
                FROM transactions left join auctions ON transactions.auction_id= auctions.id
                WHERE user_id = ?';
        $query = $this->db->query($sql, [$userid] );
        return $query->result();
    }
}
