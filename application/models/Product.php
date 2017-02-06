<?php

/**
 * Created by PhpStorm.
 * User: Nika
 * Date: 9/2/2015
 * Time: 5:36 PM
 */
class Product extends CI_Model {

    public function __construct(){
        parent::__construct();
        $this->load->library('image_lib');
    }

    public function add( $name, $categoryId, $spec, $description, $keywords, $origPrice ){
        $sql = 'INSERT INTO products(product_name,category_id,spec,description,keywords,original_price)
                VALUES( ?,?,?,?,?,? )';
        $this->db->query( $sql, [ $name, $categoryId, $spec, $description, $keywords,$origPrice ] );

        return [
            'insertId' => $this->db->insert_id(),
            'error' => $this->db->error()
        ];
    }

    public function get( $productId ){
        $sql = 'SELECT * FROM products WHERE id = ?';
        $query = $this->db->query( $sql, [ $productId ] );
        return $query->row();
    }

    public function getAll(){
        $sql = 'SELECT * FROM products';
        $query = $this->db->query( $sql );
        return $query->result();
    }

    public function addThumbnail( $filename ){
        $config['image_library'] = 'gd2';
        $config['source_image'] = './assets/uploads/'.$filename;
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['width']         = 200;
        $config['height']       = 150;

        $this->image_lib->initialize($config);
        $this->image_lib->resize();
    }

    public function addImage( $filename, $productId ){
        $sql = 'INSERT INTO product_images(filename,product_id) VALUES(?,?)';
        $this->db->query( $sql, [ $filename, $productId ] );

        return [
            'insertId' => $this->db->insert_id(),
            'error' => $this->db->error()
        ];
    }

    public function setMainThumbnail( $filename, $productId ){
        $fname = $this->getThumbnail($filename);
        $sql = 'UPDATE products SET thumbnail = ? WHERE id = ?';
        $this->db->query( $sql, [ $fname, $productId ] );
    }

    public function getCategories(){
        $sql = 'SELECT * FROM categories ORDER BY weight';
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function getThumbnail( $filename ){
        $f = substr($filename,0,strlen($filename)-4);
        $ext = substr($filename,strlen($filename)-3,3);
        return $f . '_thumb.' . $ext;
    }

    public function delete( $id ){
        $sql = 'SELECT COUNT(*) AS cnt FROM auctions WHERE product_id = ?';
        $query = $this->db->query( $sql, [ $id ] );
        if( $query->row()->cnt > 0 ){
            return false;
        }
        $sql = 'DELETE FROM products WHERE id = ?';
        $this->db->query( $sql, [ $id ] );
        return true;
    }

    public function updateProduct($id, $product_name, $category_id, $spec, $description, $keywords, $original_price){
        $sql = 'UPDATE products SET product_name = ?, category_id = ?, spec = ?, description = ?, keywords = ?, original_price = ? WHERE id = ?';
        $this->db->query( $sql, [ $product_name, $category_id, $spec, $description ,  $keywords, $original_price, $id] );
    }
}