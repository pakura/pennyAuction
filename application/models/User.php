<?php

/**
 * Created by PhpStorm.
 * User: Nika
 * Date: 9/1/2015
 * Time: 3:09 PM
 */
class User extends CI_Model{

    private static $bidsUpdated = false;

    public function __construct(){
        parent::__construct();
        if( $this->session->userdata('loggedIn') && !self::$bidsUpdated ){
            $this->session->set_userdata('userBids', $this->getUserBids( $this->session->userdata('userId') ));
            self::$bidsUpdated = true;
        }
    }

    private function checkDuplicate( $username, $email, $phone, $idNumber ){

        $sql = 'SELECT count(*) AS cnt FROM users WHERE username = ? ';
        $query = $this->db->query($sql, [ $username ] );
        $cnt = $query->row()->cnt;
        if( $cnt > 0 ){
            return 'username';
        }

        $sql = 'SELECT count(*) AS cnt FROM users WHERE email = ? ';
        $query = $this->db->query($sql, [ $email ] );
        $cnt = $query->row()->cnt;
        if( $cnt > 0 ){
            return 'email';
        }

        $sql = 'SELECT count(*) AS cnt FROM users WHERE phone = ? ';
        $query = $this->db->query($sql, [ $phone ] );
        $cnt = $query->row()->cnt;
        if( $cnt > 0 ){
            return 'phone';
        }

        $sql = 'SELECT count(*) AS cnt FROM users WHERE id_number = ? ';
        $query = $this->db->query($sql, [ $idNumber ] );
        $cnt = $query->row()->cnt;
        if( $cnt > 0 ){
            return 'idNumber';
        }

        return null;
    }

    public function activateAccount($key){
        $sql = 'SELECT id FROM users WHERE activation_key = ?';
        $query = $this->db->query( $sql, [ $key ] );
        $user = $query->row();
        if( $user == null ){
            return [
                'error' => 'NOT_FOUND',
            ];
        }

        $sql = 'UPDATE users SET verified = 1 WHERE activation_key = ?';
        $this->db->query( $sql, [ $key ] );
        $sql = 'UPDATE user_wallet SET bids = 25 WHERE user_id = ?';
        $this->db->query( $sql, [ $user->id ] );

        return [
        ];
    }

    public function register( $username, $password, $firstname, $lastname, $gender, $dateOfBirth, $idNumber, $phone, $email, $address, $city, $fbId ){
        $pwdhash = hash('sha256',$password);
        $duplicate = $this->checkDuplicate($username,$email,$phone,$idNumber);

        if( $duplicate != null ){
            return [
                'duplicate' => $duplicate
            ];
        }

        $actKey = md5(mt_rand());

        $sql = 'INSERT INTO users(username,pwd_hash,firstname,lastname,gender,date_of_birth,id_number,phone,email,
                                  address,sess,city,fb_id,activation_key)
                VALUES( ?,?,?,?,?,?,?,?,?,?,?,?,?,? )';
        $params = [
            $username, $pwdhash, $firstname, $lastname, $gender, $dateOfBirth, $idNumber, $phone, $email, $address,
            session_id(), $city, $fbId, $actKey
        ];

        $this->db->query( $sql, $params );
        $userId = $this->db->insert_id();

        $sql = 'INSERT INTO user_wallet(user_id,bids) VALUES(?,?)';
        $this->db->query( $sql, [ $userId, 0 ] );

        $this->login($username,$password);

        return [
            'insertId' => $userId,
            'error' => $this->db->error(),
            'activationKey' => $actKey
        ];
    }

    /**
     * @param $userId
     * @param $oldPassword
     * @param $newPassword
     * @return array
     */
    public function changePassword( $userId, $oldPassword, $newPassword ){
        $newPwdhash = hash('sha256',$newPassword);
        $oldPwdhash = hash('sha256',$oldPassword);

        $sql = 'UPDATE users SET pwd_hash = ? WHERE id = ? AND pwd_hash = ? ';
        $this->db->query( $sql, [ $newPwdhash, $userId, $oldPwdhash ] );

        return [
            'error' => $this->db->error(),
            'affectedRows' => $this->db->affected_rows()
        ];
    }

    /**
     * Update user info
     * @param $userId
     * @param $firstname
     * @param $lastname
     * @param $gender
     * @param $phone
     * @param $email
     * @param $address
     * @return array
     */
    public function updateInfo( $oldPassword, $userId, $phone, $email, $address, $city, $avatarId ){
        $pwdhash = hash('sha256',$oldPassword);
        $sql = 'UPDATE users SET phone = ?, email = ?, address = ?, city = ?, avatar_id = ?
                WHERE id = ? AND pwd_hash = ?';
        $this->db->query( $sql, [ $phone, $email, $address, $city, $avatarId, $userId, $pwdhash ] );
        return [
            'error' => $this->db->error()
        ];
    }

    public function login( $username, $password ){
        $pwdhash = hash('sha256',$password);

        $sql = 'SELECT id FROM users WHERE username = ? AND pwd_hash = ?';
        $query = $this->db->query( $sql, [ $username, $pwdhash ] );
        $row = $query->row();
        if( !isset( $row ) ){
            return [ 'error' => 'invalid' ];
        }

        $sessId = md5( mt_rand() );

        $this->session->set_userdata([
            'userId' => $row->id,
            'username' => $username,
            'loggedIn' => true,
            'session_id' => $sessId,
            'userBids' => $this->getUserBids( $row->id )
        ]);

        $sql = 'UPDATE users SET sess = ? WHERE id = ?';
        $this->db->query( $sql, [ $sessId, $row->id ] );

        return [
            'userId' => $row->id
        ];
    }

    public function loginWithFb(){
        $fbId = $this->session->userdata('fb')['id'];
        $sql = 'SELECT id,username FROM users WHERE fb_id = ?';
        $query = $this->db->query( $sql, [ $fbId ] );
        $row = $query->row();
        if( !isset( $row ) ){
            return [ 'error' => 'invalid' ];
        }

        $sessId = md5( mt_rand() );

        $this->session->set_userdata([
            'userId' => $row->id,
            'username' => $row->username,
            'loggedIn' => true,
            'session_id' => $sessId,
            'userBids' => $this->getUserBids( $row->id )
        ]);

        $sql = 'UPDATE users SET sess = ? WHERE id = ?';
        $this->db->query( $sql, [ $sessId, $row->id ] );

        return [
            'userId' => $row->id
        ];
    }

    public function depositBids( $userId, $bids ){
        $sql = 'UPDATE user_wallet SET bids = bids + ? WHERE user_id = ?';
        $this->db->query( $sql, [ $bids, $userId ] );
        return [
            'error' => $this->db->error()
        ];
    }

    public function getUserBids( $userId ){
        $sql = 'SELECT bids FROM user_wallet WHERE user_id = ?';
        $query = $this->db->query( $sql, [ $userId ] );
        $row = $query->row();
        if( !isset( $row ) ){
            return 0;
        }
        return $row->bids;
    }

    public function getUserInfo($userId){
        $sql = "SELECT * FROM users WHERE id = ?";
        $query = $this->db->query( $sql, [ $userId ] );
        $row = $query->row();
        if( !isset( $row ) ){
            return 0;
        }
        return $row;
    }

    public function getAvatarCount(){
        $fi = new FilesystemIterator('assets/avatars/', FilesystemIterator::SKIP_DOTS);
        return iterator_count($fi);
    }
}