<?php

/**
 * Created by PhpStorm.
 * User: Nika
 * Date: 9/25/2015
 * Time: 5:59 PM
 */
class Payment extends CI_Model{

    public function addTransaction( $amount, $userId, $auctionId, $packageId = 0 ){
        $sql = 'INSERT INTO transactions(amount,user_id,auction_id,package_id) VALUES(?,?,?,?)';
        $this->db->query( $sql, [ $amount, $userId, $auctionId, $packageId ] );
        return [
            'insertId' => $this->db->insert_id(),
            'error' => $this->db->error()
        ];
    }

    public function getTransaction( $id ){
        $sql = 'SELECT * FROM transaction WHERE id = ?';
        $query = $this->db->query($sql, [ $id ]);
        return $query->row();
    }

    public function updateTransaction( $transId, $paymentId, $paymentDate, $cardType, $reason ){
        $sql = 'UPDATE transactions
                SET payment_id = ?, payment_date = ?, card_type = ?, reason = ?
                WHERE id = ? ';
        $this->db->query($sql, [ $paymentId, $paymentDate, $cardType, $reason, $transId ]);
        return [
            'error' => $this->db->error()
        ];
    }

    public function confirmTransaction( $transId ){
        $sql = 'UPDATE transactions SET confirmed = 1 WHERE id = ?';
        $this->db->query($sql, [ $transId ]);
        return [
            'error' => $this->db->error()
        ];
    }

}