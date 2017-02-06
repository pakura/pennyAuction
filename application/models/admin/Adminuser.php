<?php

/**
 * Created by PhpStorm.
 * User: Nika
 * Date: 9/3/2015
 * Time: 1:38 PM
 */
class Adminuser extends CI_Model{



    public function login( $username, $password ){
        $pwdhash = hash('sha256',$password);

        $sql = 'SELECT id FROM admin_users WHERE username = ? AND pwd_hash = ?';
        $query = $this->db->query( $sql, [ $username, $pwdhash ] );
        $row = $query->row();
        if( !isset( $row ) ){
            return [ 'error' => 'invalid' ];
        }

        $this->session->set_userdata([
            'adminUser' => true
        ]);

        return [
            'userId' => $row->id
        ];
    }

}