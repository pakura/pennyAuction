<?php

/**
 * Created by PhpStorm.
 * User: Nika
 * Date: 9/3/2015
 * Time: 11:47 AM
 */
class Admin extends CI_Controller{

    /**
     * @var Product
     */
    public $product;

    /**
     * @var Auction
     */
    public $auction;

    /**
     * @var Thrift
     */
    public $thrift;

    private function checkAdmin(){
        if( !$this->session->userdata('adminUser') ){
            redirect('/admin/admin');
        }
    }

    public function index(){
        $this->load->helper( 'form' );
        $this->load->library('form_validation');

        $this->form_validation->set_rules('username','Username','trim|required');
        $this->form_validation->set_rules('password','Password','trim|required');
        $data['wrong']='';
        if( $this->form_validation->run() == false ){
            $this->load->view('/admin/login',$data);
        }else{
            $this->load->model('admin/adminuser');
            $this->adminuser->login(
                $this->input->post('username'),
                $this->input->post('password')
            );
            if( ! $this->session->userdata('adminUser') ){
                $data['wrong']='Wrong username or password';
                $this->load->view('/admin/login',$data);
            }else{
                redirect('/admin/admin/listproducts');
            }
        }
    }

    public function addProduct(){

        $this->checkAdmin();

        $this->load->helper( 'form' );
        $this->load->library('form_validation');
        $this->load->model('product');
        $this->form_validation->set_rules('name','product name','trim|required');
        $this->form_validation->set_rules('original_price','stock price','trim|required|decimal');
        $this->form_validation->set_rules('category_id','category','trim|required');
        $this->form_validation->set_rules('description','description','trim|required');
        $this->form_validation->set_rules('spec','specification','trim|required');
        $this->form_validation->set_rules('keywords','keywords','trim|required');

        if( $this->form_validation->run() == false ){
            $this->loadLayout('admin/add_product',[
                'categories' => $this->product->getCategories(),
                'error' => ''
            ]);
        }else{

            if( !isset( $_FILES["image1"] ) || $_FILES["image1"]['size'] == 0 ){
                $this->loadLayout('admin/add_product',[
                    'categories' => $this->product->getCategories(),
                    'error' => 'You must unload at least one image'
                ]);
                return;
            }

            $prod = $this->product->add(
                $this->input->post('name'),
                $this->input->post('category_id'),
                $this->input->post('spec'),
                $this->input->post('description'),
                $this->input->post('keywords'),
                $this->input->post('original_price')
            );
            $this->load->library('upload');

            for( $i = 1; true; $i++ ){
                if( !isset( $_FILES["image$i"] ) || $_FILES["image$i"]['size'] == 0 ){
                    break;
                }
                $filename = md5( mt_rand() );

                $config = [
                    'upload_path' => './assets/uploads/',
                    'allowed_types' => 'gif|jpg|png',
                    'file_name' => $filename
                ];
                $this->upload->initialize($config);

                if ( ! $this->upload->do_upload("image$i") ) {
                    $this->loadLayout('admin/add_product',[
                        'categories' => $this->product->getCategories(),
                        'error' => $this->upload->display_errors()
                    ]);
                    break;
                }

                $filename = $this->upload->data()['file_name'];
                $this->product->addImage($filename,$prod['insertId']);
                $this->product->addThumbnail($filename);
                if( $i == 1 ){
                    $this->product->setMainThumbnail($filename,$prod['insertId']);
                }
            }
            redirect('/admin/admin/listproducts');
        }
    }

    public function addAuction($productId){
        $this->checkAdmin();
        $this->load->helper( 'form' );
        $this->load->library('form_validation');
        $this->load->model('product');

        $prod = $this->product->get($productId);

        $this->form_validation->set_rules('product_id','product id','trim|required|integer');
        $this->form_validation->set_rules('product_name','product name','trim|required');
        $this->form_validation->set_rules('price','price','trim|required|decimal');
        $this->form_validation->set_rules('bid_price','bid price','trim|required|integer');
        $this->form_validation->set_rules('time_left','time left','trim|required|integer');
        $this->form_validation->set_rules('reset_time','reset time','trim|required|integer');
        $this->form_validation->set_rules('tags','tags','trim');
        $this->form_validation->set_rules('delivery_time','delivery time','trim|required');
        $this->form_validation->set_rules('real_price','real price','trim|required|decimal');

        if( $this->form_validation->run() == false ){
            $this->loadLayout('admin/add_auction',[
                'product' => $prod
            ]);
        }else{
            $this->load->model('auction');
            $id = $this->auction->add(
                $this->input->post('product_id'),
                $this->input->post('product_name'),
                $this->input->post('price'),
                $this->input->post('bid_price'),
                $this->input->post('time_left') * 60 * 1000 ,
                $this->input->post('reset_time'),
                $this->input->post('inc_price') == 1 ? 1 : 0,
                $this->input->post('buy_now') == 1 ? 1 : 0,
                $this->input->post('tags'),
                $this->input->post('delivery_time'),
                $this->input->post('real_price')
            );
            $this->load->model('thrift');
            $this->thrift->loadAuction($id);

            redirect('/admin/admin/listproducts');
        }
    }

    public function listProducts(){
        $this->checkAdmin();
        $this->load->model('product');
        $this->loadLayout('admin/product_list',[
            'products' => $this->product->getAll()
        ]);
    }

    public function listAuctions(){
        $this->checkAdmin();
        $this->load->model('auction');
        $this->loadLayout('admin/auction_list',[
            'auctions' => $this->auction->getAuctions(100)
        ]);
    }

    public function userslist(){
        $this->checkAdmin();
        $this->loadLayout('admin/users',[]);
    }

    public function deleteProduct( $productId ){
        $this->checkAdmin();
        $productId = (int)$productId;
        $this->load->model('product');
        $b = $this->product->delete($productId);
        if( !$b ){
            $this->loadLayout('admin/error',[
                'error' => 'this product is linked to auction'
            ]);
            return;
        }
        redirect('/admin/admin/listproducts');
    }

    private function loadLayout( $view,$data = [] ){
        $this->load->config('cities');
        $html = $this->load->view($view,$data,true);
        $menu = $this->load->view('admin/menu',[
            'cities' => $this->config->item('cities')
        ],true);

        $this->load->view('layout/admin_layout',[
            'menu' => $menu,
            'content'=> $html,
        ]);
    }

    public function editproduct($productId){
        $this->checkAdmin();
        $this->load->helper( 'form' );
        $this->load->library('form_validation');
        $this->load->model('product');
        $prodData = $this->product->get($productId);
        $this->form_validation->set_rules('name','product name','trim|required');
        $this->form_validation->set_rules('original_price','stock price','trim|required|decimal');
        $this->form_validation->set_rules('category_id','category','trim|required');
        $this->form_validation->set_rules('description','description','trim|required');
        $this->form_validation->set_rules('spec','specification','trim|required');
        $this->form_validation->set_rules('keywords','keywords','trim|required');

        if( $this->form_validation->run() == false ){
            $this->loadLayout('admin/add_product',[
                'categories' => $this->product->getCategories(),
                'error' => '',
                'productDate' => $prodData,
                'editable' => 1
            ]);
        }else{
            $prod = $this->product->updateProduct(
                $productId,
                $this->input->post('name'),
                $this->input->post('category_id'),
                $this->input->post('spec'),
                $this->input->post('description'),
                $this->input->post('keywords'),
                $this->input->post('original_price')
            );
            redirect('/admin/admin/listproducts');
        }
    }
}